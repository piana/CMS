<?php
class form
{
	private $form = array();
	private $formButton = array();
	private $method = null;
	private $formAction = null;
	private $successAction = null;
	private $form_key = null;
	
	private $rule = array();
	private $handler = null;
	
	private $pom = 0;

	function __construct($id,$action,$data,$method = "POST",$cssClass = null,$linkAddon = null, $externalActionUrl = false, $ajax = false,$messageError = 'admin.message.error')
	{
		foreach ($data as $key => $dataRow){
			$data[$key] = stripcslashes($dataRow);
		}
	
		if ($externalActionUrl==true) {
			$this->formAction = $action;
		}else{
			$homePom = explode('?', __HOME);
			$this->formAction = $homePom[0]."?mn=".$messageError.$linkAddon;
		}
		$this->successAction = $action;
		$this->method = $method;
		$this->data = $data;
		$this->id = $id;
		$this->cssClass = $cssClass;
		$this->ajax = $ajax;
	}
	
	public function setMenuFloating() {
		$this->menuFloating = true;
	}
	public function setAjax($actionLink) {
		$this->ajax = $actionLink;
	}
	public function setCssClass($cssClassString) {
		$this->cssClass = $cssClassString;
	}	
	public function setMethod($method) {
		$this->method  = $method;
	}	
	public function setSuccessAction($action) {
		$this->successAction = $action;
	}	
	public function setFormAction($action,$linkAddon = null,$externalActionUrl = false,$messageError = 'admin.message.error') {
		if ($externalActionUrl==true) {
			$this->formAction = $action;
		}else{
			$homePom = explode('?', __HOME);
			$this->formAction = $homePom[0]."?mn=".$messageError.$linkAddon;
		}
	}		

	
	
	public function add($name, $element='input-text', $title=NULL, $value=NULL, $attributes = array())
	{
		$element = ucfirst($element);
		if ($name == 'HTML')
		{
			$name = $name.'-'.md5(microtime());
			$this->form[$name] = $element;
		}
		else
		{	
			@$atr = $attributes;
			if(@$atr['key']=='1')
			{
				if (is_array($atr['option']))
				{
					foreach ($atr['option'] as $key => $val)
					{
						if(@$_COOKIE[$name]==$key)
						{
							$value = $val;
						}					
					}
				}
			}
			else if ($this->isSubmitted() && isset($this->data[$name]))
			{
				$value = $this->data[$name];
			}
			else if(isset($_COOKIE[$name]))
			{
				$value = $_COOKIE[$name];
			}
			
			$element=explode('-', $element);
			if($element[1] == 'checkbox' && $this->isSubmitted() && isset($this->data[$name])){
				if(isset($value))$attributes['checkbox-selected']=TRUE; else $attributes['checkbox-selected'] = FALSE;
			}
			if (!isset($element[1])) $element[1]=''; 
			$elementClassName = "form".$element[0]."Element";
			$this->form[$name] = new $elementClassName($name, $title, $value, $element[1], $attributes);
		}
	}
	public function addButton($name, $title = 'Save', $css = 'btn btn-primary', $url = null, $addon = null, $icon = null)
	{
		if ($icon!=null) {
			$icon = "<i class='{$icon} icon-button'></i>";
		}
		
		if ($url != null){
			$this->formButton[$name] = "<a href='{$url}' class='{$css}' $addon>{$icon}{$title}</a>";
		}else{
			$this->formButton[$name] = "<button type='submit' class='{$css}' $addon>{$icon}{$title}</button>";
		}
	}
	public function addRule($fieldName, $ruleName, $params = null, $errorText = null, $custom = false)
	{
		$this->form[$fieldName]->setAjaxValidator($ruleName);
		$this->rule[] = array("fieldName" => $fieldName, "ruleName" => $ruleName, "params" => $params, "custom" => $custom, "errorText" => $errorText);
	}	
	
	private function isSubmitted()
	{
		$pom_key = $this->data;
		if (isset($pom_key['form_key']))
		{
			if($pom_key['form_key'] == $this->id)
			{
				if(usersDB::getLoggedUser('AdminUser')!=null){
					$sessionDB = new sessionDB();
					$sessionKeyData = $sessionDB->get($pom_key['form_session_key']);

					if($sessionKeyData == $pom_key['form_key']){
						return TRUE;
					}else{
						return FALSE;
					}
				}else{
					return TRUE;
				}
			}
			else{
				return FALSE;
			}
		}
		else{
			return FALSE;
		}
	}
	
