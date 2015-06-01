<?php
 require_once './app/core/pluginManager.class.php';
 require_once './app/core/debugger.class.php';
 
 function prepareAutoloadFilesList() {
 	$cacheFile = CACHE_PATH.'system/classlist.tmp';
 	if (file_exists($cacheFile)) {
 		$filesList = unserialize(file_get_contents($cacheFile));
 	}else{
		$catalogs[] = '/app/core/';
		$catalogs[] = '/app/model/';
		$catalogs[] = '/app/controller/';
		
		$plugins = pluginManager::getList();
		
		foreach ($plugins as $plugin) {
		 	$file = PLUGIN_PATH.'/'.$plugin;
		 	if (is_dir(__SITE_PATH.'/'.$file.'/'))$catalogs[] =  '/'.$file.'/';
		 	if (is_dir(__SITE_PATH.'/'.$file.'/controller'))$catalogs[] = '/'.$file.'/controller/';
		 	if (is_dir(__SITE_PATH.'/'.$file.'/controller/do'))$catalogs[] = '/'.$file.'/controller/do/';
		 	if (is_dir(__SITE_PATH.'/'.$file.'/controller/ajax'))$catalogs[] = '/'.$file.'/controller/ajax/';
		 	if (is_dir(__SITE_PATH.'/'.$file.'/model'))$catalogs[] =  '/'.$file.'/model/';
		 	if (is_dir(__SITE_PATH.'/'.$file.'/addons'))$catalogs[] =  '/'.$file.'/addons/';
		}
		
		$filesList = array();
		foreach ($catalogs as $catalog){
			$catalogFiles = scandir(__SITE_PATH.$catalog);
			foreach ($catalogFiles as $catalogFile){
				$filesCatalogList[$catalogFile] = $catalog.$catalogFile;
			}
			$filesList = array_merge($filesCatalogList,$filesList);
		}
		if(!is_dir(CACHE_PATH.'')) mkdir(CACHE_PATH.'', 0755);		
		$systemCacheDir = CACHE_PATH.'system/';
		if(!is_dir($systemCacheDir)) mkdir($systemCacheDir, 0755);
		
		file_put_contents($cacheFile, serialize($filesList));
 	}
	return $filesList;
 }
 $filesAutoload = prepareAutoloadFilesList();

 /*** auto load model classes ***/
 spl_autoload_register('autoload');
 function autoload($class_name)
 {
    $filename = $class_name . '.class.php';
	global $filesAutoload;
	if ($filesAutoload[$filename]!='')	require_once (__SITE_PATH.$filesAutoload[$filename]);
}


 
 define('LANG_BY_DOMAIN', NULL);

 //set default timezone
 date_default_timezone_set(config::get('timezone'));
 
 pluginManager::loadMainConfigs(); //load config.php files from plugins
 if (usersDB::getLoggedUser('AdminUser')==null) {
 	define('ISADMINLOGGED', 0); 
 }else{
 	define('ISADMINLOGGED', 1); 
 }   

 //Call controller
 $request = new requestHttp($_SERVER, $_GET, $_POST);
 firewall::accessLog();
 accesslogFileDB::writeRequestToLog();
 
 $renderedResponse = router::instance()->callController($request);
 
?>