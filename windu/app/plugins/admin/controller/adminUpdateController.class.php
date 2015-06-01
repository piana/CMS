<?php /*windu.org admin controller*/
Class adminUpdateController extends adminAuthController
{
	function smartyGo()
	{
		parent::smartyGo();
		$this->smarty->template_dir = array(__SITE_PATH . '/app/plugins/admin/templates/');
	}
	public function __construct($request){

		parent::__construct($request);
	}
	public function index()
	{
		$this->smarty->assign('updateMethods',adminUpdateDoController::$updateMethodsString);
		$this->pageDisplayHook('update.tpl','mainSimple.tpl');
	}
}
?>
