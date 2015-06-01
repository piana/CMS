<?php /*windu.org model*/
class usersDB extends ekeyDB
{
	public static $user = 0;
	public static $userAdminUser = 0;
	public static $userPageUser = 0;
	
	public function add($data,$active = 0)
	{
		if ($data['email']=='') {
			return false;
		}
		$data['email']=strtolower($data['email']);
		$pass = $data['password'];
		$data['active'] = $active;
		if ($data['username']==null) {
			$username = explode('@',$data['email']);
			$data['username'] = $username[0];
		}

		if ($pass==null){
			$pass = generate::randomCode(8,2);
			$data['password'] = $pass;
		}
		$returnData = $data;
		$data['password'] = $this->saltPassword($pass);
		$this->insert($data);
		return $returnData;
	}
	public function updateRow($data,$where) {
		if ($data['email']!=null) {
			$data['email']=strtolower($data['email']);
		}
		if($data['password']!=null){
			$data['password'] = $this->saltPassword($data['password']);
		}
		parent::updateRow($data, $where);
	}
	//Sprawdza czy user jest zalogowany
	public function authCheck($className,$type){
		$sessionDB = new sessionDB();
		$usersDB = new usersDB();
		$emailKey = cookie::readCookie('login');
		$passKey = cookie::readCookie('pass');

		$email = $sessionDB->get($emailKey);
		$password = $sessionDB->get($passKey);

		if($this->checkUserLogin($email, $password, $type)){
			$user = $usersDB->fetchRow("lower(email) = lower('{$email}')");
			if ($this->promissionCheck($user,$className)){
				return true;
			}
		}

		return false;
	}
	//Sprawdza uprawnienia zalogowanego usera
	public static function permissionCheck($className) {
		$userDB = new usersDB();
		$user = $userDB->getLoggedIn();
		if ($userDB->promissionCheck($user,$className)){
			return true;
		}
		return false;
	}
	//Zwraca zalgoowanego usera
	public function getLoggedIn($type = null) {
		$user = usersDB::$user;
		$adminUser = usersDB::$userAdminUser;
		$pageUser = usersDB::$userPageUser;
		
		if ($user!==0 and $type == null) {
			return $user;
		}elseif ($adminUser!==0 and $type == 'AdminUser'){
			return $adminUser;
		}elseif ($pageUser!==0 and $type == 'PageUser'){
			return $pageUser;
		}
		
		$sessionDB = new sessionDB();
		$emailKey = cookie::readCookie('login');
		$email = $sessionDB->get($emailKey);

		$user = $this->fetchRow("lower(email)=lower('{$email}')");
		
		if ($type!=null) {
			$type = 'is'.$type;
			if (!$this->$type($user)){
				return null;
			}			
		}

		if ($type == null) {
			usersDB::$user = $user;
		}elseif ($type == 'isAdminUser'){
			usersDB::$userAdminUser = $user;
		}elseif ($type == 'isPageUser'){
			usersDB::$userPageUser = $user;
		}		

		return $user;
	}
	//sprawdzanie uprawnien do danego kontrolera
	public function promissionCheck($user,$className) {
		$usertypesDB = new usertypesDB();
		if($usertypesDB->havePromission($user,$className)){
			return true;
		}
		return false;
	}

	//Sprawdza czy user podal porpawne haslo i nazwe usera
	public function checkUserLogin($email,$password,$type = null)
	{
		if (empty($email) or empty($password)) {
			return false;
		}

		$bindValues = array(':email' => $email, ':password' => $password, ':active' => 1);
		$user = $this->fetchRow("lower(email)=lower(:email) and password=:password and active=:active",null,'*',$bindValues);
		
		if ($type!=null) {
			$type = 'is'.$type;
			if ($user!=null and $this->$type($user)){
				return true;
			}			
		}else{
			if ($user!=null){
				return true;
			}			
		}
		
		return false;
	}
	public function isPageUser($user) {
		$usertypesDB = new usertypesDB();
		if ($usertypesDB->get($user->type, 'bucket')==usertypesDB::BUCKET_PAGE) {
			return TRUE;
		}
		return false;
	}	 
	public function isAdminUser($user) {
		$usertypesDB = new usertypesDB();
		if ($usertypesDB->get($user->type, 'bucket')==usertypesDB::BUCKET_SYSTEM) {
			return TRUE;
		}
		return false;
	}
	public function login($email,$password,$expire = 0) {
		$sessionDB = new sessionDB();
		if($expire == 0){
			$sessionExpire = 86400;
		} else {
			$sessionExpire = $expire;
		}

		$emailKey = $sessionDB->set($email, $sessionExpire);
		$passKey = $sessionDB->set($this->saltPassword($password), $sessionExpire);

		cookie::setCookie('login',$emailKey,$expire);
		cookie::setCookie('pass',$passKey,$expire);
	}
	
