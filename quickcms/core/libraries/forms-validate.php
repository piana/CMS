<?php
/**
* Library with functions that support forms and verify data
* @version 1.1
* @author OpenSolution
*/

if( !defined( 'MAX_STR_LEN' ) )
  define( 'MAX_STR_LEN', 80 );

define( 'MAX_TEXTAREA_CHARS', isset( $config['max_textarea_chars'] ) ? $config['max_textarea_chars'] : 4000 );
define( 'MAX_TEXT_CHARS', isset( $config['max_text_chars'] ) ? $config['max_text_chars'] : 255 );

/**
* Function checks form fields
* @return bool
* @param array $aForm
* @param array $aFields
* @param bool $bCheckSummaryLength
*/
function checkFormFields( $aForm, $aFields, $bCheckSummaryLength = true ){
  $iTextareas = 0;
  foreach( $aFields as $sKey => $aValue ){
    if( isset( $aForm[$sKey] ) ){
      if( ( !isset( $aValue[1] ) || $aValue[1] !== false ) && getStrLen( $aForm[$sKey] ) < 1 )
        return false;

      if( isset( $aValue[0] ) ){
        if( $aValue[0] == 'email' ){
          if( checkEmail( $aForm[$sKey] ) !== 1 )
            return false;
        }
        elseif( $aValue[0] == 'textarea' ){
          $iTextareas++;
          if( strlen( $aForm[$sKey] ) > MAX_TEXTAREA_CHARS )
            return false;
        }
        elseif( $aValue[0] == 'date' ){
          if( !checkDateFormat( $aForm[$sKey] ) )
            return false;
        }
        elseif( $aValue[0] == 'int' ){
          if( !preg_match( '/[0-9]+/', $aForm[$sKey] ) )
            return false;
          if( isset( $aValue[1] ) && isset( $aValue[2] ) && ( $aForm[$sKey] < $aValue[1] || $aForm[$sKey] > $aValue[2] ) ){
            return false;
          }
        }
        elseif( $aValue[0] == 'numeric' ){
          $aForm[$sKey] = str_replace( ',', '.', $aForm[$sKey] );
          if( !is_numeric( $aForm[$sKey] ) )
            return false;
        }
        elseif( $aValue[0] == 'txt' && isset( $aValue[1] ) ){
          if( strlen( $aForm[$sKey] ) > $aValue[1] )
            return false;
        }
      }

      if( ( !isset( $aValue[0] ) || $aValue[0] != 'textarea' ) && strlen( $aForm[$sKey] ) > MAX_TEXT_CHARS )
        return false;

    }
    else{
      return false;
    }
  } // end foreach

  if( isset( $bCheckSummaryLength ) ){
    $sValuesAll = null;
    $i = 0;
    foreach( $aForm as $sValue => $mValue ){
      if( !is_array( $mValue ) && !is_bool( $mValue ) ){
        $sValuesAll .= $mValue;
      }
      $i++;
    } // end foreach
    $iMaxLength = ( ( $i - $iTextareas ) * MAX_TEXT_CHARS ) + ( $iTextareas * MAX_TEXTAREA_CHARS );
    if( strlen( $sValuesAll ) > $iMaxLength )
      return false;
  }

  return true;
} // end function checkFormFields

/**
* Checks email address format
* @return int
* @param string $sEmail
*/
function checkEmail( $sEmail ){
  return preg_match( "/^[a-z0-9_.-]+([_\\.-][a-z0-9]+)*@([a-z0-9_\.-]+([\.][a-z]{2,15}))+$/i", trim( $sEmail ) );
} // end function checkEmail

