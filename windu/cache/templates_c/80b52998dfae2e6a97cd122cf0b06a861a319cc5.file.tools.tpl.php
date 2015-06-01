<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:11:08
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\tools.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4416555da12ccb0a37-54000078%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '80b52998dfae2e6a97cd122cf0b06a861a319cc5' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\tools.tpl',
      1 => 1399139354,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4416555da12ccb0a37-54000078',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da12cd589d8_53780229',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da12cd589d8_53780229')) {function content_555da12cd589d8_53780229($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><?php echo $_smarty_tpl->getSubTemplate ('common/goProBanner.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div class="row-fluid menu">
	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/monitoring/" class="span2 box box-hover-animate">
        <i class="fa fa-bar-chart-o fa-3x icon-dark"> </i> <h4><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.monitoring"),$_smarty_tpl);?>
</h4>
    </a>
	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/seo/" class="span2 box box-hover-animate">
        <i class="fa fa-globe fa-3x icon-green"> </i> <h4><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.seo"),$_smarty_tpl);?>
</h4>
    </a>
	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/mailing/" class="span2 box box-hover-animate">
        <i class="fa fa-inbox fa-3x icon-red"> </i> <h4><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.mailing"),$_smarty_tpl);?>
</h4>
	</a>
	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/rss/" class="span2 box box-hover-animate">
        <i class="fa fa-rss fa-3x icon-orange"> </i> <h4>RSS</h4>
    </a>
	<?php if (!usersDB::isNoob()) {?>
	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/contacts/" class="span2 box box-hover-animate">
        <i class="fa fa-envelope fa-3x icon-yellow"> </i> <h4><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.contact"),$_smarty_tpl);?>
</h4>
	</a>
	<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/tools/database/" class="span2 box box-hover-animate">
        <i class="fa fa-upload fa-3x icon-purple"> </i> <h4><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.database"),$_smarty_tpl);?>
</h4>
	</a>
	<?php }?>
</div>

<div class="row-fluid menu">
    <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/stats/" class="span2 box box-hover-animate">
        <i class="fa fa-signal fa-3x icon-blue"> </i> <h4><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.stats"),$_smarty_tpl);?>
</h4>
    </a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/backup/" class="span2 box box-hover-animate">
        <i class="fa fa-archive fa-3x icon-orange"> </i> <h4><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.backup"),$_smarty_tpl);?>
</h4>
    </a>
    <?php if (!usersDB::isNoob()) {?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/log/" class="span2 box box-hover-animate">
            <i class="fa fa-bell fa-3x icon-yellow"> </i> <h4><?php echo smarty_function_L(array('key'=>"admin.system.tpl.log"),$_smarty_tpl);?>
</h4>
        </a>
        <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/cron/" class="span2 box box-hover-animate">
            <i class="fa fa-cogs fa-3x icon-green"> </i> <h4>Cron</h4>
        </a>
        <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/system/firewall/" class="span2 box box-hover-animate">
            <i class="fa fa-shield fa-3x icon-red"> </i> <h4><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.firewall"),$_smarty_tpl);?>
</h4>
        </a>
        <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/requestlog/showLogs/" class="span2 box box-hover-animate">
            <i class="fa fa-download fa-3x icon-dark"> </i> <h4><?php echo smarty_function_L(array('key'=>"admin.tools.tpl.requestlog"),$_smarty_tpl);?>
</h4>
        </a>
    <?php }?>
</div><?php }} ?>
