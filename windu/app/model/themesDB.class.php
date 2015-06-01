<?php /*windu.org model*/
class themesDB
{
	public static $baseTpl = array(
	'tpl_main/error404.tpl',
	'tpl_main/main.tpl',
	'tpl_views/simple_page.tpl',
	'tpl_views/main_page.tpl',
	'js/main.js',
	'css/main.css');
	
	public static $baseFolders = array(
	'css',
	'img',
	'js',
	'tpl_common',
	'tpl_main',
	'tpl_views');

	public static $baseViewsFolders = array(
	'tpl_views');
	
	public static $basicTpl = 'simple_page.tpl';
	
	function __construct($templateName = null)
	{
		$this->tplName = $templateName;
		if($this->tplName == null)
		{
			$configDB = new configDB();
			$themeConfig = $configDB->getByName('template');
			$this->tplName = $themeConfig->name;
		}	
		$this->templatePath = TEMPLATES_PATH.$this->tplName.'/';
	}	
	
	//Creating template with default files and catalogs
	public static function create($templateName){
		if (DB_READ_ONLY_MODE==1) return true;	
		
		$templateName = generate::cleanFileName($templateName);
		$destination = TEMPLATES_PATH.$templateName.'/';
		
		$counter = 2;
		while (is_dir($destination)) {

			$destination = TEMPLATES_PATH.$templateName."-{$counter}/";
			$counter = $counter+1;
		}		
		
		if(!is_dir($destination)){
			baseFile::createDir($destination);
			foreach (self::$baseFolders as $folder){
				baseFile::createDir($destination.$folder);
			}
			foreach (self::$baseTpl as $tpl){
				baseFile::saveFile($destination.$tpl, '');
			}			
			return true;
		}
		return false;
	}
	//Add tpl file
	public function add($fileName) {
		if (DB_READ_ONLY_MODE==1) return true;	
		$fileName = generate::cleanFileName($fileName);
		return baseFile::saveFile($this->templatePath.$fileName.'.tpl', '');
	}
	
	public function delete($fileName) {
		if (DB_READ_ONLY_MODE==1) return true;	
		return baseFile::delete($this->templatePath.$fileName);
	}
	public function deleteTemplate() {
		if (DB_READ_ONLY_MODE==1) return true;	
		return baseFile::delete($this->templatePath);
	}
	public function save($fileName, $data) {
		if (DB_READ_ONLY_MODE==1) return true;	
		return baseFile::saveFile($this->templatePath.$fileName, $data);
	}
	public function read($fileName) {
		return baseFile::readFile($this->templatePath.$fileName);
	}	
	public function rename($newname) {
		if (DB_READ_ONLY_MODE==1) return true;	
		$newname = generate::cleanFileName($newname);
		$namePom = str_replace(TEMPLATES_PATH, '', $this->templatePath);
		if(is_dir(TEMPLATES_PATH.$newname.'/')){return false;}
		if(config::get('template') == $this->tplName){
			config::set('template', $newname);
		}
		return baseFile::rename($this->templatePath, TEMPLATES_PATH.$newname.'/');
	}	
	public static function getViewsArray($themeName = null){
		if($themeName == null)
		{
			$configDB = new configDB();
			$themeConfig = $configDB->getByName('template');
			$themeName = $themeConfig->value;
		}
				
		$views = baseFile::getFilesList(TEMPLATES_PATH.$themeName.'/','tpl',true);
		$viewsArray[self::$basicTpl]=rtrim(self::$basicTpl,'.tpl');
		foreach(self::$baseViewsFolders as $folder){
			if (is_array($views[$folder]->subdir)) {
				foreach($views[$folder]->subdir as $view){
					$viewsArray[$view->name]=rtrim($view->name,'.tpl');
				}	
			}
		}
		return $viewsArray;
	}
	//Return array of resources inside type folder
	public static function getAllResources($type){
		$template = themesDB::getThemeName();
		$folder = TEMPLATES_PATH.$template.'/'.$type.'/';
		$typePom = explode('_',$type);
		$files = baseFile::getFilesList($folder,$typePom[0]);	
		$finalArr = array();
		foreach ($files as $file){
			if (preg_match('/main.css/', $file->path) or preg_match('/main.js/', $file->path) or preg_match('/less.css/', $file->path)) {
				$main[] = $file->path;
			}else{
				$finalArr[] = $file->path;
			}
		}
		
		if (is_array($main) and is_array($finalArr)) {
			$finalArr = array_merge($finalArr,$main);
		}elseif (is_array($main)){
			$finalArr = $main;
		}

		return $finalArr;
	}
	public static function getThemeName() {
		$theme = config::get('template');
		
		return $theme;
	}
	public static function themeExists($name) {
		if (is_dir(TEMPLATES_PATH.$name.'/')) {
			return true;
		}
		return false;
	}	
	public static function getThemeImagesList($templateImagesPath) {
		$files = baseFile::getFilesList($templateImagesPath,array('jpg','png','jpeg','gif'));
		return $files;
	}
	public static function getThemesFromAddonsServer($tag=null) {
		if (cache::isCached('addonsServerThemes',3600*3)) {
			$themesFromAddonsServer = cache::read('addonsServerThemes');
		}else{
			$themesFromAddonsServer = unserialize(baseFile::getExternalFileContent(ADDONS_SERVER_DATA.'getThemes/'));
			cache::write('addonsServerThemes', $themesFromAddonsServer);
		}
        $finalTheme = null;

        if(count($themesFromAddonsServer)>1){
            foreach ($themesFromAddonsServer as $theme){
                if ($tag==null or strstr($theme['tags'], $tag)) {
                    $finalTheme[] = $theme;
                }
            }
        }
		return $finalTheme;
	}
}
?>
