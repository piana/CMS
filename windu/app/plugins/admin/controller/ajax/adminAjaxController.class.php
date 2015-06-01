<?php /*windu.org admin controller*/
Class adminAjaxController extends adminAuthController
{	
	public function __construct(request $request, $plugins = array())
	{
		parent::__construct($request);
	}	
	function smartyGo()
	{
		parent::smartyGo();
		$this->smarty->template_dir = array(__SITE_PATH . '/app/plugins/admin/templates/',
											__SITE_PATH . '/app/plugins/admin/templates/ajax/');
		$this->smarty->assign('usersDB',$this->usersDB);									
		$this->smarty->assign('loggedIn',$this->user);									
	}	
	public function pageDisplay($tpl)
	{
		$this->smarty->assign('page_content',$tpl.'.tpl');
		$this->smarty->display('mainAjax.tpl');
	}		
	public function index(){}
}
?>
