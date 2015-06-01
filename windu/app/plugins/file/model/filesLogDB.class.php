<?php
class filesLogDB extends traceDB
{
	function __construct($customMySQL = array())
	{
		$this->otherDbFile = FILE_DB_LOG_FILE;
		parent::__construct($customMySQL);
	}		
	public function add($file) {
		$data['fileId'] = $file->id;
		
		$usersDB = new usersDB();
		$user = $usersDB->getLoggedIn();		
		if ($user!=null) {
			$data['userId'] = $user->id;
		}		
		parent::insert($data);
	}
	public function getDownloads($id) {
		return $this->fetchCount("fileId = $id");
	}
	public function deleteByFileId($fileId) {
		return $this->deleteRows("fileId = {$fileId}");
	}
}
?>