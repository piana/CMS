<?php 
if( !defined( 'ADMIN_PAGE' ) )
  exit( 'Script by OpenSolution.org' );

$sSelectedMenu = 'plugins';
require_once 'templates/admin/_header.php';
require_once 'templates/admin/_menu.php';
?>
<section id="body" class="plugins">
  <h1><?php echo $lang['Plugins']; ?></h1>

  <form action="#" method="get" class="search" onsubmit="return false;">
    <fieldset>
      <label for="sSearch"><?php echo $lang['search']; ?></label> <input type="text" name="sSearch" id="sSearch" class="search" placeholder="<?php echo $lang['search']; ?>" value="" size="50" onkeyup="listSearch( this, 'list' )" />
    </fieldset>
  </form>

  <?php 
  $sPluginsList = listPlugins( );
  if( isset( $sPluginsList ) ){
  ?>
  <table class="list plugins" id="list">
    <thead>
      <tr>
        <th class="screenshot"><?php echo $lang['Screenshots']; ?></th>
        <th class="name"><?php echo $lang['Name']; ?></th>
        <th class="description"><?php echo $lang['Description']; ?></th>
        <th class="options">&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <?php echo $sPluginsList; ?>
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
