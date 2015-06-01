<?php
/**
* Log in and out actions to back-end
* @return void
*/
function loginActions( ){
  global $config, $lang;
  $content = null;
  if( !isset( $_SESSION[$config['session_key_name']] ) || !is_int( $_SESSION[$config['session_key_name']] ) ){
    $oSql = Sql::getInstance( );
    $bFirstLog = null;
    if( empty( $config['login_email'] ) || !checkEmail( $config['login_email'] ) || empty( $config['login_pass'] ) ){
      $bFirstLog = true;
    }

    if( isset( $config['failed_logs'] ) && isset( $config['failed_login_time'] ) && $config['failed_logs'] > 2 && time( ) - $config['failed_login_time'] <= 900 ){
      $bLoginExceed = true;
      $content = '<div class="msg error"><strong>'.$lang['Failed_login_wait_time'].'</strong></div>';
    }
    else{
      if( $_GET['p'] == 'login' && isset( $_POST['sEmail'] ) && checkEmail( $_POST['sEmail'] ) && !empty( $_POST['sPass'] ) ){
        if( isset( $bFirstLog ) )
          saveVariables( Array( 'login_email' => $_POST['sEmail'], 'login_pass' => $_POST['sPass'] ), $config['dir_database'].'config.php' );

        if( checkLogin( $_POST['sEmail'], $_POST['sPass'], $bFirstLog ) === true ){
          if( !isset( $_COOKIE['sEmail'] ) || $_COOKIE['sEmail'] != $_POST['sEmail'] )
            @setCookie( 'sEmail', $_POST['sEmail'], time( ) + 2592000 );
          if( isset( $config['last_login'] ) )
            updateBin( 'before_last_login', $config['last_login'] );
          updateBin( 'last_login', time( ) );
          updateBin( 'failed_logs', 0 );

          header( 'Location: '.( !empty( $_SESSION['sLoginNextPage'] ) ? $_SESSION['sLoginNextPage'] : $config['admin_file'] ) );
          exit;
        }
        else{
          $sLoginPage = $config['admin_file'];
          $content = '<div class="msg error"><strong>'.$lang['Wrong_email_or_pass'].'</strong><a href="javascript:history.back()">&laquo; '.$lang['back'].'</a></div>';
        }
      }
      else{
        $_SESSION['sLoginNextPage'] = str_replace( '&amp;', '&', $_SERVER['REQUEST_URI'] );
        $content = '<form method="post" action="?p=login" id="login-form">
          <fieldset>
            <legend >'.( isset( $bFirstLog ) ? $lang['Type_login_password'] : $lang['log_in'] ).'</legend>
            <ul class="forms full">
              <li><label>'.$lang['Email'].':<input type="email" name="sEmail" class="input" value="'.( isset( $_COOKIE['sEmail'] ) ? strip_tags( $_COOKIE['sEmail'] ) : null ).'" data-form-check="email" /></label></li>
              <li><label>'.$lang['Password'].':<input type="'.( isset( $bFirstLog ) ? 'text' : 'password' ).'" name="sPass" class="input" value="" data-form-check="required" /></label></li>
              <li><input type="submit" class="main" value="'.$lang['log_in'].' &raquo;" /></li>
            </ul>
          </fieldset>
        </form>
        <script>
          $( function(){
            focusCursor( ["sEmail", "sPass"] );
            $( "#login-form" ).quickform();
          } );
        </script>';
      }
    }

    require_once 'templates/admin/_header.php';
    echo '<section id="login-panel"'.( isset( $bFirstLog ) ? ' class="init"' : null ).'>
      <header>
        <nav>
          <ul>
            <li><a href="http://opensolution.org/" target="_blank"><img src="templates/admin/img/logo_os_dark.png" alt="Logo OpenSolution" /></a></li>
            <li><a href="http://opensolution.org/" target="_blank">Quick.Cms v'.$config['version'].'</a></li>
          </ul>
        </nav>
      </header>
      '.$content.'
      <footer>
        <nav>
          <ul>
            <li><a href="./">'.$lang['homepage'].'</a></li>
            <li><a href="http://opensolution.org/dont-remember-password.html" target="_blank">'.$lang['forgot_your_password'].'</a></li>
          </ul>
        </nav>
      </footer>
    </section><style>#foot{display:none;}</style>';
    require_once 'templates/admin/_footer.php';
    exit;
  }
  else{
    if( $_GET['p'] == 'logout' ){
      foreach( $_SESSION as $sKey => $mValue ){
        unset( $_SESSION[$sKey] );
      } // end foreach
      header( 'Location: '.$config['admin_file'] );
      exit;
    }
    elseif( $_GET['p'] != 'dashboard' && !strstr( $_GET['p'], 'ajax-' ) && !isset( $_COOKIE['bLicense'.str_replace( '.', '', $config['version'] )] ) ){
      header( 'Location: '.$config['admin_file'].'?p=dashboard' );
      exit;
    }
  }
} // end function loginActions

