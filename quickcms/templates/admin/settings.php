<?php 
if( !defined( 'ADMIN_PAGE' ) )
  exit( 'Script by OpenSolution.org' );

if( isset( $_POST['sOption'] ) ){
  unset( $_POST['login_email'], $_POST['login_pass'] );
  if( !empty( $_POST['login_pass_old'] ) && !empty( $_POST['login_email_old'] ) && changeSpecialChars( $_POST['login_email_old'] ) == $config['login_email'] && changeSpecialChars( str_replace( '"', '&quot;', $_POST['login_pass_old'] ) ) == $config['login_pass'] ){
    if( !empty( $_POST['login_email_new'] ) && checkEmail( $_POST['login_email_new'] ) )
      $_POST['login_email'] = $_POST['login_email_new'];
    if( !empty( $_POST['login_pass_new'] ) )
      $_POST['login_pass'] = $_POST['login_pass_new'];
  }

  saveVariables( $_POST, $config['dir_database'].'config.php' );
  saveVariables( $_POST, $config['dir_database'].'config_'.$config['language'].'.php' );
  header( 'Location: '.$config['admin_file'].'?p=settings&sOption=save' );
  exit;
}

$sSelectedMenu = 'settings';
require_once 'templates/admin/_header.php';
require_once 'templates/admin/_menu.php';
?>
<section id="body" class="settings">

  <h1><?php echo $lang['Settings']; ?></h1>
  <?php if( isset( $config['manual_link'] ) ){
    echo '<div class="manual"><a href="'.$config['manual_link'].'instruction#settings" title="'.$lang['Help'].'" target="_blank"></a></div>';
  }
  if( isset( $_GET['sOption'] ) ){
    echo '<h2 class="msg">'.$lang['Operation_completed'].'</h2>';
  }?>

  <form action="?p=<?php echo $_GET['p']; ?>" name="form" method="post" class="main-form" onsubmit="return checkLoginChange( this );">
    <fieldset>
      <ul class="buttons">
        <li class="save"><input type="submit" name="sOption" class="main" value="<?php echo $lang['save']; ?>" /></li>
      </ul>

      <ul class="tabs">
        <!-- tabs start -->
        <li id="pages" class="selected"><a href="#"><?php echo $lang['Pages']; ?></a></li>
        <li id="loging"><a href="#"><?php echo $lang['Loging']; ?></a></li>
        <!-- <li id="options"><a href="#"><?php echo $lang['Options']; ?></a></li> --> <!-- An example of creating setting fields is described below -->
        <!-- tabs end -->
        <li class="help"><?php echo $lang['Settings_in_config_file'].' '.$config['dir_database']; ?>config.php</li>
      </ul>
      <script>
      var aLoginAjax = {};
      $(function(){
        displayTabInit();
      });
      </script>

      <ul id="tab-pages" class="forms list">
        <li>
          <label for="sStartPage"><?php echo $lang['Start_page']; ?></label>
          <select name="start_page" id="sStartPage"<?php if( isset( $config['disable_advanced_options'] ) ) echo ' disabled="disabled"'; ?>>
            <?php echo $oPage->listPagesSelectAdmin( $config['start_page'] ); ?>
          </select>
        </li>
        <li class="ext-feature">
          <label for="sSearchPage"><?php echo $lang['Search_page']; ?></label>
          <select name="" id="sSearchPage" disabled="disabled">
            <option value=""><?php echo $lang['none']; ?></option>
          </select>
          <span class="ext-info"><a href="#" class="quickbox" data-quickbox-msg="ext-features"><?php echo $lang['Available_in_Ext']; ?></a></span>
        </li>
        <li class="ext-feature">
          <label for="sSitemapPage"><?php echo $lang['Site_map_page']; ?></label>
          <select name="" id="sSitemapPage" disabled="disabled">
            <option value=""><?php echo $lang['none']; ?></option>
          </select>
          <span class="ext-info"><a href="#" class="quickbox" data-quickbox-msg="ext-features"><?php echo $lang['Available_in_Ext']; ?></a></span>
        </li>
        <!-- tab pages -->
      </ul>

      <ul id="tab-loging" class="forms list">
        <li class="new">
          <div>
            <label for="sLoginEmailNew"><?php echo $lang['Email_new']; ?></label>
            <input type="email" name="login_email_new" id="sLoginEmailNew" size="40" onchange="changeLoginData( 'email' );" onkeyup="changeLoginData( 'email' )" value="" />
            <em><?php echo $lang['and_or']; ?></em>
          </div>
          <div>
            <label for="sLoginPassNew"><?php echo $lang['Password_new']; ?></label>
            <input type="text" name="login_pass_new" id="sLoginPassNew" size="30" value="" onchange="changeLoginData( 'pass' )" onkeyup="changeLoginData( 'pass' )" />
          </div>
        </li>
        <li class="old">
          <div>
            <label for="sLoginEmailOld"><?php echo $lang['Email_old']; ?></label>
            <input type="email" name="login_email_old" id="sLoginEmailOld" size="40" value=""/>
            <em><?php echo $lang['and']; ?></em>
          </div>
          <div>
            <label for="sLoginPassOld"><?php echo $lang['Password_old']; ?></label>
            <input type="text" name="login_pass_old" id="sLoginPassOld" size="30" value="" />
          </div>
        </li>
        <!-- tab loging -->
      </ul>

      <!-- An example for creating setting fields -->
      <ul id="tab-options" class="forms list">
        <li>
          <label for="display_hidden_pages">Put here field description</label>
          <select name="display_hidden_pages" id="display_hidden_pages">
            <?php echo getYesNoSelect( $config['display_hidden_pages'] ); ?>
          </select>
          <em class="help">Example of the selection YES or NO, for variable which contains values: <strong>true</strong> or <strong>null</strong></em>
        </li>
        <li>
          <label for="name_of_config_variable_here">Put here field description</label>
          <input type="text" name="name_of_config_variable_here" id="name_of_config_variable_here" size="30" value="<?php echo ( isset( $config['name_of_config_variable_here'] ) ? $config['name_of_config_variable_here'] : null ); ?>" />
          <em class="help">Example of the text field, for variable $config['title'], name_of_config_variable_here will be <strong>title</strong></em>
        </li>
        <!-- tab options -->
      </ul>


      <ul class="buttons bottom">
        <li class="save"><input type="submit" name="sOption" class="main" value="<?php echo $lang['save']; ?>" /></li>
      </ul>

    </fieldset>
  </form>

</section>
<?php
require_once 'templates/admin/_footer.php';
?>