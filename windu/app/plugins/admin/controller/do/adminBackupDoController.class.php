<?php /*windu.org admin controller*/
Class adminBackupDoController Extends adminAuthDoController{

	public function backup(){
		$backupBD = new backupDB();
		$backupBD->backupAll();
		router::back($this->request);
	}	
	public function compress() {
		$backupBD = new backupDB();
		$backupBD->getCompressedBackup($this->request->getVariable('id'));
		cache::clearBucket('dirSize');
		router::back($this->request);
	}
	public function delete(){
		$backupDB = new backupDB();
		$backupDB->delete($this->request->getVariable('id'));
		router::back($this->request);
	}	
	public function restore() {
		$backupDB = new backupDB();
		$backupDB->restoreAll($this->request->getVariable('id'));
		router::back($this->request);
	}
}
?>