/**
* Checks login and password saved in database/config.php
* @return bool
* @param string $sEmailRaw
* @param string $sPassRaw
* @param bool $bFirstLog
*/
function checkLogin( $sEmailRaw, $sPassRaw, $bFirstLog = null ){
  global $config;
  $sEmail = changeSpecialChars( $sEmailRaw );
  $sPass = changeSpecialChars( str_replace( '"', '&quot;', $sPassRaw ) );

  if( ( $config['login_email'] == $sEmail && $config['login_pass'] == $sPass ) || isset( $bFirstLog ) ){
    $_SESSION[$config['session_key_name']] = 0;
    return true;
  }
  else{
    updateBin( 'failed_logs', ( isset( $config['failed_logs'] ) ? ( $config['failed_logs'] + 1 ) : 1 ) );
    updateBin( 'failed_login_time', time( ) );
    return false;
  }
} // end function checkLogin

/**
* Update data in bin table
* @return void
* @param string $sKey
* @param mixed $mValue
* @param bool $bValueRaw
*/
function updateBin( $sKey, $mValue, $bValueRaw = null ){
  global $config;
  $oSql = Sql::getInstance( );

  if( isset( $config[$sKey] ) )
    $oSql->query( 'UPDATE bin SET sValue = '.( isset( $bValueRaw ) ? $mValue : addslashes( $mValue ) ).' WHERE sKey = "'.addslashes( $sKey ).'"' );
  else
    $oSql->query( 'INSERT INTO bin ( "sKey", "sValue" ) VALUES( "'.addslashes( $sKey ).'", '.( isset( $bValueRaw ) ? $mValue : addslashes( $mValue ) ).' )' );
} // end function updateBin

/**
* Saves variables to config
* @return void
* @param array  $aForm
* @param string $sFile
* @param string $sVariable
*/
function saveVariables( $aForm, $sFile, $sVariable = 'config' ){
  if( is_file( $sFile ) && strstr( $sFile, '.php' ) ){
    $aFile = file( $sFile );
    $iCount = count( $aFile );
    $rFile = fopen( $sFile, 'w' );

    for( $i = 0; $i < $iCount; $i++ ){
      foreach( $aForm as $sKey => $sValue ){
        if( preg_match( '/'.$sVariable."\['".$sKey."'\]".' = /', $aFile[$i] ) && strstr( $aFile[$i], '=' ) ){
          $mEndOfLine = strstr( $aFile[$i], '; //' );
          if( empty( $mEndOfLine ) ){
            $mEndOfLine = ';';
          }
          $sValue = changeSpecialChars( trim( str_replace( '"', '&quot;', $sValue ) ) );
          if( preg_match( '/^(true|false|null)$/', $sValue ) ){
            $aFile[$i] = "\$".$sVariable."['".$sKey."'] = ".$sValue.$mEndOfLine;
          }
          else
            $aFile[$i] = "\$".$sVariable."['".$sKey."'] = \"".$sValue."\"".$mEndOfLine;
        }
      } // end foreach

      fwrite( $rFile, rtrim( $aFile[$i] ).( $iCount == ( $i + 1 ) ? null : "\r\n" ) );

    } // end for
    fclose( $rFile );
  }
} // end function saveVariables


/**
* Return themes select
* @return string
* @param int $iThemeSelect
*/
function getThemesSelect( $iThemeSelect ){
  global $config;

  $content = null;
  foreach( $config['themes'] as $iTheme => $aFiles ){
    $content .= '<option value="'.$iTheme.'"'.( ( $iTheme == $iThemeSelect ) ? ' selected="selected"' : null ).'>'.$iTheme.': '.implode( ', ', $aFiles ).'</option>';
  } // end foreach
  return $content;
} // end function getThemesSelect

/**
* Return image thumbnails sizes select
* @return string
* @param int $iSizeSelect
*/
function getThumbnailsSelect( $iSizeSelect ){
  global $config;

  $content = null;
  foreach( $config['images_thumbnails'] as $iSize ){
    $content .= '<option value="'.$iSize.'"'.( ( $iSize == $iSizeSelect ) ? ' selected="selected"' : null ).'>'.$iSize.'</option>';
  } // end foreach
  return $content;
} // end function getThumbnailsSelect

/**
* Clears cache from database/cache/
* @return void
* @param string $sName
*/
function clearCache( $sName = null ){
  global $config;

  foreach( new DirectoryIterator( $config['dir_database'].'cache/' ) as $oFileDir ){
    if( $oFileDir->isFile( ) && ( !isset( $sName ) || ( isset( $sName ) && strstr( $oFileDir->getFilename( ), $sName ) ) ) ){
      unlink( $config['dir_database'].'cache/'.$oFileDir->getFilename( ) );
    }
  } // end foreach
} // end function clearCache

