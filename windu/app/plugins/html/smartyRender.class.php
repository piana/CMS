<?php
class smartyRender
{
	public static function smartyGo($tplDir) {
		require_once( __SITE_PATH . '/app/plugins/html/smarty/SmartyBC.class.php'); 
		
		$smarty = new SmartyBC();
		$smarty->compile_dir  = CACHE_PATH.'templates_c/';
		$smarty->cache_dir    = CACHE_PATH.'cache/';
		$smarty->plugins_dir  = array(__SITE_PATH . '/app/plugins/html/smarty/plugins/',
											__SITE_PATH . '/app/plugins/html/smartyPlugins/',
											__SITE_PATH . '/data/functions/');
		$smarty->template_dir = array($tplDir);
		
		$smarty->assign('HOME',HOME);
		return $smarty;
	}
	public static function render($tplDir,$tplName,$data) {
		$smarty = smartyRender::smartyGo($tplDir);

		$tplName = rtrim($tplName,'.tpl');
		$smarty->assign('data',$data);
			
		return $smarty->fetch($tplName.'.tpl');
	}
}
?>