	private function validate()
	{
		$validator = new validator();
 		$errorNum = 0;
 		
		if (isset($this->form['captcha'])) {
			$captchaObject = $this->form['captcha'];
			if (md5(sha1($this->data['captcha']))!=cookie::get('captchaCode')) {
				$errorNum = 1;
				$this->form['captcha']->setError(lang::read('validator.captcha.error'));
			}
		}

		foreach($this->rule as $rule)
		{
			$ruleName = $rule['ruleName'];
			$fieldName = $rule['fieldName'];
			$where = $rule['where'];

			$error = false;
			
			if ($rule['custom'] == true)
			{
				$error = $this->handler->$ruleName(@$this->data[$fieldName],$rule['params'], $this->data,$fieldName,$where);
			}
			elseif (is_array($_FILES[$fieldName])){
				$error = $validator->$ruleName(@$_FILES[$fieldName],$rule['params'],$_FILES,$fieldName,$where);
			}
			else
			{
				$error = $validator->$ruleName(@$this->data[$fieldName],$rule['params'],$this->data,$fieldName,$where);
			}
			
			if ($error)
			{	
				$this->form[$fieldName]->setError($rule['errorText']);
				$errorNum++;
			}
		}
		return $errorNum;
	}
	
	public function setHandler($handler)
	{ 
        $this->handler = $handler;
	}
 
	public function handle()
	{ 
		if ($this->handler == null) throw new Exception("Handler not set"); 
        if ($this->isSubmitted())
        {
        	if ($this->validate() == 0)
        	{
        		unset($this->data['form_key']);
        		unset($this->data['form_session_key']);
        	    unset($this->data['captcha']);
 
        		if ($this->successAction == null){
        			$this->handler->success($this->data);
        		}
        		else{
        			$hendler_pom = $this->handler;
        			$acction = $this->successAction;
        			$hendler_pom->$acction($this->data);
        		}
        	}
        }
	}

	public function renderStatus($cssErrorClass = "alert alert-error",$cssSuccessClass = "alert alert-success")
	{
		if ($this->isSubmitted()){
			$errors=null;
			foreach($this->form as $name => $formItem)
			{
				if (substr($name, 0, 4)!='HTML')
				{
					if ((count($formItem->errors))>0)
					{
						foreach($formItem->errors as $error)
						{
							$errors.=	"<li>{$error}</li>";
						}
					}
				}
			}	
			if ($errors==null){
				$status = '<div class="'.$cssSuccessClass.'">
				            <button type="button" class="close" data-dismiss="alert">×</button>
				            <h4 class="alert-heading">All is OK!</h4>
				           </div>';			
			}elseif($errors!=null){
				$status = '<div class="'.$cssErrorClass.'">
				            <button type="button" class="close" data-dismiss="alert">×</button>
				            <h4 class="alert-heading">Error!</h4>
				            <ul>
				            	'.$errors.'
				            </ul>
				           </div>';
			}
			return $status;
		}
	}
		
	public function render($name)
	{
		$element = $this->form[$name];
		return $element->render();
	}
	
