<?php /*windu.org image controller*/
Class fileTempController extends controller
{	
	public function index(){
		$sessionKey = $this->request->getVariable('sessionKey');
		$sessionDB = new sessionDB();
		$ekey = $sessionDB->get($sessionKey,true,true);
		
		$filesDB = new filesDB();
		$file = $filesDB->getByEkey($ekey);
		
		if (!is_object($file)) {
			header('Content-Type: application/octet-stream');
			header("Content-Disposition:attachment; filename=Download-limit-exhausted.txt");
			passthru('Download limit exhausted from this link!');
			exit;			
		}

		$filePath=__SITE_PATH.'/'.FILES_DIR.'/'.$file->path.'/'.$file->fileName;
		
		$fileOpen = fopen($filePath,'rb');
		header('Content-Type: '.$file->realType);
		header("Content-Disposition:attachment; filename={$file->name}.{$file->type}");
		fpassthru($fileOpen);
		fclose($fileOpen);
		
		$log_filesDB = new filesLogDB();
		$log_filesDB->add($file);
	}
	
	public static function getTempKey($fileEkey,$usesNum = 5,$expire = 43200) {
		$sessionDB = new sessionDB();
		$cookieKey = cookie::readCookie(sha1($fileEkey));
		
		if ($cookieKey!=null and $sessionDB->hasUses($cookieKey)){
			$key = $cookieKey;
		}else{
			$key =  $sessionDB->set($fileEkey, $expire, $usesNum);
			cookie::setCookie(sha1($fileEkey),$key,$expire);
		}
		return $key;
	}
	
}
?>
