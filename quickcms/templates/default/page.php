<?php 
// More about design modifications - www.opensolution.org/docs/
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;

require_once 'templates/'.$config['skin'].'/'.$aThemes['sHeader']; // include design of header
?>
<article id="page">
<?php
if( isset( $aData['sName'] ) ){ // displaying pages and subpages content
  echo '<h1>'.$aData['sName'].'</h1>'; // displaying page name

  if( isset( $aData['sPagesTree'] ) )
    echo '<nav class="breadcrumb">'.$aData['sPagesTree'].'</nav>'; // displaying page tree (breadcrumb)

  echo $oFile->listImages( $aData['iPage'], Array( 'iType' => 1 ) ); // displaying images with type: left
  echo $oFile->listImages( $aData['iPage'], Array( 'iType' => 2 ) ); // displaying images with type: right
  
  if( isset( $aData['sDescriptionFull'] ) )
    echo '<div class="content">'.$aData['sDescriptionFull'].'</div>'; // full description

  echo $oFile->listFiles( $aData['iPage'] ); // display files included to the page
  echo $oPage->listPages( $aData['iPage'] ); // displaying subpages
}
else{
  echo ( isset( $config['message'] ) ? $config['message'] : '<div class="msg error"><h1>'.$lang['Data_not_found'].'</h1></div>' ); // displaying 404 error or other message
}
?>
</article>
<?php
require_once 'templates/'.$config['skin'].'/'.$aThemes['sFooter']; // include design of footer
?>
