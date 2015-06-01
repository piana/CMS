<?php
// More about design modifications - www.opensolution.org/docs/
if( !defined( 'CUSTOMER_PAGE' ) )
  exit;
?>
<!DOCTYPE HTML>
<html lang="<?php echo $config['language']; ?>">
<head>
  <title><?php echo $config['title']; ?></title>
  <meta name="description" content="<?php echo $config['description']; ?>" />
  <meta name="generator" content="Quick.Cms v<?php echo $config['version']; ?>" />

  <link rel="stylesheet" href="templates/<?php echo $config['skin']; ?>/style.css" />

  <!--[if lt IE 9]>
  <link rel="stylesheet" href="templates/<?php echo $config['skin']; ?>/oldie.css" />
  <script src="plugins/html5shiv.js"></script>
  <![endif]-->
  <script src="plugins/jquery.min.js"></script>
  <script src="core/common.js"></script>
  <?php if( isset( $config['enabled_sliders'] ) ){ ?><script src="core/libraries/quick.slider.js"></script><?php } ?>
  <script src="core/libraries/quick.box.js"></script>
  <script>$(function(){ backToTopInit(); });</script>
</head>
<body<?php if( isset( $aData['iPage'] ) && is_numeric( $aData['iPage'] ) ) echo ' id="page'.$aData['iPage'].'"'; ?>>
<nav id="skiplinks">
  <ul>
    <li><a href="#head2"><?php echo $lang['Skip_to_main_menu']; ?></a></li>
    <li><a href="#content"><?php echo $lang['Skip_to_content']; ?></a></li>
  </ul>
</nav>

<div id="container">
  <section id="header">
    <header id="head1"><?php // banner, logo and slogan starts here ?>
      <div class="container">
        <div id="logo"><?php // logo and slogan ?>
          <div id="title"><a href="./"><?php echo $config['logo']; ?></a></div>
          <div id="slogan"><?php echo $config['slogan']; ?></div>
        </div>
      </div>
    </header>
    <header id="head2"><?php // top menu starts here ?>
      <div class="container">
        <?php echo $oPage->listPagesMenu( 1, Array( 'iDepthLimit' => 0 ) ); // content of top menu ?>
      </div>
    </header>
    <?php if( isset( $config['enabled_sliders'] ) ) echo $oSlider->listSliders( ); ?>
  </section>

  <section id="body">
    <div class="container">
      <section id="content">
