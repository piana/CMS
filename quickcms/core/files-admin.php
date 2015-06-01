<?php
final class FilesAdmin extends Files
{

  private $aDirs;
  private $aFilesAll = null;
  private static $oInstance = null;

  public static function getInstance( $mValue = null ){  
    if( !isset( self::$oInstance ) ){  
      self::$oInstance = new FilesAdmin( );  
    }  
    return self::$oInstance;  
  } // end function getInstance

  /**
  * Constructor
  * @return void
  */
  private function __construct( ){
    $this->generateThumbDirs( );
  } // end function __construct

  /**
  * Returns thumbs directory names
  * @return array
  */
  private function generateThumbDirs( ){
    foreach( new DirectoryIterator( 'files/' ) as $oFileDir ) {
      if( is_numeric( $oFileDir->getFilename( ) ) && $oFileDir->isDir( ) ){
        $this->aDirs[$oFileDir->getFilename( )] = $oFileDir->getFilename( );
      }
    } // end foreach
  } // end function generateThumbDirs

  /**
  * Returns list of files in a directory
  * @return string
  * @param array $aParametersExt
  * Default options: sSort
  */
  public function listFilesInDir( $aParametersExt = null ){
    global $lang, $config;
    $content = null;
    $iTimeFile = 1;
    foreach( new DirectoryIterator( 'files/' ) as $oFileDir ) {
      $sFileName = $oFileDir->getFilename( );
      if( $oFileDir->isFile( ) && $sFileName != '.htaccess' ){
        $aFiles[$sFileName] = filemtime( 'files/'.$sFileName );
      }
    } // end foreach

    if( isset( $aFiles ) ){
      $oIJ = ImageJobs::getInstance( );

      if( isset( $aParametersExt['sSort'] ) && $aParametersExt['sSort'] == 'time' ){
        arsort( $aFiles );
        $iTimeFile = 0;
      }
      else{
        asort( $aFiles );
      }

      $iTime = time( );
      $i = 0;
      $iCount = count( $aFiles );
      foreach( $aFiles as $sFileName => $aValue ){
        $content .= '<tr class="l'.( ( $i % 2 ) ? 0: 1 ).( ( $iTime - $aValue[$iTimeFile] < 1200 ) ? ' time' : null ).'" id="fileTr'.$i.'"><td class="select custom"><input type="checkbox" name="aDirFiles['.$i.']" value="'.$sFileName.'" data-i="'.$i.'" data-img="'.( ( $oIJ->checkCorrectFile( $sFileName, $config['allowed_image_extensions'] ) == true ) ? 1 : 0 ).'" '.( isset( $_SESSION['aUploadedFiles'][$sFileName] ) ? 'checked="checked"' : null ).' id="oDF-'.$i.'" /><label for="oDF-'.$i.'">'.$lang['Delete'].'</label></td><td class="file"><a href="files/'.$sFileName.'" target="_blank">'.$sFileName.'</a></td><td class="position">&nbsp;</td><td class="description">&nbsp;</td><td class="location">&nbsp;</td><td class="thumb">&nbsp;</td></tr>';
        $i++;
      } // end foreach

      if( isset( $_SESSION['aUploadedFiles'] ) ){
        unset( $_SESSION['aUploadedFiles'] );
      }

      return '<li class="files-dir-head"><table><caption>'.$lang['Files_on_server'].'</caption><tbody><tr><th class="select">'.$lang['Select'].'</th><th class="file">'.$lang['File'].'</th><th class="position hidden">'.$lang['Position'].'</th><th class="description hidden">'.$lang['Description'].'</th><th class="location hidden">'.$lang['Location'].'</th><th class="thumb hidden">'.$lang['Thumbnail'].'</th></tr></tbody></table></li><li class="files-dir-body"><table id="files-dir-table"><tbody>'.$content.'</tbody></table><div class="space">&nbsp;</div></li>';
    }
  } // end function listFilesInDir

  /**
  * Uploads file to a server
  * @return string
  * @param string $sFileName
  */
  public function uploadFile( $sFileName ){
    global $config;
    $oIJ = ImageJobs::getInstance( );
    if( $oIJ->checkCorrectFile( $sFileName, $config['allowed_not_image_extensions'] ) || $oIJ->checkCorrectFile( $sFileName, $config['allowed_image_extensions'] ) ){
      $sFileNameNew = $oIJ->checkIsFile( $sFileName, 'files/' );  
      if( ( isset( $_FILES['sFileName']['tmp_name'] ) && move_uploaded_file( $_FILES['sFileName']['tmp_name'], 'files/'.$sFileNameNew ) ) || file_put_contents( 'files/'.$sFileNameNew, file_get_contents( "php://input" ) ) ){
        $_SESSION['aUploadedFiles'][$sFileNameNew] = true;
        return '{"success":true'.( ( $oIJ->checkCorrectFile( $sFileName, $config['allowed_image_extensions'] ) && $oIJ->checkImgMaxDimension( 'files/'.$sFileNameNew ) !== true ) ? ', "size_info":true' : null ).'}';
      }
      else{
        return '{"success":false}';
      }
    }
    else{
      return '{error:"Incorrect extension"}';
    }
  } // end function uploadFile