	public function toHtml($cssButtonClass = "btn btn-primary",$htmlOnly = false)
	{
		if ($this->ajax!=false) {
			$ajaxString = 'ajax-link="'.$this->ajax.'"';
		}
		
		$formHtml ="<form action='{$this->formAction}' enctype='multipart/form-data' method='{$this->method}' class='{$this->cssClass}' id='{$this->id}' $ajaxString >";
		if(!$htmlOnly)$formHtml.="<fieldset>";
		foreach($this->form as $name => $formItem)
		{
			if (substr($name, 0, 4)=='HTML')
			{
				$formHtml.=$formItem;
			}
			elseif(!$htmlOnly)
			{	
				if (count($formItem->errors) > 0){
					$style="error";
					if ($this->ajax!=false) {
						$ajaxValidator .= '';
					}
				}else $style="";

				if ($formItem->data['type']!='hidden') {
					$formHtml.="<div class='control-group {$style}'>";
					$formHtml.=$formItem->render($name);
					$formHtml.="</div>";
				}else{
					$formHtml.=$formItem->render($name);
				}

			}
		}
		if(!$htmlOnly)$formHtml.="<div class='form-actions'>";
		$formHtml.="<input type='hidden' name='form_key' value='".$this->id."'>";
		
		//Check form session key
		if(usersDB::getLoggedUser('AdminUser')!=null){
			$sessionDB = new sessionDB();
			$sessionKey = $sessionDB->set($this->id, 3600*3);
			$formHtml.="<input type='hidden' name='form_session_key' value='".$sessionKey."'>";
		}
		
		if(count($this->formButton) > 0 and !$htmlOnly){
			foreach($this->formButton as $button)
			{
				$formHtml .= $button;
			}
		}elseif($ajax==true){
			$formHtml .= "<a href='#' class='{$cssButtonClass}'>".lang::read('form.button.title.default')."</a>";
		}elseif(!$htmlOnly){
			$formHtml .= "<button type='submit' class='{$cssButtonClass}'>".lang::read('form.button.title.default')."</button>";
		}
		
        if(!$htmlOnly)$formHtml.="</div>"; 
		
		if(!$htmlOnly)$formHtml.="</fieldset>";
		
		$formHtml.="</form>" ;
		
		$formHtml.='
			<script>
			$(document).ready(function(){
				$.extend($.validator.messages, {
			        required: "'.lang::read('validator.required').'",
			        email: "'.lang::read('validator.email').'",
			        number: "'.lang::read('validator.number').'"
			    });
			    $("#'.$this->id.'").validate();
			});	
			</script>';	
		
		if ($this->menuFloating == true) {
			$formHtml.="
			<script>
			jQuery(function ($) {
				var offset = $('#{$this->id} .form-actions').offset();
				var scrBottom = $(document).scrollTop()+$(window).height();
				var width = $('#{$this->id} .form-actions').width();
				
				if(scrBottom >= offset.top){
					$('#{$this->id} .form-actions').removeClass('put-menu-down');
					
				}else{
					$('#{$this->id} .form-actions').addClass('put-menu-down');
					$('#{$this->id} .form-actions').css('width',width);
				}
					
				$(window).scroll(function () {
					var scrBottom = $(document).scrollTop()+$(window).height()-60;
					
					if(scrBottom >= offset.top) $('#{$this->id} .form-actions').removeClass('put-menu-down');
					else $('#{$this->id} .form-actions').addClass('put-menu-down');
				});
			});	
			</script>	
			";
		}
		if ($this->ajax != false) {
			$formHtml.='
				<script>
				function autosave() {
					var valuesAutosave = {};
					var inputs = $("#'.$this->id.' :input");
					$("div.alert-waiting").fadeIn();
					inputs.each(function() {
						if($(this).attr("editor")=="CKE"){
				        	var editorname = this.name;
				        	CKEDITOR.instances[editorname].updateElement();
				        	valuesAutosave[this.name] = CKEDITOR.instances[editorname].getData();
						}else if($(this).attr("editor")=="CodeMirror"){
							var editornameCodeMirror = this.name;
							valuesAutosave[this.name] = window[editornameCodeMirror].getValue();
						}else{
							valuesAutosave[this.name] = $(this).val();
						}
					});

					$.ajax({
					  type: "POST",
					  processData: "false",
					  url: "'.HOME.'admin/do/content/autosaveSuccess/",
					  data: valuesAutosave,
					  success: function( data ) {
					  	$("div.alert-top").hide();	
					  	$("div.alert-top-autosave").show();
					  	$("div.alert-waiting").hide();
						setTimeout(function () {
				          $("div.alert-top-autosave").delay(3000).slideUp();
				        }, 500);
				       					      
				      },
					  dataType: "text"
					});				        
				}				
				setInterval(autosave, 60 * 1000 * 5);

				$("#'.$this->id.'").submit(function(event) {

				    var btn = $(":button[type=submit]");
				    btn.button("loading");

 				    var inputs = $("#'.$this->id.' :input");
				    var inputsFile = $("#'.$this->id.' :input[type=file]");
				    var values = {};
				    var goAjax = 1;
				    
				    inputsFile.each(function() {
				    	if($(this).val()!=""){
							goAjax = 0; 
						}
				    });	

				    if(goAjax==1){				    
					    event.preventDefault(); 
					    
					    inputs.each(function() {
					        if($(this).attr("editor")=="CKE"){
					        	var editorname = this.name;
					        	CKEDITOR.instances[editorname].updateElement();
					        	values[this.name] = CKEDITOR.instances[editorname].getData();
							}else if($(this).attr("editor")=="CodeMirror"){
								var editornameCodeMirror = this.name;
								values[this.name] = window[editornameCodeMirror].getValue();
							}else{
								values[this.name] = $(this).val();
							}
					    });

					    
						inputsFile.each(function() {
					        delete values[this.name];
					    });	
					    			    	
						delete values["form_key"];
						delete values["form_session_key"];
						
						$.ajax({
						  type: "POST",
						  processData: "false",
						  url: $("#'.$this->id.'").attr("ajax-link"),
						  data: values,
						  success: function( data ) {
						  	$("div.alert-top").fadeIn(500);
							setTimeout(function () {
					          btn.button("reset");
					          $("div.alert-waiting").hide();
					          $("div.alert-top").delay(3000).slideUp(300);
					        }, 500);
					       					      
					      },
						  dataType: "text"
						});					    
				    }			
				});
				</script>
			';
		}
		//debugger::dprint($this); exit;
		return $formHtml;
	}
	
	public function toArray()
	{
		$formArray = array();
		foreach($this->form as $name => $formItem)
		{
			if (substr($name, 0, 4)=='HTML')
			{
				$formHtml.=$formItem;
			}
			else
			{
				$formArray[$name] = $formItem->toArray();
			}			
		}
		return $formArray;
	}
}
?>
