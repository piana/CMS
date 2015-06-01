/* 
License:
  Code in this file (or any part of it) can be used only as part of Quick.Cms v6.0 or later. All rights reserved by OpenSolution.
*/
function checkAll( sClass, bChecked ){
  $( 'input:checkbox.'+sClass ).prop( 'checked', bChecked );
}

function createCookie( sName, sValue, iDays ){
  sValue = escape( sValue );
  if( iDays ){
    var oDate = new Date();
    oDate.setTime( oDate.getTime() + ( iDays*24*60*60*1000 ) );
    var sExpires = "; expires="+oDate.toGMTString();
  }
  else
    var sExpires = "";
  document.cookie = sName+"="+sValue+sExpires+"; path=/";
}

function getCookie( sName ){
  var sNameEQ = sName + "=";
  var aCookies = document.cookie.split( ';' );
  for( var i=0; i < aCookies.length; i++ ){
    var c = aCookies[i];
    while( c.charAt(0) == ' ' )
      c = c.substring( 1, c.length );
    if( c.indexOf( sNameEQ ) == 0 )
      return unescape( c.substring( sNameEQ.length, c.length ) );
  }
  return null;
}

function delCookie( sName ){
  createCookie( sName, "", -1 );
}

function del( mInfo ){
  if( typeof mInfo === 'object' ){
    var mInfo = ' "'+$( mInfo ).closest( 'tr' ).find( 'th.name a:first-child' ).text()+'"';
  }
  else if( typeof mInfo === 'string' ){}
  else
    mInfo = '';
  if( confirm( (typeof aQuick === 'undefined' ? '' : aQuick['sDelShure'])+mInfo+' ?' ) ) 
    return true;
  else 
    return false
}
function backToTopInit(){
  $('#backToTop').hide();
  $(window).scroll( function(){
    if( $(this).scrollTop() > 100 )
      $('#backToTop').fadeIn();
    else
      $('#backToTop').fadeOut();
  } );
  $('#backToTop a').click( function(){
    $('body,html').animate( {scrollTop:0}, 600 );
    return false;
  } );
}

/* PLUGINS */
