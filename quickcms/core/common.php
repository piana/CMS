<?php
/**
* Returns status limit
* @return int
*/
function getStatus( ){
  if( isset( $GLOBALS['config']['session_key_name'] ) && isset( $_SESSION[$GLOBALS['config']['session_key_name']] ) && is_int( $_SESSION[$GLOBALS['config']['session_key_name']] ) ){
    if( defined( 'CUSTOMER_PAGE' ) )
      return isset( $GLOBALS['config']['display_hidden_pages'] ) ? 0 : 1;
    else
      return 0;
  }
  else
    return 1;
} // end function getStatus

/**
* Returns a theme files name
* @return array
* @param int $iTheme
*/
function throwThemeFiles( $iTheme ){
  global $config;
  if( isset( $config['themes'][$iTheme] ) && isset( $config['themes'][$iTheme][0] ) && isset( $config['themes'][$iTheme][1] ) && isset( $config['themes'][$iTheme][2] ) ){}
  else
    $iTheme = 1;

  return Array( 'sHeader' => $config['themes'][$iTheme][0], 'sMain' => $config['themes'][$iTheme][1], 'sFooter' => $config['themes'][$iTheme][2] );
} // end function throwThemeFiles

/**
* Displays date changed by $config['time_diff']
* @return string
* @param int $iTime
* @param string $sFormat
*/
function displayDate( $iTime = null, $sFormat = 'Y-m-d H:i' ){
  global $config;
  return isset( $iTime ) ? date( $sFormat, $iTime + ( $config['time_diff'] * 60 ) ) : date( $sFormat, time( )  + ( $config['time_diff'] * 60 ) );
} // end function displayDate
/**
* Function checks browser agent
* @return bool
*/
function isSpider( ){
  return ( !empty( $_SERVER['HTTP_USER_AGENT'] ) && preg_match('/'.$GLOBALS['config']['disable_agents'].'/i', $_SERVER['HTTP_USER_AGENT'] ) ) ? true : false;
}

/**
* Count visits and display
* @return array
*/
function simpleCounter( ){
  global $config;

  if( is_file( $config['dir_database'].'counter.php' ) )
    $aFile = file( $config['dir_database'].'counter.php' );
  else{
    touch( $config['dir_database'].'counter.php' );
    chmod( $config['dir_database'].'counter.php', FILES_CHMOD );
  }

  if( isset( $aFile[1] ) && !empty( $aFile[1] ) ){
    $aExp = explode( '$', $aFile[1] );
    $aVisits[0] = $aExp[0];
    $aVisits[1] = ( ( !empty( $aExp[2] ) && $aExp[2] == date( 'Y-m-d' ) ) ? $aExp[1] : 0 );
  }
  else
    $aVisits = Array( 0, 0 );

  if( !isSpider( ) && !isset( $_COOKIE['simpleCounter'] ) ){
    $aVisits[0]++;
    $aVisits[1]++;
    $rFile = fopen( $config['dir_database'].'counter.php', 'r+' );
    fwrite( $rFile, '<?php exit; ?>'."\n".$aVisits[0].'$'.$aVisits[1].'$'.date( 'Y-m-d' ).'$'."\n" );
    fclose( $rFile );
    setcookie( 'simpleCounter', true, time( ) + 7200 );
  }

  return $aVisits;
} // end function simpleCounter

/**
* Return configuration from table bin
* @return void
* @param bool $bInsert
*/
function getBinValues( $bInsert = null ){
  global $config;
  $oSql = Sql::getInstance( );
  $oQuery = $oSql->getQuery( 'SELECT sKey, sValue FROM bin' );
  while( $aValue = $oQuery->fetch( PDO::FETCH_ASSOC ) ){
    if( !isset( $config[$aValue['sKey']] ) )
      $config[$aValue['sKey']] = $aValue['sValue'];
  } // end while

  if( isset( $bInsert ) ){
    if( isset( $config['session_key_name'] ) ){
      if( time( ) - substr( $config['session_key_name'], 1, 10 ) > 86400 ){
        $oSql->query( 'DELETE FROM bin WHERE sKey = "session_key_name"' );
        $config['session_key_name'] = null;
      }
    }

    if( !isset( $config['session_key_name'] ) ){
      $config['session_key_name'] = 's'.time( ).rand( 1000, 9999 );
      $oSql->query( 'INSERT INTO bin ( "sKey", "sValue" ) VALUES( "session_key_name", "'.$config['session_key_name'].'" )' );
    }
  }
} // end function getBinValues

/**
* Function returns textarea field
* @return string
* @param  string  $sName
* @param  string  $sContent
* @param array $aParametersExt
* Default options: iTab, mWysiwyg, sToolbar, sPlugins, sClassName, sFunctionName
*/
function getTextarea( $sName = 'sContent', $sContent = '', $aParametersExt = null ){
  global $config, $lang;
  $content = null;
  if( !isset( $aParametersExt['mWysiwyg'] ) )
    $aParametersExt['mWysiwyg'] = $config['wysiwyg'];
  if( !isset( $aParametersExt['sFunctionName'] ) && isset( $aParametersExt['mWysiwyg'] ) && $aParametersExt['mWysiwyg'] !== false )
    $aParametersExt['sFunctionName'] = 'getWysiwyg'.$aParametersExt['mWysiwyg'];

  if( isset( $aParametersExt['sFunctionName'] ) && !empty( $aParametersExt['sFunctionName'] ) ){
    if( function_exists( $aParametersExt['sFunctionName'] ) ){
      $content .= $aParametersExt['sFunctionName']( $sName, $aParametersExt );
    }
    else{
      return defined( 'DEVELOPER_MODE' ) ? '<p class="dev">THERE IS NO SUCH FUNCTION - '.$aParametersExt['sFunctionName'].'</p>' : null;
    }
  }
  $content .= '<textarea name="'.$sName.'" id="'.$sName.'" rows="20" cols="60" class="'.( isset( $aParametersExt['sClassName'] ) ? $aParametersExt['sClassName'] : 'text-editor' ).'" '.( isset( $aParametersExt['iTab'] ) ? ' tabindex="'.$aParametersExt['iTab'].'"' : null ).'>'.$sContent.'</textarea>';

  return $content;
} // end function getTextarea

/**
* Returns URL
* @return void
*/
function getSiteUrl( ){
  global $config;
  if( !isset( $config['url_domain'] ) ){
    $aData = parse_url( $_SERVER['REQUEST_URI'] );
    $config['url_domain'] = 'http://'.$_SERVER['HTTP_HOST'].( isset( $aData['host'] ) ? $aData['host'] : null ).( isset( $aData['path'] ) ? substr( $aData['path'], 0, strrpos( $aData['path'], '/' ) + 1 ) : null );
  }
} // end function getSiteUrl
?>