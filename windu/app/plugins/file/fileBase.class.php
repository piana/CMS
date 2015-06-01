<?php  /*windu.org image*/

Class fileBase extends baseFile
{
	protected static function saveDownloadFile($file)
	{
		return self::save($file);
	}
	
	//imgPath odnosi sie do do sciezki wewnatrz katalogu z plikami files zdefiniowanej w configu
	protected static function deleteFiles($filePath,$fileName) 
	{
		$path = FILES_DIR.$filePath.'/';
		$thumbsPath = FILES_DIR.$filePath.'/thumbs';
		$fileBig = $path.$fileName;
		
		$fileName = explode('.', $fileName);		
		
		$deleteBig = self::delete($fileBig);

		$dir = scandir($path);
		if(count($dir)<=2){rmdir($path);}
		
		return $deleteBig;
	}
}
?>