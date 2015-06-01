<?php /*windu.org core*/
/**
 * Class for handling compression
 * @author Krzysztof Ruszczyński <http://www.ruszczak.eu>
 * @author Adam Czajkowski
 */
class compress
{   
    /**
     * @const FILELISTKEY key for array with files used by _getFileAndDirectoryList methd output
     */
    const FILELISTKEY = 'files';
    
    /**
     * @const DIRECTORYLISTKEY key for array with directories used by _getFileAndDirectoryList methd output
     */
    const DIRECTORYLISTKEY = 'directory';
    
    /**
      * @var ZipArchive zip object
      */
    private static $_zip;
    
    /**
     * @var String path to folder or file to be compressed 
     */
    private static $_source; 
   
    /**
     * @var String path to compressed file
     */
    private static $_destination;
    
    /**
     * @var Array folders and file names which are going to be ignored in compression 
     */
    private static $_excludeNames = array('.svn');
    
    /**
     * @var Integer limit of bytes for input files for one archive (now not used) 
     */
    private static $_partSizeLimit = 10000000;
    
    /**
     * @param String $source path to folder or file to be compressed
     * @return void
     */
    private static function _setSource( $source )
    {
        self::$_source = $source;
    }
    
    /**
     * @param String $destination path to compressed file
     * @return void
     */
    private static function _setDestination( $destination )
    {
        self::$_destination = $destination;
    }
    
    /**
     * @param String $file absolute path to file or folder
     * @return String relative path to file or folder
     */
    private static function _getPathWithoutSource( $file )
    {
        return str_replace(self::$_source . DIRECTORY_SEPARATOR, '', $file);
    }
    
    /**
     * @todo Implement dividing input into one or more archives, depending on input size 
     * @param Boolean $doParts if set tot true, input is divided into one or more archives, depending on input size (by default false; TO BE IMPLEMENTED)
     * @return Array list of files and directories to be compressed
     */
    private static function _getFileAndDirectoryList( $doParts = false )
    {
        $output = array();
        $currentPart = 0;
    
        if ( is_dir(self::$_source) === true )
		{
	        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(self::$_source), RecursiveIteratorIterator::SELF_FIRST);
		    foreach ($files as $file)
		    {
		      	if ( !in_array($file, self::$_excludeNames) ) {
	                $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
						
		            if (is_dir($file) === true)
		            {
	                	$output[self::DIRECTORYLISTKEY][$currentPart][] = $file;
		            }
		            else if (is_file($file) === true)
		            {
	                	$output[self::FILELISTKEY][$currentPart][] = $file;
		            }
		       	}
		    }
		}
		else if (is_file(self::$_source) === true)
		{
	    	$output[self::FILELISTKEY][$currentPart][] = basename(self::$_source);
		}
        
