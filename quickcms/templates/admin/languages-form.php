<?php 
if( !defined( 'ADMIN_PAGE' ) )
  exit( 'Script by OpenSolution.org' );

if( isset( $_POST['sOption'] ) && !empty( $_POST['sName'] ) && preg_match( '/^[a-z]{2}$/', $_POST['sName'] ) ){
  addLanguage( $_POST );
  header( 'Location: '.$config['admin_file'].'?p=languages&sOption=save' );
  exit;
}

$sSelectedMenu = 'tools';
require_once 'templates/admin/_header.php';
require_once 'templates/admin/_menu.php';
?>

<section id="body" class="langs">

  <h1><?php echo $lang['New_language']; ?></h1>
  <?php if( isset( $config['manual_link'] ) ){
    echo '<div class="manual"><a href="'.$config['manual_link'].'instruction#languages-form" title="'.$lang['Help'].'" target="_blank"></a></div>';
  }
  if( isset( $_GET['sOption'] ) ){
    echo '<h2 class="msg">'.$lang['Operation_completed'].'</h2>';
  }?>

  <form action="?p=<?php echo $_GET['p']; ?>" enctype="multipart/form-data" name="form" method="post" class="main-form no-tabs">
    <fieldset>
      <ul class="buttons">
        <li class="save"><input type="submit" name="sOption" class="main" value="<?php echo $lang['save']; ?>" /></li>
      </ul>

      <ul id="tab-content" class="forms list">
        <li>
          <label for="sName"><?php echo $lang['Language']; ?></label>
          <input type="text" name="sName" id="sName" maxlength="2" tabindex="1" placeholder="<?php echo $lang['required']; ?>" data-form-check="required;2;2" />
        </li>
        <li>
          <label for="sLanguageFile"><?php echo $lang['Upload_language_file']; ?></label>
          <input type="file" name="aFile" id="sLanguageFile" /><span class="download"><?php echo $lang['Upload_language_file_info']; ?></span>
        </li>
        <li>
          <label for="sLangFrom"><?php echo $lang['Use_language']; ?></label>
          <select name="sLangFrom" id="sLangFrom">
            <?php echo listLangSelect( $config['default_language'] ); ?>
          </select>
        </li>
        <li class="custom ext-feature">
          <span class="label">&nbsp;</span>
          <input type="checkbox" name="" id="iClone" value="1" />
          <label for="iClone"><?php echo $lang['Clone_data_from_basic_language']; ?></label>
          <span class="ext-info"><a href="#" class="quickbox" data-quickbox-msg="ext-features"><?php echo $lang['Available_in_Ext']; ?></a></span>
        </li>
      </ul>

      <ul class="buttons bottom">
        <li class="save"><input type="submit" name="sOption" class="main" value="<?php echo $lang['save']; ?>" /></li>
      </ul>

    </fieldset>
  </form>
</section>
<script>
$(function(){
  $( ".main-form" ).quickform();
  customCheckbox();
});
</script>
<?php
require_once 'templates/admin/_footer.php';
?>