	////////////////////User Mode section////////////////////
	public function toggleDeveloperMode(){
		$user = $this->getLoggedIn();
		$configName = 'userMode-'.$user->id;
		
		$userMode = config::get($configName);
		
		if ($userMode == 1) {
			config::set($configName, 2);
		}elseif ($userMode == 2){
			config::set($configName, 0);
		}else{
			config::set($configName, 1);
		}
		
	}
	public function setPanelMode($mode){
		$user = $this->getLoggedIn();
		$configName = 'userMode-'.$user->id;
	
		config::set($configName, $mode);
	}
	public static function isDeveloper() {
		$usersDB = new usersDB();
		$user = $usersDB->getLoggedIn();

		$userMode = config::get('userMode-'.$user->id);
		
		if ($userMode==2) {
			return true;
		}
		return false;
	}
	public static function isNoob() {
		$usersDB = new usersDB();
		$user = $usersDB->getLoggedIn();

		$userMode = config::get('userMode-'.$user->id);
		
		if ($userMode==0 and $userMode!==null) {
			return true;
		}
		return false;
	}	
	
	//////////////////////////////////////////////////////////
	
	
	public function logout(){
		cookie::removeCookie('login');
		cookie::removeCookie('pass');
	}
	public function activate($id) {
		$this->set($id, 'active', 1);
	}
	public function deActivate($id) {
		$this->set($id, 'active', 0);
	}
	public function setRandomPassword($id) {
		$newPassword = generate::randomCode(8,2);
		$this->set($id, 'password', $this->saltPassword($newPassword));
		return $newPassword;
	}	
	
	public function activateByEmail($email) {
		$userId = $this->fetchRow("email = '{$email}'")->id;
		$this->activate($userId);
	}
	public function deActivateByEmail($email) {
		$userId = $this->fetchRow("email = '{$email}'")->id;
		$this->deActivate($userId);
	}	
	//TODO - kasowanie usera dorobic powiazania wszytskie, na przyklad co
	public function deleteUser($id) {
		image::deleteImageByBucket('user-'.$id);
		$this->deleteRows("id = '{$id}' and 'superAdministrator' !=1");
	}
	public function getByBucket($bucketId,$where = null, $order = null, $what = '*', $limit = null, $groupby = null, $bindValues = array() ){
		$userTypesDB = new usertypesDB();
		$userTypes = $userTypesDB->getByBucket($bucketId,null,true,true);
		if ($userTypes!=null) {
			if ($where!=null) {
				$where=' AND '.$where;
			}
			$users = $this->fetchAll("type in({$userTypes})$where",$order,$what,$limit,$groupby,$bindValues);
		}
		return $users;
	}
	public function getCommentsCount($userId) {
		$commentsDB = new commentsDB();
		$count = $commentsDB->fetchCount("userId = {$userId}");
		return $count;
	}
	public function getRatesCount($userId) {
		$ratesDB = new ratesDB();
		$count = $ratesDB->fetchCount("userId = {$userId}");
		return $count;
	}	
	public function saltPassword($password) {
		$passwordPieces = array_reverse(str_split($password));
		$saltPieces = str_split(config::get('salt',true));

		$counter = 0;
        $finalPassword = '';
		foreach ($passwordPieces as $piece) {
			$finalPassword.=$piece.$saltPieces[$counter];
			$counter = $counter+1;
			if ($counter>=32)$counter = 0;
		}
		
		return sha1(sha1(md5(sha1(md5($finalPassword)))));
	}
	public static function getLoggedUser($type = null) {
		$usersDB = new usersDB();
		$user = $usersDB->getLoggedIn($type);
		return $user;
	}
	
	public function getUsers($type) {
		$userTypesDB = new usertypesDB();
		$types = $userTypesDB->getByBucket($type);
        $idString = '';
		foreach ($types as $type) {
			$idString .= $type->id.',';
		}
		$idString = rtrim($idString,',');

		$users = $this->fetchAll("type in({$idString})");

		return $users;
	}
}
?>