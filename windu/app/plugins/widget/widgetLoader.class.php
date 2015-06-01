<?php /*windu.org widget*/
Class widgetLoader
{	
	private static function smartyGo($widgetName)
	{
		require_once( __SITE_PATH . '/app/plugins/html/smarty/SmartyBC.class.php'); 
		
		$smarty = new SmartyBC();
		$smarty->template_dir = WIDGET_PATH . $widgetName .'/';
		$smarty->compile_dir  = CACHE_PATH.'templates_c/';
		$smarty->cache_dir    = CACHE_PATH.'cache/';
		$smarty->plugins_dir  = array(__SITE_PATH . '/app/plugins/html/smarty/plugins/',
											__SITE_PATH . '/app/plugins/html/smartyPlugins/',
											__SITE_PATH . '/data/functions/');

		$smarty->assign('HOME',HOME);
		return $smarty;
	}			
	public static function loadWidgetByName($params,$request) {
		if (is_dir(WIDGET_PATH.$params['name'].'/')) {
			$widgetName = $params['name'];
			
			$data = self::loadWidgetDataByName($params,$request);
			$smarty = self::smartyGo($widgetName);
			$smarty->assign('data',$data);
			$smarty->assign('params',$params);
			$smarty->assign('request',$request);
			
			$output = $smarty->fetch($widgetName.'View.tpl');
	
			if (is_dir(WIDGET_PATH.$widgetName.'/js/')) {
				$fileList = baseFile::getFilesList(WIDGET_PATH.$widgetName.'/js/','js');
				if(is_array($fileList)){
					foreach ($fileList as $file){

						if (filesize($file->path)>3) {
							if (__SITE_PATH=='/') {
								$jsPath = rtrim(HOME,'/').$file->path;
							}else{
								$jsPath = rtrim(HOME,'/').str_replace(__SITE_PATH, '', $file->path);
							}

							$output .= "<script type='text/javascript' src='".$jsPath."'></script>";
						}
					}
				}
			}



			return $output;
		}
		
		$user = usersDB::getLoggedUser('AdminUser');
		if ($user!=null) {
			if (is_dir(WIDGET_OFF_PATH.$params['name'].'/')) return 'Widget is disabled';
			return 'Widget NOT exists';
		}
		return null;

	}
	public static function loadWidgetDataByName($params,$request) {
		$widgetName = $params['name'];

		require_once WIDGET_PATH.$widgetName.'/'.$widgetName.'Controller.class.php';
		$controllerClassName = $widgetName.'Controller';
		
		$controller = new $controllerClassName($params,$request);
		$data = $controller->run();
		
		return $data;
	}	
}
?>