  /**
  * Lists all files on selected page
  * @return string
  * @param int $iPage
  */
  public function listAllFiles( $iPage ){
    global $config, $lang;

    $content = null;
    $oSql = Sql::getInstance( );
    $oQuery = $oSql->getQuery( 'SELECT * FROM files WHERE iPage = "'.$iPage.'" ORDER BY iType DESC, iPosition ASC, sFileName ASC' );
    $i = 0;
    while( $aData = $oQuery->fetch( PDO::FETCH_ASSOC ) ){
      $content .= '<tr class="l'.( ( $i % 2 ) ? 0: 1 ).'"><td class="custom"><input type="checkbox" name="aFilesDelete['.$aData['iFile'].']" id="oFD-'.$aData['iFile'].'" value="'.$aData['iFile'].'" data-img="'.$aData['iSize'].'" /><label for="oFD-'.$aData['iFile'].'">'.$lang['Delete'].'</label></td><td class="name"><a href="files/'.$aData['sFileName'].'" target="_blank">'.$aData['sFileName'].'</a></td><td class="position"><input type="text" name="aFilesPositions['.$aData['iFile'].']" value="'.$aData['iPosition'].'" size="2" maxlength="4" class="numeric" /></td><td class="description"'.( ( $aData['iSize'] == 0 ) ? ' colspan="4"' : null ).'><input type="text" name="aFilesDescription['.$aData['iFile'].']" value="'.$aData['sDescription'].'" size="20" class="input description"  /></td>'.( ( $aData['iSize'] > 0 ) ? '<td class="default"><input type="radio" name="iDefaultImage" value="'.$aData['iFile'].'"'.( $aData['iDefault'] == 1 ? ' checked="checked"' : null ).'/></td><td class="location"><select name="aFilesTypes['.$aData['iFile'].']">'.getSelectFromArray( $config['images_locations'], $aData['iType'] ).'</select></td><td class="thumb"><select name="aFilesSizes['.$aData['iFile'].']">'.getThumbnailsSelect( $aData['iSize'] ).'</select></td>' : null ).'</tr>';
      $i++;
    } // end while

    if( isset( $content ) ){
      return '<input type="hidden" name="iChangedFiles" id="iChangedFiles" value="1" /><table id="files-list"><thead><tr><th class="delete">'.$lang['Delete'].'</th><th class="name">'.$lang['File'].'</th><th class="position">'.$lang['Position'].'</th><th class="description">'.$lang['Description'].'</th><th class="default">'.$lang['Default'].'</th><th class="location">'.$lang['Location'].'</th><th class="thumb">'.$lang['Thumbnail'].'</th></tr></thead><tbody>'.$content.'</tbody></table>';
    }
  } // end function listAllFiles

  /**
  * Adds files from a server
  * @param array  $aForm
  * @param int    $iPage
  */
  public function addFilesFromServer( $aForm, $iPage ){
    global $config;

    if( isset( $aForm['aDirFiles'] ) ){
      $oIJ = ImageJobs::getInstance( );
      $oSql = Sql::getInstance( );

      foreach( $aForm['aDirFiles'] as $iKey => $sFile ){
        if( is_file( 'files/'.$sFile ) ){
          $sFileRaw = null;
          if( isset( $config['change_files_names'] ) && isset( $aForm['sName'] ) && !empty( $aForm['sName'] ) ){
            $sFileRaw = $sFile;
            $sFile = $oIJ->checkIsFile( $aForm['sName'].'.'.$oIJ->getExtOfFile( $sFile ), 'files/' );
          }

          if( isset( $sFileRaw ) && !is_file( 'files/'.$sFile ) )
            copy( 'files/'.$sFileRaw, 'files/'.$sFile );
          $iSize = ( isset( $aForm['aDirFilesSizes'][$iKey] ) && $oIJ->checkCorrectFile( $sFile, $config['allowed_image_extensions'] ) ) ? $aForm['aDirFilesSizes'][$iKey] : 0;
          $oSql->query( 'INSERT INTO files ( sFileName, iSize, iType, iPosition, sDescription, iDefault, iPage ) VALUES ( "'.$sFile.'", "'.$iSize.'", "'.( ( isset( $aForm['aDirFilesTypes'][$iKey] ) && is_numeric( $aForm['aDirFilesTypes'][$iKey] ) ) ? $aForm['aDirFilesTypes'][$iKey] : 1 ).'", "'.( ( isset( $aForm['aDirFilesPositions'][$iKey] ) && is_numeric( $aForm['aDirFilesPositions'][$iKey] ) ) ? $aForm['aDirFilesPositions'][$iKey] : 0 ).'", "'.changeTxt( trim( $aForm['aDirFilesDescriptions'][$iKey] ), 'ndnl' ).'", 0, "'.$iPage.'" )' );

          if( $iSize > 0 ){
            $this->generateThumbs( $sFile, $iSize );
          }

          if( isset( $sFileRaw ) ){
            $this->deleteFilesFromDirs( $sFileRaw, $iSize );
          }
        }
      }
    }
  } // end function addFilesFromServer

