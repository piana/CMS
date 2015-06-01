<?php /*windu.org admin controller*/
Class adminAuthController extends htmlController
{	
	public function __construct(request $request, $plugins = array())
	{
		$this->usersDB = new usersDB();
		if(!$this->usersDB->authCheck(get_class($this),'AdminUser')){
			router::redirect('admin-login',array('back'=>base64_encode($request->path())));
			exit;
		}
		
		$this->user = $this->usersDB->getLoggedIn();
		lang::set('admin');
		
		parent::__construct($request);

	}	
	public function index(){}
}
?>
