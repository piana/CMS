<?php 
if( !defined( 'ADMIN_PAGE' ) )
  exit( 'Script by OpenSolution.org' );

require_once 'core/sliders-admin.php';

if( isset( $_POST['sDescription'] ) ){
  $iSlider = saveSlider( $_POST );
  if( isset( $_POST['sOptionList'] ) )
    header( 'Location: '.$config['admin_file'].'?p=sliders&sOption=save' );
  elseif( isset( $_POST['sOptionAddNew'] ) )
    header( 'Location: '.$config['admin_file'].'?p=sliders-form&sOption=save' );
  else
    header( 'Location: '.$config['admin_file'].'?p=sliders-form&sOption=save&iSlider='.$iSlider );
  exit;
}

if( isset( $_GET['iSlider'] ) && is_numeric( $_GET['iSlider'] ) ){
  $aData = throwSlider( $_GET['iSlider'] );
}

$sSelectedMenu = 'sliders';
require_once 'templates/admin/_header.php';
require_once 'templates/admin/_menu.php';
?>

<section id="body" class="sliders">

  <h1><?php echo ( isset( $aData['iSlider'] ) ) ? $lang['Sliders_form'] : $lang['New_slider']; ?></h1>
  <?php if( isset( $config['manual_link'] ) ){
    echo '<div class="manual"><a href="'.$config['manual_link'].'instruction#sliders-form" title="'.$lang['Help'].'" target="_blank"></a></div>';
  }
  if( isset( $_GET['sOption'] ) ){
    echo '<h2 class="msg">'.$lang['Operation_completed'].'</h2>';
  }?>

  <form action="?p=<?php echo $_GET['p']; ?>" enctype="multipart/form-data" name="form" method="post" class="main-form no-tabs">
    <fieldset>
      <input type="hidden" name="iSlider" value="<?php if( isset( $aData['iSlider'] ) ) echo $aData['iSlider']; ?>" />

      <ul class="buttons">
        <li class="save"><input type="submit" name="sOption" class="main" value="<?php echo $lang['save']; ?>" /></li>
        <li class="options"><input type="submit" value="<?php echo $lang['save_add_new']; ?>" name="sOptionAddNew" />
          <ul>
            <li><input type="submit" value="<?php echo $lang['save_list']; ?>" name="sOptionList" /></li>
          </ul>
        </li>
      </ul>
      <ul id="tab-content" class="forms list">
        <?php if( !empty( $aData['iSlider'] ) ){ ?>
        <li>
          <?php echo $lang['Image'].' - <a href="files/'.$aData['sFileName'].'" target="_blank">'.$aData['sFileName'].'</a>'; ?>
        </li>
        <?php }
        else{ ?>
        <li>
          <label for="sFileName"><?php echo $lang['Image']; ?></label>
          <input type="file" name="aFile" id="sFileName" data-form-check="ext;<?php echo $config['allowed_image_extensions']; ?>" /> <span class="ext"><?php echo str_replace( '|', ' | ', $config['allowed_image_extensions'] ); ?></span>
          <script>$(function(){ $('.main-form').quickform(); } )</script>
        </li>
        <?php } ?>
        <li>
          <label for="sDescription"><?php echo $lang['Description']; ?></label>
          <?php echo getTextarea( 'sDescription', isset( $aData['sDescription'] ) ? $aData['sDescription'] : null ); ?>
        </li>
        <li>
          <label for="iPosition"><?php echo $lang['Position']; ?></label>
          <input type="text" id="iPosition" name="iPosition" value="<?php echo isset( $aData['iPosition'] ) ? $aData['iPosition'] : 0; ?>" class="numeric" size="3" maxlength="4" />
        </li>
        <li class="ext-feature">
          <label for="iType"><?php echo $lang['Type']; ?></label>
          <select name="" id="iType"><?php echo getSelectFromArray( ( $config['admin_lang'] == 'pl' ? Array( 1 => 'Nagłówek', 2 => 'Widżet 1', 3 => 'Widżet 2' ) : Array( 1 => 'Header', 2 => 'Widget 1', 3 => 'Widget 2' ) ), 0 ); ?></select>
          <span class="ext-info"><a href="#" class="quickbox" data-quickbox-msg="ext-features"><?php echo $lang['Available_in_Ext']; ?></a></span>
        </li>
        <!-- tab content -->
      </ul>


      <ul class="buttons bottom">
        <li class="save"><input type="submit" name="sOption" class="main" value="<?php echo $lang['save']; ?>" /></li>
        <li class="options"><input type="submit" value="<?php echo $lang['save_add_new']; ?>" name="sOptionAddNew" />
          <ul>
            <li><input type="submit" value="<?php echo $lang['save_list']; ?>" name="sOptionList" /></li>
          </ul>
        </li>
      </ul>

    </fieldset>
  </form>

</section>
<?php
require_once 'templates/admin/_footer.php';
?>
