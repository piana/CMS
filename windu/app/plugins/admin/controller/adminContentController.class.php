<?php /*windu.org admin controller*/

Class adminContentController Extends adminMainConfigController{
	public function __construct($request){
		parent::__construct($request);

		$pagesDB = new pagesDB();
		$imagesDB = new imagesDB();
		$this->langs = $pagesDB->fetchAll("type=".pagesDB::TYPE_LANG_CATALOG." and status !=".pagesDB::STATUS_DELETE,'id ASC','*');

		$configDB = new configDB();
		$config = $configDB->getByGroup(configDB::CONFIG_BUCKET_CONTENT);	
		$this->smarty->assign('configList',$config);
		
		$images = $imagesDB->getByBucket($this->request->getVariable('id'));
		$this->smarty->assign('images',$images);		

		$this->smarty->assign('languagePath',LANGUAGES_PATH);
		$this->smarty->assign('config',$this->langs);
		$this->smarty->assign('langs',$this->langs);	
		$this->smarty->assign('pagesDB',$pagesDB);	
		$this->smarty->assign('pagesBackups DB',new pagesbackupsDB());	
		$this->smarty->assign('imagesDB',$imagesDB);

		$this->smarty->assign('filesDB',new filesDB());
		$this->smarty->assign('filesLogDB',new filesLogDB());
		
		$this->smarty->assign('pollsDB',new pollsDB());
		$this->smarty->assign('pollAnswersDB',new pollAnswersDB());
		$this->smarty->assign('pollQuestionsDB',new pollQuestionsDB());

		$this->smarty->assign('bannersareasDB',new bannersareasDB());
		$this->smarty->assign('bannersDB',new bannersDB());	

		$this->smarty->assign('calendarDB',new calendarDB());
		$this->smarty->assign('calendarEventsDB',new calendarEventsDB());	
		$this->smarty->assign('pagesbackupsDB',new pagesbackupsDB());	

		$this->smarty->assign('id',$this->request->getVariable('id'));
		$this->smarty->assign('subpage',$this->request->getVariable('subpage'));
		$this->smarty->assign('controllerShortName','content');
	}
	public function index()
	{	
		$this->pageDisplay('content');
	}

	public function add() {
		$pagesDB = new pagesDB();

		$form = new form('add','addSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.elementname'));
		$form->add('type', 'select',lang::read('admin.content.controller.elementtype'), cookie::readCookie('lastContentAdd'), array("option"=>$pagesDB->getTypes()));

		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$form->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus ');
		$form->setHandler($this);
		$form->handle();
		$this->smarty->assign('contentType','form'); 
		$this->smarty->assign('form',$form);	
		$this->pageDisplay('content');
	}
	public function addSuccess($data) {
		$pagesDB = new pagesDB();
		$data = array_merge($data,array('parentId'=>$this->request->getVariable('id')));
		$pagesDB->insert($data);

		cookie::setCookie('lastContentAdd',$data['type']);
		router::reload();
	}


	public function editLangVariable() {
		$langKey = $this->request->getVariable('id');
		$allVariables = lang::prepareLanguageMultiArray();
		$langVariable = $allVariables[$langKey];
		
		$formLang = new form('editLangVariable','editLangVariableSuccess',$_POST,'POST','form-horizontal form-smallmargin');
		if ($langKey=='') {
			$formLang->add('langVariableNewKey', 'input-text','Klucz frazy językowej');
			$formLang->addRule('langVariableNewKey', 'required', null,lang::read('admin.content.controller.giveelementname'));
		}		
		
		foreach ($this->langs as $lang){
			$formLang->add('langVariable'.$lang->name, 'input-text',$lang->name,$langVariable[strtolower($lang->name)]);
			$formLang->addRule('langVariable'.$lang->name, 'required', null,lang::read('admin.content.controller.giveelementname'));
		}

		$formLang->add('langVariableKey', 'input-hidden',null,$this->request->getVariable('id'));
		$formLang->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary', null, null, 'fa fa-upload ');	
		$formLang->setHandler($this);
		$formLang->handle();
				
		$this->smarty->assign('formEditLangVariable',$formLang); 
		$this->pageDisplay('content');
	}	
	public function editLangVariableSuccess($data) {
		foreach ($this->langs as $lang){
			$name = strtolower($lang->name);
			$fileLangPath = LANGUAGES_PATH.$name.'/front.txt';			
			if ($data['langVariableNewKey']!=null) {
				$data['langVariableKey'] = $data['langVariableNewKey'];
			}
			baseFile::saveFile($fileLangPath, lang::replaceVariableValue($fileLangPath,$data['langVariableKey'],$data['langVariable'.$lang->name]));
		}
		cache::clearBucket('lang');
		router::reload();
	}
	public function editLangAdminVariable() {
		$langKey = $this->request->getVariable('id');
		$allVariables = lang::prepareLanguageMultiArray('admin');
		$langVariable = $allVariables[$langKey];
	
		$formLang = new form('editLangAdminVariable','editLangAdminVariableSuccess',$_POST,'POST','form-horizontal form-smallmargin');
		if ($langKey=='') {
			$formLang->add('langVariableNewKey', 'input-text','Klucz frazy językowej');
			$formLang->addRule('langVariableNewKey', 'required', null,lang::read('admin.content.controller.giveelementname'));
		}
	
		foreach ($this->langs as $lang){
			$formLang->add('langVariable'.$lang->name, 'input-text',$lang->name,$langVariable[strtolower($lang->name)]);
			$formLang->addRule('langVariable'.$lang->name, 'required', null,lang::read('admin.content.controller.giveelementname'));
		}
	
		$formLang->add('langVariableKey', 'input-hidden',null,$this->request->getVariable('id'));
		$formLang->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary', null, null, 'fa fa-upload ');
		$formLang->setHandler($this);
		$formLang->handle();
	
		$this->smarty->assign('formEditLangVariable',$formLang);
		$this->pageDisplay('content');
	}
	public function editLangAdminVariableSuccess($data) {
		foreach ($this->langs as $lang){
			$name = strtolower($lang->name);
			$fileLangPath = LANGUAGES_PATH.$name.'/admin.txt';
			if ($data['langVariableNewKey']!=null) {
				$data['langVariableKey'] = $data['langVariableNewKey'];
			}
			baseFile::saveFile($fileLangPath, lang::replaceVariableValue($fileLangPath,$data['langVariableKey'],$data['langVariable'.$lang->name]));
		}
		cache::clearBucket('lang');
		router::reload();
	}	
	public function editLangVariableWidget() {
		$langKey = $this->request->getVariable('id');
		$widget =  $this->request->getVariable('secoundId');
		
		$allVariables = lang::prepareLanguageMultiArray('widget',$widget);
		$langVariable = $allVariables[$langKey];
	
		$formLang = new form('editLangVariableWidget','editLangVariableWidgetSuccess',$_POST,'POST','form-horizontal form-smallmargin');
		if ($langKey=='') {
			$formLang->add('langVariableNewKey', 'input-text','Klucz frazy językowej');
			$formLang->addRule('langVariableNewKey', 'required', null,lang::read('admin.content.controller.giveelementname'));
		}

		foreach ($this->langs as $lang){
			$formLang->add('langVariable'.$lang->name, 'input-text',$lang->name,$langVariable[strtolower($lang->name)]);
			$formLang->addRule('langVariable'.$lang->name, 'required', null,lang::read('admin.content.controller.giveelementname'));
		}
	
		$formLang->add('langVariableKey', 'input-hidden',null,$this->request->getVariable('id'));
		$formLang->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary', null, null, 'fa fa-upload ');
		$formLang->setHandler($this);
		$formLang->handle();
	
		$this->smarty->assign('formEditLangVariable',$formLang);
		$this->pageDisplay('content');
	}
	public function editLangVariableWidgetSuccess($data) {
		foreach ($this->langs as $lang){
			$name = strtolower($lang->name);
			$fileLangPath = WIDGET_PATH.$this->request->getVariable('secoundId').'/lang/'.$name.'.txt';
			if ($data['langVariableNewKey']!=null) {
				$data['langVariableKey'] = $data['langVariableNewKey'];
			}
			baseFile::saveFile($fileLangPath, lang::replaceVariableValue($fileLangPath,$data['langVariableKey'],$data['langVariable'.$lang->name]));
		}
		cache::clearBucket('lang');
		router::reload();
	}	
	public function edit() {
		$pagesbackupsDB = new pagesbackupsDB();
		$restorePages = null;
		if (is_numeric($this->request->getVariable('id'))) {
			if ($pagesbackupsDB->hasRestorePoint($this->request->getVariable('id'))) {	
				$restorePages = $pagesbackupsDB->getBackupes("pageId = {$this->request->getVariable('id')}");
			}
		}
		$pagesDB = new pagesDB();
		$page = $pagesDB->fetchRow("id={$this->request->getVariable('id')}");
		
		$page->content = str_replace('{{$HOME}}',HOME,$page->content);
		
		$form = new form('edit','editSuccess',$_POST,'POST','form-horizontal no-margin',null,false,HOME.'admin/do/content/editAjaxSuccess/'.$this->request->getVariable('id').'/');
 
		$form->add('HTML','
		  <ul class="nav nav-tabs" id="tabContent">
		  	<li><a href="#tabContent1" style="margin-left:5px;"><i class="fa fa-clipboard icon-grey"></i>&nbsp; '.lang::read('admin.content.controller.content').'</a></li>
		    <li><a href="#tabContent2"><i class="fa fa-wrench icon-grey"></i>&nbsp;'.lang::read('admin.content.controller.general').'</a></li>
		    <li><a href="#tabContent3"><i class="fa fa-search icon-grey"></i>&nbsp;'.lang::read('admin.content.controller.seo').'</a></li>');
		$form->add('HTML','<li><a href="#tabContent7"><i class="fa fa-inbox icon-grey"></i>&nbsp;'.lang::read('admin.content.controller.customfields').'</a></li>');
		if (count($restorePages)>0){$form->add('HTML','<li><a href="#tabContent5"><i class="fa fa-tasks icon-grey"></i>&nbsp;'.lang::read('admin.content.controller.ver').' ('.count($restorePages).')</a></li>');}
		$form->add('HTML','<li class="mobileHidden"><a href="#tabContent4"><i class="fa fa-picture-o icon-grey"></i>&nbsp;'.lang::read('admin.content.controller.imageslider').'</a></li>');	
		$form->add('HTML','<li class="mobileHidden"><a href="#tabContent6"><i class="fa fa-info-circle icon-grey"></i>&nbsp;'.lang::read('admin.content.controller.info').'</a></li></ul>');		
		$form->add('HTML','<div class="tab-content">');
		$form->add('HTML','<div class="tab-pane" id="tabContent1">');	
		
		$form->add('content', 'textareaCKEditor','',$page->content,array('editorType'=>config::get('editorCKEType')));	
		$form->add('HTML','</div>');
		$form->add('HTML','<div class="tab-pane" id="tabContent2">');
		
		if ($page->type!=pagesDB::TYPE_LANG_CATALOG) {
			$form->add('name', 'input-text', lang::read('admin.content.controller.elementname'),$page->name);
			$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
			$form->add('HTML','<hr>');	
		}
	
		if ($page->type == pagesDB::TYPE_NEWS) {
			$form->add('date', 'inputDataTimePicker',lang::read('admin.content.controller.date'),$page->date,array("tooltip" => lang::read('admin.content.controller.datedescription')));
		}
		
		$imagesDB = new imagesDB();
		
		//image/////
		$mainImage = $imagesDB->getFirstByBucket('main-'.$this->request->getVariable('id'));
		if(is_object($mainImage)){
			$form->add('HTML',"
			<div class='control-group'>
				<label class='control-label'>
					<a href='".HOME."admin/do/content/deleteMainImage/main-{$this->request->getVariable('id')}/'><i class='fa fa-times-circle icon-red'>&nbsp;</i></a>
				</label>
				<div class='controls'>
					<img src='".HOME."image/{$mainImage->ekey}/200/150/fit/'>
				</div>
			</div>");
		}

		$form->add('image', 'input-file',lang::read('admin.content.controller.image'),null,array("tooltip" => lang::read('admin.content.controller.imagedescription')));	
		
		//icon///////
		$mainIcon = $imagesDB->getFirstByBucket('icon-'.$this->request->getVariable('id'));
		if(is_object($mainIcon)){
			$form->add('HTML',"
			<div class='control-group'>
				<label class='control-label'>
					<a href='".HOME."admin/do/content/deleteMainImage/icon-{$this->request->getVariable('id')}/'><i class='fa fa-times-circle icon-red'>&nbsp;</i></a>
				</label>
				<div class='controls'>
					<img src='".HOME."image/{$mainIcon->ekey}/200/150/fit/'>
				</div>
			</div>");
		}		
		$form->add('icon', 'input-file',lang::read('admin.content.controller.icon'),null,array("tooltip" => lang::read('admin.content.controller.icondescription')));	
		
		$form->add('menuCssClass', 'input-text', lang::read('admin.content.controller.menucssclass'),$page->menuCssClass);
		$form->add('HTML','<hr>');
		$form->add('status', 'select',lang::read('admin.content.controller.status'),$page->status,array('option' => array('1'=>lang::read('admin.content.controller.visable'),'2'=>lang::read('admin.content.controller.hidden'),'0'=>lang::read('admin.content.controller.deleted')),"tooltip" => lang::read('admin.content.controller.pagestatus')));
		$form->add('logged', 'select',lang::read('admin.content.controller.login'),$page->logged,array('option' => array('1'=>lang::read('admin.content.controller.forlogged'),'0'=>lang::read('admin.content.controller.forall')),"tooltip" => lang::read('admin.content.controller.pagelogged')));
		$form->add('lock', 'select',lang::read('admin.content.controller.block'),$page->lock,array('option' => array('0'=>lang::read('admin.content.controller.unlocked'),'1'=>lang::read('admin.content.controller.locked')),"tooltip" => lang::read('admin.content.controller.blockdesc')));
		$form->add('searchable', 'select',lang::read('admin.content.controller.search'),$page->searchable,array('option' => array('1'=>lang::read('admin.content.controller.searched'),'0'=>lang::read('admin.content.controller.notsearched')),"tooltip" => lang::read('admin.content.controller.searchvis')));
		$form->add('HTML','<hr>');
		$form->add('tpl', 'select',lang::read('admin.content.controller.template'),$page->tpl,array('option' => themesDB::getViewsArray(),"tooltip" => lang::read('admin.content.controller.chosentemplate')));
		if($page->type >= 10){
			$form->add('defaultTpl','select',lang::read('admin.content.controller.defaulttemplate'),$page->defaultTpl,array('option' => themesDB::getViewsArray(),"tooltip" => lang::read('admin.content.controller.chosendefaulttemplate')));
		}
		
		if($page->type != pagesDB::TYPE_LANG_CATALOG and $page->type != pagesDB::TYPE_NEWS){
			$form->add('type', 'select',lang::read('admin.content.controller.elementtype'),$page->type, array("option"=>$pagesDB->getTypes(),"tooltip" => lang::read('admin.content.controller.typeconvert')));
		}
		$form->add('HTML','</div>');
		$form->add('HTML','<div class="tab-pane" id="tabContent3">');	
		$form->add('urlKey', 'input-text',lang::read('admin.content.controller.linkname'),$page->urlKey);
		$form->addRule('urlKey', 'unique', array('table'=>$pagesDB,'where'=>"id!={$this->request->getVariable('id')}"),lang::read('admin.content.controller.adresstaken'));
		$form->add('HTML','<hr>');
		$form->add('title', 'input-text',lang::read('admin.content.controller.title'),$page->title,array("tooltip" => lang::read('admin.content.controller.sitetitle')));
		$form->add('description', 'input-text',lang::read('admin.content.controller.desc2'),$page->description,array("class" => "span8","tooltip" => lang::read('admin.content.controller.descriptioninsection')));
		$form->add('keywords', 'autocompleteInput',lang::read('admin.content.controller.keywords2'),$page->keywords,array("option"=>$pagesDB->getAllKeywords(),"class" => "span8","tooltip" => lang::read('admin.content.controller.keywords')));
		$form->add('HTML','<hr>');
		$form->add('priority', 'input-text',lang::read('admin.content.controller.prior'),$page->priority,array("class" => "span8","tooltip" => lang::read('admin.content.controller.priority')));	
		
		
		$form->add('tags', 'autocompleteInput',lang::read('admin.content.controller.tags'),$page->tags,array("option"=>$pagesDB->getAllTags('id>0',null,array(),true),"class" => "span8","tooltip" => lang::read('admin.content.controller.sitetags')));	
		
		
		$form->add('HTML','</div>');
		$form->add('HTML','<div class="tab-pane" id="tabContent4">');
		//slider-images/////
		$sliderImages = $imagesDB->getByBucket('slider-'.$this->request->getVariable('id'));
		if(is_array($sliderImages)){
			foreach ($sliderImages as $image) {
				$form->add('HTML',"
				
				<div class='control-group'>
					<label class='control-label'>
						<a href='".HOME."admin/do/content/deleteImage/{$image->id}/'><i class='fa fa-times-circle icon-red'>&nbsp;</i></a>
					</label>
					<div class='controls'>
						<img src='".HOME."image/{$image->ekey}/300/100/smart/'>
					</div>
				</div>");
			}
		}

		$form->add('sliderimage', 'input-file',lang::read('admin.content.controller.sliderimage'),null,array("tooltip" => lang::read('admin.content.controller.imagedescription')));			
		$form->add('HTML','</div>');
 
		
		
		if (count($restorePages)>0) {
			$form->add('HTML',"<div class='tab-pane' id='tabContent5'>
								<a href='".HOME."admin/do/content/compactPageVersions/{$page->id}/' class='btn pull-right margon-bottom margin-right'>".lang::read('admin.content.controller.compactversions')."</a><br><br><br>
						   		<table class='table table-striped tablesort'>
								");			
			$usersDB = new usersDB();
			foreach ($restorePages as $restorePoint) {
				$createUserName = $usersDB->get($restorePoint->createUser,'username');
				$form->add('HTML',"
				  	<tr>
						<td><i class='color-icons icons-document-zipper icon-margin'>&nbsp;</i>".generate::showDatatime($restorePoint->createTime)."</td>
						<td><span class='badge badge-inverse'>".strlen($restorePoint->pageContent)."</span></td>
						<td>{$createUserName}</td>
						<td>
							<div class='buttons'>
								<a href='".HOME."admin/do/content/restorePage/{$restorePoint->id}/'><i class='fa fa-upload icon-blue'>&nbsp;</i></a>
								<a href='".HOME."admin/do/content/deletePageVersion/{$restorePoint->id}/'><i class='fa fa-times-circle icon-red'>&nbsp;</i></a>
							</div>
						</td>
					</tr>			
				");
			}
			$form->add('HTML','</tbody></table></div>');
		}
		
		$customFields = $pagesDB->getCustomFieldsArray();
		$form->add('HTML',"<div class='tab-pane' id='tabContent7'>");			
		if (count($customFields)>0) {
			foreach ($customFields as $key => $customField) {
				$customFieldName = 'cf_'.$key.'_'.$customField;
				$form->add($customFieldName,'input-text',$key,$page->$customFieldName);
				$form->addRule($customFieldName, $customField);
			}
		}else{
			$form->add('HTML','<div class="pad">'.lang::read('admin.content.controller.nofields').'</div>');
		}
		$form->add('HTML','<a href="#modal" class="btn btn-tab-center" data-toggle="modal" data-target="#customFielsdModal"><i class="fa fa-plus-circle icon-button"></i>'.lang::read('admin.content.controller.newfield').'</a>');
		
		$form->add('HTML','</div>');	
		
		
		$infoValues = array(
			'<i class="fa fa-globe icon-grey"></i>&nbsp; '.lang::read('admin.content.controller.websitelink') => '<a href="'.HOME.$page->urlKey.'" target="blank">'.HOME.$page->urlKey.'</a>',
			'<i class="fa fa-bullseye  icon-grey"></i>&nbsp; Id' => $page->id,
			'<i class="fa fa-globe icon-grey"></i>&nbsp; urlKey' => $page->urlKey,
			'<i class="fa fa-barcode icon-grey"></i>&nbsp; Ekey' => $page->ekey,
			'<i class="fa fa-thumbs-up icon-grey"></i>&nbsp; '.lang::read('admin.content.controller.rating') => $page->rate,
			'<i class="fa fa-calendar icon-grey"></i>&nbsp; '.lang::read('admin.content.controller.datecrea') => generate::showDatatime($page->createTime),
			'<i class="fa fa-calendar-o icon-grey"></i>&nbsp; '.lang::read('admin.content.controller.datelastup') => generate::showDatatime($page->updateTime),
			'<i class="fa fa-user icon-grey"></i>&nbsp; '.lang::read('admin.content.controller.creatorip') => $page->createIP,
			'<i class="fa fa-user icon-grey"></i>&nbsp; '.lang::read('admin.content.controller.iplastedit') => $page->updateIp,
			'<i class="fa fa-code icon-grey"></i>&nbsp; '.lang::read('admin.content.controller.codeinserted') => '{{eval var=$pagesDB->getContent('.$page->id.')}}',
			'<i class="fa fa-code icon-grey"></i>&nbsp; '.lang::read('admin.content.controller.codeslider') => '{{W name="sliderBootstrap" imagesBucket="slider-'.$page->id.'"}}'
		);
		
		$form->add('HTML','<div class="tab-pane" id="tabContent6"><table class="table table-striped tablesort">');
		foreach ($infoValues as $key => $info){
			$form->add('HTML',"<tr><td>{$key}</td><td><strong>{$info}</strong></td></tr>");		
		}	
		$form->add('HTML','</table></div>');
		
		
		$form->add('HTML','</div>');
		$ajaxUrl = HOME.'admin/content/pages/editSuccess/'.$this->request->getVariable('id').'/';

		$form->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary', null, 'data-loading-text="<i class=\'fa fa-refresh  icon-button\'></i>'.lang::read('form.button.title.save').'"', 'fa fa-upload ');
		$form->addButton('images',lang::read('form.button.title.images'),"btn btn-margin-left","#modal",'data-toggle="modal" data-target="#imagesModal"', 'fa fa-picture-o');
		$form->addButton('files',lang::read('form.button.title.files'),"btn btn-margin-left","#modal",'data-toggle="modal" data-target="#filesModal"', 'fa fa-list-alt');
		$form->addButton('widgets',lang::read('form.button.title.widgets'),"btn btn-margin-left","#modal",'data-toggle="modal" data-target="#widgetsModal"', 'fa fa-bullhorn');
		$form->addButton('reload',"&nbsp","btn btn-margin-left",HOME.'admin/do/reload/','style="padding-left:12px; padding-right:2px;"', 'fa fa-refresh');
				
		$form->setHandler($this);
		$form->handle();
		
		$this->smarty->assign('contentType','edit');  
		$this->smarty->assign('form',$form);
		
		$this->pageDisplay('content');
	}
	public function editSuccess($data) {
		$pagesDB = new pagesDB();
 
		if ($_FILES['image']['error']==0) {
			image::deleteImageByBucket('main-'.$this->request->getVariable('id'));
			image::saveIncomingImage($_FILES['image'],'main-'.$this->request->getVariable('id'));
			$data['hasImage'] = 1;
		}
		if ($_FILES['icon']['error']==0) {
			image::deleteImageByBucket('icon-'.$this->request->getVariable('id'));
			image::saveIncomingImage($_FILES['icon'],'icon-'.$this->request->getVariable('id'));
			$data['hasIcon'] = 1;
		}	
		if ($_FILES['sliderimage']['error']==0) {
			image::saveIncomingImage($_FILES['sliderimage'],'slider-'.$this->request->getVariable('id'));
		}			
		
		//check that cache must be clean
		$newTagsCount = preg_match_all('/\{\{/', str_replace(HOME, '{{$HOME}}', $data['content']));
		$oldTagsCount = preg_match_all('/\{\{/', $pagesDB->get($this->request->getVariable('id'),'content'));

		if ($oldTagsCount!=$newTagsCount) {
			cache::setCleanCacheFlag();
		}
		
		$pagesDB->updatePage($data,"id={$this->request->getVariable('id')}");

		router::reload();
	}

	public function editUrl() {
		$pagesDB = new pagesDB();
		$page = $pagesDB->fetchRow("id={$this->request->getVariable('id')}");
		
		$form = new form('edit','editUrlSuccess',$_POST,'POST','form-horizontal');
		
		$form->add('content', 'input-text',lang::read('admin.content.controller.url'),$page->content,array('editorType'=>'basic'));
		$form->addRule('content', 'required', null,lang::read('admin.content.controller.giveelementname'));	
		$form->addRule('content', 'url', null,lang::read('admin.content.controller.givecorrecturl'));
		$form->add('name', 'input-text', lang::read('admin.content.controller.elementname'),$page->name);
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
		//icon///////
		$imagesDB = new imagesDB();
		$mainIcon = $imagesDB->getFirstByBucket('icon-'.$this->request->getVariable('id'));
		if(is_object($mainIcon)){
			$form->add('HTML',"
			<div class='control-group'>
				<label class='control-label'>
					<a href='".HOME."admin/do/content/deleteMainImage/icon-{$this->request->getVariable('id')}/'><i class='fa fa-times-circle icon-red'>&nbsp;</i></a>
				</label>
				<div class='controls'>
					<img src='".HOME."image/{$mainIcon->ekey}/200/150/fit/'>
				</div>
			</div>");
		}		
		$form->add('icon', 'input-file',lang::read('admin.content.controller.icon'),null,array("tooltip" => lang::read('admin.content.controller.icondescription')));	
				
					
		$form->setHandler($this);
		$form->handle();
		
		$this->smarty->assign('contentType','form');  
		$this->smarty->assign('form',$form);		
		$this->pageDisplay('content');
	}
	public function editUrlSuccess($data) {
		$pagesDB = new pagesDB();
		$page = $pagesDB->updatePage($data,"id={$this->request->getVariable('id')}");
		if ($_FILES['icon']['error']==0) {
			image::deleteImageByBucket('icon-'.$this->request->getVariable('id'));
			image::saveIncomingImage($_FILES['icon'],'icon-'.$this->request->getVariable('id'));
		}			
		router::reload();
	}
    public function addLang() {
        $formLang = new form('addLang','addLangSuccess',$_POST,'POST','form-vertical');
        $formLang->add('name', 'autocompleteSelect',lang::read('admin.content.controller.newlangname'),null,array("option"=>generate::languagesArray()));
        $formLang->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
        $formLang->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary', null, null, 'fa fa-plus ');
        $formLang->setHandler($this);
        $formLang->handle();

        $this->smarty->assign('formAddLang',$formLang);
        $this->pageDisplay('content');
    }
    public function addLangSuccess($data) {
        $pagesDB = new pagesDB();
        $pagesDB->addLang($data);
        router::reload();
    }
    public function editLang() {
		$pagesDB = new pagesDB();
		$lang = $pagesDB->fetchRow();
		$formLang = new form('editLang','editLangSuccess',$_POST,'POST','form-horizontal no-margin');
		$formLang->setMenuFloating();
		$formLang->add('content', 'textareaCodeMirrorEditor',null,file_get_contents(LANGUAGES_PATH.strtolower($this->request->getVariable('id')).'/'.$this->request->getVariable('secoundId')));
		
		$formLang->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary', null, null, 'fa fa-upload ');
		
		$formLang->addButton('cancel',lang::read('form.button.title.cancel'),'btn btn-margin-left',HOME.'admin/content/pages/',null,'fa fa-ban');
		$formLang->setHandler($this);
		$formLang->handle();	
		
		$this->smarty->assign('formEditLang',$formLang);	
		$this->pageDisplay('content');
	}	
	public function editLangSuccess($data) {
		$data['content']=str_replace("'", "&apos;", $data['content']);
		baseFile::saveFile(LANGUAGES_PATH.strtolower($this->request->getVariable('id')).'/'.$this->request->getVariable('secoundId'), $data['content']);
		cache::clearBucket('lang');
		router::reload();
	}	
	public function editImage() {
		$imagesDB = new imagesDB();
		$image = $imagesDB->fetchRow("id={$this->request->getVariable('id')}");
		$form = new form('edit','editImageSuccess',$_POST,'POST','form-horizontal');

		$form->add('name', 'input-text',lang::read('admin.content.controller.name'),$image->name);
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));		
		$form->add('url', 'input-text',lang::read('admin.content.controller.url'),$image->url);
		//$form->addRule('url', 'url', null,lang::read('admin.content.controller.url'));	
		$form->add('description', 'textareaCKEditor','',$image->description,array('editorType'=>'minimal_source'));
		
		$form->setHandler($this);
		$form->handle(); 
		 
		$this->smarty->assign('contentType','image');  
		$this->smarty->assign('form',$form);
		$this->smarty->assign('image',$image);		
		$this->pageDisplay('content');
	}	
	public function editImageSuccess($data) {
		$imagesDB = new imagesDB();
		$image = $imagesDB->updateRow($data,"id={$this->request->getVariable('id')}");
		router::reload();
	}	

	public function addWatermark() {
		$form = new form('addWatermarks','addWatermarkSuccess',$_POST,'POST','form-horizontal');
				
		$form->add('image', 'input-file',lang::read('admin.content.controller.watermark'),null);
		
		$form->add('width', 'input-text',lang::read('admin.content.controller.width'),config::get("imgWatermarkWidth"));
		$form->addRule('width', 'numeric', null,lang::read('admin.content.controller.giveelementname'));
		$form->addRule('width', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->add('transparent', 'input-text',lang::read('admin.content.controller.transparent'),config::get("imgWatermarkTransparent"));
		$form->addRule('transparent', 'numeric', null,lang::read('admin.content.controller.giveelementname'));
		$form->addRule('transparent', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$form->add('position', 'select',lang::read('admin.content.controller.position'),config::get("imgWatermarkPosition"),array('option' => array("left top"=>"top left","left bottom"=>"bottom left","center center"=>"center","right top"=>"top right","right bottom"=>"bottom right")));
				
		$form->add('widthLimit', 'input-text',lang::read('admin.content.controller.widthlimit.small'),config::get("imgWatermarkWidthLimit"),array("tooltip" => lang::read('admin.content.controller.widthlimit')));
		$form->addRule('widthLimit', 'numeric', null,lang::read('admin.content.controller.giveelementname'));
		$form->addRule('widthLimit', 'required', null,lang::read('admin.content.controller.giveelementname'));		
		
		$form->add('heightLimit', 'input-text',lang::read('admin.content.controller.heightlimit.small'),config::get("imgWatermarkHeightLimit"),array("tooltip" => lang::read('admin.content.controller.heightlimit')));
		$form->addRule('heightLimit', 'numeric', null,lang::read('admin.content.controller.giveelementname'));
		$form->addRule('heightLimit', 'required', null,lang::read('admin.content.controller.giveelementname'));	
		
		$form->add('imgwatermark', 'select',lang::read('admin.content.controller.watermarkstatus'),config::get("imgWatermark"),array('option' => array("1"=>lang::read('admin.content.controller.watermarkactive'),"0"=>lang::read('admin.content.controller.watermarkinactive'))));
			
		$form->setHandler($this);
		$form->handle();

		$imagesDB = new imagesDB();
		$image = $imagesDB->fetchRow(null,"size DESC");		
		
		$this->smarty->assign('imagePatternWatermark',$image);
		$this->smarty->assign('formAddWatermark',$form);
		$this->smarty->assign('watermarkImg',DATA_PATH."files/watermark.png");
		$this->smarty->assign('watermarkImgUrl',HOME."data/files/watermark.png");
		$this->pageDisplay('content');
	}
	public function addWatermarkSuccess($data) {
		$plik_tmp = $_FILES['image']['tmp_name'];
		
		config::set("imgWatermarkWidth", $data['width']);
		config::set("imgWatermarkTransparent", $data['transparent']);
		config::set("imgWatermarkPosition", $data['position']);
		config::set("imgWatermark", $data['imgwatermark']);
		config::set("imgWatermarkWidthLimit", $data['widthLimit']);
		config::set("imgWatermarkHeightLimit", $data['heightLimit']);
				
		if(is_uploaded_file($plik_tmp)) {
			move_uploaded_file($plik_tmp, DATA_PATH."files/watermark.png"); 
		} 
		image::deleteImageThumbsAll();
				
		router::reload();
	}	
	
	public function gallery() {
		$this->smarty->assign('contentType','gallery'); 
		$this->pageDisplay('content');
	}	
	public function news() {
		$pagesDB = new pagesDB();
		$news = $pagesDB->fetchAll("parentId = {$this->request->getVariable('id')} and status = ".pagesDB::STATUS_ACTIVE,'position ASC');
		
		$form = new form('addnews','addNewsSuccess',$_POST,'POST','form-horizontal no-margin');
		$form->add('HTML','<br>');
		$form->add('content', 'textareaCKEditor','',null,array('editorType'=>'normal'));
		$form->add('HTML','<br>');
		$form->add('name', 'input-text', lang::read('admin.content.controller.newstitle'));
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$form->add('image', 'input-file',lang::read('admin.content.controller.image'),null,array("tooltip" => lang::read('admin.content.controller.imagedescription')));	
		$form->add('tags', 'input-text',lang::read('admin.content.controller.tags'),null,array("class" => "span8","tooltip" => lang::read('admin.content.controller.sitetags')));		
		$form->add('date', 'inputDataPicker',lang::read('admin.content.controller.date'),strtotime('now'),array("tooltip" => lang::read('admin.content.controller.datedescription')));
		
		$form->add('tpl', 'select',lang::read('admin.content.controller.template2'),$pagesDB->get($this->request->getVariable('id'), 'defaultTpl'),array('option' => themesDB::getViewsArray(),"tooltip" => lang::read('admin.content.controller.chosentemplate')));

		$form->setHandler($this);
		$form->handle();

		$form->addButton('submit',lang::read('admin.content.controller.addnews'),'btn btn-primary', null, null, 'fa fa-plus ');
		
		$this->smarty->assign('form',$form);
		
		$this->smarty->assign('newsAll',$news); 
		$this->smarty->assign('contentType','news'); 
		$this->pageDisplay('content');
	}
		
	public function addNewsSuccess($data) {
		
		$pagesDB = new pagesDB();
		$data = array_merge($data,array('parentId'=>$this->request->getVariable('id'),'type' => pagesDB::TYPE_NEWS));
		$pagesDB->insert($data);
		$news = $pagesDB->fetchRow("parentId = {$this->request->getVariable('id')}",'updateTime DESC'); 
		
		if ($_FILES['image']['error']==0){
			image::deleteImageByBucket('main-'.$news->id);
			image::saveIncomingImages('main-'.$news->id);
			$pagesDB->set($news->id, 'hasImage', 1);
		}
		
		router::reload();
	}	
	public function editConfig() {
		parent::editConfig();
		$this->pageDisplay('content');
	}
	

	//////////////////////////////////////////////////////////////////////
	//Files///////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////		
	
	public function editFile() {
		$filesDB = new filesDB();
		$file = $filesDB->fetchRow("id={$this->request->getVariable('id')}");
		
		$form = new form('editFile','editFileSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.elementname'),$file->name);
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$form->add('file', 'input-file',lang::read('admin.tools.controller.file'),null,array("tooltip" => lang::read('admin.tools.controller.filedescription')));

		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formEditFile',$form);
		$this->smarty->assign('showFilesLimit',1000);

		$this->pageDisplay('content');
	}
	public function editFileSuccess($data) {
		$filesDB = new filesDB();
		$filesDB->set($this->request->getVariable('id'),'name',$data['name']);
		
		if ($_FILES['file']['error']==0) {
			file::updateFile($this->request->getVariable('id'),$_FILES['file'],$data);
		}
		router::reload();
	}	
	
	public function showAllFiles() {
		$this->smarty->assign('showFilesLimit',1000);
		$this->pageDisplay('content');
	}	
	
	
	//////////////////////////////////////////////////////////////////////
	//Images//////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////	
	public function showAllImages() {
		$this->smarty->assign('showImagesLimit',1000);
		$this->pageDisplay('content');
	}	
	public function editImageAll() {
		$imagesDB = new imagesDB();
		
		$image = $imagesDB->fetchRow("id={$this->request->getVariable('id')}");

		$form = new form('add','editImageAllSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.elementname'),$image->name);
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$form->add('file', 'input-file',lang::read('admin.tools.controller.newimage'),null,array("tooltip" => lang::read('admin.tools.controller.filedescription')));
		$form->add('description', 'textareaCKEditor','',$image->description,array('editorType'=>'minimal_source'));
			
		$form->setHandler($this);
		$form->handle();
		
		$this->smarty->assign('image',$image);
		$this->smarty->assign('formEditImage',$form);
		$this->smarty->assign('showImagesLimit',1000);

		$this->pageDisplay('content');
	}
	public function editImageAllSuccess($data) {
		$imagesDB = new imagesDB();
		$imagesDB->set($this->request->getVariable('id'),'name',$data['name']);
		$imagesDB->set($this->request->getVariable('id'),'description',$data['description']);
		if ($_FILES['file']['error']==0) {
			
			image::updateImage($this->request->getVariable('id'),$_FILES['file'],$data);
		}
		router::reload();
	}	
	
	
	
	////////////////////////////////
	/////Banners////////////////////
	////////////////////////////////	
	
	public function addBannersArea() {
		$bannerAreaAddForm = new form('bannerAreaAdd','addBannersAreaSuccess',$_POST,'POST','form-horizontal');
		$bannerAreaAddForm->add('name', 'input-text',lang::read('admin.tools.controller.banners.name'));
		$bannerAreaAddForm->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$bannerAreaAddForm->add('width', 'input-text',lang::read('admin.tools.controller.banners.width'));
		$bannerAreaAddForm->addRule('width', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$bannerAreaAddForm->addRule('width', 'numeric', null,lang::read('validator.number'));
		$bannerAreaAddForm->add('height', 'input-text',lang::read('admin.tools.controller.banners.height'));
		$bannerAreaAddForm->addRule('height', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$bannerAreaAddForm->addRule('height', 'numeric', null,lang::read('validator.number'));
		
		$bannerAreaAddForm->setHandler($this);
		$bannerAreaAddForm->handle();
		$this->smarty->assign('bannerAreaForm',$bannerAreaAddForm);
		$this->pageDisplay('content');
	}
	public function addBannersAreaSuccess($data) {
		$bannersareaDB = new bannersareasDB();
		$bannersareaDB->add($data);
		router::reload();
	}	
	public function editBannerArea() {
		$bannerAreaDB = new bannersareasDB();
		$bannerArea = $bannerAreaDB->fetchRow("id={$this->request->getVariable('id')}");
		
		$bannerAreaEditForm = new form('bannerAreaEdit','editBannerAreaSuccess',$_POST,'POST','form-horizontal');
		$bannerAreaEditForm->add('name', 'input-text',lang::read('admin.tools.controller.banners.name'),$bannerArea->name);
		$bannerAreaEditForm->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$bannerAreaEditForm->add('width', 'input-text',lang::read('admin.tools.controller.banners.width'),$bannerArea->width);
		$bannerAreaEditForm->addRule('width', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$bannerAreaEditForm->addRule('width', 'numeric', null,lang::read('validator.number'));
		$bannerAreaEditForm->add('height', 'input-text',lang::read('admin.tools.controller.banners.height'),$bannerArea->height);
		$bannerAreaEditForm->addRule('height', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$bannerAreaEditForm->addRule('height', 'numeric', null,lang::read('validator.number'));
		
		$bannerAreaEditForm->setHandler($this);
		$bannerAreaEditForm->handle();
		$this->smarty->assign('bannerAreaForm',$bannerAreaEditForm);
		$this->pageDisplay('content');
	}
	public function editBannerAreaSuccess($data) {
		$bannersareaDB = new bannersareasDB();
		$bannersareaDB->update($data,$this->request->getVariable('id'));
		router::reload();
	}		
	
	public function addBanner() {
		$bannerAddForm = new form('bannerAdd','addBannerSuccess',$_POST,'POST','form-horizontal');
		$bannerAddForm->add('name', 'input-text',lang::read('admin.tools.controller.banners.bannername'));
		$bannerAddForm->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$bannerAddForm->add('bannerFile', 'input-file',lang::read('admin.content.controller.image'),null,array("tooltip" => lang::read('admin.content.controller.imagedescription')));	
		$bannerAddForm->addRule('bannerFile', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$bannerAddForm->add('link', 'input-text',lang::read('admin.tools.controller.banners.link'));
		$bannerAddForm->addRule('link', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$bannerAddForm->addRule('link', 'url', null,lang::read('admin.content.controller.givecorrecturl'));
		
				
		$bannerAddForm->add('viewsLimit', 'input-text',lang::read('admin.tools.controller.banners.viewslimit'));
		$bannerAddForm->addRule('viewsLimit', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$bannerAddForm->addRule('viewsLimit', 'numeric', null,lang::read('validator.number'));
		
		$bannerAddForm->add('clicksLimit', 'input-text',lang::read('admin.tools.controller.banners.clickslimit'));
		$bannerAddForm->addRule('clicksLimit', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$bannerAddForm->addRule('clicksLimit', 'numeric', null,lang::read('validator.number'));
		
		$bannerAddForm->add('startDate', 'InputDataTimePicker',lang::read('admin.tools.controller.banners.startdate'));
		$bannerAddForm->addRule('startDate', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$bannerAddForm->add('endDate', 'InputDataTimePicker',lang::read('admin.tools.controller.banners.enddate'));
		$bannerAddForm->addRule('endDate', 'required', null,lang::read('admin.content.controller.giveelementname'));		
		
		$bannerAddForm->setHandler($this);
		$bannerAddForm->handle();
		$this->smarty->assign('bannerForm',$bannerAddForm);
		$this->pageDisplay('content');
	}
	public function addBannerSuccess($data) {
		$bannersDB = new bannersDB();
		$banner = $bannersDB->add($data,$this->request->getVariable('id'));
		unset($data);
		if ($_FILES['bannerFile']['error']==0) {
			file::deleteFileByBucket('banners-'.$banner->id);
			$file = file::saveIncomingFile($_FILES['bannerFile'],'banners-'.$banner->id);
			$data['fileEkey'] = $file['ekey'];
		}	
		$bannersDB->updateRow($data,"id={$banner->id}");		
		
		router::reload();
	}	
	public function editBanner() {
		$bannersDB = new bannersDB();
		$banner = $bannersDB->fetchRow("id={$this->request->getVariable('id')}");
		
		$bannerEditForm = new form('bannerEdit','editBannerSuccess',$_POST,'POST','form-horizontal');
		$bannerEditForm->add('name', 'input-text',lang::read('admin.tools.controller.banners.bannername'),$banner->name);
		$bannerEditForm->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$bannerEditForm->add('bannerFile', 'input-file',lang::read('admin.content.controller.image'),null,array("tooltip" => lang::read('admin.content.controller.imagedescription')));	
		
		
		$bannerEditForm->add('link', 'input-text',lang::read('admin.tools.controller.banners.link'),$banner->link);
		$bannerEditForm->addRule('link', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$bannerEditForm->addRule('link', 'url', null,lang::read('admin.content.controller.givecorrecturl'));
				
		$bannerEditForm->add('viewsLimit', 'input-text',lang::read('admin.tools.controller.banners.viewslimit'),$banner->viewsLimit);
		$bannerEditForm->addRule('viewsLimit', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$bannerEditForm->addRule('viewsLimit', 'numeric', null,lang::read('validator.number'));
		
		$bannerEditForm->add('clicksLimit', 'input-text',lang::read('admin.tools.controller.banners.clickslimit'),$banner->clicksLimit);
		$bannerEditForm->addRule('clicksLimit', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$bannerEditForm->addRule('clicksLimit', 'numeric', null,lang::read('validator.number'));
		
		$bannerEditForm->add('cookieCheck', 'select','Sposób zliczania',$banner->cookieCheck,array('option'=>array('1'=>'unikalne odsłony','0'=>'wszystkie odsłony')));
		
		$bannerEditForm->add('startDate', 'InputDataPicker',lang::read('admin.tools.controller.banners.startdate'),$banner->startDate);
		$bannerEditForm->addRule('startDate', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$bannerEditForm->add('endDate', 'InputDataPicker',lang::read('admin.tools.controller.banners.enddate'),$banner->endDate);
		$bannerEditForm->addRule('endDate', 'required', null,lang::read('admin.content.controller.giveelementname'));	
		
		$bannerEditForm->setHandler($this);
		$bannerEditForm->handle();
		$this->smarty->assign('bannerForm',$bannerEditForm);
		$this->pageDisplay('content');
	}
	public function editBannerSuccess($data) {
		$bannerDB = new bannersDB();

		if ($_FILES['bannerFile']['error']==0) {
			file::deleteFileByBucket('banners-'.$this->request->getVariable('id'));
			$file = file::saveIncomingFile($_FILES['bannerFile'],'banners-'.$this->request->getVariable('id'));
			$data['fileEkey'] = $file['ekey'];
		}	
		$bannerDB->updateRow($data,"id={$this->request->getVariable('id')}");
				
		router::reload();
	}	

	
	////////////////////////////////
	/////Poll///////////////////////
	////////////////////////////////		
	public function addPoll() {
		$form = new form('formAddPoll','addPollSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.name'));
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->add('description', 'textarea',lang::read('admin.content.controller.desc'));
		$form->addRule('description', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->add('startTime', 'inputDataTimePicker',lang::read('admin.tools.controller.beginingtime'),generate::sqlDate());
		$form->add('endTime', 'inputDataTimePicker',lang::read('admin.tools.controller.endtime'),generate::sqlDate(strtotime("+14days")));
		
		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formAddPoll',$form);
		$this->pageDisplay('content');
	}	
	public function addPollSuccess($data) {
		$pollsDB = new pollsDB();
		$pollsDB->add($data);
		router::reload();
	}	
	
	public function editPoll() {
		$pollDB = new pollsDB();
		$poll = $pollDB->fetchRow("id={$this->request->getVariable('id')}");
		
		$form = new form('formAddPoll','editPollSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.name'),$poll->name);
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->add('description', 'textarea',lang::read('admin.content.controller.desc'),$poll->description);
		$form->addRule('description', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->add('startTime', 'inputDataTimePicker',lang::read('admin.tools.controller.beginingtime'),$poll->startTime);
		$form->add('endTime', 'inputDataTimePicker',lang::read('admin.tools.controller.endtime'),$poll->endTime);
		
		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formAddPoll',$form);
		$this->pageDisplay('content');
	}		
	public function editPollSuccess($data) {
		$pollsDB = new pollsDB();
		$pollsDB->updateRow($data,"id={$this->request->getVariable('id')}");
		router::reload();
	}	
	
	public function addQuestionsPoll() {
		$form = new form('formQuestionPoll','addQuestionsPollSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.name'));
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->add('description', 'textarea',lang::read('admin.content.controller.desc'));
		$form->addRule('description', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->setHandler($this);
		$form->handle();
		$this->smarty->assign('showQuestionList',1);		
		$this->smarty->assign('formQuestionPoll',$form);
		$this->pageDisplay('content');
	}
	public function addQuestionsPollSuccess($data) {
		$data['pollId'] = $this->request->getVariable('id');
		$questionsDB = new pollQuestionsDB();
		$questionsDB->add($data);
		router::reload();
	}
	public function editQuestionsPoll() {
		$questionDB = new pollQuestionsDB();
		$question = $questionDB->fetchRow("id={$this->request->getVariable('secoundId')}");			
		
		$form = new form('formQuestionPoll','editQuestionsPollSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.name'),$question->name);
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->add('description', 'textarea',lang::read('admin.content.controller.desc'),$question->description);
		$form->addRule('description', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->setHandler($this);
		$form->handle();
		$this->smarty->assign('showQuestionList',1);		
		$this->smarty->assign('formQuestionPoll',$form);
		$this->pageDisplay('content');
	}
	public function editQuestionsPollSuccess($data) {
		$questionsDB = new pollQuestionsDB();
		$questionsDB->updateRow($data,"id={$this->request->getVariable('secoundId')}");
		router::reload();
	}	

	public function showPoll() {
	 	if ($this->request->getVariable('id')!=''){
	 		$where = 'questionId in('.pollsDB::getCommaArrayQuestions($this->request->getVariable('id')).')';
	 	}else{
	 		$where=null;
	 	}
	 	$this->smarty->assign('pollChartWhere',$where);
		$this->pageDisplay('content');
	}	
	
	////////////////////////////////
	/////Calendar///////////////////
	////////////////////////////////		
	public function addCalendar() {
		$form = new form('formAddCalendar','addCalendarSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.name'));
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formCalendar',$form);
		$this->pageDisplay('content');
	}	
	public function addCalendarSuccess($data) {
		$calendarDB = new calendarDB();
		$calendarDB->add($data);
		router::reload();
	}	
	
	public function editCalendar() {
		$calendarDB = new calendarDB();
		$calendar = $calendarDB->fetchRow("id={$this->request->getVariable('id')}");
		
		$form = new form('formEditCalendar','editCalendarSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.name'),$calendar->name);
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formCalendar',$form);
		$this->pageDisplay('content');
	}		
	public function editCalendarSuccess($data) {
		$calendarDB = new calendarDB();
		$calendarDB->updateRow($data,"id={$this->request->getVariable('id')}");
		router::reload();
	}	
	
	public function addCalendarEvent() {
		$form = new form('formCalendarEvent','addCalendarEventSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.name'));
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->add('description', 'input-text',lang::read('admin.content.controller.desc'));
		$form->addRule('description', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->add('date', 'inputDataTimePicker',lang::read('admin.tools.controller.beginingtime'));
		$form->addRule('date', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->setHandler($this);
		$form->handle();
	
		$this->smarty->assign('formCalendarEvent',$form);
		$this->pageDisplay('content');
	}
	public function addCalendarEventSuccess($data) {
		$data['calendarId'] = $this->request->getVariable('id');
		$calendarEventsDB = new calendarEventsDB();
		$calendarEventsDB->add($data);
		router::reload();
	}
	public function editCalendarEvent() {
		$calendarEventsDB = new calendarEventsDB();
		$calendar = $calendarEventsDB->fetchRow("id={$this->request->getVariable('id')}");			
		
		$form = new form('formEditCalendarEvent','editCalendarEventSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.name'),$calendar->name);
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->add('description', 'input-text',lang::read('admin.content.controller.desc'),$calendar->description);
		$form->addRule('description', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->add('date', 'inputDataTimePicker',lang::read('admin.tools.controller.beginingtime'),$calendar->date);
		$form->addRule('date', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$form->setHandler($this);
		$form->handle();
		$this->smarty->assign('calendarId',$calendar->calendarId);
		$this->smarty->assign('formCalendarEvent',$form);
		$this->pageDisplay('content');
	}
	public function editCalendarEventSuccess($data) {
		$calendarEventsDB = new calendarEventsDB();
		$calendarEventsDB->updateRow($data,"id={$this->request->getVariable('id')}");
		router::reload();
	}	

	public function showCalendar() {
	 	$this->smarty->assign('showCalendarId',$this->request->getVariable('id'));
		$this->pageDisplay('content');
	}	
	public function showAutosave() {
	 	$this->smarty->assign('showAutosaveId',$this->request->getVariable('id'));
		$this->pageDisplay('content');
	}		
}
?>
