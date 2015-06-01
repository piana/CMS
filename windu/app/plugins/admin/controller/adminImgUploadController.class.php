<?php /*windu.org admin controller*/
Class adminImgUploadController Extends adminMainController {

	public function index()
	{
		$data = array_merge($_POST,$_FILES);
		$form = new form('dodaj_anons','success',$data,'POST');
	
		$form->add('foto','input-file',' ');
		$form->addRule('foto', 'required', null, lang::read('admin.img.upload.controller.imagetobig'));
		$form->addRule('foto', "fileSize", array(0,0),lang::read('admin.img.upload.controller.wrongfileformat'));
		$form->addRule('foto', "fileType", array('jpg','jpeg','gif','png'),lang::read('admin.img.upload.controller.uploadimage'));
		
		$form->setHandler($this);
		$form->handle();
		
		$this->smarty->assign('form',$form);
		$this->smarty->assign('showProfile',true);
		$this->pageDisplay('imgUpload');
	}
	public function success($data)
	{
		image::saveIncomingImages();
	}	
}
?>
