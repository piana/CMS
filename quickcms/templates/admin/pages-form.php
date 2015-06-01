<?php 
if( !defined( 'ADMIN_PAGE' ) )
  exit( 'Script by OpenSolution.org' );

if( isset( $_POST['sName'] ) ){
  $iPage = $oPage->savePage( $_POST );
  if( isset( $_POST['sOptionList'] ) )
    header( 'Location: '.$config['admin_file'].'?p=pages&sOption=save' );
  elseif( isset( $_POST['sOptionAddNew'] ) )
    header( 'Location: '.$config['admin_file'].'?p=pages-form&sOption=save' );
  else
    header( 'Location: '.$config['admin_file'].'?p=pages-form&sOption=save&iPage='.$iPage );
  exit;
}

$sFilesList = null;
if( isset( $_GET['iPage'] ) && is_numeric( $_GET['iPage'] ) ){
  $aData = $oPage->throwPageAdmin( $_GET['iPage'] );
  if( isset( $aData ) && is_array( $aData ) ){
    $sFilesList = $oFile->listAllFiles( $aData['iPage'] );
  }
}

if( !isset( $sFilesList ) )
  $sFilesList = '<h2 class="msg error">'.$lang['Data_not_found'].'</h2>';

$sSelectedMenu = 'pages';
require_once 'templates/admin/_header.php';
require_once 'templates/admin/_menu.php';
?>

