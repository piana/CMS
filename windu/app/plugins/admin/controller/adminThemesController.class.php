<?php /*windu.org admin controller*/
Class adminThemesController Extends adminMainConfigController{

	public function __construct(request $request)
	{
		parent::__construct($request);
	
		$configDB = new configDB();
		$config = $configDB->getByGroup(configDB::CONFIG_BUCKET_THEMES);	
		$this->smarty->assign('configList',$config);
		
		$this->smarty->assign('themes',baseFile::getFilesList(TEMPLATES_PATH,null,true));
		$this->smarty->assign('widgets',baseFile::getFilesList(WIDGET_PATH,null,true));
		$this->smarty->assign('widgetsOff',baseFile::getFilesList(WIDGET_OFF_PATH,null,true));
		//add theme form
		$formAddTheme = new form('addTheme','addThemeSuccess',$_POST,'POST','form-horizontal');
		$formAddTheme->add('name', 'input-text',lang::read('admin.themes.controller.templatename'));
		
		$formAddTheme->addRule('name', 'required', null, lang::read('admin.themes.controller.addelementname'));
		
		$formAddTheme->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus ');
		$formAddTheme->setHandler($this);
		$formAddTheme->handle();

		$formAddThemeFile = new form('addThemeFile','addThemeFileSuccess',$_POST,'POST','form-horizontal');
		$formAddThemeFile->add('zip', 'input-file',lang::read('admin.themes.controller.zip'),null,array("tooltip" => lang::read('admin.themes.controller.zipdescription')));
		$formAddThemeFile->addRule('zip', 'required', null, lang::read('admin.themes.controller.addelementname'));
		

		$formAddThemeFile->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus ');
		$formAddThemeFile->setHandler($this);
		$formAddThemeFile->handle();	
			
		$this->smarty->assign('formThemeFile',$formAddThemeFile);
		$this->smarty->assign('formTheme',$formAddTheme);

		//add widget form
		$formAddWidgetFile = new form('addWidgetFile','addWidgetFileSuccess',$_POST,'POST','form-horizontal');
		$formAddWidgetFile->add('zip', 'input-file',lang::read('admin.themes.controller.zip'),null,array("tooltip" => lang::read('admin.themes.controller.zipdescription')));
		$formAddWidgetFile->addRule('zip', 'required', null, lang::read('admin.themes.controller.addelementname'));
		$formAddWidgetFile->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus ');	
		
		$formAddWidgetFile->setHandler($this);
		$formAddWidgetFile->handle();

		
		$formAddWidget = new form('addWidget','addWidgetSuccess',$_POST,'POST','form-horizontal');
		$formAddWidget->add('name', 'input-text',lang::read('admin.themes.controller.addvalue'),null);
		$formAddWidget->addRule('name', 'required', null, lang::read('admin.themes.controller.addelementname'));
			
		$formAddWidget->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus ');	
		
		$formAddWidget->setHandler($this);
		$formAddWidget->handle();		

		$this->smarty->assign('formWidgetFile',$formAddWidgetFile);			
		$this->smarty->assign('formWidget',$formAddWidget);			

		//widgets list from server
		if (cache::isCached('addonsServerWidgets',3600*24)) {
			$widgetsFromAddonsServer = cache::read('addonsServerWidgets');
		}else{
			$serverArray = unserialize(baseFile::getExternalFileContent(ADDONS_SERVER_DATA.'getWidgets/'.config::get('language-admin').'/'));
			if (is_array($serverArray)) {
				$widgetsFromAddonsServer = array_reverse($serverArray);
			}
			cache::write('addonsServerWidgets', $widgetsFromAddonsServer,'widgets');
		}	
		
		//widgets to update
		if (cache::isCached('widgetsToUpdate',3600*24)) {
			$widgetsToUpdate = cache::read('widgetsToUpdate');
		}else{
			$widgetsToUpdate = widgetsDB::getUpdateList();
			cache::write('widgetsToUpdate', $widgetsToUpdate,'widgets');
		}	
		$this->smarty->assign('widgetsToUpdate',$widgetsToUpdate);	
		$this->smarty->assign('widgetsFromAddonsServer',$widgetsFromAddonsServer);
		$this->smarty->assign('subpage',$this->request->getVariable('subpage'));
		$this->smarty->assign('controllerShortName','themes');
	}	
	public function index()
	{			
		$this->pageDisplay('themes');
	}
	public function addThemeSuccess($data) {
		themesDB::create($data['name']);
		router::reload();
	}	
	public function addThemeFileSuccess($data) {
		if ($_FILES['zip']['error']==0) {
			
			$source = $_FILES['zip']['tmp_name'];
			$destination = TEMPLATES_PATH.rtrim($_FILES['zip']['name'],'.zip').'/';

			$counter = 2;
			while (is_dir($destination)) {
				$destination = TEMPLATES_PATH.rtrim($_FILES['zip']['name'],'.zip')."-{$counter}/";
				$counter = $counter+1;
			}				
			
			if (!is_dir($destination)) {
				baseFile::createDir($destination);
				compress::unzip($source, $destination);
				router::reload();
			}
			router::reload('admin.message.error','mn');
			
		}
		cache::setCleanCacheFlag();		
		router::reload();
	}	
	public function addWidgetSuccess($data) {
		widgetsDB::create($data['name']);
		cache::setCleanCacheFlag();	
		router::reload();
	}		
	public function addWidgetFileSuccess($data) {
		if ($_FILES['zip']['error']==0) {
			$source = $_FILES['zip']['tmp_name'];
			$destination = WIDGET_PATH.rtrim($_FILES['zip']['name'],'.zip').'/';
			
			$counter=0;
			while (is_dir($destination)) {
				$counter=$counter+1;
				$destination = WIDGET_PATH.rtrim($_FILES['zip']['name'],'.zip').'-'.$counter.'/';
			}
			if (!is_dir($destination)) {
				baseFile::createDir($destination);
				try {
					compress::unzip($source, $destination);
				} catch (Exception $e) {
					baseFile::deleteDir($destination);
					router::reload('admin.message.error','mn');
				}
				
				router::reload();
			}
			router::reload('admin.message.error','mn');
		}
		cache::setCleanCacheFlag();	
		router::reload();
	}	
	public function add() {		
		if($this->request->getVariable('tpl')=='img'){
			$form = new form('add','addImgSuccess',$_POST,'POST','form-horizontal');
			$form->add('image', 'input-file',lang::read('admin.themes.controller.image'),null,array("class" => "span8","tooltip" => lang::read('admin.themes.controller.imagedescription')));	
			$form->addRule('image', 'fileType', array('jpg','png','gif','jpeg'), lang::read('admin.content.controller.wrongfiletype'));
			$form->addRule('image', 'fileSize', array(0,2000000), lang::read('admin.content.controller.filetolarge'));
		}elseif($this->request->getVariable('tpl')=='css'){
			$form = new form('add','addCssSuccess',$_POST,'POST','form-horizontal');
			$form->add('css', 'input-file',lang::read('admin.themes.controller.css'),null,array("class" => "span8","tooltip" => lang::read('admin.themes.controller.cssdescription')));	
			$form->addRule('css', 'fileType', array('css'), lang::read('admin.content.controller.wrongfiletype'));
		}elseif($this->request->getVariable('tpl')=='js'){
			$form = new form('add','addJsSuccess',$_POST,'POST','form-horizontal');
			$form->add('js', 'input-file',lang::read('admin.themes.controller.js'),null,array("class" => "span8","tooltip" => lang::read('admin.themes.controller.jsdescription')));	
			$form->addRule('js', 'fileType', array('js'), lang::read('admin.content.controller.wrongfiletype'));	
		}else{
			$form = new form('add','addSuccess',$_POST,'POST','form-horizontal');
			$form->add('name', 'input-text',lang::read('admin.content.controller.tplfilename'));
			$form->addRule('name', 'required', null, lang::read('admin.content.controller.addelementname'));
		}
		
		$form->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus ');	
		$form->addButton('cancel',lang::read('form.button.title.cancel'),'btn btn-margin-left',HOME.'admin/themes/themes/show/'.$this->request->getVariable('theme').'/',null,'fa fa-ban');	
		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('hideFileForm',1); 
		$this->smarty->assign('formTheme',$form);	
		$this->pageDisplay('themes');
	}
	public function addWidget() {		
		if($this->request->getVariable('tpl')=='img'){
			$form = new form('add','addWidgetImgSuccess',$_POST,'POST','form-horizontal');
			$form->add('image', 'input-file',lang::read('admin.themes.controller.image'),null,array("class" => "span8","tooltip" => lang::read('admin.themes.controller.imagedescription')));	
			$form->addRule('image', 'fileType', array('jpg','png','gif','jpeg'), lang::read('admin.content.controller.wrongfiletype'));
			$form->addRule('image', 'fileSize', array(0,MAX_UPLOAD_FILE_SIZE), lang::read('admin.content.controller.filetolarge'));
		}elseif($this->request->getVariable('tpl')=='css'){
			$form = new form('add','addWidgetCssSuccess',$_POST,'POST','form-horizontal');
			$form->add('css', 'input-file',lang::read('admin.themes.controller.css'),null,array("class" => "span8","tooltip" => lang::read('admin.themes.controller.cssdescription')));	
			$form->addRule('css', 'fileType', array('css'), lang::read('admin.content.controller.wrongfiletype'));
		}elseif($this->request->getVariable('tpl')=='doc'){
			$form = new form('add','addWidgetTxtSuccess',$_POST,'POST','form-horizontal');
			$form->add('txt', 'input-file',lang::read('admin.themes.controller.doc'),null,array("class" => "span8","tooltip" => lang::read('admin.themes.controller.docdescription')));	
			$form->addRule('txt', 'fileType', array('txt'), lang::read('admin.content.controller.wrongfiletype'));			
		}elseif($this->request->getVariable('tpl')=='js'){
			$form = new form('add','addWidgetJsSuccess',$_POST,'POST','form-horizontal');
			$form->add('js', 'input-file',lang::read('admin.themes.controller.js'),null,array("class" => "span8","tooltip" => lang::read('admin.themes.controller.jsdescription')));	
			$form->addRule('js', 'fileType', array('js'), lang::read('admin.content.controller.wrongfiletype'));	
		}elseif($this->request->getVariable('tpl')=='lang'){
			$form = new form('add','addWidgetLangSuccess',$_POST,'POST','form-horizontal');
			$form->add('lang', 'input-file',lang::read('admin.themes.controller.lang'),null,array("class" => "span8","tooltip" => lang::read('admin.themes.controller.langdescription')));	
			$form->addRule('lang', 'fileType', array('lang'), lang::read('admin.content.controller.wrongfiletype'));			
		}
		
		$form->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus ');	
		$form->addButton('cancel',lang::read('form.button.title.cancel'),'btn btn-margin-left',HOME.'admin/themes/widgets/show/'.$this->request->getVariable('theme').'/',null,'fa fa-ban');	
		
		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('hideWidgetFileForm',1);
		$this->smarty->assign('formWidget',$form);	
		$this->pageDisplay('themes');
	}
	public function addImgSuccess($data) {
		baseFile::uploadTo(TEMPLATES_PATH.$this->request->getVariable('theme').'/img/', $_FILES['image']);
		router::reload();
	}	
	public function addCssSuccess($data) {
		baseFile::uploadTo(TEMPLATES_PATH.$this->request->getVariable('theme').'/css/', $_FILES['css']);
		cache::setCleanCacheFlag();	
		router::reload();
	}
	public function addJsSuccess($data) {
		baseFile::uploadTo(TEMPLATES_PATH.$this->request->getVariable('theme').'/js/', $_FILES['js']);
		cache::setCleanCacheFlag();	
		router::reload();
	}
	public function addWidgetImgSuccess($data) {
		baseFile::uploadTo(WIDGET_PATH.$this->request->getVariable('theme').'/img/', $_FILES['image']);
		router::reload();
	}	
	public function addWidgetCssSuccess($data) {
		baseFile::uploadTo(WIDGET_PATH.$this->request->getVariable('theme').'/css/', $_FILES['css']);
		cache::setCleanCacheFlag();	
		router::reload();
	}
	public function addWidgetTxtSuccess($data) {
		baseFile::uploadTo(WIDGET_PATH.$this->request->getVariable('theme').'/doc/', $_FILES['txt']);
		router::reload();
	}	
	public function addWidgetJsSuccess($data) {
		baseFile::uploadTo(WIDGET_PATH.$this->request->getVariable('theme').'/js/', $_FILES['js']);
		cache::setCleanCacheFlag();	
		router::reload();
	}			
	public function addSuccess($data) {
		$themesDB = new themesDB($this->request->getVariable('theme').'/'.$this->request->getVariable('tpl'));
		$themesDB->add($data['name']);
		cache::setCleanCacheFlag();	
		router::reload();
	}
		
	public function edit() {
		$themesDB = new themesDB($this->request->getVariable('theme'));
		$tpl = $themesDB->read($this->request->getVariable('tpldir').'/'.$this->request->getVariable('tpl'));

		$form = new form('edit','editSuccess',$_POST,'POST','no-margin no-margin-max',null,false,HOME.'admin/do/themes/editAjaxSuccess/'.$this->request->getVariable('theme').'/'.$this->request->getVariable('tpldir').'/'.$this->request->getVariable('tpl').'/');
		$form->setMenuFloating();
		
		if ($this->request->getVariable('tpldir')=='css' or $this->request->getVariable('tpldir')=='css_less') {
			$mode = 'css';
		}else{
			$mode = 'htmlmixed';
		}
		
		$form->add('themeContent', 'textareaCodeMirrorEditor',null,$tpl,array('mode' => $mode));
		
		$form->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary', null, 'data-loading-text="<i class=\'fa fa-refresh  icon-button\'></i>'.lang::read('form.button.title.save').'"', 'fa fa-upload ');
		$form->addButton('widgets',lang::read('form.button.title.widgets'),"btn btn-margin-left","#modal",'data-toggle="modal" data-target="#widgetsModal"', 'fa fa-bullhorn');
		
		$form->addButton('cancel',lang::read('form.button.title.cancel'),'btn btn-margin-left',HOME.'admin/themes/themes/show/'.$this->request->getVariable('theme').'/',null,'fa fa-ban');	
		
		$form->setHandler($this); 
		$form->handle();
		 
		$this->smarty->assign('formTheme',$form);
		$this->smarty->assign('hideFileForm',1);			
		$this->pageDisplay('themes');
	}	
	public function editSuccess($data) {
		$themesDB = new themesDB($this->request->getVariable('theme'));
		$themesDB->save($this->request->getVariable('tpldir').'/'.$this->request->getVariable('tpl'),$data['themeContent']);

		if ($this->request->getVariable('tpldir')=='css' or $this->request->getVariable('tpldir')=='css_less') {
			config::set('resourcesVersion', intval(config::get('resourcesVersion'))+1);
            cache::setCleanCacheFlag();
        }
		router::reload();
	}	
	public function editWidget() {
		$themesDB = new widgetsDB($this->request->getVariable('theme'));
		
		$tpl = $themesDB->read($this->request->getVariable('tpldir').'/'.$this->request->getVariable('tpl'));
		if ($this->request->getVariable('tpldir')!=null) {
			$tplDirPom = '/'.$this->request->getVariable('tpldir');
		}
		
		$form = new form('editWidget','editWidgetSuccess',$_POST,'POST','no-margin no-margin-max',null,false,HOME.'admin/do/themes/editAjaxWidgetSuccess/'.$this->request->getVariable('theme').$tplDirPom.'/'.$this->request->getVariable('tpl').'/');
		
		if ($this->request->getVariable('tpldir')=='css') {
			$mode = 'css';
		}elseif ($this->request->getVariable('tpldir')=='js'){
			$mode = 'javascript';
		}elseif (preg_match("/php/i",$this->request->getVariable('tpl'))){
			$mode = 'php';
		}else{
			$mode = 'htmlmixed';
		}
		
		$form->add('widgetContent', 'textareaCodeMirrorEditor',null,$tpl,array('mode' => $mode));
		
		$form->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary', null, 'data-loading-text="<i class=\'fa fa-refresh  icon-button\'></i>'.lang::read('form.button.title.save').'"', 'fa fa-upload ');
		$form->addButton('cancel',lang::read('form.button.title.cancel'),'btn btn-margin-left',HOME.'admin/themes/widgets/show/'.$this->request->getVariable('theme').'/',null,'fa fa-ban');	
		$form->setHandler($this);
		$form->handle();
		 
		$this->smarty->assign('hideWidgetFileForm',1);
		$this->smarty->assign('formWidget',$form);		
		$this->pageDisplay('themes');
	}	
	public function editWidgetSuccess($data) {
		$widgetsDB = new widgetsDB($this->request->getVariable('theme'));
		$widgetsDB->save($this->request->getVariable('tpldir').'/'.$this->request->getVariable('tpl'),$data['widgetContent']);

        adminThemesDoController::setWidgetEdited($this->request->getVariable('theme'));
        cache::setCleanCacheFlag();
        router::reload();
	}		
	public function editConfig() {
		parent::editConfig();
		$this->pageDisplay('themes');
	}	
	public function editTheme() {
		$form = new form('editTheme','editThemeSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.themes.controller.templatename'),$this->request->getVariable('theme'));
		$form->addRule('name', 'required', null, lang::read('admin.themes.controller.addelementname'));
		
		$form->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary',null,null,'fa fa-upload ');	
		$form->addButton('cancel',lang::read('form.button.title.cancel'),'btn btn-margin-left',HOME.'admin/themes/themes/show/'.$this->request->getVariable('theme').'/',null,'fa fa-ban');	
		
		$form->setHandler($this); 
		$form->handle();
		 
		$this->smarty->assign('hideFileForm',1);
		$this->smarty->assign('formTheme',$form);		
		$this->pageDisplay('themes');
	}
	public function editThemeSuccess($data) {
		$themesDB = new themesDB($this->request->getVariable('theme'));
        cache::setCleanCacheFlag();
        if ($themesDB->rename($data['name'])) {
			router::reload();
		}
		router::reload('admin.message.error','mn');
	}	

	
	public function editWidgetName() {
		$editWidgetNameform = new form('editWidgetName','editWidgetNameSuccess',$_POST,'POST','form-horizontal');
		$editWidgetNameform->add('name', 'input-text',lang::read('admin.themes.controller.templatename'),$this->request->getVariable('theme'));
		$editWidgetNameform->addRule('name', 'required', null, lang::read('admin.themes.controller.addelementname'));
		
		$editWidgetNameform->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary',null,null,'fa fa-upload ');	
		$editWidgetNameform->addButton('cancel',lang::read('form.button.title.cancel'),'btn btn-margin-left',HOME.'admin/themes/widgets/show/'.$this->request->getVariable('theme').'/',null,'fa fa-ban');	
		
		$editWidgetNameform->setHandler($this); 
		$editWidgetNameform->handle();
		 
		$this->smarty->assign('hideWidgetFileForm',1);
		$this->smarty->assign('formWidget',$editWidgetNameform);		
		$this->pageDisplay('themes');
	}
	public function editWidgetNameSuccess($data) {

		$newName = $data['name'];
		
		baseFile::rename( WIDGET_PATH.$this->request->getVariable('theme').'/'.$this->request->getVariable('theme').'Controller.class.php',
						  WIDGET_PATH.$this->request->getVariable('theme').'/'.$newName.'Controller.class.php');

		baseFile::rename( WIDGET_PATH.$this->request->getVariable('theme').'/'.$this->request->getVariable('theme').'View.tpl',
						  WIDGET_PATH.$this->request->getVariable('theme').'/'.$newName.'View.tpl');	


		$controlerContent = file_get_contents(WIDGET_PATH.$this->request->getVariable('theme').'/'.$newName.'Controller.class.php');
		$controlerContent = str_replace($this->request->getVariable('theme'), $newName, $controlerContent);	
					
		file_put_contents(WIDGET_PATH.$this->request->getVariable('theme').'/'.$newName.'Controller.class.php', $controlerContent) ; 
		
		
		baseFile::rename( WIDGET_PATH.$this->request->getVariable('theme').'/',
						  WIDGET_PATH.$newName.'/');
        cache::setCleanCacheFlag();
        router::reload();
	}	
}
?>