  /**
  * Saves data of files and images (description, position etc.) to flat files database
  * @return void
  * @param array $aForm
  * @param int $iPage
  */
  public function saveFiles( $aForm, $iPage = null ){
    if( isset( $aForm['aFilesDescription'] ) && is_array( $aForm['aFilesDescription'] ) ){
      if( isset( $aForm['aFilesDelete'] ) ){
        $this->deleteSelectedFiles( $aForm['aFilesDelete'] );
      }
      $oSql = Sql::getInstance( );
      $oQuery = $oSql->getQuery( 'SELECT * FROM files WHERE iPage = "'.$iPage.'" ORDER BY iPosition ASC' );
      while( $aData = $oQuery->fetch( PDO::FETCH_ASSOC ) ){
        if( !isset( $aForm['aFilesDelete'][$aData['iFile']] ) && isset( $aForm['aFilesDescription'][$aData['iFile']] ) ){
          if( isset( $aForm['aFilesSizes'][$aData['iFile']] ) && $aForm['aFilesSizes'][$aData['iFile']] != $aData['iSize'] && $aData['iSize'] > 0 ){
            $aUpdate[$aData['iFile']][] = 'iSize = "'.$aForm['aFilesSizes'][$aData['iFile']].'"';
            $aUpdateSize[$aData['iFile']][] = $aData['sFileName'];
            $aUpdateSize[$aData['iFile']][] = $aForm['aFilesSizes'][$aData['iFile']];
          }

          if( isset( $aForm['aFilesTypes'][$aData['iFile']] ) && $aForm['aFilesTypes'][$aData['iFile']] != $aData['iType'] ){
            $aUpdate[$aData['iFile']][] = 'iType = "'.$aForm['aFilesTypes'][$aData['iFile']].'"';
          }

          if( $aForm['aFilesPositions'][$aData['iFile']] != $aData['iPosition'] ){
            $aUpdate[$aData['iFile']][] = 'iPosition = "'.$aForm['aFilesPositions'][$aData['iFile']].'"';
          }

          $aForm['aFilesDescription'][$aData['iFile']] = changeTxt( trim( $aForm['aFilesDescription'][$aData['iFile']] ), 'ndnl' );
          if( $aForm['aFilesDescription'][$aData['iFile']] != $aData['sDescription'] ){
            $aUpdate[$aData['iFile']][] = 'sDescription = '.$oSql->quote( $aForm['aFilesDescription'][$aData['iFile']] );
          }
        }
      } // end while

      if( isset( $aUpdate ) ){
        foreach( $aUpdate as $iFile => $aFields ){
          $oSql->query( 'UPDATE files SET '.implode( ', ', $aFields ).' WHERE iFile = "'.$iFile.'"' );
        } // end foreach
        if( isset( $aUpdateSize ) ){
          foreach( $aUpdateSize as $iFile => $aValue ){
            $this->generateThumbs( $aValue[0], $aValue[1] );
          } // end foreach
        }
      }
    }
  } // end function saveFiles

  /**
  * Generates thumbnails
  * @return void
  * @param string $sFileName
  * @param int $iSize
  */
  private function generateThumbs( $sFileName, $iSize ){
    global $config;
    $oIJ = ImageJobs::getInstance( );
    $aImgSize = $oIJ->throwImgSize( 'files/'.$sFileName );
    if( isset( $config['max_dimension_of_image'] ) && is_numeric( $config['max_dimension_of_image'] ) && ( $aImgSize['width'] > $config['max_dimension_of_image'] || $aImgSize['height'] > $config['max_dimension_of_image'] ) && ( $aImgSize['width'] < MAX_IMAGE_SIZE && $aImgSize['height'] < MAX_IMAGE_SIZE ) ){
      $oIJ->setThumbSize( $config['max_dimension_of_image'] );
      $oIJ->createThumb( 'files/'.$sFileName, 'files/', $sFileName );
    }
    $sThumbsDir = 'files/'.$iSize.'/';

    if( !is_dir( $sThumbsDir ) ){
      mkdir( $sThumbsDir );
      chmod( $sThumbsDir, FILES_CHMOD );
    }

    if( !is_file( $sThumbsDir.$sFileName ) )
      $oIJ->createCustomThumb( 'files/'.$sFileName, $sThumbsDir, $iSize, $sFileName, true );
  } // end function generateThumbs

