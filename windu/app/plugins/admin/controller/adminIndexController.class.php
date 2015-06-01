<?php /*windu.org admin controller*/
Class adminIndexController Extends adminMainController {

	public function index()
	{
		$this->smarty->assign('systemStatusDB',new systemStatusDB());	
		$this->smarty->assign('logDB',new logDB());	
		$this->pageDisplay('index');
	}

}

?>
