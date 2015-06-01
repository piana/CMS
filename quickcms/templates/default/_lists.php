<?php
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;

/**
* Displays page in the menu - default settings
* @return string
* @param array $aData
* @param array $aParametersExt
*/
function listPagesMenuView( $aData, $aParametersExt ){
  $sClassName = null;
  if( isset( $aParametersExt['bSelected'] ) )
    $sClassName .= 'selected';
  return '<li'.( isset( $sClassName ) ? ' class="'.$sClassName.'"' : null ).'><a href="'.$aData['sLinkName'].'">'.$aData['sName'].'</a>'.$aParametersExt['sSubMenu'].'</li>';
} // end function listPagesMenu

/**
* Displays page in the list - default settings
* @return string
* @param array $aData
* @param array $aParametersExt
*/
function listPagesView( $aData, $aParametersExt ){
  $oFile = Files::getInstance( );
  //return '<li'.( ( $aParametersExt['iElement'] % 4 ) == 1 ? ' class="row"' : null ).'>'. // oldie
  return '<li>'.
    $oFile->getDefaultImage( $aData['iPage'], Array( 'sLink' => ( !isset( $aParametersExt['bNoLinks'] ) ? $aData['sLinkName'] : null ), 'bNoLinks' => ( isset( $aParametersExt['bNoLinks'] ) ? true : null ) ) ). // image
    '<h2>'.( !isset( $aParametersExt['bNoLinks'] ) ? '<a href="'.$aData['sLinkName'].'">' : null ).$aData['sName'].( !isset( $aParametersExt['bNoLinks'] ) ? '</a>' : null ).'</h2>'. // name and link to page
    ( !empty( $aData['sDescriptionShort'] ) ? '<div class="description">'.$aData['sDescriptionShort'].'</div>' : null ). // short description here
    '</li>';
} // end function listPagesView

/**
* Displays images
* @return string
* @param array $aData
* @param array $aParametersExt
*/
function listImagesView( $aData, $aParametersExt ){
  //return '<li'.( ( $aParametersExt['iElement'] % 4 ) == 1 ? ' class="row"' : null ).'>'. // oldie
  return '<li>'.
  ( !isset( $aParametersExt['bNoLinks'] ) ? '<a href="files/'.$aData['sFileName'].'" class="quickbox['.( isset( $aData['iPage'] ) ? $aData['iPage'] : 0 ).']" title="'.$aData['sDescription'].'">' : null ).'<img src="files/'.$aData['iSize'].'/'.$aData['sFileName'].'" alt="'.( !empty( $aData['sDescription'] ) ? $aData['sDescription'] : null ).'" />'.( !isset( $aParametersExt['bNoLinks'] ) ? '</a>' : null ).( !empty( $aData['sDescription'] ) ? '<p>'.$aData['sDescription'].'</p>' : null ).'</li>';
} // end function listImagesView

/**
* Displays files
* @return string
* @param array $aData
* @param array $aParametersExt
*/
function listFilesView( $aData, $aParametersExt ){
  return '<li class="'.$aData['sIconStyle'].'"><a href="files/'.$aData['sFileName'].'">'.$aData['sFileName'].'</a>'.( !empty( $aData['sDescription'] ) ? '<p>'.$aData['sDescription'].'</p>' : null ).'</li>';
} // end function listFilesView

/**
* Displays sliders
* @return string
* @param array $aData
* @param array $aParametersExt
*/
function listSlidersView( $aData, $aParametersExt ){
  return '<li class="slide'.$aData['iSlider'].' '.( !empty( $aData['sFileName'] ) ? 'img' : 'no-img' ).'">'.( !empty( $aData['sFileName'] ) ? '<img src="files/'.$aData['sFileName'].'" alt="Slider '.$aData['iSlider'].'" />' : null ).( !empty( $aData['sDescription'] ) ? '<div class="description">'.$aData['sDescription'].'</div>' : null ).'</li>';
} // end function listSlidersView
?>