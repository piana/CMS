<?php
if( !defined( 'FILES_CHMOD' ) )
  define( 'FILES_CHMOD', 0777 );

/**
* FileJobs
* @version  0.7
* @author   OpenSolution
*/
class FileJobs
{

  protected $sFileName;
	protected $sChmod = FILES_CHMOD;
  protected $bChangeNamesToLowerCase = true;
	
  /**
  * Add name to variable
  * @return void
  * @param string $sFileName
  */
  public function setFileName( $sFileName ){
    $this->sFileName = $sFileName;
  } // end function setFileName
	
  /**
  * Creates file
  * @return bool
  * @param string $sFileName
  */
	public function addFile( $sFileName = null ){
		
		if( isset( $sFileName ) )
			$this->setFileName( $sFileName );	

		if( is_file( $this->sFileName ) )
			return false;
		else{
			touch( $this->sFileName );
			chmod( $this->sFileName, $this->sChmod );
			if( is_file( $this->sFileName ) )
				return true;
			else
				return false;
		}
	} // end function addFile

  /**
  * Return file name without extension
  * @return string
  * @param string $sName
  */
	public function getNameOfFile( $sName ){
		$aExp = explode( '.', $sName );
    if( isset( $aExp[0] ) && isset( $aExp[1] ) ){
      array_pop( $aExp );
      return implode( '.', $aExp );
    }
    else
      return $sName;
	} // end function getNameOfFIle

  /**
  * Return extension from file name
  * @return string
  * @param string $sName
  */
	public function getExtOfFile( $sName ){
		$aExp = explode( '.', $sName );
    if( isset( $aExp[0] ) && isset( $aExp[1] ) ){
      return $aExp[count( $aExp ) - 1]; 
    }
    else
      return null;
	} // end function getExtOfFile

  /**
  * Return extension and file name in array
  * @return array
  * @param string $sName
  */
  public function throwNameExtOfFile( $sName ){
    return Array( $this->getNameOfFile( $sName ), $this->getExtOfFile( $sName ) );
  } // end function throwNameExtOfFile

  /**
  * Return file content
  * @return string
  * @param string $sFile
  */
  public function getFile( $sFile ){
    return is_file( $sFile ) ? file_get_contents( $sFile ) : null;
  } // end function getFile

  /**
  * Check file extensions
  * For example if file have jpg or jpeg or gif or png extension then public function return true
  * @return int
  * @param string $sName
  * @param string $sSearch
  */
	public function checkCorrectFile( $sName, $sSearch = 'jpg|jpeg|png|gif' ){
		return preg_match( '/('.$sSearch.')/i', $this->getExtOfFile( $sName ) );
	} // end function checkCorrectFile

  /**
  * Change file name from strange name to latin
  * @return string
  * @param string $sFileName
  */
  public function changeFileName( $sFileName ){
    $sFileName = change2Latin( str_replace( Array( '$', '\'', '"', '~', '/', '\\', '?', '#', '%', '+', '*', ':', '|', '<', '>', ' ', '__', '.' ), '_', $sFileName ) );
    if( isset( $this->bChangeNamesToLowerCase ) )
      $sFileName = strtolower( $sFileName );
    return $sFileName;
  } // end function changeFileName

  /**
  * If file with set name exists then create uniq name for file
  * @return string
  * @param string $sFileOutName
  * @param string $sOutDir
  */
  public function checkIsFile( $sFileName, $sOutDir = '' ){
    
    $sName = $this->changeFileName( $this->getNameOfFile( $sFileName ) );
    $sExt = $this->changeFileName( $this->getExtOfFile( $sFileName ) );
    $sFileName = $sName.'.'.$sExt;

    for( $i = 1; is_file( $sOutDir.$sFileName ); $i++ )
      $sFileName = $sName.'['.$i.'].'.$sExt;

    return $sFileName;
  } // end function checkIsFile

  /**
  * Upload file on server
  * @return string
  * @param array  $aFiles
  * @param string $sOutDir
  * @param mixed  $sFileOutName
  */
  public function uploadFile( $aFiles, $sOutDir = null, $sFileOutName = null ){
    $sUpFileSrc = $aFiles['tmp_name'];
    if( !isset( $sFileOutName ) )
      $sFileOutName = $aFiles['name'];

    $sFileOutName = $this->checkIsFile( $sFileOutName, $sOutDir );

    if( move_uploaded_file( $sUpFileSrc, $sOutDir.$sFileOutName ) ){
      chmod( $sOutDir.$sFileOutName, $this->sChmod );
      return $sFileOutName;
    }
    else
      return null; 
  } // end function uploadFile

  /**
  * Delete all files and directories from directory
  * @return void
  * @param string $sDir
  */
  public function truncateDir( $sDir ){
    foreach( new DirectoryIterator( $sDir ) as $oFileDir ) {
      if( $oFileDir->isFile( ) ){
        unlink( $oFileDir->getPathname( ) );
      }
      else{
        if( $oFileDir->isDir( ) && ( !strstr( $oFileDir->getFilename( ), '.' ) && !strlen( $oFileDir->getFilename( ) ) < 3 ) ){
          $this->truncateDir( $oFileDir->getPathname( ).'/' );
          rmdir( $oFileDir->getPathname( ) );
        }
      }
    } // end foreach
  } // end function truncateDir

};
?>