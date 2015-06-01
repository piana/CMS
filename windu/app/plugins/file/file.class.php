<?php /*windu.org image*/

Class file extends fileBase
{		
	//zapisuje pliki przychodzace z formularza, wszystkie ktore napotka
	public static function saveIncomingFiles($bucket = 0,$returnObject = false)
	{
		$imgDB = new filesDB();
		//przygotowywuje zmienna na wypadek multiuploadu
		
		$files = self::prepareFileVariable($_FILES);

		foreach ($files as $file)
		{	
			$images[] = self::saveIncomingFile($file,$bucket,$returnObject);
		}
		
		return $images;
	}

	//zapisuje pojedynczy obrazek ze zmiennej rpzekazanej nam
	public static function saveIncomingFile($file, $bucket = 0,$returnObject = false)
	{
		$filesDB = new filesDB();
		//przygotowywuje zmienna na wypadek multiuploadu
		$data = self::saveDownloadFile($file);
		
		if ($data!=false)
		{
			$pomName = explode('.',$file['name']);
			$data['name'] = $pomName[0];
			$data['type'] = $pomName[count($pomName)-1];
			$data['realType'] = $file['type'];
			$data['size'] = $file['size'];
			$data['bucket'] = $bucket;
			$file = $filesDB->insert($data);
			$data['ekey'] = $file['ekey'];
		}
		if ($returnObject == true) {
			$data['url'] = HOME.FILES_DIR.$data['path'].'/'.$data['fileName'];
			$data = (object)$data;
		}
		$file = $data;

		return $file;
	}	
	public static function updateFile($id,$file,$data)
	{
		$filesDB = new filesDB();
		
		$newFile = file::saveIncomingFile($file);
		
		$oldFile = $filesDB->fetchRow("id={$id}");
		//delete old file
		self::deleteFile("ekey='{$oldFile->ekey}'",true);
		
		$pomName = explode('.',$file['name']);
		$data['id'] = $oldFile->id;
		$data['type'] = $pomName[count($pomName)-1];
		$data['realType'] = $file['type'];
		$data['size'] = $file['size'];
		$data['ekey'] = $oldFile->ekey;
		//replace new file data fron old file
		$filesDB->updateRow($data,"ekey='{$newFile['ekey']}'");

		return false;
	}	
	//usuwanie wsyztkich tam gdzie spelniony jest warunek where w bazie danych
	public static function deleteFile($where,$noLogDelete = false)
	{
		$filesDB = new filesDB();
		$files = $filesDB->fetchAll($where);
		foreach ($files as $file)
		{
			if(self::deleteFiles($file->path,$file->fileName))
			{
				$filesDB->delete($file->id,$noLogDelete);
			}		
		}
	}
	public static function deleteFileById($id) {
		self::deleteFile("id = {$id}");
	}
	public static function deleteFileByBucket($bucketId) {
		self::deleteFile("bucket = '{$bucketId}'");
	}	
	public static function deleteFileByEkey($ekey) {
		self::deleteFile("ekey = '{$ekey}'");
	}	

}
?>