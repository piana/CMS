<?php  /*windu.org image*/

Class imageBase extends baseFile
{
	protected static function saveImage($file)
	{
		$type = explode('/',$file['type']);
		
		if ($type[0]=='image')
		{
			return self::save($file);
		}
		else
		{
			return false;
		}
	}
	
	//imgPath odnosi sie do do sciezki wewnatrz katalogu z plikami files zdefiniowanej w configu
	protected static function deleteImageFiles($imgPath,$imgName)
	{
		$path = FILES_DIR.$imgPath.'/';
		$thumbsPath = FILES_DIR.$imgPath.'/thumbs';
		$fileBig = $path.$imgName;
		
		$fileName = explode('.', $imgName);		
		
		if (is_dir($thumbsPath))
		{
			if($handle = opendir($thumbsPath))
			{
			 	while (false !== ($file = readdir($handle)))
				{ 
					if (preg_match('/'.$fileName[0].'/',$file)>0)
			 		{
			 			self::delete($thumbsPath.'/'.$file);
			 		}
				}
			}
			$dir = scandir($thumbsPath);	
			if(count($dir)<=2){rmdir($thumbsPath);}
		}
		$deleteBig = self::delete($fileBig);

		$dir = scandir($path);
		if(count($dir)<=2){rmdir($path);}

		return $deleteBig;
	}
}
?>