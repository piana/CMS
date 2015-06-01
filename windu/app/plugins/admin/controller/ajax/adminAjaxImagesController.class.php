<?php /*windu.org admin controller*/
Class adminAjaxImagesController Extends adminAjaxController{
	public function __construct($request){
		parent::__construct($request);
	}
	public function index()
	{	
		
	}	
	public function modalUploader()
	{	
		$imagesDB = new imagesDB();
		
		$images = $imagesDB->getByBucket($this->request->getVariable('id'));
		$this->smarty->assign('images',$images);	
		$this->pageDisplay('imagesModal');
	}
	public function modalImageGenerator()
	{	
		$imagesDB = new imagesDB();
		$image = $imagesDB->getByEkey($this->request->getVariable('id'));
		$this->smarty->assign('image',$image);
		$this->pageDisplay('imageGeneratorModal');
	}	
	public function modalImageSelectUploader()
	{
		$imgUrl = urldecode(urldecode($this->request->getVariable('id')));

		$form = new form('replaceImg','replaceImgSuccess',$_POST,'POST','form-horizontal');
		
		$form->add('image', 'input-file','Wybierz obrazek');
		$form->addRule('image', 'fileType', array('jpg','png','gif','jpeg'), lang::read('admin.content.controller.wrongfiletype'));
		$form->addRule('image', 'fileSize', array(0,2000000), lang::read('admin.content.controller.filetolarge'));

		if (strpos($imgUrl,'image/')!==FALSE) {
			$form->add('type', 'input-hidden','','imageServer');
			$form->add('path', 'input-hidden','',$imgUrl);
		}else{
			$form->add('type', 'input-hidden','','template');
			$form->add('path', 'input-hidden','',$imgUrl);
		}
		
		$form->addButton('submit','Zamień obrazek','btn btn-primary',null,null,'fa fa-upload ');	
		$form->addButton('refresh','Odśwież stronę','btn btn-margin-left',HOME.'admin/do/reloadParent/',null,'fa fa-refresh');	
		$form->setHandler($this);
		$form->handle();			
		
		$this->smarty->assign('imageForm',$form);			
		$this->smarty->assign('imgUrl',$imgUrl);
		$this->pageDisplay('imageSelectModal');
	}

	public function replaceImgSuccess($data){
		if ($data['type']=='imageServer' and $_FILES['image']['error']==0) {
			$imageEkey = explode('/',$data['path']);
			$imageEkey = $imageEkey[1];

			$imagesDB = new imagesDB();
			$image = $imagesDB->getByEkey($imageEkey);
			image::updateImage($image->id,$_FILES['image']);
		}elseif($data['type']=='template' and $_FILES['image']['error']==0){
			$filePath = __SITE_PATH.'/'.$data['path'];
			baseFile::replaceFile($filePath, $_FILES['image']); 
		}
		router::back($this->request);
	}
}
?>
