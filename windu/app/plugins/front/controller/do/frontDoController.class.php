<?php /*windu.org front controller*/
Class frontDoController Extends controller{
	public function __construct(request $request){
		lang::set('front');
		parent::__construct($request);
	}
	public function rate(){
		
		$ratesDB = new ratesDB();
		$usersDB = new usersDB();
		
		$table = generate::clean($this->request->getVariable('first'));
		$ekey = generate::clean($this->request->getVariable('secound'));
		$rate = generate::clean($this->request->getVariable('third'));
		
		$tableDB = new $table();
		$id = $tableDB->getByEkey($ekey)->id;
		
		if ($ratesDB->checkUnique($id,$table)) {
			
			$data['rate'] = $rate;
			$data['elementId'] = $id;
			$data['userId'] = $usersDB->getLoggedIn()->id;
			$data['bucket'] = $table;
			
			$ratesDB->add($data);
			echo lang::read('rate.message.positive');
			return true;
		}
		echo lang::read('rate.message.negative');
		return false;
	}
	public function vote(){
		
		$pollAnswersDB = new pollAnswersDB();
		
		$ekey = generate::clean($this->request->getVariable('first'));
		
		if ($pollAnswersDB->addVote($ekey)) {
			echo lang::read('rate.message.positive');
			return true;
		}
		echo lang::read('rate.message.negative');
		return false;
	}	
	public function activateUser() {
		$sessionDB = new sessionDB();
		$usersDB = new usersDB();
		$userEmail = $sessionDB->get(generate::clean($this->request->getVariable('first')));
		if ($userEmail!=null) {
			$usersDB->activateByEmail($userEmail);
			$sessionDB->delete(generate::clean($this->request->getVariable('first')));
			router::redirect('front',array('mp'=>'front.user.activate'));
		}
		router::redirect('front',array('mn'=>'front.user.keynotexists'));
	}

	public function resetAdminPassword() {
		self::resetPassword('admin');
	}	
	public function resetUserPassword() {
		self::resetPassword('front');
	}	
	private function resetPassword($redirect = 'front') {
		$sessionDB = new sessionDB();
		$usersDB = new usersDB();
		$userEmail = $sessionDB->get($this->request->getVariable('first'),true,true);
		$user = $usersDB->fetchRow("email = '{$userEmail}'");
		
		if ($user!=null) {
			$sessionDB->delete(generate::clean($this->request->getVariable('first')));
			$sessionDB->set($data, $expire);

			router::redirect($redirect,array('mp'=>'front.user.activate'));
		}
		
		router::redirect($redirect,array('mn'=>'front.user.keynotexists'));
	}			
	public function logout() {
		$usersDB = new usersDB();
		$usersDB->logout();
		router::back($this->request);
	}
	public function deleteUserImage(){
		$usersDB = new usersDB();
		$user = $usersDB->getLoggedIn();
		image::deleteImageByBucket('user-'.$user->id);
		router::back($this->request);
	}	
	public function bannerClick() {
		$id = intval($this->request->getVariable('first'));
		$bannersDB = new bannersDB();
		$banner = $bannersDB->fetchRow("id={$id}");
		
		$bannerLog = new bannerlogDB();
		$bannerLog->addClick($banner->id);
		
		router::redirect($banner->link);
	}	
	public function setAllForumTopicReaded() {
		$groupEkey = $this->request->getVariable('first');
		$user = usersDB::getLoggedUser();
		$forumReadedLogDB = new forumReadedLogDB();		
		$forumReadedLogDB->setAllTopicReaded($user->id,$groupEkey);
		router::back($this->request);
	}	
}
?>
