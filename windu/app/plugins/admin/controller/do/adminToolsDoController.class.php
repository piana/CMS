<?php /*windu.org admin controller*/
Class adminToolsDoController Extends adminAuthDoController{
	public function deleteRssUrl() {
		$urls = unserialize(config::get('rssUrls'));
		unset($urls[$this->request->getVariable('id')]);
		config::set('rssUrls', serialize($urls));
		router::back($this->request);
	}	
	public function deleteFile() {
		file::deleteFileById($this->request->getVariable('id'));
		router::back($this->request);
	}
	public function deleteFileAjax() {
		file::deleteFileById($this->request->getVariable('id'));
	}	
	public function refreshResuestLogData(){
		accesslogFileDB::moveLogsToDatabase();
		router::back($this->request);
	}
	public function cleanAccessLog(){
		$logDB = new accesslogDB();
		$logDB->clean(strtotime('now - '.$this->request->getVariable('id').' days')); 
		router::back($this->request);
	}	
	public function cleanMonitoring(){
		$systemStatusDB = new systemStatusDB();
		$systemStatusDB->clean(strtotime('now - '.$this->request->getVariable('id').' days')); 
		router::back($this->request);
	}		
	public function deleteFirewallIp(){
		$firewallDB = new firewallDB();
		$denyIp = $firewallDB->fetchRow("id={$this->request->getVariable('id')}");
		
		if($denyIp->status==0){
			$firewallDB->delete($this->request->getVariable('id'));
		}else{
			$firewallDB->update('status','0',"id={$this->request->getVariable('id')}");
		}
		router::back($this->request);
	}
	public function firewallRecreateHtaacess() {
		firewall::saveHtaacess();
		router::back($this->request);
	}	
	public function firewallDeactivateLocks() {
		$firewallDB = new firewallDB();
		$firewallDB->update('status', '0', 'id>0');
		router::back($this->request);
	}	
	public function firewallActivateLocks() {
		$firewallDB = new firewallDB();
		$firewallDB->update('status', '1', 'id>0');
		router::back($this->request);
	}			
	public function firewallDeleteAll() {
		$firewallDB = new firewallDB();
		$firewallDB->deleteRows('id>0');
		router::back($this->request);
	}	
	public function cleanMonitoringLog(){
		$systemStatusDB = new systemStatusDB();
		$systemStatusDB->clean(strtotime('now - '.$this->request->getVariable('id').' days')); 
		router::back($this->request);
	}	

	public function deleteRedirect() {
		$redirectDB = new redirectDB();
		$redirectDB->deleteRedirect($this->request->getVariable('id'));
		router::back($this->request);
	}	
	public function toggleCronConfig() {
		$config = config::get($this->request->getVariable('id'));
		if($config == '0'){
			config::set($this->request->getVariable('id'),1,configDB::CONFIG_BUCKET_SYSTEM);
		}else{
			config::set($this->request->getVariable('id'),0,configDB::CONFIG_BUCKET_SYSTEM);
		}
		router::back($this->request);
	}	
	public function toggleCronConfigAjax() {
		$config = config::get($this->request->getVariable('id'));
		if($config == '0'){
			config::set($this->request->getVariable('id'),1,configDB::CONFIG_BUCKET_SYSTEM);
		}else{
			config::set($this->request->getVariable('id'),0,configDB::CONFIG_BUCKET_SYSTEM);
		}
	}		
	public function ajaxMigrateTableMySQL(){
		$part = 1000;
		$dbConfig = unserialize(config::get('MySQLmigrationDatabaseConfig'));
		if ($dbConfig!=null) {
			$startRow = intval($this->request->getVariable('secoundId'));
			$tableName = $this->request->getVariable('id');
			
			$table = new $tableName();
			$rows = $table->fetchAll(null,null,'*',"$startRow,$part",null,array(),PDO::FETCH_ASSOC);
			
			if (count($rows)>=1) {
				$newTable = new $tableName($dbConfig);
				if ($startRow==0) {
					$newTable->deleteRows("id>=0");
				}
				
				$newTable->insertMultipleFast($rows);
		
				echo count($rows);
			}
			
			return TRUE;
		}
		config::set('MySQLmigrationError',1);
		echo '<span class="badge badge-error">Error</span>';
		return FALSE;
	}
}
?>