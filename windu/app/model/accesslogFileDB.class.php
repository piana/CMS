<?php /*windu.org model*/
class accesslogFileDB
{
	function __construct()
	{
		$this->dir = DATA_PATH.'log/accesslog/';
		$time = date('Y-m-d',strtotime('now'));

		$this->actualFilePath = $this->dir.$time.'.log';
	}
	public function add() {
		$data['insertTime'] = generate::sqlDatetime();
		$data['ip'] = generate::ip();		
		$data['url'] = $_SERVER['REQUEST_URI'];
				
		if (cookie::readCookie('pageVisited')!=1) {
			cookie::setCookie('pageVisited',1,86400);
			$data['visitCookie']=0;
		}else{
			$data['visitCookie']=1;
		}	

		baseFile::saveFile($this->actualFilePath , serialize($data)."\n",FILE_APPEND);
	}
	public static function moveLogsToDatabase() {
		if (config::getSystemRun("requestLog")) {
			$accesslogFileDB = new accesslogFileDB();
			$logsArray = $accesslogFileDB->getAllLogsArray();
			$accesLogDB = new accesslogDB();
			$accesLogDB->insertMultipleFast($logsArray);
			$accesslogFileDB->deleteOldFiles();
			cache::clearBucket('accessLog');
			cache::fileClearByBucket('accessLog');
			
			return 'accesslog.filedb.logsmoved_'.count($logsArray);
		}
	}
	
	private function getAllLogsArray() {
		$files = $this->getLogFileList();
		$finalArray = array();
		foreach ($files as $file){
			$fileArray = file($this->dir.$file);
			
			foreach ($fileArray as $fileRow){
				$row = unserialize($fileRow);

				if (is_array($row)) {
					$row['month'] = substr($row['insertTime'], 0, -12);
					$row['day'] = substr($row['insertTime'], 0, -9);
					$row['hour'] = substr($row['insertTime'], 0, -6); 
					$row['minuts'] = substr($row['insertTime'], 0, -3);
					
					$finalArray[] = $row;
				}
			}
		}
		return $finalArray;
	}
	private function getLogFileList(){
		$files = scandir($this->dir);
		unset($files[0]);
		unset($files[1]);
		return $files;
	}
	private function deleteOldFiles() {
		$files = $this->getLogFileList();
		foreach ($files as $file){
			baseFile::delete($this->dir.$file);
		}
	}
	public static function writeRequestToLog(){
		if (config::getSystemRun("requestLog")) {
			$acceslogDB = new accesslogFileDB();
			$acceslogDB->add();
		}
	}
}
?>
