<?php
/*
* Quick.Cms by OpenSolution.org
* www.OpenSolution.org
*/
$_SERVER['REQUEST_URI'] = htmlspecialchars( strip_tags( $_SERVER['REQUEST_URI'] ) );
$_GET['p'] = isset( $_GET['p'] ) ? htmlspecialchars( strip_tags( $_GET['p'] ) ) : null;

session_start( );

define( 'ADMIN_PAGE', true );
require_once 'database/config.php';

if( isset( $config['allowed_ip_admin_panel'] ) && $config['allowed_ip_admin_panel'] != $_SERVER['REMOTE_ADDR'] ){
  header( 'Location: ./' );
  exit;
}

header( 'Content-Type: text/html; charset=utf-8' );

require_once 'core/libraries/file-jobs.php';
require_once 'core/libraries/image-jobs.php';
$oIJ = ImageJobs::getInstance( );

require_once 'core/libraries/trash.php';
require_once 'core/libraries/forms-validate.php';
require_once 'core/libraries/sql.php';
$oSql = Sql::getInstance( );

require_once 'core/common.php';
require_once 'core/common-admin.php';
getBinValues( true );
loginActions( );

require_once 'core/pages.php';
require_once 'core/pages-admin.php';
$oPage = PagesAdmin::getInstance( );

require_once 'core/files.php';
require_once 'core/files-admin.php';
$oFile = FilesAdmin::getInstance( );

require_once 'core/lang-admin.php';

require_once 'plugins/plugins-admin.php';

listMessagesNews( );
listMessagesNotices( );
if( ( !empty( $_SERVER['HTTP_REFERER'] ) && !strstr( $_SERVER['HTTP_REFERER'], $_SERVER['SCRIPT_NAME'] ) && ( isset( $_GET['iItemDelete'] ) || isset( $_GET['sItemDelete'] ) || count( $_POST ) > 0 ) ) && ( !isset( $_GET['sVerify'] ) || ( isset( $_GET['sVerify'] ) && $_GET['sVerify'] != md5( $config['session_key_name'] ) ) ) ){
  header( 'Location: '.$config['admin_file'].'?p=dashboard' );
  exit;
}

if( strstr( $_GET['p'], 'ajax-' ) ){
  if( $_GET['p'] == 'ajax-files-upload' && !empty( $_GET['sFileName'] ) ){
    echo $oFile->uploadFile( $_GET['sFileName'] );
  }
  elseif( $_GET['p'] == 'ajax-files-in-dir' ){
    header( 'Cache-Control: no-cache' );
    header( 'Content-type: text/html' );
    echo $oFile->listFilesInDir( Array( 'sSort' => 'time' ) );
  }
  elseif( $_GET['p'] == 'ajax-files-thumb' && isset( $_GET['sFileName'] ) ){
    echo '<img src="templates/admin/img/none.png" />';
  }
  elseif( $_GET['p'] == 'ajax-messages-news' && isset( $_SESSION['sMessagesNews'] ) ){
    echo $_SESSION['sMessagesNews'].( $_SESSION['iMessagesNewsNumber'] > 0 ? '<footer><a href="#" onclick="clearMessages( \'news\' );return false;">'.$lang['Mark_as_read'].'</a></footer>' : null );
  }
  elseif( $_GET['p'] == 'ajax-messages-notices-clear' ){
    $_SESSION['iMessagesNoticesNumber'] = 0;
    updateBin( 'failed_logs', 0 );
  }
  elseif( $_GET['p'] == 'ajax-verify-login' ){
    if( isset( $_GET['sVerifyemail'] ) &&  isset( $_GET['sVerifypass'] ) && changeSpecialChars( $_GET['sVerifyemail'] ) == $config['login_email'] && changeSpecialChars( str_replace( '"', '&quot;', $_GET['sVerifypass'] ) ) == $config['login_pass'] ){
      echo 'true';
    }
  }
  elseif( $_GET['p'] == 'ajax-messages-notices' && isset( $_SESSION['sMessagesNotices'] ) ){
    echo $_SESSION['sMessagesNotices'].( $_SESSION['iMessagesNoticesNumber'] > 0 ? '<footer><a href="#" onclick="clearMessages( \'notices\' );return false;">'.$lang['Mark_as_read'].'</a></footer>' : null );
  }
  // end ajax requests
  exit;
}
elseif( !empty( $_GET['p'] ) && preg_match( '/[a-z-]+/', $_GET['p'] ) && is_file( 'templates/admin/'.$_GET['p'].'.php' ) )
  require 'templates/admin/'.$_GET['p'].'.php';
else
  require_once 'templates/admin/dashboard.php';
?>