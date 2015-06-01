<?php
if( !defined( 'ADMIN_PAGE' ) )
  exit;
?>
<!DOCTYPE HTML>
<html lang="<?php echo $config['language']; ?>">
<head>
  <title>Admin - Quick.Cms v<?php echo $config['version']; ?></title>
  <meta name="description" content="" />
  <meta name="generator" content="Quick.Cms v<?php echo $config['version']; ?>" />

  <link rel="stylesheet" href="templates/admin/style.css" />
  <link rel="stylesheet" href="plugins/valums-file-uploader/fileuploader.css" type="text/css" />
  <!--[if lt IE 9]>
  <link rel="stylesheet" href="templates/admin/oldie.css" />
  <script src="plugins/html5shiv.js"></script>
  <![endif]-->
  <script src="plugins/jquery.min.js"></script>
  <script src="core/common.js"></script>
  <script src="core/common-admin.js"></script>
  <script src="core/libraries/quick.form.js"></script>
  <script src="core/libraries/quick.box.js"></script>
  <script>
    var aCF = {
          'sWarning' : '<?php echo $lang['Fill_required_fields']; ?>',
          'sEmail' : '<?php echo $lang['Type_correct_email']; ?>',
          'sTooShort' : '<?php echo $lang['Txt_to_short']; ?>',
          'sInt' : '<?php echo $lang['Wrong_value']; ?>'
        },
        aQuick = {
          'sPhpSelf' : '<?php echo $config['admin_file']; ?>',
          'sIncorrectData' : '<?php echo $lang['Incorrect_data']; ?>',
          'sConfirmShure' : '<?php echo $lang['Operation_sure']; ?>',
          'sDelShure' : '<?php echo $lang['Operation_sure_delete']; ?>'
        },
        oLoad, oTempEl;
    <?php if( isset( $sSelectedMenu ) ){ ?>$(function(){ $( '#header .menu li.<?php echo $sSelectedMenu; ?>' ).addClass( 'selected' ); }); <?php } ?>
  </script>
</head>
<body>

<div id="container">
