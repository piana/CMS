<?php
final class PagesAdmin extends Pages
{
  private static $oInstance = null;
  private $aPageChildrens = null;
  private $sSelects = null;
  public $aLinksIds = null;

  public static function getInstance( ){  
    if( !isset( self::$oInstance ) ){  
      self::$oInstance = new PagesAdmin( );  
    }  
    return self::$oInstance;  
  } // end function getInstance

  /**
  * Constructor
  * @return void
  */
  private function __construct( ){
    global $config;
    if( !is_file( $config['dir_database'].'cache/links_ids' ) || !is_file( $config['dir_database'].'cache/links' ) )
      $this->generateLinks( );
    $this->aLinksIds = unserialize( file_get_contents( $config['dir_database'].'cache/links_ids' ) );
  } // end function __construct

  /**
  * Returns a list of pages in form of a HTML select
  * @return string
  * @param int $iPageSelected
  */
  public function listPagesSelectAdmin( $iPageSelected ){
    global $config;

    if( isset( $iPageSelected ) && $iPageSelected > 0 && isset( $bMainOnly ) ){
      $oSql = Sql::getInstance( );
      if( $oSql->getColumn( 'SELECT iPage FROM pages WHERE iPage = "'.$iPageSelected.'" AND iPageParent > 0 AND sLang = "'.$config['language'].'"' ) == $iPageSelected )
        $bMainOnly = null;
    }

    $content = null;
    if( isset( $this->sSelects ) ){
      $content = $this->sSelects;
    }
    else{
      $oSql = Sql::getInstance( );
      foreach( $config['pages_menus'] as $iMenu => $sMenu ){
        $oQuery = $oSql->getQuery( 'SELECT iPage, sName FROM pages WHERE iPageParent = 0 AND sLang = "'.$config['language'].'" AND iMenu = "'.$iMenu.'" ORDER BY iPosition ASC' );
        $i = 0;
        while( $aData = $oQuery->fetch( PDO::FETCH_ASSOC ) ){
          if( $i == 0 )
            $content .= '<option value="0" disabled="disabled" style="color:#999;">'.$config['pages_menus'][$iMenu].'</option>';
          $content .= '<option value="'.$aData['iPage'].'">'.$aData['sName'].'</option>';
          $content .= $this->listSubPagesSelectAdmin( $iPageSelected, $aData['iPage'] );
          $i++;
        } // end while
      } // end foreach
      $this->sSelects = $content;
    }
    
    if( isset( $content ) ){
      if( isset( $iPageSelected ) && $iPageSelected > 0 )
        return str_replace( 'value="'.$iPageSelected.'"', 'value="'.$iPageSelected.'" selected="selected"', $content );
      else
        return $content;
    }
  } // end function listPagesSelectAdmin

  /**
  * Returns a list of subpages in form of a HTML select
  * @return string
  * @param int $iPageSelected
  * @param int $iPageParent
  * @param int $iDepth
  */
  public function listSubPagesSelectAdmin( $iPageSelected, $iPageParent, $iDepth = 1 ){
    $oSql = Sql::getInstance( );
    $content = null;
    $oQuery = $oSql->getQuery( 'SELECT iPage, sName FROM pages WHERE iPageParent = "'.$iPageParent.'" ORDER BY iPosition ASC' );
    $sSeparator = str_repeat( '&nbsp;&nbsp;', $iDepth );
    while( $aData = $oQuery->fetch( PDO::FETCH_ASSOC ) ){
      $content .= '<option value="'.$aData['iPage'].'">'.$sSeparator.$aData['sName'].'</option>'.$this->listSubPagesSelectAdmin( $iPageSelected, $aData['iPage'], $iDepth + 1 );
    } // end while
    return $content;
  } // end function listSubPagesSelectAdmin


