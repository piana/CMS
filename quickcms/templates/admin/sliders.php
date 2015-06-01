<?php 
if( !defined( 'ADMIN_PAGE' ) )
  exit( 'Script by OpenSolution.org' );

require_once 'core/sliders-admin.php';

if( isset( $_GET['iItemDelete'] ) && is_numeric( $_GET['iItemDelete'] ) ){
  deleteSlider( $_GET['iItemDelete'] );
  header( 'Location: '.$config['admin_file'].'?p=sliders&sOption=del' );
  exit;
}

$sSelectedMenu = 'sliders';
require_once 'templates/admin/_header.php';
require_once 'templates/admin/_menu.php';
?>
<section id="body" class="sliders">
  <h1><?php echo $lang['Sliders']; ?></h1>
  <?php if( isset( $config['manual_link'] ) ){
    echo '<div class="manual"><a href="'.$config['manual_link'].'instruction#sliders" title="'.$lang['Help'].'" target="_blank"></a></div>';
  }
  if( isset( $_GET['sOption'] ) ){
    echo '<h2 class="msg">'.$lang['Operation_completed'].'</h2>';
  }?>

  <?php 
  $sSlidersList = listSlidersAdmin( );
  if( isset( $sSlidersList ) ){
  ?>
  <table class="list sliders">
    <thead>
      <tr>
        <th class="image-description"><?php echo $lang['Image']; ?></th>
        <th class="position"><?php echo $lang['Position']; ?></th>
        <th class="options">&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <?php echo $sSlidersList; ?>
    </tbody>
  </table>
  <?php
    }
    else{
      echo '<h2 class="msg error">'.$lang['Data_not_found'].'</h2>';
    }
  ?>

</section>
<?php
require_once 'templates/admin/_footer.php';
?>
