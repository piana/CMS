<?php /*windu.org admin controller*/
Class adminCreatorController extends adminMainController
{	
	public function index()
	{	
		$this->smarty->assign('load','10');	
		$this->smarty->assign('title','Wybierz typ strony jaką chcesz stworzyć');			
		$this->pageDisplayHook('creator.tpl','mainSimple.tpl');
	}
	public function selectTemplate()
	{	
		config::set('creatorSiteType', $this->request->getVariable('id'));
		//themes list from server
		if (cache::isCached('addonsServerThemes',3600*24)) {
			$themesFromAddonsServer = cache::read('addonsServerThemes');
		}else{
			$themesFromAddonsServer = unserialize(baseFile::getExternalFileContent(ADDONS_SERVER_DATA.'getThemes/'));
			cache::write('addonsServerThemes', $themesFromAddonsServer);
		}		

		$this->smarty->assign('themesFromAddonsServer',$themesFromAddonsServer);			
		$this->smarty->assign('load','35');	
		$this->smarty->assign('title','Wybierz template strony');			
		$this->pageDisplayHook('creator.tpl','mainSimple.tpl');
	}
	public function editImages()
	{	
		//Form images	
		$form = new form('add','addImgSuccess',$_POST,'POST','form-horizontal');
		$counter = 0;
		foreach (themesDB::getThemeImagesList(TEMPLATES_PATH.config::get('template').'/img/') as $image){
			$counter = $counter + 1;
			$form->add('HTML','
				<div class="themeImagesBox imgMedium">
					<img src="'.HOME.$image->pathSimple.'?ver='.microtime().'"><br>
					<span class="badge badge-inverse">'.$image->name.'</span>');
			$inputName = 
			$form->add('image'.$counter, 'input-file','',null,array("class" => "span8","tooltip" => lang::read('admin.themes.controller.imagedescription')));	
			$form->addRule('image'.$counter, 'fileType', array('jpg','png','gif','jpeg'), lang::read('admin.content.controller.wrongfiletype'));
			$form->addRule('image'.$counter, 'fileSize', array(0,2000000), lang::read('admin.content.controller.filetolarge'));
			$form->add('name'.$counter, 'input-hidden','',$image->name);	
			$form->add('HTML','</div>');
		}
		
		$form->addButton('submit','Zapisz','btn btn-inverse',null,null,'fa fa-upload');	
		$form->setHandler($this);
		$form->handle();			
		$this->smarty->assign('imagesForm',$form);	
		$this->smarty->assign('load','70');	
		$this->smarty->assign('title','Dodaj logo oraz obrazki templata');			
		$this->pageDisplayHook('creator.tpl','mainSimple.tpl');
	}	
	public function addImgSuccess($data) {
		foreach ($_FILES as $key => $image){
			if ($image['error']==0) {
				$keyNumPom = str_replace('image', '', $key);
				$image['name'] = $data['name'.$keyNumPom];
				baseFile::uploadTo(TEMPLATES_PATH.themesDB::getThemeName().'/img/', $image);
			}
		}
		router::back($this->request);
	}	
	//TODO
	public function addPages()
	{	
		$this->smarty->assign('pagesDB',new pagesDB());
		$this->smarty->assign('load','75');	
		$this->smarty->assign('title','Dodaj podstrony');			
		$this->pageDisplayHook('creator.tpl','mainSimple.tpl');
	}
	public function finish()
	{	
		$this->smarty->assign('load','100');	
		$this->smarty->assign('title','Zobacz stronę!');			
		$this->pageDisplayHook('creator.tpl','mainSimple.tpl');
	}					
}
?>
