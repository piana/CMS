<?php /*windu.org core*/
	class config
	{
		private $plugins;
		private static $config;
		public function __construct(array $plugins = null){
			if(is_array($plugins)){
				$this->plugins = $plugins;
			}else{
				$this->plugins = pluginManager::getList();
			}
		}

		//prepare ini files from widgets
		public function prepareIni(array $filesList) {
			$configArray = array();

			foreach ($filesList as $file) {
			 	if (file_exists($file)){
			 		$newConfigArray = parse_ini_file($file,true);
			 		$configArray = array_merge($configArray,$newConfigArray);
			 	}
			}				
			return $configArray;
		}
        public static function cleanCache(){
            cache::fileClearByBucket('config');
            self::$config = null;
        }

		//return config value
		public static function get($name,$force = false) {
			if ($force!=false) {
				$configDB = new configDB();
				return $configDB->fetchRow("name='{$name}'")->value;
			}elseif (is_array(self::$config)) {
				return self::$config[$name];
			}else{
				$configDB = new configDB();
				$configArray = $configDB->getConfigSimpleArray();
				self::$config = $configArray;
				if (isset($configArray[$name])) {
					return $configArray[$name];
				}else{
					$configDB = new configDB();
					return $configDB->fetchRow("name='{$name}'")->value;
				}
				
			}
		}
		//return config value
		public static function getByPrefix($prefix,$exclude=null) {
			$configDB = new configDB();
			if ($exclude!=null) {
				$configArray = $configDB->fetchAll("name LIKE '{$prefix}%' AND name NOT LIKE '{$exclude}%'");
			}else{
				$configArray = $configDB->fetchAll("name LIKE '{$prefix}%'");
			}
			return $configArray;
		}			
		public static function set($name,$value,$bucket=null,$type=null) {
			$configDB = new configDB();
			if (is_array($value)) {
				$value = serialize($value);
			}
			
			$data['value'] = $value;
			if ($bucket!=null) {$data['bucket'] = $bucket;}
			if ($type!=null) {$data['type'] = $type;}
			
			
			if($configDB->fetchRow("name = '{$name}'")!=null){
				$configDB->updateRow($data,"name = '{$name}'");
			}else{
				$data['name'] = $name;
				$configDB->insert($data);
			}
		}	
		
		//systemRun
		public static function setSystemRun($name,$value){
			config::set('SystemRun-'.$name,$value);
		}
		public static function getSystemRun($name){
			if (config::get('SystemRun-'.$name)==1 or config::get('SystemRun-'.$name)=='') {
				return true;
			}else{
				return false;
			}
		}
	}
?>