<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:55:11
         compiled from "C:\xampp\htdocs\windu\data\themes\Orange\tpl_common\top.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13342555d9d6fbee573-80724959%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '17c0e44442c9f097b83d8823bf3a5e7e1a91ec5f' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\data\\themes\\Orange\\tpl_common\\top.tpl',
      1 => 1432197208,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13342555d9d6fbee573-80724959',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 0,
    'TEMPLATE_HOME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9d6fc194f6_84710414',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9d6fc194f6_84710414')) {function content_555d9d6fc194f6_84710414($_smarty_tpl) {?><?php if (!is_callable('smarty_function_W')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.W.php';
?><div class="top">	
		<?php echo smarty_function_W(array('name'=>'notify'),$_smarty_tpl);?>
	
	<div class="container-fluid">
		<div class="row">
		    <div class="col-md-1 drplang">
		    	<?php echo smarty_function_W(array('name'=>'languageDropDownBox'),$_smarty_tpl);?>

		    </div>
		    	<div class="col-md-3 topmn">
					<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
" class="logo"><img src="<?php echo $_smarty_tpl->tpl_vars['TEMPLATE_HOME']->value;?>
/img/logo2.png"></a>
		    	</div>	 
	         <div class="col-md-8 clm7">
	        	<div class="dropcl">
					<?php echo smarty_function_W(array('name'=>'menuDroppy'),$_smarty_tpl);?>

				</div>
	        </div>	   
		</div>     
	</div>
</div>
	
<?php }} ?>