  /**
  * Returns the list of pages
  * @return string 
  * @param array $aParametersExt
  * Default options: iDepth, iMenu, iPageParent
  */
  public function listPagesAdmin( $aParametersExt = null ){
    global $lang, $config;

    $content = null;
    $sWhere = null;
    $oSql = Sql::getInstance( );
    if( !isset( $aParametersExt['iDepth'] ) )
      $aParametersExt['iDepth'] = 0;
    
    if( isset( $aParametersExt['iMenu'] ) && isset( $config['pages_menus'][$aParametersExt['iMenu']] ) )
      $sWhere = ' AND iMenu = "'.$aParametersExt['iMenu'].'" AND iPageParent = 0 ';
    elseif( isset( $aParametersExt['iPageParent'] ) && is_numeric( $aParametersExt['iPageParent'] ) )
      $sWhere = ' AND iPageParent = "'.$aParametersExt['iPageParent'].'" ';

    $oQuery = $oSql->getQuery( 'SELECT * FROM pages WHERE sLang = "'.$config['language'].'"'.$sWhere.' ORDER BY '.( isset( $_GET['sSort'] ) ? ( ( $_GET['sSort'] == 'id' ) ? 'iPage ASC' : 'sName ASC, iPosition ASC' ) : 'iPosition ASC, sName ASC' ) );
    while( $aData = $oQuery->fetch( PDO::FETCH_ASSOC ) ){
      $content .= '<tr class="l'.$aParametersExt['iDepth'].'"><td class="id">'.$aData['iPage'].'</td><th class="name">
            <a href="?p=pages-form&amp;iPage='.$aData['iPage'].'">'.$aData['sName'].'</a> <a href="./'.( ( $config['start_page'] == $aData['iPage'] ) ? null : $this->aLinksIds[$aData['iPage']] ).'" target="_blank" class="preview" title="'.$lang['Preview'].'">'.$lang['Preview'].'</a>
            <ul>
              <li class="status custom"><input type="checkbox" class="status" name="aStatus['.$aData['iPage'].']" id="aStatus['.$aData['iPage'].']" value="1"'.( ( $aData['iStatus'] == 1 ) ? ' checked="checked"' : null ).' /><label for="aStatus['.$aData['iPage'].']">'.$lang['Status'].'</label></li>
            </ul>
          </th><td class="position">
            <input type="text" name="aPositions['.$aData['iPage'].']" value="'.$aData['iPosition'].'" class="numeric" size="3" maxlength="4" />
          </td><td class="options">
            <a href="?p=pages-form&amp;iPage='.$aData['iPage'].'" class="edit" title="'.$lang['Edit'].'">'.$lang['Edit'].'</a>
            <a href="?p=pages&amp;iItemDelete='.$aData['iPage'].'" class="delete" title="'.$lang['Delete'].'" onclick="return del( this )">'.$lang['Delete'].'</a>  
          </td>
        </tr>';
      $content .= $this->listPagesAdmin( Array( 'iPageParent' => $aData['iPage'], 'iDepth' => ( $aParametersExt['iDepth'] + 1 ) ) );
    } // end while

    if( isset( $content ) ){
      if( isset( $aParametersExt['iMenu'] ) && isset( $config['pages_menus'][$aParametersExt['iMenu']] ) )
        $content = '<tr class="type"><td colspan="4">'.$config['pages_menus'][$aParametersExt['iMenu']].'</td></tr>'.$content;
      return $content;
    }
  } // end function listPagesAdmin


  /**
  * Saves page's position and status
  * @return void
  * @param array $aForm
  */
  public function savePages( $aForm ){
    global $config;

    if( isset( $aForm['aPositions'] ) && is_array( $aForm['aPositions'] ) ){
      
      clearCache( );

      $oSql = Sql::getInstance( );
      $oQuery = $oSql->getQuery( 'SELECT iPage, iPosition, iStatus FROM pages WHERE sLang = "'.$config['language'].'"' );
      while( $aData = $oQuery->fetch( PDO::FETCH_ASSOC ) ){
        if( isset( $aForm['aPositions'][$aData['iPage']] ) && !isset( $aChanged[$aData['iPage']] ) ){
          $iStatus = isset( $aForm['aStatus'][$aData['iPage']] ) ? 1 : 0;
          if( $iStatus != $aData['iStatus'] ){
            $aChanged[$aData['iPage']] = true;
            if( $iStatus == 0 ){
              $this->generatePageAllChildrens( $aData['iPage'] );
              if( isset( $this->aPageChildrens ) ){
                foreach( $this->aPageChildrens as $iPage ){
                  if( isset( $aForm['aStatus'][$iPage] ) ){
                    unset( $aForm['aStatus'][$iPage] );
                    $aChanged[$iPage] = true;
                  }
                } // end foreach
              }
            }
          }

          if( !isset( $aChanged[$aData['iPage']] ) && $aForm['aPositions'][$aData['iPage']] != $aData['iPosition'] ){
            $aChanged[$aData['iPage']] = true;
          }
        }
      } // end while

      if( isset( $aChanged ) ){
        foreach( $aChanged as $iPage => $bValue ){
          $oSql->query( 'UPDATE pages SET iPosition = "'.( (int) $aForm['aPositions'][$iPage] ).'", iStatus = '.( isset( $aForm['aStatus'][$iPage] ) ? 1 : 0 ).' WHERE iPage = '.$iPage );
        } // end foreach
      }
    }
  } // end function savePages


  /**
  * Returns id's of all subpages of a given page
  * @return void
  * @param int  $iPage
  */
  private function throwSubpagesIdAdmin( $iPage ){
    $iCount = count( $this->aPagesChildrens[$iPage] );
    for( $i = 0; $i < $iCount; $i++ ){
      $this->mData[$this->aPagesChildrens[$iPage][$i]] = true;
      if( isset( $this->aPagesChildrens[$this->aPagesChildrens[$iPage][$i]] ) ){
        $this->throwSubpagesIdAdmin( $this->aPagesChildrens[$iPage][$i] );
      }
    } // end for
  } // end function throwSubpagesIdAdmin

