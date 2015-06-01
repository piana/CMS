<?php /*windu.org core*/
class baseFile
{
	protected static function save($file)
	{
		if (DB_READ_ONLY_MODE==1) return true;	
		$mainPath = FILES_DIR;
		$type = explode('/',$file['type']);	

		if ($type[0]!='image') {
			$typePom = explode('.',$file['name']);
			$type[0] = $typePom[count($typePom)-1];
			$type[1] = $typePom[count($typePom)-1];
		}

		$nazwa = '';
		$katalog = '';
		$dest = '';
		
		while (file_exists($dest) or $nazwa=='' or $katalog=='')
		{
			$nazwa = generate::randomCode(6,2);
			$katalog = generate::randomCode(1,2);
			
			if (!is_dir("{$mainPath}{$type[0]}/{$katalog}"))
			{
				$oldumask = umask(0);
				if (!is_dir("{$mainPath}{$type[0]}"))
				{
					mkdir("{$mainPath}{$type[0]}", 0755);
				}
				mkdir("{$mainPath}{$type[0]}/{$katalog}", 0755);
				umask($oldumask);					
			}
			$dest = "{$mainPath}{$type[0]}/{$katalog}/{$nazwa}.{$type[1]}";
		}
		if(move_uploaded_file($file['tmp_name'],$dest))
		{
			$data['path']=$type[0].'/'.$katalog;
			$data['fileName']=$nazwa.'.'.$type[1];
			return $data;			
		}
		else
		{
			return false;
		}

	}
	public static function readFile($path)
	{
		$data = null;
		if (file_exists($path)) {
			$data = file_get_contents($path);
		}
		return $data;
	}
	public static function saveFile($path,$data,$flags = 0)
	{
		if (DB_READ_ONLY_MODE==1) return true;
		return file_put_contents($path, $data, $flags);
	}
	public static function createDir($path) {
		if(is_dir($path)) return false;
		mkdir($path, 0777);
		return true;
	}
	//delete files or if is dir delete dir
	public static function delete($path)
	{
		if (DB_READ_ONLY_MODE==1) return true;	
		
		if(is_dir($path)){
			return baseFile::deleteDir($path);
		}elseif(file_exists($path)){
			unlink($path);
			return true;
		}
		return false;
	}
	public static function deleteDir($dir,$saveFolder = false)
	{
		if (DB_READ_ONLY_MODE==1) return true;	
		
		
	    $dirPath=rtrim($dir,'/');
	    if (is_dir($dirPath)){
		    $folderList = glob($dirPath.'/*');
		    if (is_array($folderList)) {
		    	$files = array_filter(glob($dirPath.'/*'), 'is_file');
		    	if (is_array($files)){
		    		array_map( "unlink", $files );
		    	}	    	
		    }
	
		    $dirDP = opendir( $dirPath . '/' ); 
	    
	        while( $element = readdir( $dirDP ))
	        { 
	             if ($element!='.' and $element!='..')
	             {
	                 if (is_dir($dirPath . '/' . $element))
	                 {
	                 	self::deleteDir($dirPath . '/' . $element);
	                 }
	             } 
	        } 
	        closedir($dirDP); 
	        if($saveFolder==false){
	        	rmdir( $dirPath );
	        } 
	        return true;
	    }else{
	    	return false;
	    }		
	}
	public static function truncateDir($dir) {
		if (DB_READ_ONLY_MODE==1) return true;	
		self::deleteDir($dir,true);
	}
	public static function prepareFileVariable($filess){
		foreach ($filess as $files){
			if(is_array($files['name'])){
				foreach ($files as $key => $filesLine){
					$filesFin[$key] = $filesLine[0];
				}
				$fin[] = $filesFin;
			}else{
				$fin[] = $files;
			}
		}
		return $fin;
	}
	public static function getFilesList($dir,$fileType = null,$subFolders = false,$sort = null,$pregMatchName = null){
		if($handle = opendir($dir))
		{ $k=0;
			while (false !== ($file = readdir($handle)))
			{
				if ($pregMatchName!=null) {
					if (preg_match($pregMatchName, $file)) {$pregMatchNameBool = true;}else{$pregMatchNameBool = false;}
				}else{$pregMatchNameBool = true;}
				
				if ($file != "." && $file != ".." && $file != ".svn" && $pregMatchNameBool)
				{
					$fName = $file; $file = $dir.$file;
					$simplePath = str_replace(__SITE_PATH, '', $file);
					
					if (is_dir($file) and ($subFolders==true))
					{
						$files[$fName] = new stdClass();
						$files[$fName]->name=$fName;
						$files[$fName]->path=$file;
						$files[$fName]->pathSimple=$simplePath;
						$files[$fName]->subdir=self::getFilesList($files[$fName]->path.'/',$fileType,true);
					}
					elseif ((is_file($file)) and $file!='')
					{
						if (self::isFileType($fileType, $fName))
						{
							$files[$fName] = new stdClass();
							$files[$fName]->name=$fName;
							$files[$fName]->path=$file;
							$files[$fName]->pathSimple=$simplePath;
						}
					}
					elseif ($fileType=='dir' and is_dir($file)){
						$files[$fName] = new stdClass();
						$files[$fName]->name=$fName;
						$files[$fName]->path=$file;			
						$files[$fName]->pathSimple=$simplePath;			
					}
				}
			}
		}
		closedir($handle);
		
		if (is_array($files)){
			ksort($files);
			//generate::subvalArrayObjectsSort($files, 'name');
		}
		
		return $files;
	}
	public static function isFileType($fileType,$fName)
	{
		if($fileType!=null)
		{
			$isType = false;
			if(is_array($fileType))
			{
				foreach ($fileType as $type)
				{
					if(stristr(strtolower($fName),'.'.strtolower($type))){$isType = true;}
				}
			}
			else
			{
				if(stristr(strtolower($fName),'.'.strtolower($fileType))){$isType = true;}								
			}
			return $isType;
		}
		else
		{
			return true;
		}
		return false;
	}
	public static function getSize($path)
	{
		if (!is_dir($path)){
			if (!is_file($path)) {
				return null;
			}
			return filesize($path);
		}
		$size = 0;
		foreach (scandir($path) as $file)
		{
			if ($file=='.' or $file=='..') continue;

            if($path==__SITE_PATH){
                if(($file=='app' or $file=='data' or $file=='cache')){
                    $size+=self::getsize($path.'/'.$file);
                }
            }else{
			    $size+=self::getsize($path.'/'.$file);
            }
		}
		return $size;
	}	
	public static function uploadTo($destinationDir,$file)
	{
		if (file_exists($destinationDir.$file["name"])){unlink($destinationDir.$file["name"]);}
	    move_uploaded_file($file["tmp_name"],$destinationDir.generate::cleanFileName($file["name"]));
	}
	public static function replaceFile($destinationFile,$file)
	{
		if (file_exists($destinationFile)){unlink($destinationFile);}
	    move_uploaded_file($file["tmp_name"],$destinationFile);
	}	
	public static function copyDir($src,$dst,$exclude = array()) {
		if (DB_READ_ONLY_MODE==1) return true;
		$dir = opendir($src); 
		@mkdir($dst); 

		while(false !== ( $file = readdir($dir)) ) { 
			if (( $file != '.' ) && ( $file != '..' ) && ( $file != '.svn' ) && (!in_array($file,$exclude))) { 
				$sourceDir = $src.$file;
				if ( is_dir($sourceDir)) { 
					self::copyDir($sourceDir.'/', $dst.'/'.$file.'/', $exclude); 
				} else {  
					copy($sourceDir,$dst . '/' . $file); 
				} 
			} 
		}
		closedir($dir); 
	}
	public static function getExternalFileContent($url) {
		$data = externalContent::get($url);
		return $data;
	}
	public static function checkCHMOD($path,$exclude = array()) {
		$dir = opendir($path); 

		while(false !== ( $file = readdir($dir)) ) { 
			if (( $file != '.' ) && ( $file != '..' ) && ( $file != '.svn' ) && (!in_array($file,$exclude))) { 
				if ( @is_dir($path.'/'.$file)) { 
					if (!@is_writable($path.'/'.$file) and !@is_readable($path.'/'.$file)) {
						$error['file'][] = $path.'/'.$file;
					}
					self::checkCHMOD($path.'/'.$file,$exclude); 
				} 
				else {  
					if (!@is_writable($path.'/'.$file) or !@is_readable($path.'/'.$file)) {
						$error['dir'][] = $path.'/'.$file;
					}					
				} 
			} 
		}
		closedir($dir); 
		return $error;
	}	
	public static function rename($oldname,$newname) {
		if (DB_READ_ONLY_MODE==1) return true;	
		return rename($oldname, $newname);
	}
}

?>