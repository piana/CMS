<?php
/**
* Library with all kind functions
* @version 1.1
* @author OpenSolution
*/
if( !defined( 'MAX_PAGES' ) )
  define( 'MAX_PAGES', 10 );

/**
* Counts page number and position in the database file
* @return array
* @param int $iCount
* @param int $iPage
* @param int $iList
*/
function countPageNumber( $iCount, $iPage, $iList = null ){
  if( !isset( $iList ) )
    $iList = isset( $GLOBALS['config']['admin_list'] ) ? $GLOBALS['config']['admin_list'] : 25;
  $iPages = ceil( $iCount / $iList );
  $iPageNumber = isset( $iPage ) ? $iPage : 1;
  if( !isset( $iPageNumber ) || !is_numeric( $iPageNumber ) || $iPageNumber < 1 )
    $iPageNumber = 1;
  if( $iPageNumber > $iPages )
    $iPageNumber = $iPages;

  $iEnd = $iPageNumber * $iList;
  $iStart = $iEnd - $iList;

  if( $iEnd > $iCount )
    $iEnd = $iCount;

  return Array( 'iStart' => $iStart, 'iEnd' => $iEnd, 'iPageNumber' => $iPageNumber ); 
} // end function countPageNumber

/**
* Trims a phrase to a given number of characters
* @return string
* @param string $sContent
* @param int $iLength
*/
function cutText( $sContent, $iLength = 156 ){
  $sContent = substr( $sContent, 0, $iLength );
  $iPos = strrpos( $sContent, ' ' );
  if( is_numeric( $iPos ) )
    return substr( $sContent, 0, $iPos );
  else
    return $sContent;
} // end function cutText

/**
* Count pages by defined positions / max positions per page
* @return string
* @param int $iMax
* @param int $iMaxPerPage
* @param int $iPage
* @param array $aParametersExt
* Possible options: sUrlName, bNoFollow, iMaxPagesPerPage, sAddress, sAddressFirstPage
*/
function countPages( $iMax, $iMaxPerPage, $iPage, $aParametersExt = null ){

  if( !isset( $aParametersExt['sUrlName'] ) )
    $aParametersExt['sUrlName'] = 'iPage';
  if( !isset( $aParametersExt['iMaxPagesPerPage'] ) )
    $aParametersExt['iMaxPagesPerPage'] = MAX_PAGES;
  if( !isset( $aParametersExt['sAddress'] ) )
    $aParametersExt['sAddress'] = $_SERVER['REQUEST_URI'];
  $aParametersExt['sAddress'] = parseUrl( changeUri( $aParametersExt['sAddress'], $aParametersExt['sUrlName'] ) );
  if( !isset( $aParametersExt['sAddressFirstPage'] ) )
    $aParametersExt['sAddressFirstPage'] = $aParametersExt['sAddress'];

  $sAnd = strstr( $aParametersExt['sAddress'], '?' ) ? '&amp;' : '?';
  $iPage = (int) $iPage;
  $iSubPages = ceil( $iMax / $iMaxPerPage );
  $iNext = ( $iSubPages > $iPage ) ? 1 : 0;
  $iMax = ceil( $iPage + ( $aParametersExt['iMaxPagesPerPage'] / 2 ) );
  $iMin = ceil( $iPage - ( $aParametersExt['iMaxPagesPerPage'] / 2 ) );
  $sPages = null;

  if( $iMin < 0 )
    $iMax += -( $iMin );
  if( $iMax > $iSubPages )
    $iMin -= $iMax - $iSubPages;

  $l = Array( 'min' => 0, 'max' => 0 );

  for( $i = 1; $i <= $iSubPages; $i++ ){
    if( $i == 1 )
      $sUrl = '<a href="'.$aParametersExt['sAddressFirstPage'].'">';
    else
      $sUrl = '<a href="'.$aParametersExt['sAddress'].$sAnd.$aParametersExt['sUrlName'].'='.$i.'"'.( isset( $aParametersExt['bNoFollow'] ) ? ' rel="nofollow"' : null ).'>';

    if( $i >= $iMin && $i <= $iMax ) {
      if ( $i == $iPage )
        $sPages .= '<li><strong>'.$i.'</strong></li>';
      else
        $sPages .= '<li>'.$sUrl.$i.'</a></li>';
    }
    elseif( $i < $iMin ) {
      if( $i == 1 )
        $sPages .= '<li>'.$sUrl.$i.'</a></li>';
      else{
        if( $l['min'] == 0 ){
          $sPages .= '<li>...</li>';
          $l['min'] = 1;
        }
      }
    }
    elseif( $i > $iMin ) {
      if( $i == $iSubPages ){
        $sPages .= '<li>'.$sUrl.$i.'</a></li>';
      }
      else{
        if( $l['max'] == 0 ){
          $sPages .= '<li>...</li>';
          $l['max'] = 1;
        }
      }
    }
  } // end for

  return ( ( $iPage > 1 ) ? '<li>'.'<a href="'.( ( $iPage == 2 ) ? $aParametersExt['sAddressFirstPage'] : $aParametersExt['sAddress'].$sAnd.$aParametersExt['sUrlName'].'='.( $iPage - 1 ).( isset( $aParametersExt['bNoFollow'] ) ? '" rel="nofollow' : null ) ).'" class="pPrev">'.$GLOBALS['lang']['Page_prev'].'</a></li>' : null ).$sPages.( ( $iNext == 1 ) ? '<li><a href="'.$aParametersExt['sAddress'].$sAnd.$aParametersExt['sUrlName'].'='.($iPage+1).'" class="pNext"'.( isset( $aParametersExt['bNoFollow'] ) ? ' rel="nofollow"' : null ).'>'.$GLOBALS['lang']['Page_next'].'</a></li>' : null );
} // end function countPages

