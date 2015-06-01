<?php /*windu.org image controller*/
Class fileController extends controller
{	
	public function index(){
		$filesDB = new filesDB();
		$file = $filesDB->getByEkey($this->request->getVariable('ekey'),$this->request->getVariable('type'));
		
		//TODO kompresja plików po zmianie w zmiennej
		
		$filePath=__SITE_PATH.'/'.FILES_DIR.'/'.$file->path.'/'.$file->fileName;
		if ($this->request->getVariable('type')=='zip'){
			compress::getZipFile($file->name.'.zip',$filePath);
			$log_filesDB = new filesLogDB();
			$log_filesDB->add($file);
			exit;			
		}
		
		$fileOpen = fopen($filePath,'rb');
		
		$fileSize = filesize($filePath);
		header("Pragma: ");
   		header("Cache-Control: ");
		header('Content-Type: '.$file->realType);
		header("Content-Disposition:attachment; filename={$file->name}.{$file->type}");
		header("Content-length: {$fileSize}");
		header("Connection: close");
		fpassthru($fileOpen);
		fclose($fileOpen);		
		
		$log_filesDB = new filesLogDB();
		$log_filesDB->add($file);
	}
	
}
?>
