<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 11:18:12
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\check.tpl" */ ?>
<?php /*%%SmartyHeaderCode:31340555da2d429b701-84629161%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bde090baf7265a5538120cc2a7662ee1ec4c0bc3' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\check.tpl',
      1 => 1400626416,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31340555da2d429b701-84629161',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 0,
    'methodsToCheckSerialized' => 0,
    'backUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555da2d4301020_75552083',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555da2d4301020_75552083')) {function content_555da2d4301020_75552083($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?>	<div class="loginbox">
		<img src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/admin/resources/img/logo-login<?php echo license::get();?>
.png">
		<div class="loginbox-white">
			<script>
				
			 	$(document).ready(function() {
			 		$.ajaxSetup ({
			 		    cache: false
			 		});
	
			 		var toCheckArray = new Array(<?php echo $_smarty_tpl->tpl_vars['methodsToCheckSerialized']->value;?>
);	
			 		window.barWidth = 10;
			 		window.counter = toCheckArray.length;
			 		
				 	$.each(toCheckArray , function( index, checkType ) {
				 		$('#ajax-response').load('<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/login/ajaxCheck/'+checkType+'/', function(response) {
			 				window.barWidth = window.barWidth+(90/toCheckArray.length);
			 				$(".bar").css('width',window.barWidth+'%');
							
				 			if(window.counter<=1){
				 				$(".bar").css('width','100%');
				 				$(".progress").addClass('progress-success');
				 				$(".progress").removeClass('active');				 				
				 				window.location.replace('<?php echo $_smarty_tpl->tpl_vars['backUrl']->value;?>
');
						 	}	
				 			window.counter = window.counter-1;
				 		});
					});
			    });
			 	
			</script>
			<div class="pad">
				<h3><?php echo smarty_function_L(array('key'=>"admin.check.system"),$_smarty_tpl);?>
</h3>
				<div id="ajax-response"></div>
				<div class="progress progress-striped active">
				  <div class="bar" style="width: 10%;"></div>
				</div>
			</div>	
		</div>
		<p class="text-shadow">Windu 3.1 rev. <?php echo config::get('revision');?>
</p>
	</div>
<?php }} ?>
