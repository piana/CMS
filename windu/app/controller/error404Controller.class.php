<?php /*windu.org front controller*/

Class error404Controller Extends htmlController {
	function smartyGo()
	{
		parent::smartyGo();
		$this->smarty->template_dir = array(__SITE_PATH . '/app/templates/');
	}	
	public function index()
	{
		router::get404Redirect(__HOME);
		log::write(__HOME,logDB::BUCKET_404);
		$this->pageDisplay('error404.tpl');
	}
}
?>
