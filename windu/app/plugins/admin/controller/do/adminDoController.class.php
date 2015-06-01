<?php /*windu.org admin controller*/
Class adminDoController Extends adminAuthDoController{
	public function pinIt(){
		$user = usersDB::getLoggedUser();
		$name = 'pins-'.$user->id;
		$oldValue = config::get($name);
		$url = explode('?',$this->request->server('HTTP_REFERER'));
		$newValue = array($url[0]);

		$newValueKey = $this->request->getVariable('id');
		if ($oldValue!='') {
			$value = unserialize(config::get($name));
			if ($value[$newValueKey]!='') {
				unset($value[$newValueKey]);
			}else{
				$value = array_merge($value,array($newValueKey=>$newValue));
			}
		}else{
			$value = array($newValueKey=>$newValue);
		}
		
		config::set($name, $value);
		router::back($this->request);
	}
	public function cleanPins(){
		$user = usersDB::getLoggedUser();
		$name = 'pins-'.$user->id;
		config::set($name, '');
		router::back($this->request);
	}	
	public function toggleDeveloperMode(){
		$usersDB = new usersDB();
		$usersDB->toggleDeveloperMode();
		router::back($this->request);
	}
	public function setPanelMode(){
		$mode = $this->request->getVariable('id');
		$usersDB = new usersDB();
		$usersDB->setPanelMode($mode);
		router::back($this->request);		
	}
	public function toogleCookie() {
		$cookie = cookie::readCookie($this->request->getVariable('id'));
		if($cookie != 1){
			cookie::setCookie($this->request->getVariable('id'),1);
		}else{
			cookie::setCookie($this->request->getVariable('id'),0);
		}

		router::back($this->request,$this->request->getVariable('anchor'));
	}
	public function toggleConfig() {
		$config = config::get($this->request->getVariable('id'));
		if($config != 1){
			config::set($this->request->getVariable('id'),1);
		}else{
			config::set($this->request->getVariable('id'),0);
		}
		
		if ($this->request->getVariable('id')=='cacheResources') {
			config::set('resourcesVersion', intval(config::get('resourcesVersion'))+1);
			cache::flushAllCache();
		}
		
		router::back($this->request);
	}	
	public function toggleConfigParent() {
		$config = config::get($this->request->getVariable('id'));
		if($config != 1){
			config::set($this->request->getVariable('id'),1);
		}else{
			config::set($this->request->getVariable('id'),0);
		}
		router::reloadParent();
	}	
	
	public function reload() {
		router::back($this->request);
	}
	public function reloadParent() {
		router::reloadParent();
	}	
	public function setPaginatorPage() {
		cookie::setCookie($this->request->getVariable('id'),1);
		router::back($this->request);
	}
	public function flushCache() {
		cache::flushAllCache();
		router::back($this->request);
	}
	public function flushCacheFront() {
		cache::flushAllCache();
		router::reloadParent();
	}	
	public function setBackground(){
		$usersDB = new usersDB();
		$user = $usersDB->getLoggedIn();
		config::set('backgroundAdmin'.$user->id,$this->request->getVariable('id'));
		
		router::back($this->request);
	}
	
	public function toggleSystemRun() {
		$panelName = $this->request->getVariable('id');
		$panelStatus = config::getSystemRun($panelName);
		
		if ($panelStatus==1) {
			config::setSystemRun($panelName,0);
		}else{
			config::setSystemRun($panelName,1);
		}
		
		router::back($this->request);
	}
	
	public function showTab() {
		$url = base64_decode($this->request->getVariable('id'));
		$tab = $this->request->getVariable('anchor');
		
		$url = HOME.$url;
		
		$tabNameArray=explode('_', $tab);
		
		cookie::setCookie('main-'.$tabNameArray[0],$tabNameArray[1],7200,'admin/');
		cookie::setCookie('openMainMenu','main-'.$tabNameArray[0],7200,'admin/');		
		
		router::redirect($url);
	}
	
	public function saveLessVariables() {
		$url = urldecode(urldecode($this->request->getVariable('id')));
		$variablesString = urldecode($this->request->getVariable('anchor'));
		$variablesArrayPom = explode(',',$variablesString);
		foreach($variablesArrayPom as $variableLine){
			if ($variableLine!='') {
				$varPom = explode(':',$variableLine);
				$finalVariablesArray[$varPom[0]] = $varPom[1];
			}
		}
		less::replaceVariables($url, $finalVariablesArray);
		cache::flushAllCache();
		echo  lang::read('admin.do.controller.changes');
	}
	public function setLanguage() {
		$user = usersDB::getLoggedUser();
		config::set('language-admin-'.$user->id, $this->request->getVariable('id'));
        cache::flushSmartyStaticCache();
		router::back($this->request);
	}
	public function setPageTemplate() {
		$templateName = $this->request->getVariable('id');
		$pageId = $this->request->getVariable('anchor');
		
		$pagesDB = new pagesDB();
		$pagesDB->set($pageId, 'tpl', $templateName);
		
		router::reloadParent();
	}	
	public function closeGoProBanner() {
		$user = usersDB::getLoggedUser();
		cookie::setCookie('closeGoProBanner',1,3600*24*7);
		router::back($this->request);
	}	
}
?>