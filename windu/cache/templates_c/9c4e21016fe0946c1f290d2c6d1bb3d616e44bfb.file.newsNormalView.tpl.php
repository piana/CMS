<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:55:14
         compiled from "C:\xampp\htdocs\windu\data\widgets\newsNormal\newsNormalView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12099555d9d722983f4-96252171%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9c4e21016fe0946c1f290d2c6d1bb3d616e44bfb' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\data\\widgets\\newsNormal\\newsNormalView.tpl',
      1 => 1432112870,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12099555d9d722983f4-96252171',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'params' => 0,
    'first' => 0,
    'last' => 0,
    'where' => 0,
    'data' => 0,
    'newsGroup' => 0,
    'getNews' => 0,
    'HOME' => 0,
    'news' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9d72524a14_61357938',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9d72524a14_61357938')) {function content_555d9d72524a14_61357938($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include 'C:\\xampp\\htdocs\\windu/app/plugins/html/smarty/plugins\\modifier.truncate.php';
if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><?php if (!isset($_smarty_tpl->tpl_vars['params']->value['count'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['count'] = config::get('newsCount');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['length'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['length'] = config::get('newsLength');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['lengthTitle'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['lengthTitle'] = config::get('newsLengthTitle');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['width'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['width'] = config::get('imgSmallWidth');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['height'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['height'] = config::get('imgSmallHeight');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['span'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['span'] = config::get('newsSpan');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['btncss'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['btncss'] = config::get('newsBtnCssClass');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['cssUl'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['cssUl'] = 'newsNormal';?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['cssLi'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['cssLi'] = '';?><?php }?>

<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['showDate'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['showDate'] = true;?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['showAuthor'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['showAuthor'] = true;?><?php }?>

<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['showTitle'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['showTitle'] = true;?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['showContent'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['showContent'] = true;?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['showImg'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['showImg'] = true;?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['showMore'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['showMore'] = false;?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['startNews'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['startNews'] = 0;?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['fit'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['fit'] = 'smart';?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['where'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['where'] = null;?><?php }?>

<?php if ($_smarty_tpl->tpl_vars['params']->value['range']!='') {?>
    <?php if (isset($_smarty_tpl->tpl_vars['first'])) {$_smarty_tpl->tpl_vars['first'] = clone $_smarty_tpl->tpl_vars['first'];
$_smarty_tpl->tpl_vars['first']->value = generate::sqlDate(strtotime("first day of ".((string)$_smarty_tpl->tpl_vars['params']->value['range']))); $_smarty_tpl->tpl_vars['first']->nocache = null; $_smarty_tpl->tpl_vars['first']->scope = 0;
} else $_smarty_tpl->tpl_vars['first'] = new Smarty_variable(generate::sqlDate(strtotime("first day of ".((string)$_smarty_tpl->tpl_vars['params']->value['range']))), null, 0);?>
    <?php if (isset($_smarty_tpl->tpl_vars['last'])) {$_smarty_tpl->tpl_vars['last'] = clone $_smarty_tpl->tpl_vars['last'];
$_smarty_tpl->tpl_vars['last']->value = generate::sqlDate(strtotime("last day of ".((string)$_smarty_tpl->tpl_vars['params']->value['range']))); $_smarty_tpl->tpl_vars['last']->nocache = null; $_smarty_tpl->tpl_vars['last']->scope = 0;
} else $_smarty_tpl->tpl_vars['last'] = new Smarty_variable(generate::sqlDate(strtotime("last day of ".((string)$_smarty_tpl->tpl_vars['params']->value['range']))), null, 0);?>
    <?php if (isset($_smarty_tpl->tpl_vars['where'])) {$_smarty_tpl->tpl_vars['where'] = clone $_smarty_tpl->tpl_vars['where'];
$_smarty_tpl->tpl_vars['where']->value = " and type=2 and status=1 and createTime >= '".((string)$_smarty_tpl->tpl_vars['first']->value)."' and createTime <= '".((string)$_smarty_tpl->tpl_vars['last']->value)."'"; $_smarty_tpl->tpl_vars['where']->nocache = null; $_smarty_tpl->tpl_vars['where']->scope = 0;
} else $_smarty_tpl->tpl_vars['where'] = new Smarty_variable(" and type=2 and status=1 and createTime >= '".((string)$_smarty_tpl->tpl_vars['first']->value)."' and createTime <= '".((string)$_smarty_tpl->tpl_vars['last']->value)."'", null, 0);?>
    <?php if (isset($_smarty_tpl->tpl_vars['getNews'])) {$_smarty_tpl->tpl_vars['getNews'] = clone $_smarty_tpl->tpl_vars['getNews'];
$_smarty_tpl->tpl_vars['getNews']->value = $_smarty_tpl->tpl_vars['data']->value['pagesDB']->getNews($_smarty_tpl->tpl_vars['params']->value['newsGroup'],$_smarty_tpl->tpl_vars['params']->value['count'],$_smarty_tpl->tpl_vars['params']->value['startNews'],$_smarty_tpl->tpl_vars['where']->value); $_smarty_tpl->tpl_vars['getNews']->nocache = null; $_smarty_tpl->tpl_vars['getNews']->scope = 0;
} else $_smarty_tpl->tpl_vars['getNews'] = new Smarty_variable($_smarty_tpl->tpl_vars['data']->value['pagesDB']->getNews($_smarty_tpl->tpl_vars['params']->value['newsGroup'],$_smarty_tpl->tpl_vars['params']->value['count'],$_smarty_tpl->tpl_vars['params']->value['startNews'],$_smarty_tpl->tpl_vars['where']->value), null, 0);?>
    <?php } else { ?>
    <?php if (isset($_smarty_tpl->tpl_vars['getNews'])) {$_smarty_tpl->tpl_vars['getNews'] = clone $_smarty_tpl->tpl_vars['getNews'];
$_smarty_tpl->tpl_vars['getNews']->value = $_smarty_tpl->tpl_vars['data']->value['pagesDB']->getNews($_smarty_tpl->tpl_vars['params']->value['newsGroup'],$_smarty_tpl->tpl_vars['params']->value['count'],$_smarty_tpl->tpl_vars['params']->value['startNews']); $_smarty_tpl->tpl_vars['getNews']->nocache = null; $_smarty_tpl->tpl_vars['getNews']->scope = 0;
} else $_smarty_tpl->tpl_vars['getNews'] = new Smarty_variable($_smarty_tpl->tpl_vars['data']->value['pagesDB']->getNews($_smarty_tpl->tpl_vars['params']->value['newsGroup'],$_smarty_tpl->tpl_vars['params']->value['count'],$_smarty_tpl->tpl_vars['params']->value['startNews']), null, 0);?>
<?php }?>

<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['news'])) {?><?php if (isset($_smarty_tpl->tpl_vars['newsList'])) {$_smarty_tpl->tpl_vars['newsList'] = clone $_smarty_tpl->tpl_vars['newsList'];
$_smarty_tpl->tpl_vars['newsList']->value = $_smarty_tpl->tpl_vars['newsGroup']->value; $_smarty_tpl->tpl_vars['newsList']->nocache = null; $_smarty_tpl->tpl_vars['newsList']->scope = 0;
} else $_smarty_tpl->tpl_vars['newsList'] = new Smarty_variable($_smarty_tpl->tpl_vars['newsGroup']->value, null, 0);?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['newsList'])) {$_smarty_tpl->tpl_vars['newsList'] = clone $_smarty_tpl->tpl_vars['newsList'];
$_smarty_tpl->tpl_vars['newsList']->value = $_smarty_tpl->tpl_vars['params']->value['news']; $_smarty_tpl->tpl_vars['newsList']->nocache = null; $_smarty_tpl->tpl_vars['newsList']->scope = 0;
} else $_smarty_tpl->tpl_vars['newsList'] = new Smarty_variable($_smarty_tpl->tpl_vars['params']->value['news'], null, 0);?><?php }?>


<ul class="<?php echo $_smarty_tpl->tpl_vars['params']->value['cssUl'];?>
">
    <?php  $_smarty_tpl->tpl_vars['news'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['news']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['getNews']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['news']->key => $_smarty_tpl->tpl_vars['news']->value) {
$_smarty_tpl->tpl_vars['news']->_loop = true;
?>
        <li class="<?php echo $_smarty_tpl->tpl_vars['params']->value['cssLi'];?>
">
            <?php if ($_smarty_tpl->tpl_vars['params']->value['showMore']==false) {?><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
<?php echo $_smarty_tpl->tpl_vars['news']->value->urlKey;?>
"><?php }?>
                <?php if (pagesDB::getMainImageEkey($_smarty_tpl->tpl_vars['news']->value->id)!=null&&$_smarty_tpl->tpl_vars['params']->value['showImg']) {?>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
<?php echo $_smarty_tpl->tpl_vars['news']->value->urlKey;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo pagesDB::getMainImageEkey($_smarty_tpl->tpl_vars['news']->value->id);?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['width'];?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['height'];?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['fit'];?>
/" class="pull-left img-margin"></a>
                <?php }?>

                <?php if ($_smarty_tpl->tpl_vars['params']->value['showTitle']) {?><h4><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
<?php echo $_smarty_tpl->tpl_vars['news']->value->urlKey;?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['news']->value->name,$_smarty_tpl->tpl_vars['params']->value['lengthTitle']);?>
</a></h4><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['params']->value['showAuthor']||$_smarty_tpl->tpl_vars['params']->value['showDate']) {?>
                    <p class="newsNormal-meta">
                        <?php if ($_smarty_tpl->tpl_vars['params']->value['showAuthor']) {?><span class="label margin-right"><?php echo $_smarty_tpl->tpl_vars['data']->value['usersDB']->get($_smarty_tpl->tpl_vars['news']->value->authorId,'username');?>
</span><?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['params']->value['showDate']) {?><?php echo $_smarty_tpl->tpl_vars['news']->value->date;?>
<?php }?>
                    </p>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['params']->value['showContent']) {?><p><?php echo smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['news']->value->content),$_smarty_tpl->tpl_vars['params']->value['length']);?>
</p><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['params']->value['showMore']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
<?php echo $_smarty_tpl->tpl_vars['news']->value->urlKey;?>
" class="<?php echo $_smarty_tpl->tpl_vars['params']->value['btncss'];?>
"><?php echo smarty_function_L(array('key'=>"news.normal.more"),$_smarty_tpl);?>
</a><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['params']->value['showMore']==false) {?></a><?php }?>
        </li>
    <?php } ?>
</ul><?php }} ?>
