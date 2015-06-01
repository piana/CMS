<?php /*windu.org core*/
class cache
{
	//Filecache
	public static function fileRead($bucket,$key) {
		$key = md5($key);
		return unserialize(file_get_contents(CACHE_PATH."system/{$bucket}-{$key}.tmp"));
	}
	public static function fileWrite($bucket,$key,$data,$extension = 'tmp') {
		$key = md5($key);
		return file_put_contents(CACHE_PATH."system/{$bucket}-{$key}.{$extension}",serialize($data));
	}	
	public static function fileIsCached($bucket,$key) {
		$key = md5($key);
		return file_exists(CACHE_PATH."system/{$bucket}-{$key}.tmp");
	}	
	public static function fileClearByBucket($bucket){
		$files = array_merge(glob( CACHE_PATH."rasources/{$bucket}-*" ),glob( CACHE_PATH."system/{$bucket}-*"));
		if (is_array($files)) {
			array_map( "unlink", $files);
		}
	}
	
	//Sqlite Cache
	private static $data = array();
	
	public static function read($name){
		if (isset(self::$data[$name])) {
			return self::$data[$name];
		}
		$cacheDB = new cacheDB();
		$data = $cacheDB->fetchRow("name = '".md5($name)."'");
		
		if ($data->serialized == 1) {
			$data->data = unserialize($data->data);
		}
		self::$data[$name] = $data->data;
		return $data->data;
	}
	public static function write($name,$data,$bucket = 0){
		$cacheDB = new cacheDB();
		$serialized = 0;
		if (is_array($data)) {
			$data = serialize($data);
			$serialized = 1;
		}
		return $cacheDB->write(md5($name),$data,$bucket,$serialized);
	}
	public static function isCached($name,$expire = null) {
		$cacheDB = new cacheDB();
		$name = md5($name);
		if ($expire!=null) {
			$date = generate::sqlDatetime(time()-$expire);

			$dataWhere = " and updateTime > '{$date}'";
		}else $dataWhere = null;
		 
		if(is_object($cacheDB->fetchRow("name = '{$name}' {$dataWhere}"))){
			return true;
		}else{
			return false;
		}
	}
	public static function clearBucket($bucket) {
		$cacheDB = new cacheDB();
		$cacheDB->deleteRows("bucket='{$bucket}'");
	}
	public static function clearByName($name) {
		$cacheDB = new cacheDB();
		$name = md5($name);
		$cacheDB->deleteRows("name='{$name}'");
	}	
	public static function clearAll(){
		$cacheDB = new cacheDB();
		$cacheDB->truncate();

		$sessionDB = new sessionDB();
		$sessionDB->clean();
	}
	
	public static function flushAllCache() {
		//clear database
		self::clearAll();
						
		//clear files dir
		baseFile::truncateDir(CACHE_PATH.'cache/');
		baseFile::truncateDir(CACHE_PATH.'templates_c/');
		baseFile::truncateDir(CACHE_PATH.'resources/');
		baseFile::truncateDir(CACHE_PATH.'system/');

        //clear external caches
        self::resetExternalCaches();

		cache::unsetCleanCacheFlag();
		config::set('resourcesVersion', intval(config::get('resourcesVersion'))+1);
		return true;
	}

	public static function flushSystemCache() {
		baseFile::truncateDir(CACHE_PATH.'system/');
		return true;
	}
    public static function flushSmartyStaticCache() {
        baseFile::truncateDir(CACHE_PATH.'cache/');
        return true;
    }

	//Clean cache flag methods
	public static function setCleanCacheFlag() {
		config::set('cleanCacheFlag', 1);
	}
	public static function unsetCleanCacheFlag() {
		config::set('cleanCacheFlag', 0);
	}

    //Reset system cache (APC, oPcache, etc...)
    public static function resetExternalCaches(){
        if(function_exists('opcache_reset')){opcache_reset();}
        if(function_exists('apc_clear_cache')){apc_clear_cache();}
    }
}
?>
