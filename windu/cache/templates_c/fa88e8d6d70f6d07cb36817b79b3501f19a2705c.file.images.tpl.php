<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:59:33
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\images.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17784555d9e7507c6d0-44736053%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fa88e8d6d70f6d07cb36817b79b3501f19a2705c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\images.tpl',
      1 => 1398498526,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17784555d9e7507c6d0-44736053',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 0,
    'formAddWatermark' => 0,
    'imagePatternWatermark' => 0,
    'watermarkImg' => 0,
    'watermarkImgUrl' => 0,
    'formEditImage' => 0,
    'imagesDB' => 0,
    'pageCount' => 0,
    'REQUEST' => 0,
    'elementCount' => 0,
    'image' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9e7520ecb2_38594085',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9e7520ecb2_38594085')) {function content_555d9e7520ecb2_38594085($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><div class="tab-menu-top">
	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/images/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	<h3 class="pull-left tab-title"> <?php echo smarty_function_L(array('key'=>"admin.tools.tpl.images"),$_smarty_tpl);?>
</h3>
	
	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/content/images/addWatermark/" class="btn btn-small btn-info"><?php echo smarty_function_L(array('key'=>"admin.common.images.tpl.addwatermark"),$_smarty_tpl);?>
</a>
	<span class="line-vertical"></span>	
    <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/cleanImagesThumbs/" class="btn btn-small btn-warning"><?php echo smarty_function_L(array('key'=>"admin.common.images.tpl.clear"),$_smarty_tpl);?>
</a>
	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/cleanImagesDatabase/" class="btn btn-danger btn-small"><?php echo smarty_function_L(array('key'=>"admin.common.conservation.tpl.cleandatabase"),$_smarty_tpl);?>
</a>	
	<span class="line-vertical"></span>	
	<?php if (config::get("month_delete_thumbs")!=0) {?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/tools/toggleCronConfig/month_delete_thumbs/" class="btn btn-success btn-small"><i class="fa fa-power-off "></i><?php echo smarty_function_L(array('key'=>"admin.common.conservation.tpl.thumbnailclear"),$_smarty_tpl);?>
</a>
	<?php } else { ?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/tools/toggleCronConfig/month_delete_thumbs/" class="btn btn-danger btn-small"><i class="fa fa-power-off "></i><?php echo smarty_function_L(array('key'=>"admin.common.conservation.tpl.thumbnailclear"),$_smarty_tpl);?>
</a>
	<?php }?>	
</div>	
<div class="row-fluid">
  <?php if (isset($_smarty_tpl->tpl_vars['formAddWatermark']->value)) {?>
  	<div class="span6">
  		<div class="box">
			<img src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['imagePatternWatermark']->value->ekey;?>
/1000/800/fit/">
  		</div>	
  	</div>	
  	<div class="span6">
  		<div class="box">
   			<?php if (file_exists($_smarty_tpl->tpl_vars['watermarkImg']->value)) {?>
  				<div class="align-center"><img src="<?php echo $_smarty_tpl->tpl_vars['watermarkImgUrl']->value;?>
?"></div>
  			<?php }?> 			
  			<?php echo $_smarty_tpl->tpl_vars['formAddWatermark']->value->toHtml();?>

  		</div> 
  	</div>	
  <?php } else { ?>	
  	  <?php if (!isset($_smarty_tpl->tpl_vars['formEditImage']->value)) {?> 
	  <div class="span2 mobileHidden">
		<div class="box pad margin-bottom align-center">
			<?php echo smarty_function_L(array('key'=>"admin.common.images.tpl.numberimg"),$_smarty_tpl);?>

			<h2><?php echo $_smarty_tpl->tpl_vars['imagesDB']->value->fetchCount();?>
</h2>
		</div>	
		<div class="box pad margin-bottom align-center">
			<?php echo smarty_function_L(array('key'=>"admin.common.images.tpl.gennumber"),$_smarty_tpl);?>

			<h2><?php echo image::getThumbsCount();?>
</h2>
		</div>	
	  </div>
	  <?php }?>
	  
		<?php if (isset($_smarty_tpl->tpl_vars['pageCount'])) {$_smarty_tpl->tpl_vars['pageCount'] = clone $_smarty_tpl->tpl_vars['pageCount'];
$_smarty_tpl->tpl_vars['pageCount']->value = 20; $_smarty_tpl->tpl_vars['pageCount']->nocache = null; $_smarty_tpl->tpl_vars['pageCount']->scope = 0;
} else $_smarty_tpl->tpl_vars['pageCount'] = new Smarty_variable(20, null, 0);?>
		<?php if (isset($_smarty_tpl->tpl_vars['page'])) {$_smarty_tpl->tpl_vars['page'] = clone $_smarty_tpl->tpl_vars['page'];
$_smarty_tpl->tpl_vars['page']->value = $_smarty_tpl->tpl_vars['pageCount']->value*$_smarty_tpl->tpl_vars['REQUEST']->value->getVariable('p'); $_smarty_tpl->tpl_vars['page']->nocache = null; $_smarty_tpl->tpl_vars['page']->scope = 0;
} else $_smarty_tpl->tpl_vars['page'] = new Smarty_variable($_smarty_tpl->tpl_vars['pageCount']->value*$_smarty_tpl->tpl_vars['REQUEST']->value->getVariable('p'), null, 0);?>
		<?php if (isset($_smarty_tpl->tpl_vars['elementCount'])) {$_smarty_tpl->tpl_vars['elementCount'] = clone $_smarty_tpl->tpl_vars['elementCount'];
$_smarty_tpl->tpl_vars['elementCount']->value = $_smarty_tpl->tpl_vars['imagesDB']->value->fetchCount(); $_smarty_tpl->tpl_vars['elementCount']->nocache = null; $_smarty_tpl->tpl_vars['elementCount']->scope = 0;
} else $_smarty_tpl->tpl_vars['elementCount'] = new Smarty_variable($_smarty_tpl->tpl_vars['imagesDB']->value->fetchCount(), null, 0);?>

	  <div class="<?php if (isset($_smarty_tpl->tpl_vars['formEditImage']->value)) {?>span5<?php } else { ?>span10<?php }?>">
	  	<?php echo $_smarty_tpl->getSubTemplate ('common/paginator.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('elementsCount'=>$_smarty_tpl->tpl_vars['elementCount']->value,'count'=>$_smarty_tpl->tpl_vars['pageCount']->value), 0);?>
	 
	  	<div class="box">
			<h5><i class="fa fa-picture-o icon-margin icon-grey">&nbsp;</i> <?php echo smarty_function_L(array('key'=>"admin.common.images.tpl.photolist"),$_smarty_tpl);?>
</h5>
			<?php if (isset($_smarty_tpl->tpl_vars['formEditImage']->value)) {?>
				<?php echo $_smarty_tpl->getSubTemplate ('common/images_all_list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			<?php } else { ?>
				<?php echo $_smarty_tpl->getSubTemplate ('common/images_all_list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('extended'=>1), 0);?>

			<?php }?>
		</div>
		<?php echo $_smarty_tpl->getSubTemplate ('common/paginator.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('elementsCount'=>$_smarty_tpl->tpl_vars['elementCount']->value,'count'=>$_smarty_tpl->tpl_vars['pageCount']->value), 0);?>
	 
	  </div>
	  <?php if (isset($_smarty_tpl->tpl_vars['formEditImage']->value)) {?>
	  	<div class="span7">
		  		<div class="box box-floating">
		  			<h5><i class="fa fa-pencil icon-margin icon-grey">&nbsp;</i> <?php echo smarty_function_L(array('key'=>"admin.common.images.tpl.editimage"),$_smarty_tpl);?>
</h5>
		  			<center class="pad"><img src='<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['image']->value->ekey;?>
/500/200/fit/'></center>
		  			<?php echo $_smarty_tpl->tpl_vars['formEditImage']->value->toHtml();?>

		  		</div>
	  	</div>
	  <?php }?>
  <?php }?>
</div>	 
     	<?php }} ?>
