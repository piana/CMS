<?php 
if( !defined( 'ADMIN_PAGE' ) )
  exit( 'Script by OpenSolution.org' );

if( isset( $_POST['sOption'] ) ){
  $oPage->savePages( $_POST );
  header( 'Location: '.str_replace( '&amp;', '&', $_SERVER['REQUEST_URI'] ).( strstr( $_SERVER['REQUEST_URI'], 'sOption=' ) ? null : '&sOption=' ) );
  exit;
}

if( isset( $_GET['iItemDelete'] ) && is_numeric( $_GET['iItemDelete'] ) ){
  $oPage->deletePage( $_GET['iItemDelete'] );
  header( 'Location: '.$config['admin_file'].'?p=pages&sOption=del' );
  exit;
}

$sSelectedMenu = 'pages';
require_once 'templates/admin/_header.php';
require_once 'templates/admin/_menu.php';
?>

<section id="body" class="pages">

  <h1><?php echo $lang['Pages']; ?></h1>
  <?php if( isset( $config['manual_link'] ) ){
    echo '<div class="manual"><a href="'.$config['manual_link'].'instruction#pages" title="'.$lang['Help'].'" target="_blank"></a></div>';
  }

  if( isset( $_GET['sOption'] ) ){
    echo '<h2 class="msg">'.$lang['Operation_completed'].'</h2>';
  }
  ?>
  <form action="#" method="get" class="search box ext-feature" onsubmit="$('.ext-info a').trigger('click');return false;">
    <fieldset>
      <label for="sSearch"><?php echo $lang['search']; ?></label> <input type="text" name="" id="sSearch" class="search" value="" size="50" onclick="$('.ext-info a').trigger('click');" tabindex="-1" />
      <input type="submit" value="<?php echo $lang['search']; ?> &raquo;" tabindex="-1" />
      <span class="ext-info"><a href="#" class="quickbox" data-quickbox-msg="ext-features">&nbsp;</a></span>
    </fieldset>
  </form>
  <?php

  $sPagesList = null;
  foreach( $config['pages_menus'] as $iMenu => $sMenu ){
    $sPagesList .= $oPage->listPagesAdmin( Array( 'iMenu' => $iMenu ) );
  } // end foreach

  if( !empty( $sPagesList ) ){
  ?>
  <form action="?p=pages<?php if( isset( $_GET['sSort'] ) ) echo '&amp;sSort='.$_GET['sSort']; ?>" name="form" method="post" class="main-form">
    <fieldset>

      <ul class="buttons">
        <li class="save"><input type="submit" name="sOption" class="main" value="<?php echo $lang['save']; ?>" /></li>
      </ul>

      <table class="list pages">
        <thead>
          <tr>
            <th class="id"><a href="?p=pages&amp;sSort=id" class="sort"><?php echo $lang['Id']; ?></a></th>
            <th class="name"><a href="?p=pages&amp;sSort=name" class="sort"><?php echo $lang['Name']; ?></a><ul><li class="status"><?php echo $lang['Status']; ?></li></ul></th>
            <th class="position"><a href="?p=pages" class="sort"><?php echo $lang['Position']; ?></a></th>
            <th class="options">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <?php echo $sPagesList; ?>
        </tbody>
      </table>
      <ul class="buttons bottom">
        <li class="save"><input type="submit" name="sOption" class="main" value="<?php echo $lang['save']; ?>" /></li>
      </ul>

    </fieldset>
  </form>
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
