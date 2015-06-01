<?php 
if( !defined( 'ADMIN_PAGE' ) )
  exit( 'Script by OpenSolution.org' );

if( isset( $_POST['sOption'] ) && isset( $_GET['sLangEdit'] ) && !empty( $_GET['sLangEdit'] ) && preg_match( '/^[a-z]{2}$/', $_GET['sLangEdit'] ) ){
  saveVariables( $_POST, $config['dir_database'].'lang_'.$_GET['sLangEdit'].'.php', 'lang' );
  header( 'Location: '.$config['admin_file'].'?p='.$_GET['p'].'&sOption=save&sLangEdit='.$_GET['sLangEdit'] );
  exit;
}
elseif( isset( $_GET['sItemDelete'] ) && !empty( $_GET['sItemDelete'] ) && preg_match( '/^[a-z]{2}$/', $_GET['sItemDelete'] ) ){
  deleteLanguage( $_GET['sItemDelete'] );
  header( 'Location: '.$config['admin_file'].'?p='.$_GET['p'].'&sOption=del' );
  exit;
}

$sSelectedMenu = 'tools';
require_once 'templates/admin/_header.php';
require_once 'templates/admin/_menu.php';

$aVariables = ( isset( $_GET['sLangEdit'] ) && preg_match( '/^[a-z]{2}$/', $_GET['sLangEdit'] ) ) ? listLangVariables( $_GET['sLangEdit'] ) : null;
?>
<section id="body" class="langs">
  <h1><?php echo $lang['Languages'].( isset( $_GET['sLangEdit'] ) ? ' '.$_GET['sLangEdit'] : null ); ?></h1>
  <?php if( isset( $config['manual_link'] ) ){
    echo '<div class="manual"><a href="'.$config['manual_link'].'instruction#languages" title="'.$lang['Help'].'" target="_blank"></a></div>';
  }?>

  <?php
  if( isset( $_GET['sOption'] ) ){
    echo '<h2 class="msg">'.$lang['Operation_completed'].'</h2>';
  }
  if( isset( $aVariables ) ){
  ?>
    <form action="#" method="get" class="search box" onsubmit="return false;">
      <fieldset>
        <label for="sSearch"><?php echo $lang['search']; ?></label> <input type="text" name="sSearch" id="sSearch" class="search" placeholder="<?php echo $lang['search']; ?>" value="" size="50" onkeyup="listSearch( this, 'tab-front-end', true )" />
      </fieldset>
    </form>

    <form action="?p=<?php echo $_GET['p']; ?>&amp;sLangEdit=<?php echo $_GET['sLangEdit']; ?>" name="form" method="post" class="main-form">
      <fieldset>
        <ul class="buttons">
          <li class="save"><input type="submit" name="sOption" class="main" value="<?php echo $lang['save']; ?>" /></li>
        </ul>
        <ul class="tabs">
          <!-- tabs start -->
          <li id="front-end" class="selected"><a href="#"><?php echo $lang['Front_end_back_end']; ?></a></li>
          <li id="back-end"><a href="#"><?php echo $lang['Back_end_only']; ?></a></li>
          <!-- tabs end -->
        </ul>
        <script>
        $(function(){
          var sCurrentTab = displayTabInit( changeSearchAttr );
          if( $( '#tab-'+sCurrentTab ).length > 0 )
            $( '.search input' ).attr( 'onkeyup', " listSearch( this, 'tab-"+sCurrentTab+"', true )" );
        });
        </script>

        <ul id="tab-front-end" class="forms list">
          <?php echo $aVariables[0]; ?>
        </ul>
        <ul id="tab-back-end" class="forms list">
          <?php echo $aVariables[1]; ?>
        </ul>

        <ul class="buttons bottom">
          <li class="save"><input type="submit" name="sOption" class="main" value="<?php echo $lang['save']; ?>" /></li>
        </ul>

      </fieldset>
    </form>
  <?php
  }
  else{
  ?>
  <table class="list">
    <thead>
      <tr>
        <th class="name"><?php echo $lang['Name']; ?></th>
        <th class="options">&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <?php echo listLanguages( ); ?>
    </tbody>
  </table>
  <?php } ?>
</section>
<?php
require_once 'templates/admin/_footer.php';
?>
