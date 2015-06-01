<?php /*windu.org model*/
Class userLoginController extends widgetMainController
{		
	public function run() {
		$pagesDB = new pagesDB();
		$usersDB = new usersDB();
		$registerUrlKey = $pagesDB->get($this->params['registerPage'],'urlKey');
		$panelUrlKey = $pagesDB->get($this->params['panelPage'],'urlKey');

		$form = new form('userLogin','userLoginSuccess',$_POST,'POST');
		$form->add('user', 'input-text',null,null,array("tooltip" => lang::read('userlogin.autogener'),"placeholder" => lang::read('userlogin.username')));
		$form->addRule('user', 'required', null, lang::read('userlogin.addusername'));
		$form->addRule('user', 'email', null, lang::read('userlogin.addcorectusername'));
		
		$form->add('password', 'input-password',null,null,array("tooltip" => lang::read('userlogin.autogener'),"placeholder" => lang::read('userlogin.password')));
		$form->addRule('password', 'required', null, lang::read('userlogin.addpassword'));	

		if (cookie::get('loginError')>2) {
			$form->add('captcha', 'captcha',null,null,array("tooltip" => lang::read('admin.login.controller.autogener'),"placeholder" => lang::read('admin.login.controller.password')));
		}		
		
		$form->add('remember', 'input-checkbox',lang::read('userlogin.rememberme'),true,array("chacked" => true,"placeholder" => lang::read('userlogin.password')));
		$form->addButton('login',lang::read('userlogin.login'),'btn btn-primary');
		$form->addButton('register',lang::read('userlogin.register'),'btn userlogin-btn-margin-left',HOME.$registerUrlKey);
		$form->setHandler($this);
		$form->handle();
		$loggedIn = $usersDB->getLoggedIn();
	
		return array("form" => $form,"loggedIn" => $loggedIn, "panelPage" => $panelUrlKey);
	}
	public function userLoginSuccess($data) {
		
		$sessionDB = new sessionDB();
		$usersDB = new usersDB();
		
		//delete old entries
		$sessionDB->clean(generate::sqlDatetime());
		$data['user'] = generate::sqlInjesctionStringSecure($data['user']);
		$password = $usersDB->saltPassword($data['password']);



		if($usersDB->checkUserLogin($data['user'],$password)){
			if ($data['remember']) {
				$expire = 604800; //7 days
			}else{
				$expire = 0;
			}
			$usersDB->login($data['user'], $data['password'],$expire);
			log::write($data['user'],logDB::BUCKET_LOGIN_SUCCESS);
			cookie::removeCookie('loginError');
			
			router::back($this->request);
		}
		$usersDB->logout();
		cookie::setCookie('loginError',cookie::get('loginError')+1);
		log::write($data['user'],logDB::BUCKET_LOGIN_ERROR);
		router::back($this->request);
	}
}
?>