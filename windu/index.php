<?php /*windu.org by Adam Czajkowski*/
	ob_start();

    //Define developer mode with shows errors and debug
	define ('DEV_MODE', FALSE);

	if (DEV_MODE) {
        $executeTimeStart = microtime(true);
		error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
	}else{
		error_reporting(0);
	}

	ini_set('memory_limit', '128M');
	ini_set('max_execution_time', '120');
	ini_set('post_max_size', '32M');
	ini_set('upload_max_filesize', '32M');
	
	/*** define the site path ***/
	define ('__SITE_PATH', realpath(dirname(__FILE__)));
	define ('__HOME', "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	define ('__BASE', "http://".$_SERVER['HTTP_HOST']);
	define ('__HOST_NAME', $_SERVER['HTTP_HOST']);
	define ('__HOME_NOGET',__BASE.str_replace('index.php', '', $_SERVER['REDIRECT_URL']));
	define ('__REQUEST_ID', microtime());

	//Dir on serwer
	define('SUBDIR', rtrim($_SERVER['PHP_SELF'],'index.php'));
	define('HOME', __BASE.SUBDIR); 	

	if (!file_exists(__SITE_PATH.'/data/log/systemchecked.tmp')) {
		include __SITE_PATH.'/app/includes/check.php'; 
	}else{	
		try {
			if(file_exists(__SITE_PATH.'/app/includes/configDB.php')){
				require_once 'app/includes/configDB.php';
			}else{
				require_once 'app/includes/configDB.install.php';
			}
			
			require_once 'app/includes/config.php';
			require_once 'app/includes/init.php';
		}catch (Exception $e) {
			log::write($e->getMessage(),logDB::BUCKET_ERROR);
			die('<h3>Windu ERROR</h3>'.$e->getMessage());
		}
	}

    if (DEV_MODE) {
        $executeTimeStop = microtime(true) - $executeTimeStart;
        echo '<center><div style="font-size:50px; color:silver; padding-bottom:100px; padding-left:100px;">'.round($executeTimeStop, 5).' s</span></center>';
    }
?>