if( !function_exists( 'change2Latin' ) ){
  /**
  * Change string to latin
  * @return string
  * @param string $sContent
  */
  function change2Latin( $sContent ){
    return str_replace(
      Array( 'ś', 'ą', 'ź', 'ż', 'ę', 'ł', 'ó', 'ć', 'ń', 'Ś', 'Ą', 'Ź', 'Ż', 'Ę', 'Ł', 'Ó', 'Ć', 'Ń', 'á', 'č', 'ď', 'é', 'ě', 'í', 'ň', 'ř', 'š', 'ť', 'ú', 'ů', 'ý', 'ž', 'Á', 'Č', 'Ď', 'É', 'Ě', 'Í', 'Ň', 'Ř', 'Š', 'Ť', 'Ú', 'Ů', 'Ý', 'Ž', 'ä', 'ľ', 'ĺ', 'ŕ', 'Ä', 'Ľ', 'Ĺ', 'Ŕ', 'ö', 'ü', 'ß', 'Ö', 'Ü' ),
      Array( 's', 'a', 'z', 'z', 'e', 'l', 'o', 'c', 'n', 'S', 'A', 'Z', 'Z', 'E', 'L', 'O', 'C', 'N', 'a', 'c', 'd', 'e', 'e', 'i', 'n', 'r', 's', 't', 'u', 'u', 'y', 'z', 'A', 'C', 'D', 'E', 'E', 'I', 'N', 'R', 'S', 'T', 'U', 'U', 'Y', 'Z', 'a', 'l', 'l', 'r', 'A', 'L', 'L', 'R', 'o', 'u', 'S', 'O', 'U' ),
      $sContent
    );
  } // end function change2Latin
}

/**
* Change '$' to '&#36;'
* @return string
* @param string $sTxt
*/
function changeSpecialChars( $sTxt ){
  return str_replace( '$', '&#36;', $sTxt );
} // end function changeSpecialChars

/**
* Return string length
* @return int
* @param string $sContent
*/
function getStrLen( $sContent ){
  return strlen( trim( changeTxt( $sContent, 'hsBrSpace' ) ) );
} // end function getStrLen

/**
* Return microtime
* @return float
*/
function getMicroTime( ){ 
  $exp = explode( " ", microtime( ) ); 
  return ( (float) $exp[0] + (float) $exp[1] ); 
} // end function getMicroTime

/**
* Change string parameter to url name
* @return string
* @param string $sContent
*/
function change2Url( $sContent ){
  return strtolower( change2Latin( str_replace( 
    Array( ' ', '&raquo;', '/', '$', '\'', '"', '~', '\\', '?', '#', '%', '+', '^', '*', '>', '<', '@', '|', '&quot;', '%', ':', '&', ',', '=', '--', '--', '[', ']', '.' ),
    Array( '-', '', '-', '-', '',   '',  '-', '-',  '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-',      '-', '-', '',  '-', '-', '-',  '-', '(', ')', '' ),
    trim( $sContent )
  ) ) );
} // end function change2Url

/**
* Returns words array
* @return array
* @param string $sPhrase
*/
function getWordsFromPhrase( $sPhrase ){
  if( !empty( $sPhrase ) ){
    $aExp = explode( ' ', $sPhrase );
    $iCount = count( $aExp );
    for( $i = 0; $i < $iCount; $i++ ){
      $aExp[$i] = trim( $aExp[$i] );
      if( !empty( $aExp[$i] ) )
        $aWords[] = preg_quote( $aExp[$i], '/' );
    } // end for

    return $aWords;
  }
} // end function getWordsFromPhrase

/**
* Find words in text
* @return bool
* @param array $aWords
* @param int $iCount
* @param string $sContent
*/
function findWords( $aWords, $iCount, $sContent ){
  $iFound = 0;
  for( $i = 0; $i < $iCount; $i++ ){
    if( preg_match( '/'.$aWords[$i].'/ui', $sContent ) )
      $iFound++;
  } // end for

  if( $iFound == $iCount ){
    return true;
  }
} // end function findWords

/**
* Deletes page id from the URL address
* @return string
* @param string $sUrl
* @param string $sPageName
*/
function changeUri( $sUrl, $sPageName = 'iPage' ){
  return preg_replace( "/(&amp;)*[&\?]*".$sPageName."=[0-9]*/", '', $sUrl );
} // end function changeUri

/**
* Removes malicious code from ULR addresses
* @return string
* @param string $sUrl
*/
function parseUrl( $sUrl ){
  return str_replace( '&amp;', '&', htmlspecialchars( $sUrl ) );
} // end function parseUrl 

/**
* Changes text to HTML entity numbers
* @return string
* @param string $sContent
*/
function changeTxtToCode( $sContent ){
  if( !is_string( $sContent ) )
    $sContent = (string) $sContent;
  if( !empty( $sContent ) ){
    $sReturn = null;
    $iCount = strlen( $sContent );
    for( $i = 0; $i < $iCount; $i++ ){
      $sReturn .= '&#'.ord( $sContent[$i] ).';';
    } // end for
    return $sReturn;
  }
  else
    return $sContent;
} // end function changeTxtToCode

/**
* Return Yes if $iValue will be 1
* @return string
* @param int $iValue
*/
function getYesNoTxt( $iValue = 0 ){
  return $iValue == 1 ? $GLOBALS['lang']['yes'] : $GLOBALS['lang']['no'];
} // end function getYesNoTxt
?>