<?php
/**
* Save slider data
* @return int
* @param array $aForm
*/
function saveSlider( $aForm ){
  global $config;
  
  clearCache( 'sliders' );
  $oSql = Sql::getInstance( );
  $oIJ = ImageJobs::getInstance( );

  $aForm = changeMassTxt( $aForm, 'ndnl', Array( 'sDescription', 'nds ndnl' ) );

  $aForm['sFileName'] = ( ( !empty( $_FILES['aFile']['name'] ) && $oIJ->checkCorrectFile( $_FILES['aFile']['name'], $config['allowed_image_extensions'] ) ) ? $oIJ->uploadFile( $_FILES['aFile'], 'files/' ) : null );
  if( isset( $aForm['iSlider'] ) && is_numeric( $aForm['iSlider'] ) ){
    if( !isset( $aForm['sFileName'] ) )
      $aForm['sFileName'] = false;
    $oSql->update( 'sliders', $aForm, Array( 'iSlider' => $aForm['iSlider'] ), true );
  }
  else{
    $aForm['sLang'] = $config['language'];
    unset( $aForm['iSlider'] );
    $aForm['iSlider'] = $oSql->insert( 'sliders', $aForm, true );
  }

  return $aForm['iSlider'];
} // end function saveSlider

/**
* Returns slider data
* @return array
* @param int $iSlider
*/
function throwSlider( $iSlider ){
  $oSql = Sql::getInstance( );
  return $oSql->throwAll( 'SELECT * FROM sliders WHERE iSlider = "'.$iSlider.'"' );
} // end function throwSlider

/**
* List sliders
* @return string
*/
function listSlidersAdmin( ){
  global $lang;

  $oSql = Sql::getInstance( );
  $oQuery = $oSql->getQuery( 'SELECT * FROM sliders WHERE sLang = "'.$GLOBALS['config']['language'].'" ORDER BY iPosition ASC' );
  $i = 0;
  $content = null;
  while( $aData = $oQuery->fetch( PDO::FETCH_ASSOC ) ){
    $content .= '<tr class="l'.( ( ++$i % 2 ) ? 0: 1 ).'"><td>'.( !empty( $aData['sFileName'] ) ? '<a href="?p=sliders-form&amp;iSlider='.$aData['iSlider'].'"><img src="files/'.$aData['sFileName'].'" alt="" /></a>' : '<p>'.htmlspecialchars( $aData['sDescription'] ).'</p>' ).'</td><td>'.$aData['iPosition'].'</td><td class="options"><a href="?p=sliders-form&amp;iSlider='.$aData['iSlider'].'" class="edit">'.$lang['Edit'].'</a><a href="?p=sliders&amp;iItemDelete='.$aData['iSlider'].'" onclick="return del( )" class="delete">'.$lang['Delete'].'</a></td></tr>';
  } // end while

  return $content;
} // end function listSlidersAdmin

/**
* Deletes slider
* @return void
* @param int $iSlider
*/
function deleteSlider( $iSlider ){
  clearCache( 'sliders' );
  $oSql = Sql::getInstance( );
  $aData = throwSlider( $iSlider );
  if( isset( $aData['iSlider'] ) ){
    $oSql->query( 'DELETE FROM sliders WHERE iSlider = "'.$iSlider.'" ' );
    if( !empty( $aData['sFileName'] ) ){
      $oFile = FilesAdmin::getInstance( );
      $oFile->deleteFilesFromDirs( $aData['sFileName'] );
    }
  }
} // end function deleteSlider
?>