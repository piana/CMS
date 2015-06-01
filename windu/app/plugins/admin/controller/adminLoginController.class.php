<?php /*windu.org admin controller*/
Class adminLoginController extends adminNoAuthController
{	
	function smartyGo()
	{
		parent::smartyGo();
		$this->smarty->template_dir = array(__SITE_PATH . '/app/plugins/admin/templates/');
	}
	public function __construct($request){
		if (config::get('install')==0){
			router::redirect('admin-install');
		}
		parent::__construct($request);
	}
	public function index()
	{	
		$usersDB = new usersDB();
		if($usersDB->authCheck('login','AdminUser')){
			router::redirect('admin');
			exit;
		}				
		
		$form = new form('login','loginSuccess',$_POST,'POST',null,null);
		$form->add('user', 'input-text',null,null,array("tooltip" => lang::read('admin.login.controller.autogener'),"class" => "input-medium","placeholder" => lang::read('admin.login.controller.username')));
		$form->addRule('user', 'required', null, lang::read('admin.login.controller.addusername'));
		
		$form->add('password', 'input-password',null,null,array("tooltip" => lang::read('admin.login.controller.autogener'),"class" => "input-medium","placeholder" => lang::read('admin.login.controller.password')));
		$form->addRule('password', 'required', null, lang::read('admin.login.controller.addpassword'));	

		if (cookie::get('loginError')>2) {
			$form->add('captcha', 'captcha',null,null,array("tooltip" => lang::read('admin.login.controller.autogener'),"class" => "input-medium","placeholder" => lang::read('admin.login.controller.password')));
		}
		
		$form->add('remember', 'input-checkbox',lang::read('admin.login.controller.rememberme'),true,array("chacked" => true,"placeholder" => lang::read('admin.login.controller.password')));
		$form->add('back', 'input-hidden',null,$this->request->getVariable('back'));
		$form->addButton('login',lang::read('admin.login.controller.login'),'btn btn-primary btn-large',null,null,'fa fa-lock ');
		$form->addButton('rememberPassword',lang::read('admin.login.controller.forgotpassword'),'btn btn-link btn-large btn-margin-left btn-newline',router::route('admin-action',array('action'=>'forgotPassword')));
		$form->setHandler($this);
		$form->handle();
		 
		$this->smarty->assign('form',$form);	
		$this->pageDisplayHook('login.tpl','mainSimple.tpl');
	}

	public function loginSuccess($data) {
		$sessionDB = new sessionDB();
		$usersDB = new usersDB();
		
		//delete old entries
		$sessionDB->clean(generate::sqlDatetime());
		$data['user'] = generate::sqlInjesctionStringSecure($data['user']);
		$password = $usersDB->saltPassword($data['password']);
		
		if($usersDB->checkUserLogin($data['user'],$password,'AdminUser')){
			if ($data['remember']) {
				$expire = 3600*24*7; //7 days
			}else{
				$expire = 0; //1 hours
			}
			$usersDB->login($data['user'], $data['password'],$expire);
			log::write($data['user'],logDB::BUCKET_LOGIN_SUCCESS);
			
			cookie::removeCookie('loginError');
			$backUrl = $data['back'];

			if ($backUrl!=null) {
				router::redirect('admin-check',array('back'=>$backUrl));
			}else{
				router::redirect('admin-check');
			}
			
		}

		cookie::setCookie('loginError',cookie::get('loginError')+1);
		$usersDB->logout();
		log::write($data['user'],logDB::BUCKET_LOGIN_ERROR);
		
		router::redirect('admin-login',array('mn'=>'admin.message.loginerror'));
	}
	public function forgotPassword() {
		$usersDB = new usersDB();
		if($usersDB->authCheck('login','AdminUser')){
			router::redirect('admin');
			exit;
		}				
		
		$form = new form('rememberPassword','forgotPasswordSuccess',$_POST,'POST',null,null);
		$form->add('user', 'input-text',null,null,array("tooltip" => lang::read('admin.login.controller.autogener'),"class" => "input-medium","placeholder" => lang::read('admin.login.controller.username')));
		$form->addRule('user', 'required', null, lang::read('admin.login.controller.addusername'));
		$form->addRule('user', 'email', null, lang::read('admin.login.controller.addusername'));
		
		$form->addButton('submit',lang::read('admin.login.controller.resetpassword'),'btn btn-primary btn-large',null,null,'fa fa-plus ');
		$form->addButton('reset',lang::read('admin.login.controller.cancel'),'btn btn-large btn-link',router::route('admin-login'));
		$form->setHandler($this);
		$form->handle();
		 
		$this->smarty->assign('form',$form);	
		$this->pageDisplayHook('login.tpl','mainSimple.tpl');
	}	
	public function forgotPasswordSuccess($data) {
		$sessionDB = new sessionDB();
		$usersDB = new usersDB();
		
		//delete old entries
		$sessionDB->clean(generate::sqlDatetime());

		$data['user'] = generate::sqlInjesctionStringSecure($data['user']);
				
		
		if (validator::isEmail($data['user'])) {
			$user = $usersDB->fetchRow("email='{$data['user']}'");
		}		
		
		
		if ($user!=null) {
			$sessionKey = $sessionDB->set($data['user'], 7200, 3);
			mail::send($user->email, lang::read('admin.users.controller.youruserdata'), $this->pageFetchHook('mail/mailResetAdminPassword.tpl','mail/mailBase.tpl','page',$sessionKey,null));
			router::redirect('admin-login',array('mi'=>'admin.message.receive.email'));
		}
		router::redirect('admin-login',array('mn'=>'admin.message.user.not.exist'));
	}	
	public function setNewPassword() {
		$usersDB = new usersDB();
		$sessionDB = new sessionDB();
		$sessionDB->clean(generate::sqlDatetime());	
		$userEmail = $sessionDB->get($this->request->getVariable('sessionKey'),true,true);
		
		if($usersDB->authCheck('login','AdminUser')){router::redirect('admin'); exit;}	
		if ($userEmail==null) {router::redirect('admin-login'); exit;}
		
		$user = $usersDB->fetchRow("email='{$userEmail}'");
		if ($user==null) {router::redirect('admin-login'); exit;}

		$form = new form('setNewPassword','setNewPasswordSuccess',$_POST,'POST',null,null);
		$form->add('password', 'input-password',null,null,array("tooltip" => lang::read('admin.users.controller.autogener'),"class" => "input-medium","placeholder" => lang::read('admin.users.controller.password')));
		$form->addRule('password', 'string', array(6,50),lang::read('admin.users.controller.toshortpass'));	
		$form->addRule('password', 'same','passwordCompare',lang::read('admin.users.controller.diffpasswords'));
		$form->add('passwordCompare', 'input-password',null,null,array("class" => "input-medium","placeholder" => lang::read('admin.users.controller.repeatpassword')));
		$form->add('sessionKey', 'input-hidden',null,$this->request->getVariable('sessionKey'));
		
		
		$form->addButton('submit','Zapisz hasło','btn btn-primary btn-large',null,null,'icon-envelope ');
		$form->addButton('reset','Anuluj','btn btn-large btn-margin-left',router::route('admin-login'));
		$form->setHandler($this);
		$form->handle();
		 
		$this->smarty->assign('form',$form);	
		$this->pageDisplayHook('login.tpl','mainSimple.tpl');
	}	

	public function setNewPasswordSuccess($data) {
		$usersDB = new usersDB();
		$sessionDB = new sessionDB();
		$userEmail = generate::sqlInjesctionStringSecure($sessionDB->get($data['sessionKey'],true,true));

		$usersDB->updateRow(array('password'=>$data['password']),"email='{$userEmail}'");
		
		router::redirect('admin-login',array('mp'=>'admin.message.password.changed'));
	}
	public function logout() {
		$usersDB = new usersDB();
		$usersDB->logout();
		router::redirect('admin-login');
	}
	public function logoutFront() {
		$usersDB = new usersDB();
		$usersDB->logout();
		router::redirect('front');
	}	
}
?>