<section id="body" class="pages">

  <h1><?php echo ( isset( $aData['iPage'] ) ) ? $lang['Pages_form'].': '.$aData['sName'] : $lang['New_page']; ?></h1>
  <?php if( isset( $config['manual_link'] ) ){
    echo '<div class="manual"><a href="'.$config['manual_link'].'instruction#pages-form" title="'.$lang['Help'].'" target="_blank"></a></div>';
  }
  if( isset( $_GET['sOption'] ) ){
    echo '<h2 class="msg">'.$lang['Operation_completed'].'</h2>';
  }?>

  <form action="?p=<?php echo $_GET['p']; ?>" name="form" method="post" class="main-form" onsubmit="return checkParentForm()">
    <fieldset>
      <input type="hidden" name="iPage" id="iPage" value="<?php if( isset( $aData['iPage'] ) ) echo $aData['iPage']; ?>" />

      <?php if( isset( $aData['iPage'] ) ){ ?>
      <ul class="options">
        <li class="preview"><a href="./<?php echo ( ( $config['start_page'] == $aData['iPage'] ) ? '?sLanguage='.$config['language'] : $oPage->aLinksIds[$aData['iPage']] ); ?>" target="_blank" title="<?php echo $lang['Preview']; ?>"><?php echo $lang['Preview']; ?></a></li>
        <li class="delete"><a href="?p=pages&amp;iItemDelete=<?php echo $aData['iPage']; ?>" title="<?php echo $lang['Delete']; ?>" onclick="return del( )"><?php echo $lang['Delete']; ?></a></li>
      </ul>
      <?php } ?>
      <ul class="buttons">
        <li class="save"><input type="submit" name="sOption" class="main" value="<?php echo $lang['save']; ?>" /></li>
        <li class="options"><input type="submit" value="<?php echo $lang['save_add_new']; ?>" name="sOptionAddNew" />
          <ul>
            <li><input type="submit" value="<?php echo $lang['save_list']; ?>" name="sOptionList" /></li>
          </ul>
        </li>
      </ul>

      <ul class="tabs">
        <!-- tabs start -->
        <li id="content" class="selected"><a href="#content"><?php echo $lang['Content']; ?></a></li>
        <li id="options"><a href="#options"><?php echo $lang['Options']; ?></a></li>
        <li id="seo"><a href="#seo"><?php echo $lang['Seo']; ?></a></li>
        <li id="add-files"><a href="#add-files"><?php echo $lang['Add_files']; ?></a></li>
        <li id="files"><a href="#files"><?php echo $lang['Files']; ?></a></li>
        <li id="advanced"><a href="#advanced"><?php echo $lang['Advanced']; ?></a></li>
        <!-- tabs end -->
      </ul>

      <ul id="tab-content" class="forms full">
        <li>
          <label for="sName"><?php echo $lang['Name']; ?></label>
          <input type="text" name="sName" id="sName" value="<?php if( isset( $aData['sName'] ) ) echo $aData['sName']; ?>" placeholder="<?php echo $lang['only_this_field_is_required']; ?>" data-form-check="required" />
        </li>

        <li class="short-description">
          <label for="sDescriptionShort"><?php echo $lang['Short_description']; ?> <a href="#" class="expand"><span class="display"><?php echo $lang['Display']; ?></span><span class="hide"><?php echo $lang['Hide']; ?></span></a></label>
          <div class="toggle"><?php echo getTextarea( 'sDescriptionShort', isset( $aData['sDescriptionShort'] ) ? $aData['sDescriptionShort'] : null, Array( 'iHeight' => '120' ) ); ?></div>
        </li>

        <li>
          <label for="sDescriptionFull"><?php echo $lang['Full_description']; ?></label>
          <?php echo getTextarea( 'sDescriptionFull', isset( $aData['sDescriptionFull'] ) ? $aData['sDescriptionFull'] : null, Array( 'iHeight' => '300', 'sClassName' => 'text-editor full-description' ) ); ?>
        </li>
        <!-- tab content -->
      </ul>

      <ul id="tab-options" class="forms list">
        <li class="custom">
          <span class="label">&nbsp;</span>
          <?php echo getYesNoBox( 'iStatus', isset( $aData['iStatus'] ) ? $aData['iStatus'] : 1 ); ?>
          <label for="iStatus"><?php echo $lang['Status']; ?></label>
        </li>
        <li class="parent">
          <label for="iPageParent"><?php echo $lang['Parent_page']; ?></label>
          <select name="iPageParent" onchange="checkType( );" id="iPageParent" size="15"><option value=""<?php if( !isset( $aData['iPageParent'] ) || $aData['iPageParent'] == 0 ) echo ' selected="selected"'; ?>><?php echo $lang['none']; ?></option><?php echo $oPage->listPagesSelectAdmin( ( isset( $aData['iPageParent'] ) ? $aData['iPageParent'] : null ) ); ?></select>
        </li>
        <li>
          <label for="iPosition"><?php echo $lang['Position']; ?></label>
          <input type="text" id="iPosition" name="iPosition" value="<?php echo isset( $aData['iPosition'] ) ? $aData['iPosition'] : 0; ?>" class="numeric" size="3" maxlength="4" />
        </li>
        <li>
          <label for="iMenu"><?php echo $lang['Menu']; ?></label>
          <select name="iMenu" id="iMenu"><?php echo getSelectFromArray( $config['pages_menus'], isset( $aData['iMenu'] ) ? $aData['iMenu'] : $config['default_pages_menu'] ); ?></select>
        </li>
        <!-- tab options -->
      </ul>

      <ul id="tab-seo" class="forms list">
        <li>
          <label for="sTitle"><?php echo $lang['Page_title']; ?></label>
          <input type="text" name="sTitle" value="<?php if( isset( $aData['sTitle'] ) ) echo $aData['sTitle']; ?>" id="sTitle" size="75" maxlength="60" />
        </li>
        <li>
          <label for="sUrl"><?php echo $lang['Url_name']; ?></label>
          <input type="text" name="sUrl" value="<?php if( isset( $aData['sUrl'] ) ) echo $aData['sUrl']; ?>" id="sUrl" size="75" />
        </li>
        <li>
          <label for="sDescriptionMeta"><?php echo $lang['Meta_description']; ?></label>
          <input type="text" name="sDescriptionMeta" value="<?php if( isset( $aData['sDescriptionMeta'] ) ) echo $aData['sDescriptionMeta']; ?>" id="sDescriptionMeta" size="75" maxlength="160" />
        </li>
        <!-- tab seo -->
      </ul>

      <ul id="tab-advanced" class="forms list">
        <li class="ext-feature">
          <label for="iSubpages"><?php echo $lang['Subpages_list_types']; ?></label>
          <select name="" id="iSubpages"><?php echo getSelectFromArray( ( $config['admin_lang'] == 'pl' ? Array( 1 => 'Lista tylko z nazwą', 2 => 'Lista bez zdjęcia', 3 => 'Lista ze zdjęciem', 4 => 'Newsy', 5 => 'Galeria', 0 => 'Brak wyświetlania' ) : Array( 1 => 'List with only name', 2 => 'List without photo', 3 => 'List with photo', 4 => 'News', 5 => 'Gallery', 0 => 'No display' ) ), 3 ); ?></select>
          <span class="ext-info"><a href="#" class="quickbox" data-quickbox-msg="ext-features"><?php echo $lang['Available_in_Ext']; ?></a></span>
        </li>
        <li>
          <label for="iTheme"><?php echo $lang['Templates']; ?></label>
          <select name="iTheme" id="iTheme"<?php if( isset( $config['disable_advanced_options'] ) ) echo ' disabled="disabled"'; ?>><?php echo getThemesSelect( isset( $aData['iTheme'] ) ? $aData['iTheme'] : $config['default_theme'] ); ?></select>
        </li>
        <li>
          <label for="sRedirect"><?php echo $lang['Address']; ?></label>
          <input type="text" name="sRedirect" value="<?php if( isset( $aData['sRedirect'] ) ) echo $aData['sRedirect']; ?>" id="sRedirect" size="75" />
        </li>
        <!-- tab advanced -->
      </ul>

      <section id="tab-add-files" class="forms files">

        <script src="plugins/valums-file-uploader/fileuploader.min.js"></script>
        <div id="fileUploader">		
        </div>
        <div id="attachingFilesInfo"><?php echo $lang['Choose_files_to_attach']; ?></div>
        <ul id="files-dir">
        <?php echo $oFile->listFilesInDir( Array( 'sSort' => 'time' ) ); ?>
        </ul>
      </section>

      <section id="tab-files" class="forms files">
        <?php echo $sFilesList; ?>
      </section>

      <ul class="buttons bottom">
        <li class="save"><input type="submit" name="sOption" class="main" value="<?php echo $lang['save']; ?>" /></li>
        <li class="options"><input type="submit" value="<?php echo $lang['save_add_new']; ?>" name="sOptionAddNew" />
          <ul>
            <li><input type="submit" value="<?php echo $lang['save_list']; ?>" name="sOptionList" /></li>
          </ul>
        </li>
      </ul>

    </fieldset>
  </form>