  /**
  * Set page default image
  * @return void
  * @param int $iPage
  * @param int $iFile
  */
  public function setDefaultImage( $iPage, $iFile = null ){
    $oSql = Sql::getInstance( );
    $oSql->query( 'UPDATE files SET iDefault = 0 WHERE iPage = "'.$iPage.'" AND iSize > 0'.( isset( $iFile ) ? ' AND iFile != "'.$iFile.'"' : null ) );
    if( isset( $iFile ) ){
      $oSql->query( 'UPDATE files SET iDefault = 1 WHERE iFile = "'.$iFile.'"' );
    }
    else{
      $oSql->query( 'UPDATE files SET iDefault = 1 WHERE iFile = "'.$oSql->getColumn( 'SELECT iFile FROM files WHERE iPage = "'.$iPage.'" AND iSize > 0 ORDER BY iPosition ASC, sFileName ASC LIMIT 1' ).'"' );
    }
  } // end function setDefaultImage

  /**
  * Deletes all files attached to pages that are being deleted
  * @return void
  * @param array  $aPages
  */
  public function deleteFiles( $aPages ){
    global $config;
    if( isset( $aPages ) && is_array( $aPages ) ){
      $oSql = Sql::getInstance( );
      $sWhere = implode( ' OR iPage = ', $aPages );
      if( isset( $config['delete_unused_files'] ) ){
        $oQuery = $oSql->getQuery( 'SELECT sFileName, iSize FROM files WHERE iPage = '.$sWhere );
        while( $aData = $oQuery->fetch( PDO::FETCH_ASSOC ) ){
          $aDelete[$aData['sFileName']] = $aData['iSize'];
        } // end while
        if( isset( $aDelete ) ){
          $oSql->query( 'DELETE FROM files WHERE iPage = '.$sWhere );
          foreach( $aDelete as $sFileName => $iSize ){
            $this->deleteFilesFromDirs( $sFileName, $iSize );
          } // end foreach
        }
      }
      else{
        $oSql->query( 'DELETE FROM files WHERE iPage = '.$sWhere );
      }
    }
  } // end function deleteFiles

  /**
  * Deletes all files selected for deletion
  * @return void
  * @param array  $aFiles
  */
  public function deleteSelectedFiles( $aFiles ){
    global $config;
    if( isset( $aFiles ) && is_array( $aFiles ) ){
      $oSql = Sql::getInstance( );
      $sWhere = implode( ' OR iFile = ', $aFiles );
      if( isset( $config['delete_unused_files'] ) ){
        $oQuery = $oSql->getQuery( 'SELECT sFileName, iSize FROM files WHERE iFile = '.$sWhere );
        while( $aData = $oQuery->fetch( PDO::FETCH_ASSOC ) ){
          $aDelete[$aData['sFileName']] = $aData['iSize'];
        } // end while
        if( isset( $aDelete ) ){
          $oSql->query( 'DELETE FROM files WHERE iFile = '.$sWhere );
          foreach( $aDelete as $sFileName => $iSize ){
            $this->deleteFilesFromDirs( $sFileName, $iSize );
          } // end foreach
        }
      }
      else{
        $oSql->query( 'DELETE FROM files WHERE iFile = '.$sWhere );
      }
    }
  } // end function deleteSelectedFiles

  /**
  * Deletes files and images from the "files/" directory
  * @return void
  * @param string $sFileName
  * @param int    $iSize
  */
  public function deleteFilesFromDirs( $sFileName, $iSize = null ){
    $oSql = Sql::getInstance( );
    $iData = $oSql->getColumn( 'SELECT iFile FROM files WHERE sFileName = "'.$sFileName.'"' );
    if( empty( $iData ) ){
      $iData = $oSql->getColumn( 'SELECT iSlider FROM sliders WHERE sFileName = "'.$sFileName.'"' );
    }
    if( empty( $iData ) ){
      if( isset( $iSize ) && $iSize > 0 && isset( $this->aDirs ) ){
        foreach( $this->aDirs as $iDir ){
          if( is_file( 'files/'.$iDir.'/'.$sFileName ) )
            unlink ( 'files/'.$iDir.'/'.$sFileName );
        } // ennd foreach
      }
      if( is_file( 'files/'.$sFileName ) )
        unlink( 'files/'.$sFileName );
    }
  } // end function deleteFilesFromDirs
};
?>