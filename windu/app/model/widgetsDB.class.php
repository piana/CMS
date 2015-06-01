<?php /*windu.org model*/
class widgetsDB
{
	public static $baseWidgetFolders = array(
	'css',
	'js',
	'img',
	'doc',
	'lang');
	
	public static $baseWidgetFiles = array(
	'View.tpl',
	'Controller.class.php'
	);	
	
	public static $commonWidgetFiles = array(
	'css/main.css',
	'js/main.js',
	'doc/helper.ini',
	'doc/readme.txt',
	'doc/smallhelp.txt',
	'lang/pl.txt',
	'lang/en.txt');	
		
	function __construct($widgetName)
	{
		$this->widgetPath = WIDGET_PATH.$widgetName.'/';
	}	
	
	//Creating widget with default files
	public static function create($widgetName){
		if (DB_READ_ONLY_MODE==1) return true;	
		$widgetName = generate::cleanClassName($widgetName);
		if(!is_dir(WIDGET_PATH.$widgetName)){
			baseFile::createDir(WIDGET_PATH.$widgetName);
			
			//create subdirs
			foreach (self::$baseWidgetFolders as $dir){
				baseFile::createDir(WIDGET_PATH.$widgetName.'/'.$dir.'/');
			}			

			//create default files
			foreach (self::$commonWidgetFiles as $file){
				baseFile::saveFile(WIDGET_PATH.$widgetName.'/'.$file, '');
			}				
			
			//create default files
			foreach (self::getFilesArray($widgetName) as $file => $data){
				baseFile::saveFile(WIDGET_PATH.$widgetName.'/'.$widgetName.$file, $data);
			}	

			
			return true;
		}
		return false;
	}
	public function deleteWidget(){
		if (DB_READ_ONLY_MODE==1) return true;	
		return baseFile::delete($this->widgetPath);
	}
	public function save($fileName, $data) {
		if (DB_READ_ONLY_MODE==1) return true;	
		return baseFile::saveFile($this->widgetPath.$fileName, $data);
	}
	public function read($fileName) {
		return baseFile::readFile($this->widgetPath.$fileName);
	}
	public static function getWidgetArray(){
		$widgets = baseFile::getFilesList(WIDGET_PATH,'dir');
		foreach($widgets as $key=>$widget){
			$widgetsArray[$widget->name] = $widget->name;
		}
		return $widgetsArray;
	}
	public static function getLanguage($lang) {
		$widgets = baseFile::getFilesList(WIDGET_PATH,'dir');

		$langArray = array();
		foreach ($widgets as $widget){
			if (file_exists($widget->path.'/lang/'.$lang.'.txt')) {
				$langArray = array_merge(lang::prepareLanguageArray($widget->path.'/lang/'.$lang.'.txt'),$langArray);
			}elseif(file_exists($widget->path.'/lang/en.txt')){
				$langArray = array_merge(lang::prepareLanguageArray($widget->path.'/lang/en.txt'),$langArray);
			}
		}

		return $langArray;
	}	
	
	public static function getFilesArray($className) {
		foreach (self::$baseWidgetFiles as $file){
			$pom = explode('.', $file);
			$methodName = 'example'.$pom[0];
			$array[$file] = self::$methodName($className);
		}	
		return $array;	
	}
	/////////////////////////////////////////////////
	//Example generators/////////////////////////////
	/////////////////////////////////////////////////
	private static function exampleView($className){
		$data = '<h3>Example of '.$className.' widget</h3>
<div>{{$data.content}}</div>';
		return $data;
	}	
	private static function exampleController($className){
		$data ='<?php /*windu.org model*/
Class '.$className.'Controller extends widgetMainController
{		
	public function run() {
		$data = "Example Content";	
		return array("content" => $data);
	}
}
?>';
		return $data;
	}	
	private static function exampleMain($className){
		$data = "$(document).ready(function(){
	alert('this is example of ".$className."');
});";
		return $data;
	}	
	private static function exampleStyle($className){
		$data = '.className{
	color:#000;
}';
		return $data;
	}	
	public static function getAllResources($type){

		$fileCache = CACHE_PATH.'system/widgets-enabled-'.themesDB::getThemeName().'-'.md5(__HOME_NOGET).'.tmp';
		

		$userLoggedAddon = '';
		if (usersDB::getLoggedUser('AdminUser')!=null) {
			$userLoggedAddon='AdminUser';
		}
		$cacheWidgetsFile = CACHE_PATH.'system/widgetlist-enabled-final-'.$userLoggedAddon.md5(__HOME_NOGET).'.tmp';

		if (file_exists($fileCache) and file_exists($cacheWidgetsFile)){
	 		$finalArr = unserialize(file_get_contents($fileCache));
		}else{
			$folder = __SITE_PATH.'/data/widgets/';
			$files = baseFile::getFilesList($folder,'dir');	

			foreach ($files as $file){
				if (file_exists($cacheWidgetsFile)) {
					$widgetsArray = file($cacheWidgetsFile);
					if (is_array($widgetsArray)) {
						$widgetsArray = array_map("trim", $widgetsArray);
					}
				}
				$getResourceFlag = false;
				if (is_dir($folder.$file->name."/{$type}/")) {
					$getResourceFlag = true;
				}

				if (is_array($widgetsArray)) {
					if (!in_array($file->name, $widgetsArray)) {
						$getResourceFlag = false;
					}
				}
				
				if ($getResourceFlag==true) {
					$fileList = baseFile::getFilesList($folder.$file->name."/{$type}/",$type);
					if(is_array($fileList)){
						foreach ($fileList as $filef){
							if (filesize($filef->path)>3) {
								$finalArr[] = $filef->path;
							}						
						}		
					}		
				}			
			}

			if (file_exists($cacheWidgetsFile) and is_array($finalArr)) {
				file_put_contents($fileCache, serialize($finalArr));
			}
						
		}
		
		return $finalArr;		
	}	
	public static function widgetExists($name) {
		if (is_dir(WIDGET_PATH.$name.'/') or is_dir(WIDGET_OFF_PATH.$name.'/')) {
			return true;
		}
		return false;
	}
	public static function getUpdateList() {
		//widgets list from server
		if (cache::isCached('addonsServerWidgets',3600*24)) {
			$widgetsFromAddonsServer = cache::read('addonsServerWidgets');
		}else{
			$serverArray = unserialize(baseFile::getExternalFileContent(ADDONS_SERVER_DATA.'getWidgets/'.config::get('language-admin').'/'));
			if (is_array($serverArray)) {
				$widgetsFromAddonsServer = array_reverse($serverArray);
			}
			cache::write('addonsServerWidgets', $widgetsFromAddonsServer);
		}	

		if (is_array($widgetsFromAddonsServer)) {
			$allInstalledWidgets = baseFile::getFilesList(WIDGET_PATH,null,true);
			$widgetsToUpdate = array();
			foreach ($allInstalledWidgets as $key=>$widget){
				$updateFilePath = $widget->path.'/doc/lastupdate.ini';
				if (!file_exists($updateFilePath)){
					baseFile::saveFile($updateFilePath, '2013-05-15 23:00:00');
				}
				$localVersionTime = strtotime(baseFile::readFile($updateFilePath));
				$serverVersionTime = strtotime($widgetsFromAddonsServer[$key]['updateTime']);
				
				if($localVersionTime<$serverVersionTime){
					$widgetsToUpdate[$key]['name']=$key;
					$widgetsToUpdate[$key]['fileEkey']=$widgetsFromAddonsServer[$key]['fileEkey'];
				}
			}
			return $widgetsToUpdate;
		}else{
			return null;
		}
		
		
	}
}
?>