        return $output;
    }
    
    /**
     * Function checking whether current system is capable of creating zip archives
     * @return void
     * @throws Exception
     */
    private static function _checkBefore()
    {
        if (!extension_loaded('zip'))
        {
            throw new Exception('No ZIP extension Installed on yout Server!'/*lang::read($key)*/);
        }
    }
    
    /**
     * Function creating new archive (uses self::$_destination variable to create new archive)
     * @return void
     * @throws Exception
     */
    private static function _createArchive()
    {
        if ( !self::$_zip->open(self::$_destination, ZIPARCHIVE::CREATE) )
        {
            throw new Exception('Cannot create ZIP archive on destination path!' . self::$_destination);
        }   
    }
    
    /**
     * Function opening existing archive (uses self::$_source variable to open archive)
     * @return void
     * @throws Exception
     */
    private static function _openArchive()
    {   
        if ( !self::$_zip->open(self::$_source) )
        {
            throw new Exception('Cannot open ZIP archive on destination path!' . self::$_source);
        }   
    }
    
    /**
     * Function checking consistency of just created archive
     * @param String $archiveSource path to archive that have to be checked (source for unzip, destination for zip)
     * @return void
     * @throws Exception
     */
    private static function _checkArchive( $archiveSource )
    {
    	$res = self::$_zip->open($archiveSource, ZIPARCHIVE::CHECKCONS);
    	
    	if ( $res !== TRUE) {
    		switch($res){
    			case ZipArchive::ER_EXISTS:
    				$ErrMsg = "File already exists.";
    				break;
    	
    			case ZipArchive::ER_INCONS:
    				$ErrMsg = "Zip archive inconsistent.";
    				break;
    	
    			case ZipArchive::ER_MEMORY:
    				$ErrMsg = "Malloc failure.";
    				break;
    	
    			case ZipArchive::ER_NOENT:
    				$ErrMsg = "No such file.";
    				break;
    	
    			case ZipArchive::ER_NOZIP:
    				$ErrMsg = "Not a zip archive.";
    				break;
    	
    			case ZipArchive::ER_OPEN:
    				$ErrMsg = "Can't open file.";
    				break;
    	
    			case ZipArchive::ER_READ:
    				$ErrMsg = "Read error.";
    				break;
    	
    			case ZipArchive::ER_SEEK:
    				$ErrMsg = "Seek error.";
    				break;
    	
    			default:
    				$ErrMsg = "Unknow (Code $rOpen)";
    				break;
    		}   
    		throw new Exception('Check constraint failed (archive: ' . $archiveSource . ')<br>Error message: <strong>'.$ErrMsg.'</strong>');
    	}
    }
    
    /**
     * Function responsible for adding empty directories to archive
     * @todo I think it is not working, maybe should be removed
     * @param Array $directoryList array with directories
     * @param Integer $currentPart number of current archive (default set to 0, if input is not divided this should not be changed)
     * @return void
     */
    private static function _addDirectories( $directoryList, $currentPart = 0 )
    {
        foreach( $directoryList[$currentPart] as $directory )
        {
            self::$_zip->addEmptyDir( self::_getPathWithoutSource( $directory ) );
        }
    }
        
    /**
     * Function responsible for adding files to archive
     * 
     * @param Array $fileList array with files
     * @param Integer $currentPart number of current archive (default set to 0, if input is not divided this should not be changed)
     * @return void
     */
    private static function _addFiles( $fileList, $currentPart = 0 )
    {
        foreach( $fileList[$currentPart] as $file )
        {
            self::$_zip->addFile( $file, self::_getPathWithoutSource( $file ) );
        }
    }
    
    /**
     * Function responsible for the whole process of creating archive
     * 
     * @param String $source path to folder or file to be compressed 
     * @param String $destination path to compressed file
     * @return void
     * @throws Exception
     */
    public static function zip($source, $destination)
    {
        self::_checkBefore();
        
        self::_setSource($source);
        self::_setDestination($destination);
        
        
        $fileAndDirectoryList = self::_getFileAndDirectoryList();
		self::$_zip = new ZipArchive();
		self::_createArchive();        

        self::_addDirectories($fileAndDirectoryList[self::DIRECTORYLISTKEY]);
        self::_addFiles($fileAndDirectoryList[self::FILELISTKEY]);

        self::$_zip->close();        
        
        self::_checkArchive( self::$_destination );
    }
    
    public static function unzip($source, $destination, $entries = '')
    {
        self::$_zip = new ZipArchive();
        
        self::_checkBefore();
        
        self::_setSource($source);
        self::_setDestination($destination);
        
        self::_checkArchive( self::$_source );
        
        self::_openArchive();
        
        if( empty($entries) )
        {   //extract all files
            self::$_zip->extractTo($destination);
        }
        else 
        {
            self::$_zip->extractTo($destination, $entries);
        }
    
        return false;
    }
    
	public static function getZipFile($fileName,$source) {
		$tempDir = CACHE_PATH.'temp/';
		$destination = $tempDir.time().'.zip';
		$fileName = rtrim($fileName,'.zip');
		
		if (!is_dir($tempDir)) baseFile::createDir($tempDir);

		compress::zip($source, $destination);

		$fileOpen = fopen($destination, 'rb');
		header('Content-type: application/octet-stream');
		header("Content-Disposition:attachment; filename={$fileName}.zip");
		fpassthru($fileOpen);
		baseFile::delete($destination);
	} 
}
