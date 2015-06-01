<?php

/**
* Function returns code for tinymce wysiwyg editor
* @return string
* @param  string  $sName
* @param  string  $sContent
* @param array $aParametersExt
* Default options: sToolbar, sPlugins
*/
function getWysiwygTinymce( $sName, $aParametersExt ){
  $content = null;
  if( !defined( 'WYSIWYG_START' ) ){
    define( 'WYSIWYG_START', true );
    $content .= '<script src="plugins/tinymce/tinymce.min.js"></script>';
  }

  $content .= '<script>
  tinymce.init({
      selector : "textarea#'.$sName.'",
      toolbar : "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | undo redo | link unlink removeformat | about fullscreen code '.( isset( $aParametersExt['sToolbar'] ) ? $aParametersExt['sToolbar'] : null ).'",
      menubar : false,
      plugins: ["link, code, fullscreen, tabindex'.( isset( $aParametersExt['sPlugins'] ) ? $aParametersExt['sPlugins'] : null ).'"],
      entity_encoding : "raw",
      gecko_spellcheck : true,
      setup: function(editor) {
        editor.addButton("about", {
          title: "About",
          icon: "help",
          onclick: function() {
            editor.windowManager.open({title:"About",url:editor.editorManager.baseURL+"/plugins/about.htm",width:480,height:300,inline:true})
          }

        });
      }
   });
  </script>';
  return $content;
} // end function getWysiwygTinymce

?>