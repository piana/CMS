<?php /*windu.org admin controller*/
Class adminAjaxFilesController Extends adminAjaxController{
	public function __construct($request){
		parent::__construct($request);
	}
	public function index()
	{	
		
	}	
	public function modalUploader()
	{	
		$filesDB = new filesDB();
		$files = $filesDB->getByBucket($this->request->getVariable('id'));
		$this->smarty->assign('files',$files);	
		$this->pageDisplay('filesModal');
	}

}
?>
