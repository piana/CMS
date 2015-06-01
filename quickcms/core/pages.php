<?php
if( !defined( 'CUSTOMER_PAGE' ) && !defined( 'ADMIN_PAGE' ) )
  exit( 'Quick.Cms by OpenSolution.org' );

class Pages
{

  public $aPagesParentsMenus = null;
  public $aPages = null;
  public $sLanguageBackEndChoosed = null;
  public $aPagesChildrens = null;
  public $aPagesAllChildrens = null;
  public $aPagesParents = null;
  private static $oInstance = null;

  public static function getInstance( ){
    if( !isset( self::$oInstance ) ){  
      self::$oInstance = new Pages( );  
    }  
    return self::$oInstance;  
  } // end function getInstance

  /**
  * Constructor
  * @return void
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

    if( !is_file( $config['dir_database'].'cache/links_ids' ) || !is_file( $config['dir_database'].'cache/links' ) )
      $this->generateLinks( );

    $iStatus = getStatus( );
    if( $iStatus == 0 )
      $config['enable_cache'] = null;

    if( !isset( $config['pages_links'] ) )
      $config['pages_links'] = unserialize( file_get_contents( $config['dir_database'].'cache/links' ) );
    if( isset( $config['enable_cache'] ) && is_file( $config['dir_database'].'cache/'.$config['language'].'_pages' ) ){
      $this->aPages = unserialize( file_get_contents( $config['dir_database'].'cache/'.$config['language'].'_pages' ) );
      $this->aPagesChildrens = unserialize( file_get_contents( $config['dir_database'].'cache/'.$config['language'].'_pages_childrens' ) );
      $this->aPagesParents = unserialize( file_get_contents( $config['dir_database'].'cache/'.$config['language'].'_pages_parents' ) );
      $this->aPagesParentsMenus = unserialize( file_get_contents( $config['dir_database'].'cache/'.$config['language'].'_pages_parents_menus' ) );
      $this->aPagesAllChildrens = unserialize( file_get_contents( $config['dir_database'].'cache/'.$config['language'].'_pages_all_childrens' ) );
      return true;
    }

    $aLinksIds = unserialize( file_get_contents( $config['dir_database'].'cache/links_ids' ) );
    $oSql = Sql::getInstance( );
    $oQuery = $oSql->getQuery( 'SELECT iPage, iPageParent, iMenu, sName, sTitle, sUrl, iTheme, sRedirect, sDescriptionMeta, sDescriptionShort FROM pages WHERE iStatus >= '.$iStatus.' AND sLang = "'.$config['language'].'" ORDER BY iPosition ASC' );
    while( $aData = $oQuery->fetch( PDO::FETCH_ASSOC ) ){
      if( isset( $aData['sDescriptionShort'] ) ){
        $aData['sDescriptionShort'] = stripslashes( $aData['sDescriptionShort'] );
      }

      $this->aPages[$aData['iPage']] = $aData;

      $this->aPages[$aData['iPage']]['sLinkName'] = $aLinksIds[$aData['iPage']];
      if( $config['start_page'] == $aData['iPage'] && $config['language'] == $config['default_language'] ){
        $this->aPages[$aData['iPage']]['sLinkName'] = './';
      }

      if( $aData['iPageParent'] > 0 ){
        $this->aPagesChildrens[$aData['iPageParent']][] = $aData['iPage'];
        $this->aPagesParents[$aData['iPage']] = $aData['iPageParent'];
      }
      else{
        if( isset( $aData['iMenu'] ) )
          $this->aPagesParentsMenus[$aData['iMenu']][] = $aData['iPage'];
      }
    } // end while

    $this->generateAllChildrens( );

    if( isset( $config['enable_cache'] ) ){
      file_put_contents( $config['dir_database'].'cache/'.$config['language'].'_pages', serialize( $this->aPages ) );
      file_put_contents( $config['dir_database'].'cache/'.$config['language'].'_pages_childrens', serialize( isset( $this->aPagesChildrens ) ? $this->aPagesChildrens : null ) );
      file_put_contents( $config['dir_database'].'cache/'.$config['language'].'_pages_parents', serialize( isset( $this->aPagesParents ) ? $this->aPagesParents : null ) );
      file_put_contents( $config['dir_database'].'cache/'.$config['language'].'_pages_parents_menus', serialize( isset( $this->aPagesParentsMenus ) ? $this->aPagesParentsMenus : null ) );
      file_put_contents( $config['dir_database'].'cache/'.$config['language'].'_pages_all_childrens', serialize( isset( $this->aPagesAllChildrens ) ? $this->aPagesAllChildrens : null ) );
    }
  } // end function generateCache

  /**
  * Generates links
  * @return void
  */
  public function generateLinks( ){
    global $config;

    $oSql = Sql::getInstance( );
    $oQuery = $oSql->getQuery( 'SELECT sUrl, sName, sLang, iPage FROM pages ORDER BY iPosition ASC, iPage ASC' );

    while( $aData = $oQuery->fetch( PDO::FETCH_ASSOC ) ){
      $aData['iPage'] = (int) $aData['iPage'];
      $sUrl1 = '?'.( isset( $config['language_separator'] ) ? $aData['sLang'].$config['language_separator'] : null ).change2Url( !empty( $aData['sUrl'] ) ? $aData['sUrl'] : $aData['sName'] );
      $sUrl2 = ','.$aData['iPage'];

      if( isset( $aLinks[$sUrl1] ) ){
        $aLinksIds[$aData['iPage']] = $sUrl1.$sUrl2;
        $aLinks[$sUrl1.$sUrl2] = Array( $aData['iPage'], $aData['sLang'] );
      }
      else{
        $aLinksIds[$aData['iPage']] = $sUrl1;
        $aLinks[$sUrl1] = Array( $aData['iPage'], $aData['sLang'] );
      }
    } // end while

    if( isset( $aLinks ) ){
      file_put_contents( $config['dir_database'].'cache/links', serialize( $aLinks ) );
      file_put_contents( $config['dir_database'].'cache/links_ids', serialize( $aLinksIds ) );
    }
  } // end function generateLinks

