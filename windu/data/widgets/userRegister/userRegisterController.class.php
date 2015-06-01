<?php /*windu.org model*/
Class userRegisterController extends widgetMainController
{		
	public function run() {
		$usersDB = new usersDB();
		$user = $usersDB->getLoggedIn();
		if ($user!=null) {
			router::redirect('front');
		}
		
		$userPageForm = new form('registerUser','registerUserSuccess',$_POST,'POST','form-horizontal');
		$userPageForm->add('email', 'input-text',lang::read('user.register.email'),null,array());
		$userPageForm->addRule('email', 'required', null, lang::read('user.register.giveemail'));	
		$userPageForm->addRule('email', 'email', null, lang::read('user.register.givecorrectmail'));	
		$userPageForm->addRule('email', 'unique', array('table'=>$usersDB), lang::read('user.register.emailtaken'));
		
		$userPageForm->add('password', 'input-password',lang::read('user.register.password'),null,array("tooltip" => lang::read('user.register.autogener')));
		$userPageForm->addRule('password', 'string', array(6,50),lang::read('user.register.toshortpass'));	
		$userPageForm->addRule('password', 'same','passwordCompare',lang::read('user.register.diffpasswords'));
		$userPageForm->add('passwordCompare', 'input-password',lang::read('user.register.repeatpassword'),null);
		
		$userPageForm->add('username', 'input-text',lang::read('user.register.username'),null,array("tooltip" => lang::read('user.register.shownname'),"placeholder" => lang::read('user.register.kowal')));
		$userPageForm->add('name', 'input-text',lang::read('user.register.name'),null,array("placeholder" => lang::read('user.register.jan')));
		$userPageForm->add('surname', 'input-text',lang::read('user.register.surname'),null,array("placeholder" => lang::read('user.register.kowalski')));
		
		$userPageForm->addButton('submit',lang::read('user.register.register'));	
		
		$userPageForm->setHandler($this);
		$userPageForm->handle();

		return array("form" => $userPageForm);
	}
	public function registerUserSuccess($data) {
		$template = themesDB::getThemeName();
		
		$finishData['type'] = 14;
		$finishData['email'] = $data['email'];
		$finishData['password'] = generate::sqlInjesctionStringSecure($data['password']);
		$finishData['username'] = generate::sqlInjesctionStringSecure($data['username']);
		$finishData['name'] = generate::sqlInjesctionStringSecure($data['name']);
		$finishData['surname'] = generate::sqlInjesctionStringSecure($data['surname']);
		
		$usersDB = new usersDB();
		$user = $usersDB->add($finishData,config::get('userActive'));
        //FIXME nie dziala wysylanie maila bo nie ma obiektu smarty!
		if (config::get('userMailActivation')) {

            require_once( __SITE_PATH . '/app/plugins/html/smarty/SmartyBC.class.php');

            $this->smarty = new SmartyBC();
            $this->smarty->compile_dir  = CACHE_PATH . 'templates_c/';
            $this->smarty->cache_dir    = CACHE_PATH . 'cache/';
            $this->smarty->plugins_dir  = array(__SITE_PATH . '/app/plugins/html/smarty/plugins/',
                __SITE_PATH . '/app/plugins/html/smartyPlugins/',
                __SITE_PATH . '/data/functions/');

            $this->smarty->template_dir = array(WIDGET_PATH.'userRegister/');

            $this->smarty->assign('HOME',HOME);
            $this->smarty->assign('SITE_PATH',__SITE_PATH);


			$sessionDB = new sessionDB();
			$sessionKey = $sessionDB->set($user['email'], 259200);
			
			$this->smarty->assign('user',$user);
			$this->smarty->assign('sessionKey',$sessionKey);

			mail::send($user['email'], lang::read('user.register.activate.account'), $this->smarty->fetch('userRegisterMail.tpl'),$user['email']);
		}
		
		$pagesDB = new pagesDB();
		$pageUrlKey = $pagesDB->get($this->params['successPage'],'urlKey');		
		$redirectUrl = HOME.$pageUrlKey;
		
		router::redirect($redirectUrl);
	}		
}
?>