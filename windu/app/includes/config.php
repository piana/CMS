<?php
	define('DB_READ_ONLY_MODE', 0);
	define('DB_READ_ONLY_EXCLUDED_TABLES', 'cache,log,notify,session,systemstatus,accesslog,fileslog');

	define('DATA_PATH', __SITE_PATH.'/data/');
	
	define('CACHE_PATH', __SITE_PATH.'/cache/');
	define('CACHE_PATH_HOME', HOME.'cache/');	
	
	define('ADDONS_SERVER', 'http://www.windu.org/');
	define('ADDONS_SERVER_DATA', 'http://www.windu.org/addonsServer/');
	
	//SQLite Database
	define('FILE_DB_PATH', DATA_PATH.'database'.'/');
	define('FILE_DB_FILE', 'database.sqlite');
	define('FILE_DB_LOG_FILE', 'log.sqlite');
	
	//Php Ini config
	if (ini_get('post_max_size') > ini_get('upload_max_filesize')) {
		define('MAX_UPLOAD_FILE_SIZE',intval(str_replace('M', '', ini_get('upload_max_filesize')))*1000000);
	}else{
		define('MAX_UPLOAD_FILE_SIZE',intval(str_replace('M', '', ini_get('post_max_size')))*1000000);
	}

	//Paths
	define('WIDGET_PATH', DATA_PATH.'widgets/');	
	define('WIDGET_OFF_PATH', DATA_PATH.'widgetsOff/');	
	define('TEMPLATES_PATH',DATA_PATH.'themes/');
	define('LANGUAGES_PATH', DATA_PATH.'languages/');	
	define('BACKUPS_PATH', DATA_PATH.'backups/');	
	define('DUMPS_PATH', DATA_PATH.'dumps/');	
	
	define('PLUGIN_PATH', 'app/plugins');	
	
	define('FILES_DIR', 'data/files/');

	//Plugins
	define('PLUGINS', 'admin,database,update,rss,front,html,image,mail,widget,file');

	//Others
	define('CACHE_ADMIN_RESOURCES', FALSE);	
?>