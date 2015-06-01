<?php /*windu.org model*/
class backupDB
{
	function __construct(){
		$this->backupPath = BACKUPS_PATH;
		$this->dumpsPath = DUMPS_PATH;
		$this->backupDataPath = DATA_PATH;
	}	

	public function backupAll(){
		if (DB_READ_ONLY_MODE==1) return true;		
		
		$exclude = array('backups','dumps');
		baseFile::copyDir($this->backupDataPath, $this->backupPath.date("Y-m-d",time()).'_'.time(), $exclude);
		
		return 'admin.backupdb.class.php.backups';
	}
	public function cleanOldBackups($time=null){
		if (DB_READ_ONLY_MODE==1) return true;	
		if ($time==null) {
			$maximumTime = intval(time())-3600*24*90;
		}else{
			$maximumTime = intval(time())-$time;
		}	
		
		$filesList = scandir(BACKUPS_PATH);
		foreach ($filesList as $file){
			$filePom = rtrim($file,'.zip');
			$fileName = explode('_', $filePom);
			if (intval($fileName[1])<$maximumTime and intval($fileName[1])!=0) {
				baseFile::delete(BACKUPS_PATH.$file);
			}
		}
		return 'admin.backupdb.class.php.oldbackups_'.date("Y-m-d",$maximumTime);
	}	
	public function getCompressedBackup($backup) {
	   if (DB_READ_ONLY_MODE==1) return true;		
       compress::zip(BACKUPS_PATH . $backup, BACKUPS_PATH . $backup . '.zip');
	}

	public function restoreAll($backupId){
		if (DB_READ_ONLY_MODE==1) return true;	
		
		$backupPath = BACKUPS_PATH.$backupId.DIRECTORY_SEPARATOR;
		$backupFolder = BACKUPS_PATH;
		
		$tempBackupsDir = __SITE_PATH.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR.'backups'.DIRECTORY_SEPARATOR;
		$tempBackupDir = __SITE_PATH.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR.$backupId.DIRECTORY_SEPARATOR;
		$tempDataDir = __SITE_PATH.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;
		
		//Przygotowanie
		//Przenosze backup do folderu tymczasowego
		baseFile::rename($backupPath,$tempBackupDir);
		
		//Przenosze Wszystkie Backupy do folderu tymczasowego
		baseFile::rename($backupFolder,$tempBackupsDir);

		//Przenosze pozostale dane do foldeur tymczasegowe
		baseFile::rename(DATA_PATH,$tempDataDir);
			
		//Przenoszenie
		//Przywracam z kopi zapasowej
		baseFile::rename($tempBackupDir,DATA_PATH);
		
		//Przenosze pozostale backupy do folderu z backupami
		baseFile::rename($tempBackupsDir,$backupFolder);
		
		//Przenosze katalog z poprzednia wersja danych do katalogu z backupami
		baseFile::rename($tempDataDir,$backupFolder.date("Y-m-d-His",time()).DIRECTORY_SEPARATOR);
	}	
	public function delete($fileName){
		if (DB_READ_ONLY_MODE==1) return true;	
		
		baseFile::delete($this->backupPath.$fileName);
		if (file_exists($this->backupPath.$fileName.'.zip')) {
			baseFile::delete($this->backupPath.$fileName.'.zip');
		}
		return true;
	}

}
?>
