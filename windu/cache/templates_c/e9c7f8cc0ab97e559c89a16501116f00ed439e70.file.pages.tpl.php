<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:07:54
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\pages.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6543555da06a3f9aa7-52831121%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e9c7f8cc0ab97e559c89a16501116f00ed439e70' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\pages.tpl',
      1 => 1398323026,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6543555da06a3f9aa7-52831121',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 0,
    'contentType' => 0,
    'form' => 0,
    'images' => 0,
    'image' => 0,
    'formRestore' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da06a5c2b93_27011079',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da06a5c2b93_27011079')) {function content_555da06a5c2b93_27011079($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?>			<div class="row-fluid">
			  <div class="span5 box">
			  	<h5><i class="fa fa-clipboard icon-margin icon-grey">&nbsp;</i> <?php echo smarty_function_L(array('key'=>"admin.content.common.tpl.pageslist"),$_smarty_tpl);?>

				  	<div class="buttons buttons-three">
				  		<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/mainDo/toogleCookie/sortableOn/tab1/" class="btn btn-small <?php if (cookie::readCookie('sortableOn')) {?>btn-success<?php }?>"><?php echo smarty_function_L(array('key'=>"admin.content.tpl.sort"),$_smarty_tpl);?>
</a>
				  		<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/mainDo/toogleCookie/showAllOn/tab1/" class="btn btn-small <?php if (cookie::readCookie('showAllOn')) {?>btn-success<?php }?>"><?php echo smarty_function_L(array('key'=>"admin.content.tpl.showall"),$_smarty_tpl);?>
</a>
				  		<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/content/hideTreelistAll/" class="btn btn-small">-</a>
				  	</div>
			  	</h5>
				<?php echo $_smarty_tpl->getSubTemplate ('common/content_list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			  </div>
			  	<?php if ($_smarty_tpl->tpl_vars['contentType']->value=='form') {?>
				  	<div class="span7">
				  		<div class="box box-floating">
				  			<h5><i class="fa fa-plus-circle icon-margin icon-grey">&nbsp;</i><?php echo smarty_function_L(array('key'=>"admin.content.common.tpl.addelement"),$_smarty_tpl);?>
</h5>
					  		<?php echo $_smarty_tpl->tpl_vars['form']->value->toHtml();?>

				  		</div>
				  	</div>
				<?php } elseif ($_smarty_tpl->tpl_vars['contentType']->value=='edit') {?>
					<?php echo $_smarty_tpl->getSubTemplate ('common/images_modal.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					<?php echo $_smarty_tpl->getSubTemplate ('common/widgets_modal.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					<?php echo $_smarty_tpl->getSubTemplate ('common/files_modal.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					<?php echo $_smarty_tpl->getSubTemplate ('common/customfields_modal.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				  	<div class="span7">
					  	<div class="box box-silver">
							<?php echo $_smarty_tpl->tpl_vars['form']->value->toHtml();?>

					  	</div>
					  	<?php if ($_smarty_tpl->tpl_vars['images']->value!=null) {?>
					  	<div class="box margin-top mobileHidden">
					  		<h5><i class="fa fa-picture-o icon-margin icon-grey">&nbsp;</i> <?php echo smarty_function_L(array('key'=>"admin.content.common.tpl.imagelistingalery"),$_smarty_tpl);?>

							  	<div class="buttons">
							  		<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/mainDo/toogleCookie/sortableOn/tab1/" class="btn btn-small <?php if (cookie::readCookie('sortableOn')) {?>btn-success<?php }?>"><?php echo smarty_function_L(array('key'=>"admin.content.tpl.sort"),$_smarty_tpl);?>
</a>
							  	</div>				  			
					  		</h5>
					  		<?php echo $_smarty_tpl->getSubTemplate ('common/images_list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					  	</div>
					  	<?php }?>
				  	</div>				  	
			  	<?php } elseif ($_smarty_tpl->tpl_vars['contentType']->value=='gallery') {?>
				  	<div class="span7">
					  		<div class="box">
						  		<h5><i class="fa fa-plus-circle icon-margin icon-grey">&nbsp;</i> <?php echo smarty_function_L(array('key'=>"admin.content.common.tpl.addimages"),$_smarty_tpl);?>
</h5>
						  		<?php echo $_smarty_tpl->getSubTemplate ('common/images_multiuploader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						  	</div>	
						  	<div class="box margin-top">
					  			<h5><i class="fa fa-picture-o icon-margin icon-grey">&nbsp;</i> <?php echo smarty_function_L(array('key'=>"admin.content.common.tpl.imagelistingalery"),$_smarty_tpl);?>

								  	<div class="buttons">
								  		<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/mainDo/toogleCookie/sortableOn/tab1/" class="btn btn-small <?php if (cookie::readCookie('sortableOn')) {?>btn-success<?php }?>"><?php echo smarty_function_L(array('key'=>"admin.content.tpl.sort"),$_smarty_tpl);?>
</a>
								  	</div>				  			
					  			</h5>
					  			<?php echo $_smarty_tpl->getSubTemplate ('common/images_list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
	
					  		</div>
				  	</div>
				<?php } elseif ($_smarty_tpl->tpl_vars['contentType']->value=='image') {?>
				  	<div class="span2">
					  	<div class="box">
						  	<h5><i class="fa fa-pencil icon-margin icon-grey">&nbsp;</i> <?php echo smarty_function_L(array('key'=>"admin.content.tpl.editimages"),$_smarty_tpl);?>
</h5>
							<?php echo $_smarty_tpl->getSubTemplate ('common/images_editor.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
	
						</div>				  	
				  		<div class="box margin-top">
					  		<h5><i class="fa fa-picture-o icon-margin icon-grey">&nbsp;</i> <?php echo smarty_function_L(array('key'=>"admin.content.common.tpl.imagelistingalery"),$_smarty_tpl);?>
</h5>
					  		<?php echo $_smarty_tpl->getSubTemplate ('common/images_list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('parentId'=>$_smarty_tpl->tpl_vars['image']->value->bucket,'small'=>1), 0);?>
	
					  	</div>	
				  	</div>					
				  	<div class="span5">
				  		<div class="box">
					  		<h5><i class="fa fa-clipboard icon-margin icon-grey">&nbsp;</i> <?php echo smarty_function_L(array('key'=>"admin.content.tpl.description"),$_smarty_tpl);?>
</h5>
					  		<?php echo $_smarty_tpl->tpl_vars['form']->value->toHtml();?>

					  	</div>
				  	</div>	
				<?php } elseif ($_smarty_tpl->tpl_vars['contentType']->value=='news') {?>
				  	<div class="span7">
				  		<div class="box">
					  		<h5><i class="fa fa-calendar icon-margin icon-grey">&nbsp;</i> <?php echo smarty_function_L(array('key'=>"admin.content.tpl.addnews"),$_smarty_tpl);?>
</h5>
					  		<?php echo $_smarty_tpl->tpl_vars['form']->value->toHtml();?>

					  	</div>	
					  	<?php if (is_object($_smarty_tpl->tpl_vars['formRestore']->value)) {?>
				  		<div class="box margin-top">
					  		<h5><i class="fa fa-picture-o icon-margin icon-grey">&nbsp;</i> <?php echo smarty_function_L(array('key'=>"admin.content.tpl.restore"),$_smarty_tpl);?>
</h5>
					  		<?php echo $_smarty_tpl->tpl_vars['formRestore']->value->toHtml();?>

				  		</div>
				  		<?php }?>	
				  	</div>	
			  	<?php } else { ?>
			  		<div class="span7">
			  			<?php echo $_smarty_tpl->getSubTemplate ('common/content_info.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			  		</div>
			  	<?php }?>
			</div><?php }} ?>
