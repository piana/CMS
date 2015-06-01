<?php /*windu.org admin controller*/

Class adminFrontEditorController Extends adminAuthController{
	public function __construct($request){
		parent::__construct($request);
	}
	
	function smartyGo()
	{
		parent::smartyGo();
		$this->smarty->template_dir = array(__SITE_PATH . '/app/plugins/admin/templates/');
		$this->smarty->left_delimiter = "{{";
		$this->smarty->right_delimiter = "}}";
											
		$this->smarty->assign('usersDB',$this->usersDB);									
		$this->smarty->assign('loggedIn',$this->user);		
		$this->smarty->assign('now',generate::sqlDatetime());		
		
		$template = themesDB::getThemeName();
		$homeTemplate = str_replace(__SITE_PATH.'/', HOME, TEMPLATES_PATH);
		$this->smarty->assign('TEMPLATE_HOME',$homeTemplate.$template);
		$this->smarty->assign('TEMPLATE_PATH',TEMPLATES_PATH.$template.'/');
		$this->smarty->assign('TEMPLATE_IMG_PATH',TEMPLATES_PATH.$template.'/img/');						
	}	

	public function show()
	{	
		$form = new form('add','addImgSuccess',$_POST,'POST','form-horizontal');
		$form->add('image', 'input-file','',null,array("class" => "span8","tooltip" => lang::read('admin.themes.controller.imagedescription')));	
		$form->addRule('image', 'fileType', array('jpg','png','gif','jpeg'), lang::read('admin.content.controller.wrongfiletype'));
		$form->addRule('image', 'fileSize', array(0,2000000), lang::read('admin.content.controller.filetolarge'));

		
		$form->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus ');	
		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formAddImage',$form);	

		$form = new form("form",'saveConfigSuccess',$_POST,'POST','form-horizontal');
		foreach (config::getByPrefix('imgGallery') as $config) {
			$form->add($config->name, 'input-text',$config->name,$config->value,array("tooltip" => lang::read($config->shortDescription)));
			$form->addRule($config->name, 'required', null, lang::read('admin.config.controller.addvalue'));	
			$form->addRule($config->name, $config->type, null, lang::read('admin.config.controller.addvalue'));
			$form->add('HTML','<hr>');
		}		

		$form->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary', null, null, 'fa fa-upload ');	
		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign("configGalerryForm",$form);		

		
		$form = new form("form",'saveConfigSuccess',$_POST,'POST','form-horizontal');
		foreach (config::getByPrefix('news') as $config) {
			$form->add($config->name, 'input-text',$config->name,$config->value,array("tooltip" => lang::read($config->shortDescription)));
			$form->addRule($config->name, 'required', null, lang::read('admin.config.controller.addvalue'));	
			$form->addRule($config->name, $config->type, null, lang::read('admin.config.controller.addvalue'));
			$form->add('HTML','<hr>');
		}		

		$form->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary', null, null, 'fa fa-upload ');	
		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign("configNewsForm",$form);	

		$form = new form("form",'saveConfigSuccess',$_POST,'POST','form-horizontal');
		foreach (config::getByPrefix('slider') as $config) {
			$form->add($config->name, 'input-text',$config->name,$config->value,array("tooltip" => lang::read($config->shortDescription)));
			$form->addRule($config->name, 'required', null, lang::read('admin.config.controller.addvalue'));	
			$form->addRule($config->name, $config->type, null, lang::read('admin.config.controller.addvalue'));
			$form->add('HTML','<hr>');
		}

		$form->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary', null, null, 'fa fa-upload ');	
		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign("configSliderForm",$form);	

		$form = new form("form",'saveConfigSuccess',$_POST,'POST','form-horizontal');
		foreach (config::getByPrefix('img','imgGallery') as $config) {
			$form->add($config->name, 'input-text',$config->name,$config->value,array("tooltip" => lang::read($config->shortDescription)));
			$form->addRule($config->name, 'required', null, lang::read('admin.config.controller.addvalue'));	
			$form->addRule($config->name, $config->type, null, lang::read('admin.config.controller.addvalue'));
			$form->add('HTML','<hr>');
		}		

		$form->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary', null, null, 'fa fa-upload ');	
		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign("configImagesForm",$form);			
		
		$pageId = $this->request->getVariable('id');
		$pagesDB = new pagesDB();
		$page = $pagesDB->fetchRow("id={$pageId}");
		$this->smarty->assign('page',$page);
		
		$pageInfoArray = array(
			'Id' => $page->id,
			lang::read('admin.content.controller.datelastup') => generate::showDatatime($page->updateTime)
		);		
		
		$this->smarty->assign('pageInfoArray',$pageInfoArray);
		
		echo $this->smarty->fetch('frontEditor.tpl');
	}
	public function addImgSuccess($data) {
		baseFile::uploadTo(TEMPLATES_PATH.themesDB::getThemeName().'/img/', $_FILES['image']);
		router::reloadParent();
	}	
	public function saveConfigSuccess($data) {
		foreach ($data as $key => $val){
			config::set($key, $val);
		}
		router::reloadParent();
	}
	public function deleteImage() {
		$imageName = urldecode($this->request->getVariable('id'));
		baseFile::delete(TEMPLATES_PATH.themesDB::getThemeName().'/img/'.$imageName);
		router::reloadParent();
	}		
}
?>