/**
* Checks date format
* @return bool
* @param string $sDate
*/
function checkDateFormat( $sDate ){ 
  if( !empty( $sDate ) && strtotime( $sDate ) && preg_match( '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $sDate ) === 1 )
    return true;
  else
    return false;
 } // end function checkDateFormat

 /**
* Function return HTML select
* @return string
* @param mixed $mValue
* @param string $iOption
*/
function getYesNoSelect( $mValue, $iOption = 1 ){
  if( $iOption == 1 )
    $aValues = Array( 'true', 'null' );
  elseif( $iOption == 2 )
    $aValues = Array( 'true', 'false' );
  else
    $aValues = Array( 1, 0 );

  if( $mValue === true || ( is_numeric( $mValue ) && $mValue == 1 ) )
    $aValues[0] .= '" selected="selected';
  else
    $aValues[1] .= '" selected="selected';

  return '<option value="'.$aValues[0].'">'.$GLOBALS['lang']['yes'].'</option><option value="'.$aValues[1].'">'.$GLOBALS['lang']['no'].'</option>';
} // end function getYesOrNoSelect

/**
* Function return HTML checkbox and it will be selected
* when $iYesNo will be 1
* @return string
* @param string $sBoxName
* @param int    $iYesNo
*/
function getYesNoBox( $sBoxName, $iYesNo = 0 ){
  if( $iYesNo == 1 )
    $sChecked = 'checked="checked"';
  else
    $sChecked = null;

  return '<input type="checkbox" '.$sChecked.' id="'.$sBoxName.'" name="'.$sBoxName.'" value="1" />';
} // end function getYesNoBox


/**
* Function change recieved string
* @return string
* @param string $sContent
* @param mixed  $sOption
*/
function changeTxt( $sContent, $sOption = null ){

  if( preg_match( '/tag/i', $sOption ) )
    $sContent = changeHtmlEditorTags( $sContent );

  if( preg_match( '/h/i', $sOption ) ){
    if( preg_match( '/hs/i', $sOption ) )
      $sContent = strip_tags( $sContent );

    $sContent = htmlspecialchars( $sContent );
  }

  $sContent = changeSpecialChars( $sContent );

  if( !preg_match( '/nds/i', $sOption ) ){
    $aSea[] = '"';
    $aRep[] = '&quot;';
  }
  
  $sContent = preg_replace( "/\r/", "", $sContent );

  if( preg_match( '/len/i', $sOption ) )
    $sContent = checkLengthOfTxt( $sContent );

  if( !preg_match( '/ndnl/i', $sOption ) ){
    if( preg_match( '/nl/i', $sOption ) ){
      $aSea[] = "\n";
      $aRep[] = null;
      $aSea[] = '|n|';
      $aRep[] = "\n";
    }
    elseif( preg_match( '/br/i', $sOption ) ){
      $aSea[] = "\n";
      $aRep[] = '<br />';
    }
    else{
      $aSea[] = "\n";
      $aRep[] = '|n|';
    }
  }

  if( preg_match( '/space/i', $sOption ) ){
    $aSea[] = ' ';
    $aRep[] = null;
  }

  if( isset( $aSea ) )
    $sContent = str_replace( $aSea, $aRep, $sContent );

  if( preg_match( '/sl/i', $sOption ) )
    $sContent = addslashes( $sContent );
  else
    $sContent = stripslashes( $sContent );

  return $sContent;
} // end function changeTxt

/**
* Change all array values using changeTxt function
* @return array
* @param array  $aData
* @param string $sOption
* 1. $aData = changeMassTxt( $aData, 'sl' );
* 2. $aData = changeMassTxt( $aData, 'sl', Array( 'index1', 'Nds' ), Array( 'index2', 'SlNds' ) );
*/
function changeMassTxt( $aData, $sOption = null ){
  $iParams = func_num_args( );
  if( $iParams > 2 ){
    $aParam = func_get_args( );
    for( $i = 2; $i < $iParams; $i++ ){
      $aData[$aParam[$i][0]] = changeTxt( $aData[$aParam[$i][0]], $aParam[$i][1] );
      $aDontDo[$aParam[$i][0]] = true;
    } // end for
  }
    
  foreach( $aData as $mKey => $mValue )
    if( !isset( $aDontDo[$mKey] ) && !is_numeric( $mValue ) && !is_array( $mValue ) )
      $aData[$mKey] = changeTxt( $mValue, $sOption );
  return $aData;
} // end function changeMassTxt


/**
* Check that date format is correct
* @return boolean
* @param string $sDate
* @param string $sSeparator
*/
function is_date( $sDate, $sSeparator = '-' ){
  if ( preg_match( "/([0-9]{4})".$sSeparator."([0-9]{2})".$sSeparator."([0-9]{2})/", $sDate ) ){
    $aDates = explode( $sSeparator, $sDate );
    return checkdate( $aDates[1], $aDates[2], $aDates[0] );
  }
  else
    return false;
} // end function is_date

/**
* Return HTML select from defined array
* @return string
* @param array  $aData
* @param mixed  $mData
*/
function getSelectFromArray( $aData, $mData = null ){
  $content = null;
  foreach( $aData as $mKey => $mValue ){
    if( is_array( $mValue ) ){
      $mValue = $mValue[0];
    }
    $content .= '<option value="'.$mKey.'" '.( ( isset( $mData ) && $mData == $mKey ) ? 'selected="selected"' : null ).'>'.$mValue.'</option>';  
  }
  return $content;
} // end function getSelectFromArray

/**
* Check string length and add space if string is longer then defined limit
* @return string
* @param string $sContent
*/
function checkLengthOfTxt( $sContent ){
  return wordwrap( $sContent, MAX_STR_LEN, ' ', 1 );
} // end function checkLengthOfTxt
?>