/**
* List news from OpenSolution
* @return void
*/
function listMessagesNews( ){
  global $config;
  if( isset( $_COOKIE['iMessagesNewsTime'] ) && ( !isset( $_SESSION['iMessagesNewsTime'] ) || $_SESSION['iMessagesNewsTime'] != $_COOKIE['iMessagesNewsTime'] ) ){
    $_SESSION['iMessagesNewsTime'] = $_COOKIE['iMessagesNewsTime'];
    $_SESSION['iMessagesNewsNumber'] = 0;
  }
  if( isset( $_COOKIE['bMessagesNewsClear'] ) && isset( $_SESSION['sMessagesNews'] ) ){
    $_SESSION['sMessagesNews'] = str_replace( ' class="unread"', '', $_SESSION['sMessagesNews'] );
  }

  if( !isset( $_SESSION['sMessagesNews'] ) ){
    getSiteUrl( );
    $content = @file_get_contents( 'http://opensolution.org/list-messages.html?sLang='.$config['admin_lang'].'&sUrl='.$config['url_domain'].'&sScript=Quick.Cms&sVersion='.$config['version'].( isset( $_COOKIE['iMessagesNewsTime'] ) ? '&iMessagesNewsTime='.$_COOKIE['iMessagesNewsTime'] : null ).( defined( 'DEVELOPER_MODE' ) ? '&amp;bDeveloper=' : null ) ); 
    if( !empty( $content ) && strstr( $content, ':"iMessagesNewsNew";' ) ){
      $aData = unserialize( $content );
      if( isset( $aData['sNews'] ) ){
        $_SESSION['sMessagesNews'] = $aData['sNews'];
        $_SESSION['iMessagesNewsNumber'] = $aData['iMessagesNewsNew'];
      }
    }
  }
} // end function listMessagesNews

/**
* Lists notifications and alerts
* @return string
*/
function listMessagesNotices( ){
  global $lang, $config;

  if( !isset( $_SESSION['sMessagesNotices'] ) ){
    if( $config['failed_logs'] > 0 ){
      $aNotices[] = '<li>'.$lang['Failed_logs'].' <strong>'.displayDate( $config['failed_login_time'], $config['date_format_admin_default'] ).'</strong></li>';
    }

    if( strstr( $_SERVER['REQUEST_URI'], 'admin.php' ) && !preg_match( '/localhost|192\.168\.|127\.0\.0\.1/', $_SERVER['HTTP_HOST'].$_SERVER['SERVER_ADDR'] ) ){
      $aNotices[] = '<li>'.$lang['Increase_security'].' <a href="'.$config['manual_link'].'information#security" target="_blank">'.$lang['More'].' &raquo;</a></li>';
    } 

    if( !defined( 'LICENSE_NO_LINK' ) && is_dir( 'templates/'.$config['skin'].'/' ) ){
      foreach( new DirectoryIterator( 'templates/'.$config['skin'].'/' ) as $oFileDir ) {
        if( strstr( $oFileDir->getFilename( ), '.php' ) && preg_match( '/http:\/\/opensolution\.org|http:\/\/www\.opensolution\.org/i', file_get_contents( 'templates/'.$config['skin'].'/'.$oFileDir->getFilename( ) ) ) ){
          define( 'LICENSE_LINK_OK', true );
          break;
        }
      } // end foreach

      if( !defined( 'LICENSE_LINK_OK' ) )
        $aNotices[] = '<li>Restore link <strong>http://opensolution.org/</strong> located in the footer on your website <a href="http://opensolution.org/license.html" target="_blank">'.$lang['More'].' &raquo;</a></li>';
    }

    if( is_file( 'index.php' ) && ( time( ) - filemtime( 'index.php' ) > 6480000 ) && ( isset( $aNotices ) || rand( 1, 3 ) == 2 ) ){
      $aNotices[] = '<li>'.$lang['Check_for_bug_fixes'].'</li>';
    }

    if( isset( $aNotices ) ){
      $_SESSION['sMessagesNotices'] = '<ul>'.implode( '', $aNotices ).'</ul>';
      $_SESSION['iMessagesNoticesNumber'] = count( $aNotices );
    }
  }
} // end function listMessagesNotices

/**
* Displays the lists of backup files
* @return string
*/
function listPlugins( ){
  global $lang, $config;

  if( !isset( $_SESSION['sPluginsList'] ) ){
    getSiteUrl( );
    $sPlugins = @file_get_contents( 'http://opensolution.org/plugins.html?sLang='.$config['admin_lang'].'&sUrl='.$config['url_domain'].'&sScript=Quick.Cms&sVersion='.$config['version'].( defined( 'DEVELOPER_MODE' ) ? '&amp;bDeveloper=' : null ) );
    if( !empty( $sPlugins ) )
      $_SESSION['sPluginsList'] = $sPlugins;
  }

  if( isset( $_SESSION['sPluginsList'] ) )
    return $_SESSION['sPluginsList'];
} // end function listPlugins
?>