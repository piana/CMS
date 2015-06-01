<?php
class Sliders
{

  public $aSliders;
  private static $oInstance = null;

  public static function getInstance( ){  
    if( !isset( self::$oInstance ) ){  
      self::$oInstance = new Sliders( );  
    }  
    return self::$oInstance;  
  } // end function getInstance

  /**
  * Constructor
  * @return void
  * @param mixed $mValue
  */
  private function __construct( ){
    $this->generateCache( );
  } // end function __construct

  /**
  * Generates cache variables
  * @return void
  */
  public function generateCache( ){
    global $config;

    if( isset( $config['enable_cache'] ) && is_file( $config['dir_database'].'cache/'.$config['language'].'_sliders' ) ){
      $this->aSliders = unserialize( file_get_contents( $config['dir_database'].'cache/'.$config['language'].'_sliders' ) );
      if( !is_array( $this->aSliders ) ){
        $config['enabled_sliders'] = null;
      }
      return true;
    }
    
    $this->aSliders = null;
    $oSql = Sql::getInstance( );
    $oQuery = $oSql->getQuery( 'SELECT iSlider, sFileName, sDescription FROM sliders WHERE sLang = "'.$config['language'].'" ORDER BY iPosition ASC' );
    while( $aValue = $oQuery->fetch( PDO::FETCH_ASSOC ) ){
      $this->aSliders[$aValue['iSlider']] = $aValue;
    } // end while

    if( isset( $config['enable_cache'] ) ){
      if( !is_array( $this->aSliders ) ){
        $config['enabled_sliders'] = null;
      }
      file_put_contents( $config['dir_database'].'cache/'.$config['language'].'_sliders', serialize( $this->aSliders ) );
    }
  } // end function generateCache

  /**
  * Displays slider
  * @return string
  * @param array $aParametersExt
  * Default options: sClassName, bNoLinks, iType, sConfig
  */
  public function listSliders( $aParametersExt = null ){
    global $lang, $config;

    if( isset( $this->aSliders ) ){
      $content = null;
      $i = 1;
      foreach( $this->aSliders as $iKey => $aValue ){
        $aParametersExt['iElement'] = $i;
        $content .= listSlidersView( $aValue, $aParametersExt );
        $i++;
      } // end foreach

      if( isset( $content ) )
        return '<section class="'.( isset( $aParametersExt['sClassName'] ) ? $aParametersExt['sClassName'] : 'slider' ).'" id="slider"><ul>'.$content.'</ul></section><script>$("'.( isset( $aParametersExt['sClassName'] ) ? '.'.$aParametersExt['sClassName'] : '#slider' ).'").quickslider({'.( isset( $aParametersExt['sConfig'] ) ? $aParametersExt['sConfig'] : $config['default_slider_config'] ).'});</script>';
    }
  } // end function listSliders

};
?>