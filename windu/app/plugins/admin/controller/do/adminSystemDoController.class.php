<?php /*windu.org admin controller*/
Class adminSystemDoController Extends adminAuthDoController{
	public function clean(){
		$logDB = new logDB();
		$logDB->clean(strtotime('now - '.$this->request->getVariable('id').' days')); 
		router::back($this->request);
	}	
	public function cleanCronLog(){
		$cronlogDB = new cronlogDB();
		$cronlogDB->clean(strtotime('now - '.$this->request->getVariable('id').' days')); 
		router::back($this->request);
	}	
	public function clearAllCache() {
		cache::clearAll();
		router::back($this->request);
	}
	public function clearBucketCache(){
		cache::clearBucket($this->request->getVariable('id'));
		router::back($this->request);
	}	
	public function closeNotify() {
		$notifyDB = new notifyDB();
		$notifyDB->close($this->request->getVariable('id'));
		router::back($this->request);
	}	
	public function deleteNotify() {
		$notifyDB = new notifyDB();
		$notifyDB->delete($this->request->getVariable('id'));
		router::back($this->request);
	}	
	public function vacuumDatabase() {
		DB::vacuum();
		router::back($this->request);
	}
	public function cleanNotifications() {
		$notifyDB = new notifyDB();
		$notifyDB->closeAll();
		router::back($this->request);
	}		
	
	public function cleanAllNotifications() {
		$notifyDB = new notifyDB();
		$notifyDB->deleteRows("id>0");
		router::back($this->request);
	}
	
	//Clear all subsystems light
	public function vacuumSystem() {
		$accesslogDB = new accesslogDB();
		$accesslogDB->clean(time()-3600*24*90);

		$logsDB = new logDB();
		$logsDB->clean(time()-3600*24*90);	
		
		$cronlogsDB = new cronlogDB();
		$cronlogsDB->clean(time()-3600*24*90);			
		
		$backupBD = new backupDB();
		$backupBD->cleanOldBackups();		

		image::deleteImageThumbsAll();
		cache::flushAllCache();
		baseDB::vacuum();
		router::back($this->request);
	}	
	
	//Clear all subsystems strong
	public function cleanSystem() {
		$accesslogDB = new accesslogDB();
		$accesslogDB->clean(time()-3600*24);

		$logsDB = new logDB();
		$logsDB->clean(time()-3600*24);	
		
		$cronlogsDB = new cronlogDB();
		$cronlogsDB->clean(time()-3600*24);			
		
		$backupBD = new backupDB();
		$backupBD->cleanOldBackups(1);		

		image::deleteImageThumbsAll();
		cache::flushAllCache();
		baseDB::vacuum();
		router::back($this->request);
	}		
}
?>