</section>
<script>
  var sTypesSelect = '<?php echo getSelectFromArray( $config['images_locations'], $config['default_image_location'] ); ?>',
      sSizeSelect = '<?php echo getThumbnailsSelect( $config['default_image_size'] ); ?>';
  $(function(){
    var uploader = new qq.FileUploader({
      element: document.getElementById('fileUploader'),
      action: aQuick['sPhpSelf']+'?p=ajax-files-upload',
      inputName: 'sFileName',
      uploadButtonText: '<?php echo addslashes( $lang['Files_from_computer'] ); ?>',
      cancelButtonText: '<?php echo addslashes( $lang['Cancel'] ); ?>',
      failUploadText: '<?php echo addslashes( $lang['Upload_failed'] ); ?>',
      onComplete: function(id, fileName, response){
        if (!response.success){
          return;
        }
        if( uploader.getInProgress() == 0 )
          refreshFiles( );
        if( response.size_info ){
          qq.addClass(uploader._getItemByFileId(id), 'qq-upload-maxdimension');
          uploader._getItemByFileId(id).innerHTML += '<span class="qq-upload-warning"><?php echo addslashes( $lang['Image_over_max_dimension'] ); ?></span>';
        }
      }
    });

    displayTabInit();
    checkType();
    checkChangedFile( );
    $( ".main-form" ).quickform();
    customCheckbox();
    $( '#tab-content li.short-description label a.expand' ).click( function(){ displayShortDescriptionField( true ) } );
    <?php
    if( !empty( $aData['sDescriptionShort'] ) ){
      echo 'displayShortDescriptionField( false );';
    }
    ?>

    filesFromServerEvents( );
    $( '#tab-files td.name' ).hover( displayThumbPreview, clearThumbPreview );

  });
</script>
<?php
require_once 'templates/admin/_footer.php';
?>