  /**
  * Returns page data
  * @return array
  * @param int  $iPage
  */
  public function throwPage( $iPage ){
    if( isset( $this->aPages[$iPage] ) ){
      $oSql = Sql::getInstance( );
      $aData = array_merge( $this->aPages[$iPage], $oSql->throwAll( 'SELECT sDescriptionFull FROM pages WHERE iPage = '.$iPage ) );
      if( !empty( $aData['sDescriptionFull'] ) ){
        $aData['sDescriptionFull'] = stripslashes( $aData['sDescriptionFull'] );
      }
      return $aData;
    }
    else
      return null;
  } // end function throwPage

  /**
  * Returns a list of pages
  * @return string
  * @param mixed $mData
  * @param array $aParametersExt
  * Default options: sClassName, bNoLinks, iType
  */
  public function listPages( $mData, $aParametersExt = null ){
    global $config, $lang;

    if( is_array( $mData ) ){
      $aPages = $mData;
    }
    else{
      if( isset( $this->aPagesChildrens[$mData] ) )
        $aPages = $this->aPagesChildrens[$mData];
    }

    if( isset( $aPages ) ){
      $iCount = count( $aPages );
      $content = null;
      $i = 1;
      foreach( $aPages as $iPage ){
        $aParametersExt['iElement'] = $i++;
        $content .= listPagesView( $this->aPages[$iPage], $aParametersExt );
      } // end foreach

      if( isset( $content ) ){
        return '<ul class="'.( isset( $aParametersExt['sClassName'] ) ? $aParametersExt['sClassName'] : 'pages-list' ).'">'.$content.'</ul>';
      }
    }  
  } // end function listPages

  /**
  * Generates and displays a menu
  * @return string
  * @param int $iMenu
  * @param array $aParametersExt
  * Default options: sClassName, iDepthLimit, bExpanded, bDisplayTitles
  */
  public function listPagesMenu( $iMenu, $aParametersExt = null ){
    global $lang, $config;

    if( !isset( $this->aPagesParentsMenus[$iMenu] ) )
      return null;

    $this->aMenuParams['iDepthLimit'] = isset( $aParametersExt['iDepthLimit'] ) ? $aParametersExt['iDepthLimit'] : 1;
    $this->aMenuParams['bExpanded'] = isset( $aParametersExt['bExpanded'] ) ? true : null;

    $content = null;
    foreach( $this->aPagesParentsMenus[$iMenu] as $iElement => $iPage ){
      $aParametersExt['sSubMenu'] = ( isset( $this->aPagesChildrens[$iPage] ) && ( isset( $this->aMenuParams['bExpanded'] ) || ( isset( $config['current_page_id'] ) && ( $iPage == $config['current_page_id'] || isset( $this->aPagesAllChildrens[$iPage][$config['current_page_id']] ) ) ) ) && $this->aMenuParams['iDepthLimit'] > 0 ) ? $this->listPagesSubMenu( $iPage, 1 ) : null;
      $aParametersExt['bSelected'] = ( isset( $config['current_page_id'] ) && $config['current_page_id'] == $iPage ) ? true : null;
      $aParametersExt['iElement'] = $iElement;

      $content .= listPagesMenuView( $this->aPages[$iPage], $aParametersExt );
    } // end foreach
    unset( $this->aMenuParams );

    if( isset( $content ) ){
      return '<nav class="'.( isset( $aParametersExt['sClassName'] ) ? $aParametersExt['sClassName'] : 'menu-'.$iMenu ).'">'.( ( isset( $aParametersExt['bDisplayTitles'] ) && isset( $lang['Menu_'.$iMenu] ) ) ? '<strong>'.$lang['Menu_'.$iMenu].'</strong>' : null ).'<ul>'.$content.'</ul></nav>';
    }
  } // end function listPagesMenu

