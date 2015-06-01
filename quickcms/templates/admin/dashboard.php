<?php 
if( !defined( 'ADMIN_PAGE' ) )
  exit;

if( !isset( $config['url_domain'] ) )
  getSiteUrl( );

$sSelectedMenu = 'dashboard';
require_once 'templates/admin/_header.php';
require_once 'templates/admin/_menu.php';
?>

<section id="body" class="dashboard">
  <h1><?php echo $lang['Dashboard']; ?></h1>
  
  <section>
    <div id="welcome" class="panel">
      <section>
        <!-- LICENSE REQUIREMENTS, DONT DELETE OR HIDE THIS IFRAME AND CONTENT OF THIS IFRAME -->
        <iframe src="http://opensolution.org/dashboard-iframe.html?sLang=<?php echo $config['admin_lang']; ?>&amp;sUrl=<?php echo $config['url_domain']; ?>&amp;sScript=Quick.Cms&amp;sVersion=<?php echo $config['version'].( defined( 'DEVELOPER_MODE' ) ? '&amp;bDeveloper=' : null ); ?>"></iframe>
        <!-- LICENSE REQUIREMENTS, DONT DELETE OR HIDE THIS IFRAME AND CONTENT OF THIS IFRAME -->
      </section>
    </div>
  </section>

</section>
<?php
require_once 'templates/admin/_footer.php';
?>
