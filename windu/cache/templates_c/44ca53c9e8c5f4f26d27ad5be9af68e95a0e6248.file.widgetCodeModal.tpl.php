<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:09:03
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\ajax\widgetCodeModal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6522555da0af2dc482-99571065%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '44ca53c9e8c5f4f26d27ad5be9af68e95a0e6248' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\ajax\\widgetCodeModal.tpl',
      1 => 1398323026,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6522555da0af2dc482-99571065',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'widgetCode' => 0,
    'HOME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da0af33df25_96131354',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da0af33df25_96131354')) {function content_555da0af33df25_96131354($_smarty_tpl) {?><div class="pad-big">
	<div class="progress progress-striped">
		 <div class="bar" style="width: 100%;"></div>
	</div>
</div>
<div class="pad-big widgetCode">
	<h4><?php echo $_smarty_tpl->tpl_vars['widgetCode']->value;?>
</h4>
</div>
<div class="bottomForm">
	<div class="form-actions" style="text-align:center;">
		<a href="#" onclick="parent.editorInsertText('<?php echo $_smarty_tpl->tpl_vars['widgetCode']->value;?>
'); parent.$('#widgetsModal').modal('hide');" class="btn btn-primary">Dodaj kod na strone</a>
		<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/ajax/widgets/choseWidget/" class="btn">Anuluj</a>		
	</div>
</div>	

<?php }} ?>
