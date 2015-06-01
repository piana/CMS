<?php /*windu.org admin controller*/
Class adminAjaxWidgetsController Extends adminAjaxController{
	public function __construct($request){
		parent::__construct($request);
	}
	public function index()
	{	
		
	}	
	public function choseWidget()
	{	
		$this->smarty->assign('widgetsList',widgetsDB::getWidgetArray());
		$this->pageDisplay('widgetsChoseWidgetModal');
	}
	private function widgetChoseOptionForm($widgetName,$startConfig = array(),$showNotNullElements = false,$succesMethod = 'choseOptionsSuccess',$showCancelLink = true,$template = null) {

		$form = new form('selectWidget',$succesMethod,$_POST,'POST','form-horizontal');
		
		$widgetIniFilePath = WIDGET_PATH.$widgetName.'/doc/helper.ini';
		$valuesConfig = ini::parse($widgetIniFilePath);

		if (count($valuesConfig)<=0 and !$showNotNullElements) {
			router::redirect('admin-widgets-ajax-action-id',array('action'=>'generateWidgetCode','id'=>$widgetName));
		}
		
		foreach ($valuesConfig as $valueConfig){

				$inputData = null;
				if ($valueConfig['dateType']=='php') {
					eval($valueConfig['date']);
					if ($inputData['option']==null) {
						$inputData['option'] = array('0'=>'-');
					}
				}elseif ($valueConfig['dateType']=='commaArray'){
					$inputDataArray=explode(',', $valueConfig['date']);
					$inputDataArrayFin = array();
					foreach ($inputDataArray as $row){
						$inputDataArrayFin[$row]=$row;
					}
					$inputData=array("option"=>$inputDataArrayFin);
				}
				if (!($startConfig[$valueConfig['name']]!=null or !$showNotNullElements)) {$form->add('HTML','<span class="silver">');}

				if ($startConfig[$valueConfig['name']]=='1') {
					$startConfig[$valueConfig['name']] = 'true';
				}elseif ($startConfig[$valueConfig['name']]=='0'){
					$startConfig[$valueConfig['name']] = 'false';
				}
				$form->add($valueConfig['name'], $valueConfig['inputType'],$valueConfig['name'], $startConfig[$valueConfig['name']], $inputData);
				if (!($startConfig[$valueConfig['name']]!=null or !$showNotNullElements)) {$form->add('HTML','</span>');}
				if ($valueConfig['rule']!=null) {
					$form->addRule($valueConfig['name'], $valueConfig['rule'], null,lang::read('admin.content.controller.giveelementname'));	
				}
		}
		$form->add('name', 'input-hidden',null, $widgetName);
		
		if ($template != null) {
			$form->add('templateVal', 'input-hidden',null, base64_encode($template));
			$form->add('paramsVal', 'input-hidden',null, serialize($startConfig));
		}		
		
		if ($showCancelLink) {
			$form->addButton('submit',lang::read('form.button.title.next'));
		}else{
			$form->addButton('submit',lang::read('form.button.title.save'));
		}	
		if ($showCancelLink) {
			$form->addButton('cancel',lang::read('form.button.title.cancel'),'btn btn-margin-left',HOME.'admin/ajax/widgets/choseWidget/',null,'fa fa-ban');
		}
		$form->setHandler($this);
		$form->handle();
				
		return $form;
	}
	public function choseOptions()
	{	
		$form  = $this->widgetChoseOptionForm($this->request->getVariable('id'));
		$this->smarty->assign('form',$form);
		$this->pageDisplay('widgetsChoseOptionsModal');
	}	
	public function choseOptionsSuccess($data){
		$widgetName = $data['name'];
		unset($data['name']); 
		
		if (is_array($data)){
			foreach ($data as $key => $value){
				if ($value!==null) {
					if ($value=='false' or $value=='true' or is_numeric($value)) {
						$widgetCode .= ' '.$key.'='.$value;
					}else{
						$widgetCode .= ' '.$key.'="'.$value.'"';
					}
				}
			}
		}
		$widgetCode = htmlentities($widgetCode);
		router::redirect('admin-widgets-ajax-action-id',array('action'=>'generateWidgetCode','id'=>$widgetName,'data'=>base64_encode($widgetCode)));
	}
		
	public function generateWidgetCode(){	
		$data = unserialize(cookie::readCookie('widgetInserter'));
	
		$widgetCode .= "{{W name={$this->request->getVariable('id')}";

		if ($this->request->getVariable('data')!=null) {
			$widgetCode .= ' '.base64_decode($this->request->getVariable('data'));
		}
		$widgetCode .= '}}';

		$this->smarty->assign('widgetCode',$widgetCode);
		$this->pageDisplay('widgetCodeModal');
	}
	
	////////////////////////////////////////////
	////front editor////////////////////////////
	////////////////////////////////////////////
	public function modalWidgetSelect() {
		$params = cache::read($this->request->getVariable('id'));
		$template = cache::read($this->request->getVariable('data'));

		$form  = $this->widgetChoseOptionForm($params['name'],$params,true,'editOptionsWidgetSelectSuccess',false,$template);
		
		//$form->addButton('deleteWidget','Delete widget','btn btn-danger',HOME.'',null,'fa fa-times-circle ');
		$form->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary margin-right',null,null,'fa fa-upload ');
		$this->smarty->assign('form',$form);
		$this->pageDisplay('widgetSelectModal');
	}	
	
	public function editOptionsWidgetSelectSuccess($data){
		
		$widgetName = $data['name'];
		$templateFile = base64_decode($data['templateVal']);
		$oryginalParams = unserialize($data['paramsVal']);
		$oryginalWidgetCode = '{{W ';
		foreach ($oryginalParams as $key=>$orgParam) {
			if ($orgParam=='') {
				$orgParam = 0;
			}
			$oryginalWidgetCode .= "{$key}={$orgParam} ";
		}
		$oryginalWidgetCode .= '}}';
		
		unset($data['name']); 
		unset($data['templateVal']); 
		unset($data['paramsVal']); 

		if (is_array($data)){
			foreach ($data as $key => $value){
				if ($value!==null and $value!='') {
					if ($value=='false' or $value=='true' or is_numeric($value)) {
						$widgetCode .= ' '.$key.'='.$value;
					}else{
						$widgetCode .= ' '.$key.'="'.$value.'"';
					}
				}
			}
		}
		$widgetCode = "{{W name={$widgetName} ".$widgetCode.'}}';
		
		$templateContent = baseFile::readFile($templateFile);
		preg_match_all('/{{W name=(.*?) (.*?)}}/', $templateContent, $matches);

		$index = 0;
		foreach ($matches[0] as $match){
			if ($this->prepareWidgetCodeToMatch($match) == $this->prepareWidgetCodeToMatch($oryginalWidgetCode)) {
				$widgetToReplace =  $matches[0][$index];
			}
			$index = $index+1;
		}

		$templateContent = str_replace($widgetToReplace, $widgetCode, $templateContent);//tutaj robimy replace tresci

		baseFile::saveFile($templateFile, $templateContent);
			
		router::reloadParent();
	}	
	private function prepareWidgetCodeToMatch($widgetCode) {
		$widgetCode = str_replace(array('"',"'",' ','false','true'), array('','','','0','1'), strtolower($widgetCode));
		
		return $widgetCode;
	}
}
?>
