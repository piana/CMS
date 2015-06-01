<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:00:02
         compiled from "C:\xampp\htdocs\windu\data\widgets\sliderBootstrap\sliderBootstrapView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:28007555d9e92d7b695-69210491%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '63dbe11e283e5922d0e4fa6ad7d9e6320fdf88cf' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\data\\widgets\\sliderBootstrap\\sliderBootstrapView.tpl',
      1 => 1432112876,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '28007555d9e92d7b695-69210491',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'params' => 0,
    'data' => 0,
    'images' => 0,
    'foo' => 0,
    'HOME' => 0,
    'img' => 0,
    'descriptionColName' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9e93175551_20128759',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9e93175551_20128759')) {function content_555d9e93175551_20128759($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include 'C:\\xampp\\htdocs\\windu/app/plugins/html/smarty/plugins\\modifier.truncate.php';
?><?php if (!isset($_smarty_tpl->tpl_vars['params']->value['width'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['width'] = config::get('imgBigWidth');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['height'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['height'] = config::get('imgBigHeight');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['fit'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['fit'] = config::get('sliderImageFit');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['filter'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['filter'] = config::get('sliderImageFilter');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['contentLenght'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['contentLenght'] = config::get('sliderContentLength');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['count'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['count'] = config::get('sliderCount');?><?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['params']->value['showContent'])) {?><?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value['showContent'] = true;?><?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['dataNow'])) {$_smarty_tpl->tpl_vars['dataNow'] = clone $_smarty_tpl->tpl_vars['dataNow'];
$_smarty_tpl->tpl_vars['dataNow']->value = generate::sqlDatetime(); $_smarty_tpl->tpl_vars['dataNow']->nocache = null; $_smarty_tpl->tpl_vars['dataNow']->scope = 0;
} else $_smarty_tpl->tpl_vars['dataNow'] = new Smarty_variable(generate::sqlDatetime(), null, 0);?>

<?php if ($_smarty_tpl->tpl_vars['params']->value['imagesBucket']!='') {?>
	<?php if (isset($_smarty_tpl->tpl_vars['images'])) {$_smarty_tpl->tpl_vars['images'] = clone $_smarty_tpl->tpl_vars['images'];
$_smarty_tpl->tpl_vars['images']->value = $_smarty_tpl->tpl_vars['data']->value['imagesDB']->getByBucket($_smarty_tpl->tpl_vars['params']->value['imagesBucket'],'position ASC','*',$_smarty_tpl->tpl_vars['params']->value['count']); $_smarty_tpl->tpl_vars['images']->nocache = null; $_smarty_tpl->tpl_vars['images']->scope = 0;
} else $_smarty_tpl->tpl_vars['images'] = new Smarty_variable($_smarty_tpl->tpl_vars['data']->value['imagesDB']->getByBucket($_smarty_tpl->tpl_vars['params']->value['imagesBucket'],'position ASC','*',$_smarty_tpl->tpl_vars['params']->value['count']), null, 0);?>
	<?php if (isset($_smarty_tpl->tpl_vars['descriptionColName'])) {$_smarty_tpl->tpl_vars['descriptionColName'] = clone $_smarty_tpl->tpl_vars['descriptionColName'];
$_smarty_tpl->tpl_vars['descriptionColName']->value = 'description'; $_smarty_tpl->tpl_vars['descriptionColName']->nocache = null; $_smarty_tpl->tpl_vars['descriptionColName']->scope = 0;
} else $_smarty_tpl->tpl_vars['descriptionColName'] = new Smarty_variable('description', null, 0);?>
<?php } elseif ($_smarty_tpl->tpl_vars['params']->value['pagesBucket']!='') {?>
	<?php if (isset($_smarty_tpl->tpl_vars['images'])) {$_smarty_tpl->tpl_vars['images'] = clone $_smarty_tpl->tpl_vars['images'];
$_smarty_tpl->tpl_vars['images']->value = $_smarty_tpl->tpl_vars['data']->value['pagesDB']->getPagesByParentMulti($_smarty_tpl->tpl_vars['params']->value['pagesBucket'],'hasImage = 1 and status = 1','date DESC,createTime DESC','*',$_smarty_tpl->tpl_vars['params']->value['count']); $_smarty_tpl->tpl_vars['images']->nocache = null; $_smarty_tpl->tpl_vars['images']->scope = 0;
} else $_smarty_tpl->tpl_vars['images'] = new Smarty_variable($_smarty_tpl->tpl_vars['data']->value['pagesDB']->getPagesByParentMulti($_smarty_tpl->tpl_vars['params']->value['pagesBucket'],'hasImage = 1 and status = 1','date DESC,createTime DESC','*',$_smarty_tpl->tpl_vars['params']->value['count']), null, 0);?>
	<?php if (isset($_smarty_tpl->tpl_vars['descriptionColName'])) {$_smarty_tpl->tpl_vars['descriptionColName'] = clone $_smarty_tpl->tpl_vars['descriptionColName'];
$_smarty_tpl->tpl_vars['descriptionColName']->value = 'content'; $_smarty_tpl->tpl_vars['descriptionColName']->nocache = null; $_smarty_tpl->tpl_vars['descriptionColName']->scope = 0;
} else $_smarty_tpl->tpl_vars['descriptionColName'] = new Smarty_variable('content', null, 0);?>
<?php } elseif ($_smarty_tpl->tpl_vars['params']->value['tagsBucket']!='') {?>
	<?php if (isset($_smarty_tpl->tpl_vars['images'])) {$_smarty_tpl->tpl_vars['images'] = clone $_smarty_tpl->tpl_vars['images'];
$_smarty_tpl->tpl_vars['images']->value = $_smarty_tpl->tpl_vars['data']->value['pagesDB']->getPagesByTag($_smarty_tpl->tpl_vars['params']->value['tagsBucket'],"hasImage = 1 and status = 1 and date <= '".((string)$_smarty_tpl->tpl_vars['dataNow']->value)."'",'date DESC,createTime DESC','*',$_smarty_tpl->tpl_vars['params']->value['count']); $_smarty_tpl->tpl_vars['images']->nocache = null; $_smarty_tpl->tpl_vars['images']->scope = 0;
} else $_smarty_tpl->tpl_vars['images'] = new Smarty_variable($_smarty_tpl->tpl_vars['data']->value['pagesDB']->getPagesByTag($_smarty_tpl->tpl_vars['params']->value['tagsBucket'],"hasImage = 1 and status = 1 and date <= '".((string)$_smarty_tpl->tpl_vars['dataNow']->value)."'",'date DESC,createTime DESC','*',$_smarty_tpl->tpl_vars['params']->value['count']), null, 0);?>	
	<?php if (isset($_smarty_tpl->tpl_vars['descriptionColName'])) {$_smarty_tpl->tpl_vars['descriptionColName'] = clone $_smarty_tpl->tpl_vars['descriptionColName'];
$_smarty_tpl->tpl_vars['descriptionColName']->value = 'content'; $_smarty_tpl->tpl_vars['descriptionColName']->nocache = null; $_smarty_tpl->tpl_vars['descriptionColName']->scope = 0;
} else $_smarty_tpl->tpl_vars['descriptionColName'] = new Smarty_variable('content', null, 0);?>	
<?php } elseif ($_smarty_tpl->tpl_vars['params']->value['images']!='') {?>
	<?php if (isset($_smarty_tpl->tpl_vars['images'])) {$_smarty_tpl->tpl_vars['images'] = clone $_smarty_tpl->tpl_vars['images'];
$_smarty_tpl->tpl_vars['images']->value = $_smarty_tpl->tpl_vars['params']->value['images']; $_smarty_tpl->tpl_vars['images']->nocache = null; $_smarty_tpl->tpl_vars['images']->scope = 0;
} else $_smarty_tpl->tpl_vars['images'] = new Smarty_variable($_smarty_tpl->tpl_vars['params']->value['images'], null, 0);?>
	<?php if (isset($_smarty_tpl->tpl_vars['descriptionColName'])) {$_smarty_tpl->tpl_vars['descriptionColName'] = clone $_smarty_tpl->tpl_vars['descriptionColName'];
$_smarty_tpl->tpl_vars['descriptionColName']->value = 'description'; $_smarty_tpl->tpl_vars['descriptionColName']->nocache = null; $_smarty_tpl->tpl_vars['descriptionColName']->scope = 0;
} else $_smarty_tpl->tpl_vars['descriptionColName'] = new Smarty_variable('description', null, 0);?>
<?php }?>


<div id="sliderBootstrap" class="carousel slide">
	<ol class="carousel-indicators">
	     <li data-target="#sliderBootstrap" data-slide-to="0" class="active"></li>
         <?php $_smarty_tpl->tpl_vars['foo'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['foo']->step = 1;$_smarty_tpl->tpl_vars['foo']->total = (int) ceil(($_smarty_tpl->tpl_vars['foo']->step > 0 ? count($_smarty_tpl->tpl_vars['images']->value)-1+1 - (1) : 1-(count($_smarty_tpl->tpl_vars['images']->value)-1)+1)/abs($_smarty_tpl->tpl_vars['foo']->step));
if ($_smarty_tpl->tpl_vars['foo']->total > 0) {
for ($_smarty_tpl->tpl_vars['foo']->value = 1, $_smarty_tpl->tpl_vars['foo']->iteration = 1;$_smarty_tpl->tpl_vars['foo']->iteration <= $_smarty_tpl->tpl_vars['foo']->total;$_smarty_tpl->tpl_vars['foo']->value += $_smarty_tpl->tpl_vars['foo']->step, $_smarty_tpl->tpl_vars['foo']->iteration++) {
$_smarty_tpl->tpl_vars['foo']->first = $_smarty_tpl->tpl_vars['foo']->iteration == 1;$_smarty_tpl->tpl_vars['foo']->last = $_smarty_tpl->tpl_vars['foo']->iteration == $_smarty_tpl->tpl_vars['foo']->total;?>
        	<li data-target="#sliderBootstrap" data-slide-to="<?php echo $_smarty_tpl->tpl_vars['foo']->value;?>
"></li>
         <?php }} ?>
	</ol>

	<div class="carousel-inner">
	<?php  $_smarty_tpl->tpl_vars['img'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['img']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['images']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['img']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['img']->key => $_smarty_tpl->tpl_vars['img']->value) {
$_smarty_tpl->tpl_vars['img']->_loop = true;
 $_smarty_tpl->tpl_vars['img']->index++;
 $_smarty_tpl->tpl_vars['img']->first = $_smarty_tpl->tpl_vars['img']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['first'] = $_smarty_tpl->tpl_vars['img']->first;
?>
		<div class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['first']) {?>active <?php }?>item">
			<?php if ($_smarty_tpl->tpl_vars['params']->value['pagesBucket']!=''||$_smarty_tpl->tpl_vars['params']->value['tagsBucket']!='') {?>
				<a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
<?php echo $_smarty_tpl->tpl_vars['img']->value->urlKey;?>
">
					<img src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo pagesDB::getMainImageEkey($_smarty_tpl->tpl_vars['img']->value->id);?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['width'];?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['height'];?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['fit'];?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['filter'];?>
/" title='<?php echo smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['img']->value->name),$_smarty_tpl->tpl_vars['params']->value['contentLenght']);?>
'>
				</a>
				<?php if ($_smarty_tpl->tpl_vars['img']->value->{$_smarty_tpl->tpl_vars['descriptionColName']->value}!=null&&$_smarty_tpl->tpl_vars['params']->value['showContent']==true) {?>
				<div class="container">
					<div class="carousel-caption">
						<h4><?php echo $_smarty_tpl->tpl_vars['img']->value->name;?>
</h4>
						<p><?php echo smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['img']->value->{$_smarty_tpl->tpl_vars['descriptionColName']->value}),$_smarty_tpl->tpl_vars['params']->value['contentLenght']);?>
</p>
					</div>	
				</div>
				<?php }?>					
			<?php } else { ?>
				<img src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
image/<?php echo $_smarty_tpl->tpl_vars['img']->value->ekey;?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['width'];?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['height'];?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['fit'];?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['filter'];?>
/" title='<?php echo smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['img']->value->description),$_smarty_tpl->tpl_vars['params']->value['contentLenght']);?>
'>
				<?php if ($_smarty_tpl->tpl_vars['img']->value->{$_smarty_tpl->tpl_vars['descriptionColName']->value}!=null&&$_smarty_tpl->tpl_vars['params']->value['showContent']==true) {?>
				<div class="container">
					<div class="carousel-caption">
						<h4><?php echo $_smarty_tpl->tpl_vars['img']->value->name;?>
</h4>
						<p><?php echo smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['img']->value->{$_smarty_tpl->tpl_vars['descriptionColName']->value}),$_smarty_tpl->tpl_vars['params']->value['contentLenght']);?>
</p>
					</div>	
				</div>	
				<?php }?>				
			<?php }?>
							
		</div>	
	<?php } ?>
	</div>	

	<a class="carousel-control left" href="#sliderBootstrap" data-slide="prev">‹</a>
	<a class="carousel-control right" href="#sliderBootstrap" data-slide="next">›</a>	
</div> <?php }} ?>
