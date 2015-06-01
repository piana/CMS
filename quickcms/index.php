<?php
/*
* Quick.Cms by OpenSolution.org
* www.OpenSolution.org
*/
define( 'CUSTOMER_PAGE', true );
require_once 'database/config.php';

if( isset( $config['display_hidden_pages'] ) )
 session_start( );

header( 'Content-Type: text/html; charset=utf-8' );
require_once 'core/libraries/file-jobs.php';
require_once 'core/libraries/trash.php';
require_once 'core/libraries/sql.php';
$oSql = Sql::getInstance( );

require_once 'core/common.php';
getBinValues( );

require_once 'templates/'.$config['skin'].'/_lists.php';
require_once 'core/pages.php';
$oPage = Pages::getInstance( );

require_once 'core/files.php';
$oFile = Files::getInstance( );

if( isset( $config['enabled_sliders'] ) ){
  require_once 'core/sliders.php';
  $oSlider = Sliders::getInstance( );
}
$aVisits = simpleCounter( );
if( isset( $config['current_page_id'] ) && is_numeric( $config['current_page_id'] ) && isset( $oPage->aPages[$config['current_page_id']] ) ){
  $aData = $oPage->throwPage( $config['current_page_id'] );

  if( !empty( $aData['sRedirect'] ) ){
    header( 'Location: '.$aData['sRedirect'] );
    exit;
  }

  $config['title'] = trim( !empty( $aData['sTitle'] ) ? $aData['sTitle'] : strip_tags( $aData['sName'] ) ).' - '.$config['title'];
  if( !empty( $aData['sDescriptionMeta'] ) )
    $config['description'] = $aData['sDescriptionMeta'];
  $aData['sPagesTree'] = $oPage->getPagesTree( $aData['iPage'] );
  $aThemes = throwThemeFiles( $aData['iTheme'] );
  
  if( empty( $aData['sDescriptionFull'] ) && !empty( $aData['sDescriptionShort'] ) )
    $aData['sDescriptionFull'] = $aData['sDescriptionShort'];
}
elseif( isset( $_GET['p'] ) ){
  if( $_GET['p'] == 'test' ){
  }
  // plugins actions
  else{
    $bError404 = true;
  }
}
else{
  $bError404 = true;
}

if( isset( $bError404 ) ){
  header( "HTTP/1.0 404 Not Found\r\n" );
  $config['title'] = $lang['404_error'].' - ';
  //$aThemes['sMain'] = '404.php';
}

if( !isset( $aThemes ) )
  $aThemes = throwThemeFiles( 1 );

require_once 'templates/'.$config['skin'].'/'.$aThemes['sMain'];
?>