<?php /*windu.org admin controller*/
Class adminAuthDoController extends controller
{	
	public function __construct(request $request, $plugins = array())
	{
		$usersDB = new usersDB();
		if(!$usersDB->authCheck(get_class($this),'AdminUser')){
			router::redirect('admin-login');
			exit;
		}
		$this->user = $usersDB->getLoggedIn();
		parent::__construct($request);
	}	
}
?>