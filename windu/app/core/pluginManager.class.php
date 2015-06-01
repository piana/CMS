<?php /*windu.org core*/
class pluginManager
{
	//return plugin array list
	public static function getList($plugins = null){
		if($plugins!=null){
			return $plugins;
		}
		return explode(',',PLUGINS);
	}
	//return all ini files from plugins
	private static function getIniList($fileName,array $plugins = null) {
		$plugins = self::getList($plugins);
		foreach ($plugins as $plugin) {
		 	$file = __SITE_PATH.'/'.PLUGIN_PATH.'/'.$plugin;
		 	$fileName = rtrim($fileName,'.ini');
		 	$path = $file.'/config/'.$fileName.'.ini';

		 	if (file_exists($path)){
		 		$configFilesPath[] = $path;
		 	}
		}	
		return $configFilesPath;
	}
	//return config
	public static function getConfig($fileName,array $plugins = null){
		$key = null;
		if ($plugins!=null) {
			$key = md5(serialize($plugins));
		}
		$file = CACHE_PATH."system/{$fileName}{$key}inilist.tmp";
		if (file_exists($file)){
			$configFinal = unserialize(file_get_contents($file));
		}else{
			$config = new config($plugins);
			$configFinal = $config->prepareIni(self::getIniList($fileName,$plugins));
			file_put_contents($file, serialize($configFinal));	
		}		
		
		return $configFinal;
	}
	//load config.php files from plugins
	public static function loadMainConfigs() {
		foreach (self::getList() as $plugin) {
			$file = __SITE_PATH.'/'.PLUGIN_PATH.'/'.$plugin;
			$path = $file.'/config/config.php';
		 	if (is_file($path)){
		 		include $path;
		 	}			
		}
	}
	public static function loadAdminMenuItems() {
		$cacheFile = CACHE_PATH.'system/adminmenupluginsitems.tmp';
		$menuItems = null;
		if (file_exists($cacheFile)){
			$menuItems = unserialize(file_get_contents($cacheFile));
		}else{
			$menuIniList = self::getIniList('menu');
			if (is_array($menuIniList)) {
				foreach($menuIniList as $menuItemIniPath){
					$menuItems[] = parse_ini_file($menuItemIniPath);
				}
			}

			file_put_contents($cacheFile, serialize($menuItems));	
		}		
		return $menuItems;
	}
}
?>