  /**
  * Displays a sub menu
  * @return string
  * @param int $iPageParent
  * @param int $iDepth
  */
  public function listPagesSubMenu( $iPageParent, $iDepth = 1 ){
    global $config;

    if( isset( $this->aPagesChildrens[$iPageParent] ) ){

      $content = null;
      foreach( $this->aPagesChildrens[$iPageParent] as $iElement => $iPage ){
        $aParametersExt['sSubMenu'] = ( isset( $this->aPagesChildrens[$iPage] ) && ( ( isset( $this->aMenuParams['bExpanded'] ) || ( isset( $config['current_page_id'] ) && ( $iPage == $config['current_page_id'] || isset( $this->aPagesAllChildrens[$iPage][$config['current_page_id']] ) ) ) ) && $this->aMenuParams['iDepthLimit'] > $iDepth ) ? $this->listPagesSubMenu( $iPage, $iDepth + 1 ) : null );
        $aParametersExt['bSelected'] = ( isset( $config['current_page_id'] ) && $config['current_page_id'] == $iPage ) ? true : null;
        $aParametersExt['iElement'] = $iElement;
        $content .= $this->aMenuParams['sFunctionView']( $this->aPages[$iPage], $aParametersExt );
      } // end foreach

      if( isset( $content ) ){
        return '<ul>'.$content.'</ul>';
      }
    }
  } // end function listPagesSubMenu

  /**
  * Returns all main pages childrens
  * @return null
  */
  protected function generateAllChildrens( $iPageParentMain = null, $iPageParent = null ){
    if( isset( $this->aPagesChildrens ) ){
      if( isset( $iPageParent ) ){
        foreach( $this->aPagesChildrens[$iPageParent] as $iSubPage ){
          $this->aPagesAllChildrens[$iPageParentMain][$iSubPage] = true;
          $this->aPagesAllChildrens[$iPageParent][$iSubPage] = true;
          if( isset( $this->aPagesChildrens[$iSubPage] ) ){
            $this->generateAllChildrens( $iPageParentMain, $iSubPage );
          }
        } // end foreach      
      }
      else{
        foreach( $this->aPagesChildrens as $iPageParent => $aChildrens ){
          if( !isset( $this->aPagesParents[$iPageParent] ) && $this->aPages[$iPageParent]['iMenu'] != 0 ){
            foreach( $aChildrens as $iSubPage ){
              $this->aPagesAllChildrens[$iPageParent][$iSubPage] = true;
              if( isset( $this->aPagesChildrens[$iSubPage] ) ){
                $this->generateAllChildrens( $iPageParent, $iSubPage );
              }
            } // end foreach
          }
        } // end foreach
      }
    }
  } // end function generateAllChildrens

  /**
  * Returns a page tree
  * @return string
  * @param int  $iPage
  * @param int  $iPageCurrent
  */
  public function getPagesTree( $iPage, $iPageCurrent = null ){
    if( !isset( $iPageCurrent ) ){
      $iPageCurrent = $iPage;
      $this->mData = null;
    }
    
    if( isset( $this->aPagesParents[$iPage] ) && isset( $this->aPages[$this->aPagesParents[$iPage]] ) ){
      $this->mData[] = '<a href="'.$this->aPages[$this->aPagesParents[$iPage]]['sLinkName'].'">'.$this->aPages[$this->aPagesParents[$iPage]]['sName'].'</a>';
      return $this->getPagesTree( $this->aPagesParents[$iPage], $iPageCurrent );
    }
    else{
      if( isset( $this->mData ) ){
        array_unshift( $this->mData, ( isset( $GLOBALS['config']['page_link_in_navigation_path'] ) ) ? '<a href="'.$this->aPages[$iPageCurrent]['sLinkName'].'">'.$this->aPages[$iPageCurrent]['sName'].'</a>' : '<span>'.$this->aPages[$iPageCurrent]['sName'].'</span>' );
        $aReturn = array_reverse( $this->mData );
        $this->mData = null;
        return implode( '&nbsp;&raquo;&nbsp;', $aReturn );
      }
    }
  } // end function getPagesTree

};
?>