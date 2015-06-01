<?php /*windu.org admin controller*/
Class adminUsersController Extends adminMainConfigController {
	public function __construct($request){
		parent::__construct($request);
		$userDB = new usersDB();
		$commentsDB = new commentsDB();
		$this->smarty->assign('userDB',$userDB);
		$this->smarty->assign('commentsDB',$commentsDB);
		$this->smarty->assign('pagesDB',new pagesDB());	
		
		$usersSystem = $userDB->getByBucket(usertypesDB::BUCKET_SYSTEM);
		$this->smarty->assign('usersSystem',$usersSystem);
		
		$usersPage = $userDB->getByBucket(usertypesDB::BUCKET_PAGE);
		$this->smarty->assign('usersPage',$usersPage);		
		
		$userTypesDB = new usertypesDB();
		$userTypes = $userTypesDB->fetchAll();
		$this->smarty->assign('userTypes',$userTypes);
		
		$configDB = new configDB();
		$config = $configDB->getByGroup(configDB::CONFIG_BUCKET_USERS);	
		$this->smarty->assign('configList',$config);
				
		$usersDB = new usersDB();
		$userTypesDB = new usertypesDB();
		$userTypesSystemArray = $userTypesDB->getByBucket(usertypesDB::BUCKET_SYSTEM,null,false,false,true);
		$userTypesPageArray = $userTypesDB->getByBucket(usertypesDB::BUCKET_PAGE,null,false,false,true);

		$userTypesArray = $userTypesDB->getArray();
		$this->smarty->assign('userTypesArray',$userTypesArray);			
		
		//////////////////////////////////////
		//user system form////////////////////	
		//////////////////////////////////////
		$userSystemForm = new form('addUserSystem','addUserSystemSuccess',$_POST,'POST','form-horizontal');
		
		$userSystemForm->add('type', 'select',lang::read('admin.users.controller.usertype'),null,array('option' => $userTypesSystemArray,"tooltip" => lang::read('admin.users.controller.permits')));
		$userSystemForm->add('email', 'input-text',lang::read('admin.users.controller.email'),null,array());
		$userSystemForm->addRule('email', 'required', null, lang::read('admin.users.controller.giveemail'));	
		$userSystemForm->addRule('email', 'email', null, lang::read('admin.users.controller.givecorrectemail'));	
		$userSystemForm->addRule('email', 'unique', array('table'=>$usersDB), lang::read('admin.users.controller.emailtaken'));
		
		$userSystemForm->add('password', 'input-password',lang::read('admin.users.controller.password'),null,array("tooltip" => lang::read('admin.users.controller.autogener'),"class" => "input-medium"));
		//$userSystemForm->addRule('password', 'required', null, "Podaj hasło!");	
		$userSystemForm->addRule('password', 'string', array(6,50),lang::read('admin.users.controller.toshortpass'));	
		$userSystemForm->addRule('password', 'same','passwordCompare',lang::read('admin.users.controller.diffpasswords'));
		$userSystemForm->add('passwordCompare', 'input-password',lang::read('admin.users.controller.repeatpassword'),null,array("class" => "input-medium"));
		//$userSystemForm->addRule('passwordCompare', 'required', null, "Podaj powtórzone hasło!");	
		
		$userSystemForm->add('username', 'input-text',lang::read('admin.users.controller.username'),null,array("tooltip" => lang::read('admin.users.controller.shownname'),"placeholder" => lang::read('admin.users.controller.kowal'),"class" => "input-medium"));
		$userSystemForm->add('name', 'input-text',lang::read('admin.users.controller.name'),null,array("placeholder" => lang::read('admin.users.controller.jan'),"class" => "input-medium"));
		$userSystemForm->add('surname', 'input-text',lang::read('admin.users.controller.surname'),null,array("placeholder" => lang::read('admin.users.controller.kowalski'),"class" => "input-medium"));


		$userSystemForm->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus ');
		$userSystemForm->setHandler($this);
		$userSystemForm->handle();
		
		$this->smarty->assign('userSystem',$userSystemForm);	
		
		//////////////////////////////////////
		//user page form//////////////////////
		//////////////////////////////////////
		$userPageForm = new form('addUserPage','addUserPageSuccess',$_POST,'POST','form-horizontal');
		$userPageForm->add('type', 'select',lang::read('admin.users.controller.usertype'),null,array('option' => $userTypesPageArray,"tooltip" => lang::read('admin.users.controller.permits')));
		$userPageForm->add('email', 'input-text',lang::read('admin.users.controller.email'),null,array());
		$userPageForm->addRule('email', 'required', null, lang::read('admin.users.controller.giveemail'));	
		$userPageForm->addRule('email', 'email', null, lang::read('admin.users.controller.givecorrectmail'));	
		$userPageForm->addRule('email', 'unique', array('table'=>$usersDB), lang::read('admin.users.controller.emailtaken'));
		
		$userPageForm->add('password', 'input-password',lang::read('admin.users.controller.password'),null,array("tooltip" => lang::read('admin.users.controller.autogener'),"class" => "input-medium"));
		//$userPageForm->addRule('password', 'required', null, "Podaj hasło!");	
		$userPageForm->addRule('password', 'string', array(6,50),lang::read('admin.users.controller.toshortpass'));	
		$userPageForm->addRule('password', 'same','passwordCompare',lang::read('admin.users.controller.diffpasswords'));
		$userPageForm->add('passwordCompare', 'input-password',lang::read('admin.users.controller.repeatpassword'),null,array("class" => "input-medium"));
		//$userPageForm->addRule('passwordCompare', 'required', null, "Podaj powtórzone hasło!");	
		
		$userPageForm->add('username', 'input-text',lang::read('admin.users.controller.username'),null,array("tooltip" => lang::read('admin.users.controller.shownname'),"placeholder" => lang::read('admin.users.controller.kowal'),"class" => "input-medium"));
		$userPageForm->add('name', 'input-text',lang::read('admin.users.controller.name'),null,array("placeholder" => lang::read('admin.users.controller.jan'),"class" => "input-medium"));
		$userPageForm->add('surname', 'input-text',lang::read('admin.users.controller.surname'),null,array("placeholder" => lang::read('admin.users.controller.kowalski'),"class" => "input-medium"));
		
		$userPageForm->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus ');	
		
		$userPageForm->setHandler($this);
		$userPageForm->handle();
		$this->smarty->assign('userPage',$userPageForm);	
				
		//////////////////////////////////////
		//user type form//////////////////////
		//////////////////////////////////////
		$userType = new form('addUserType','addUserTypeSuccess',$_POST,'POST','form-horizontal');
		$userType->add('name', 'input-text',lang::read('admin.users.controller.nametype'));
		$userType->addRule('name', 'required', null, lang::read('admin.users.controller.addname'));
		
		$userType->add('bucket', 'select',lang::read('admin.users.controller.powersfor'),null,array('option' => $userTypesDB->getBuckets(),"tooltip" => lang::read('admin.users.controller.powerssetting')));
		$userType->add('extends', 'select',lang::read('admin.users.controller.extension'),null,array('option' => $userTypesDB->getArray(),"tooltip" => lang::read('admin.users.controller.powersextension')));
		
		$userType->add('regexp', 'textarea',lang::read('admin.users.controller.expressionregular'),null,array("tooltip" => lang::read('admin.users.controller.addformula')));
		$userType->addRule('regexp', 'required', null, lang::read('admin.users.controller.addregularformula'));
		
		$userType->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus ');		
		
		$userType->setHandler($this);
		$userType->handle();		
		$this->smarty->assign('userType',$userType);
		$this->smarty->assign('subpage',$this->request->getVariable('subpage'));	
		$this->smarty->assign('controllerShortName','users');
		
		//Search/////////////////////////////
		$formSearch = new form('search','searchSuccess',$_POST,'POST','form-inline');
		
		$formSearch->add('searchText', 'input-text',null,null,array('placeholder'=>lang::read('admin.content.controller.searchedphrase')));
		$formSearch->addRule('searchText', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$formSearch->addButton('search',lang::read('admin.content.controller.search'),'btn btn-small');
		$formSearch->setHandler($this);
		$formSearch->handle();
		$this->smarty->assign('formSearch',$formSearch);

        $logDB = new logDB();
        $this->smarty->assign('logDB',$logDB);

        $this->smarty->assign('historyPageCount',50);
        $this->smarty->assign('historyPage',50*$this->request->getVariable('p'));
        $this->smarty->assign('historyCount',$logDB->getHistoryLogsCount());
	}
	public function index()
	{		
		$this->pageDisplay('users');
	}
	////////////////////////////////////////////////////////
	////Search//////////////////////////////////////////////
	////////////////////////////////////////////////////////
	public function searchSuccess($data){
		router::redirect('admin-users-action-userId',array('action'=>'searchResult','subpage'=>'users','id'=>base64_encode($data['searchText'])));
	}
	public function searchResult() {
		$usersDB = new usersDB();
		$searchString = base64_decode($this->request->getVariable('id'));
	
		$searchResult=$usersDB->fetchTextSearch($searchString,array('email','username','name','surname','createTime','updateTime','createIP','updateIp','ekey'));
	
		$this->smarty->assign('searchString',$searchString);
		$this->smarty->assign('usersPage',$searchResult);
		$this->pageDisplay('users');
	}
		
	public function addUserSystemSuccess($data) {
		unset($data['passwordCompare']);
		$usersDB = new usersDB();
		$user = $usersDB->add($data,true);
		$this->smarty->assign('data',$data);	
		mail::send($data['email'], lang::read('admin.users.controller.youruserdata'), $this->pageFetchHook('mail/mailRegisterAdminUser.tpl', 'mail/mailBase.tpl','page',$user,null));
		router::reload();
	}	
	public function addUserPageSuccess($data) {
		unset($data['passwordCompare']);
		$usersDB = new usersDB();
		$user = $usersDB->add($data,config::get('userActive'));
		mail::send($user['email'], lang::read('admin.users.controller.youruserdata'), $this->pageFetchHook('mail/mailRegisterPageUser.tpl', 'mail/mailBase.tpl','page',$user,null));
		router::reload();
	}	
	public function addUserTypeSuccess($data) {
		$userTypesDB = new usertypesDB();
		$userTypesDB->add($data);
		router::reload();
	}	
	public function editUserType() {
		//user type form//////////////////////
		
		$userTypesDB = new usertypesDB();
		$type = $userTypesDB->fetchRow("id={$this->request->getVariable('id')}");	
			
		$userType = new form('editUserType','editUserTypeSuccess',$_POST,'POST','form-horizontal');
		$userType->add('name', 'input-text',lang::read('admin.users.controller.nametype'),$type->name);
		$userType->addRule('name', 'required', null, lang::read('admin.users.controller.addname'));
		
		$userType->add('bucket', 'select',lang::read('admin.users.controller.powersfor'),$type->bucket,array('option' => $userTypesDB->bucket,"tooltip" => lang::read('admin.users.controller.powerssetting')));
		$userType->add('extends', 'select',lang::read('admin.users.controller.extension'),$type->extends,array('option' => $userTypesDB->getArray(),"tooltip" => lang::read('admin.users.controller.powerextension')));
		
		$userType->add('regexp', 'textarea',lang::read('admin.users.controller.expressionregular'),$type->regexp,array("tooltip" => lang::read('admin.users.controller.addformula')));
		$userType->addRule('regexp', 'required', null, lang::read('admin.users.controller.addregularformula'));
		
		$userType->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary',null,null,'fa fa-upload ');
				
		$userType->setHandler($this);
		$userType->handle();			
			
		$this->smarty->assign('userType',$userType);	
		$this->pageDisplay('users');
	}
	public function editUserTypeSuccess($data) {
		$userTypesDB = new usertypesDB();
		$userTypesDB->updateRow($data,"id={$this->request->getVariable('id')}");
		router::reload();
	}	
	public function editUserTypePanels() {
		//user type form//////////////////////
		
		$userTypesDB = new usertypesDB();
		$type = $userTypesDB->fetchRow("id={$this->request->getVariable('id')}");	
		
		$panels = array();
		$panelsArray = unserialize($type->panels);	
		if (is_array($panelsArray)) {
			$panels = $panelsArray;
		}
		
		$userTypePanels = new form('editUserType','editUserTypePanelsSuccess',$_POST,'POST','form-horizontal');
		$userTypePanels->add('HTML','<div class="row-fluid">');
			$userTypePanels->add('HTML','<div class="span4"><div class="pad">');
				if (array_key_exists('mainContent', $panels)){$chacked = 1;}else{$chacked = 0;}
				$userTypePanels->add('mainContent', 'input-checkbox',lang::read('admin.menu.content'),1,array('checkbox-selected'=>$chacked));
				$userTypePanels->add('HTML','<hr>');
				foreach ($userTypesDB->contentPanels as $panelName=>$langKey){
					if (array_key_exists($panelName, $panels)){$chacked = 1;}else{$chacked = 0;}
					$userTypePanels->add($panelName, 'input-checkbox',lang::read($langKey),1,array('checkbox-selected'=>$chacked));
				}
			$userTypePanels->add('HTML','</div></div>');	
			$userTypePanels->add('HTML','<div class="span4"><div class="pad">');	
				if (array_key_exists('mainForum', $panels)){$chacked = 1;}else{$chacked = 0;}
				$userTypePanels->add('mainForum', 'input-checkbox',lang::read('admin.menu.forum'),1,array('checkbox-selected'=>$chacked));
				$userTypePanels->add('HTML','<hr>');				
				foreach ($userTypesDB->forumPanels as $panelName=>$langKey){
					if (array_key_exists($panelName, $panels)){$chacked = 1;}else{$chacked = 0;}
					$userTypePanels->add($panelName, 'input-checkbox',lang::read($langKey),1,array('checkbox-selected'=>$chacked));
				}
			$userTypePanels->add('HTML','</div></div>');	
			$userTypePanels->add('HTML','<div class="span4"><div class="pad">');
				if (array_key_exists('mainUsers', $panels)){$chacked = 1;}else{$chacked = 0;}	
				$userTypePanels->add('mainUsers', 'input-checkbox',lang::read('admin.menu.users'),1,array('checkbox-selected'=>$chacked));
				$userTypePanels->add('HTML','<hr>');				
				foreach ($userTypesDB->usersPanels as $panelName=>$langKey){
					if (array_key_exists($panelName, $panels)){$chacked = 1;}else{$chacked = 0;}
					$userTypePanels->add($panelName, 'input-checkbox',lang::read($langKey),1,array('checkbox-selected'=>$chacked));
				}
			$userTypePanels->add('HTML','</div></div>');	
		$userTypePanels->add('HTML','</div>');	
		$userTypePanels->add('HTML','<div class="row-fluid">');	
			$userTypePanels->add('HTML','<div class="span4"><div class="pad">');	
				if (array_key_exists('mainThemes', $panels)){$chacked = 1;}else{$chacked = 0;}
				$userTypePanels->add('mainThemes', 'input-checkbox',lang::read('admin.menu.themes'),1,array('checkbox-selected'=>$chacked));
				$userTypePanels->add('HTML','<hr>');				
				foreach ($userTypesDB->themesPanels as $panelName=>$langKey){
					if (array_key_exists($panelName, $panels)){$chacked = 1;}else{$chacked = 0;}
					$userTypePanels->add($panelName, 'input-checkbox',lang::read($langKey),1,array('checkbox-selected'=>$chacked));
				}
			$userTypePanels->add('HTML','</div></div>');	
			$userTypePanels->add('HTML','<div class="span4"><div class="pad">');	
				if (array_key_exists('mainTools', $panels)){$chacked = 1;}else{$chacked = 0;}
				$userTypePanels->add('mainTools', 'input-checkbox',lang::read('admin.menu.tools'),1,array('checkbox-selected'=>$chacked));
				$userTypePanels->add('HTML','<hr>');				
				foreach ($userTypesDB->toolsPanels as $panelName=>$langKey){
					if (array_key_exists($panelName, $panels)){$chacked = 1;}else{$chacked = 0;}
					$userTypePanels->add($panelName, 'input-checkbox',lang::read($langKey),1,array('checkbox-selected'=>$chacked));
				}								
			$userTypePanels->add('HTML','</div></div>');	
			$userTypePanels->add('HTML','<div class="span4"><div class="pad">');	
				if (array_key_exists('mainSystem', $panels)){$chacked = 1;}else{$chacked = 0;}
				$userTypePanels->add('mainSystem', 'input-checkbox',lang::read('admin.menu.system'),1,array('checkbox-selected'=>$chacked));
				$userTypePanels->add('HTML','<hr>');				
				foreach ($userTypesDB->systemPanels as $panelName=>$langKey){
					if (array_key_exists($panelName, $panels)){$chacked = 1;}else{$chacked = 0;}
					$userTypePanels->add($panelName, 'input-checkbox',lang::read($langKey),1,array('checkbox-selected'=>$chacked));
				}		
			$userTypePanels->add('HTML','</div></div>');	
		$userTypePanels->add('HTML','</div>');	
		$userTypePanels->add('HTML','<div class="row-fluid">');		
			$userTypePanels->add('HTML','<div class="span4"><div class="pad">');	
				$userTypePanels->add('HTML','<h5><i class="fa fa-user icon-margin icon-grey"></i>'.lang::read('admin.main.tpl.allowedothers').'</h5>');			
				if (array_key_exists('update', $panels)){$chacked = 1;}else{$chacked = 0;}		
				$userTypePanels->add('update', 'input-checkbox','Update',1,array('checkbox-selected'=>$chacked));
				
				if (array_key_exists('mainCustom', $panels)){$chacked = 1;}else{$chacked = 0;}
				$userTypePanels->add('mainCustom', 'input-checkbox',lang::read('admin.menu.custom'),1,array('checkbox-selected'=>$chacked));
				if (array_key_exists('mainConfig', $panels)){$chacked = 1;}else{$chacked = 0;}
				$userTypePanels->add('mainConfig', 'input-checkbox',lang::read('admin.menu.config'),1,array('checkbox-selected'=>$chacked));			
				
			$userTypePanels->add('HTML','</div></div>');
		$userTypePanels->add('HTML','</div>');
		
		$userTypePanels->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary',null,null,'fa fa-upload ');
				
		$userTypePanels->setHandler($this);
		$userTypePanels->handle();			
			
		$this->smarty->assign('userTypePanels',$userTypePanels);	
		$this->pageDisplay('users');
	}
	public function editUserTypePanelsSuccess($data) {
		$userTypesDB = new usertypesDB();
		$data = serialize($data);
		$userTypesDB->updateRow(array('panels'=>$data),"id={$this->request->getVariable('id')}");
		router::reload();
	}
	
	
	public function editUserSystem() {
		$usersDB = new usersDB();
		$user = $usersDB->fetchRow("id={$this->request->getVariable('id')}");		
		
		$userTypesDB = new usertypesDB();
		$userTypesSystemArray = $userTypesDB->getByBucket(usertypesDB::BUCKET_SYSTEM,null,false,false,true);	
		
		$userSystemForm = new form('editUserSystem','editUserSuccess',$_POST,'POST','form-horizontal');
		if ($user->superAdministrator != 1) {
			$userSystemForm->add('type', 'select',lang::read('admin.users.controller.usertype'),$user->type,array('option' => $userTypesSystemArray,"tooltip" => lang::read('admin.users.controller.permits')));
		}
		
		$userSystemForm->add('password', 'input-password',lang::read('admin.users.controller.password'),null,array("tooltip" => lang::read('admin.users.controller.empty'),"class" => "input-medium"));
		//$userSystemForm->addRule('password', 'required', null, "Podaj hasło!");	
		$userSystemForm->addRule('password', 'string', array(6,50),lang::read('admin.users.controller.toshortpass'));	
		$userSystemForm->addRule('password', 'same','passwordCompare',lang::read('admin.users.controller.diffpasswords'));
		$userSystemForm->add('passwordCompare', 'input-password',lang::read('admin.users.controller.repeatpassword'),null,array("class" => "input-medium"));
		//$userSystemForm->addRule('passwordCompare', 'required', null, "Podaj powtórzone hasło!");	
		
		$userSystemForm->add('username', 'input-text', lang::read('admin.users.controller.username'),$user->username,array("tooltip" => lang::read('admin.users.controller.shownname'),"placeholder" => lang::read('admin.users.controller.kowal'),"class" => "input-medium"));
		$userSystemForm->add('name', 'input-text',lang::read('admin.users.controller.name'),$user->name,array("placeholder" => lang::read('admin.users.controller.jan'),"class" => "input-medium"));
		$userSystemForm->add('surname', 'input-text',lang::read('admin.users.controller.surname'),$user->surname,array("placeholder" => lang::read('admin.users.controller.kowalski'),"class" => "input-medium"));

		$userSystemForm->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary',null,null,'fa fa-upload ');
		
		$userSystemForm->setHandler($this);
		$userSystemForm->handle();
		$this->smarty->assign('userSystem',$userSystemForm);	
		$this->pageDisplay('users');
	}	

		
	public function editUserPage() {
		$usersDB = new usersDB();
		$user = $usersDB->fetchRow("id={$this->request->getVariable('id')}");				

		$userTypesDB = new usertypesDB();
		$userTypesPageArray = $userTypesDB->getByBucket(usertypesDB::BUCKET_PAGE,null,false,false,true);			
		
		$userPageForm = new form('addUserPage','editUserSuccess',$_POST,'POST','form-horizontal');
		$userPageForm->add('type', 'select',lang::read('admin.users.controller.usertype'),$user->type,array('option' => $userTypesPageArray,"tooltip" => lang::read('admin.users.controller.permits')));
		
		$userPageForm->add('password', 'input-password',lang::read('admin.users.controller.password'),null,array("tooltip" => lang::read('admin.users.controller.autogener'),"class" => "input-medium"));
		//$userPageForm->addRule('password', 'required', null, "Podaj hasło!");	
		$userPageForm->addRule('password', 'string', array(6,50),lang::read('admin.users.controller.toshortpass'));	
		$userPageForm->addRule('password', 'same','passwordCompare',lang::read('admin.users.controller.diffpasswords'));
		$userPageForm->add('passwordCompare', 'input-password',lang::read('admin.users.controller.repeatpassword'),null,array("class" => "input-medium"));
		//$userPageForm->addRule('passwordCompare', 'required', null, "Podaj powtórzone hasło!");	
		
		$userPageForm->add('username', 'input-text',lang::read('admin.users.controller.username'),$user->username,array("tooltip" => lang::read('admin.users.controller.shownname'),"placeholder" => "Kowal","class" => "input-medium"));
		$userPageForm->add('name', 'input-text',lang::read('admin.users.controller.name'),$user->name,array("placeholder" => lang::read('admin.users.controller.jan'),"class" => "input-medium"));
		$userPageForm->add('surname', 'input-text',lang::read('admin.users.controller.surname'),$user->surname,array("placeholder" => lang::read('admin.users.controller.kowalski'),"class" => "input-medium"));

		$userPageForm->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary',null,null,'fa fa-upload ');
		
		$userPageForm->setHandler($this);
		$userPageForm->handle();
		$this->smarty->assign('userPage',$userPageForm);	
		$this->pageDisplay('users');
	}		
	public function editUserSuccess($data) {
		unset($data['passwordCompare']);
		if ($data['password']==null){
			unset($data['password']);
		}
		$usersDB = new usersDB();
		$usersDB->updateRow($data,"id={$this->request->getVariable('id')}");
		router::reload();
	}
	public function editConfig() {
		parent::editConfig();
		$this->pageDisplay('users');
	}	
	

}
?>