  /**
  * Saves page data including data of all attached images and files
  * @return int
  * @param array  $aForm
  */
  public function savePage( $aForm ){
    global $config;

    clearCache( );

    $oFile = FilesAdmin::getInstance( );
    $oSql = Sql::getInstance( );
    $aForm = changeMassTxt( $aForm, 'ndnl', Array( 'sDescriptionShort', 'nds ndnl' ), Array( 'sDescriptionFull', 'nds ndnl' ), Array( 'sDescriptionMeta', 'Nds' ) );
    $aForm['iStatus'] = isset( $aForm['iStatus'] ) ? 1 : 0;

    if( isset( $aForm['iPageParent'] )&& is_numeric( $aForm['iPageParent'] ) && $aForm['iPageParent'] != $aForm['iPage'] ){
      $aDataParent = $oSql->throwAll( 'SELECT iMenu, iStatus FROM pages WHERE iPage = '.$aForm['iPageParent'] );
      $aForm['iMenu'] = $aDataParent['iMenu'];
      if( $aForm['iStatus'] == 1 && $aDataParent['iStatus'] == 0 )
        $aForm['iStatus'] = 0;
    }
    else
      $aForm['iPageParent'] = 0;

    if( isset( $aForm['iPosition'] ) && !is_numeric( $aForm['iPosition'] ) )
      $aForm['iPosition'] = 0;

    if( isset( $aForm['iPage'] ) && is_numeric( $aForm['iPage'] ) ){
      if( $aForm['iStatus'] == 0 && $aForm['iStatus'] != $oSql->getColumn( 'SELECT iStatus FROM pages WHERE iPage = '.$aForm['iPage'] ) ){
        $this->generatePageAllChildrens( $aForm['iPage'] );
        if( isset( $this->aPageChildrens ) ){
          foreach( $this->aPageChildrens as $iPage ){
            $oSql->query( 'UPDATE pages SET iStatus = 0 WHERE iPage = '.$iPage );
          } // end foreach
        }
      }
      $oSql->update( 'pages', $aForm, Array( 'iPage' => $aForm['iPage'] ), true );
    }
    else{
      $aForm['sLang'] = $config['language'];
      unset( $aForm['iPage'] );
      $aForm['iPage'] = $oSql->insert( 'pages', $aForm, true );
    }

    if( ( isset( $aForm['iChangedFiles'] ) && $aForm['iChangedFiles'] == 1 ) || isset( $aForm['aDirFiles'] ) || isset( $aForm['aFilesDelete'] ) ){
      if( isset( $aForm['aDirFiles'] ) )
        $oFile->addFilesFromServer( $aForm, $aForm['iPage'] );

      if( isset( $aForm['iChangedFiles'] ) && $aForm['iChangedFiles'] == 1 || isset( $aForm['aFilesDelete'] ) ){
        if( isset( $aForm['aFilesDescription'] ) )
          $oFile->saveFiles( $aForm, $aForm['iPage'] );
      }

      $oFile->setDefaultImage( $aForm['iPage'], isset( $aForm['iDefaultImage'] ) ? $aForm['iDefaultImage'] : null );
    }

    return $aForm['iPage'];
  } // end function savePage 

  /**
  * Returns all main pages childrens
  * @return null
  * @param int $iPageParent
  * @param bool $bUnset
  */
  private function generatePageAllChildrens( $iPageParent = null, $bUnset = true ){
    if( isset( $bUnset ) )
      unset( $this->aPageChildrens );
    $oSql = Sql::getInstance( );
    $oQuery = $oSql->getQuery( 'SELECT iPage FROM pages WHERE iPageParent = "'.$iPageParent.'"' );
    while( $aData = $oQuery->fetch( PDO::FETCH_ASSOC ) ){
      $this->aPageChildrens[$aData['iPage']] = $aData['iPage'];
      $this->generatePageAllChildrens( $aData['iPage'], null );
    }
  } // end function generatePageAllChildrens

  /**
  * Deletes a page and its subpages
  * @return void
  * @param int $iPage
  */
  public function deletePage( $iPage ){
    $oSql = Sql::getInstance( );
    $oFile = FilesAdmin::getInstance( );

    clearCache( );
    $this->generatePageAllChildrens( $iPage );
    $this->aPageChildrens[$iPage] = $iPage;
    foreach( $this->aPageChildrens as $iPage ){
      $oSql->query( 'DELETE FROM pages WHERE iPage = '.$iPage );
    } // end foreach
    $oFile->deleteFiles( $this->aPageChildrens );
  } // end function deletePage

  /**
  * Returns page data
  * @return array
  * @param int  $iPage
  */
  public function throwPageAdmin( $iPage ){
    global $config;

    $oSql = Sql::getInstance( );
    $aData = $oSql->throwAll( 'SELECT * FROM pages WHERE iPage = '.$iPage.' AND sLang = "'.$config['language'].'"' );
    if( isset( $aData ) && is_array( $aData ) ){
      return $aData;
    }
  } // end function throwPageAdmin

};
?>