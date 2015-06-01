<?php /*windu.org core*/
class resourceManager
{
    public static function getCssWidgetsPath(){
        return CACHE_PATH.'resources/css-widgets-'.md5(__HOME_NOGET).'.css';
    }
	public static function loadResourceByPlugins(array $plugins = null,$bucket,$type,$forceCache = false){
		$pluginsResource = pluginManager::getConfig($type,$plugins);
		return self::loadResource($pluginsResource,$bucket,$type,$forceCache);
	}

	private static function cacheResources(array $resourcesArray,$bucket,$type) {
        $resourceString = '';
		if ($bucket=='admin') {
			$cacheFilePath = CACHE_PATH.'resources/'.$bucket.'-'.md5(HOME).'.'.$type;
			$cacheFilePathReturn = CACHE_PATH_HOME.'resources/'.$bucket.'-'.md5(HOME).'.'.$type;
		}else{
			$cacheFilePath = CACHE_PATH.'resources/'.$bucket.'.'.$type;
			$cacheFilePathReturn = CACHE_PATH_HOME.'resources/'.$bucket.'.'.$type;
		}


		if (file_exists($cacheFilePath)) {
			return array('cache.'.$bucket => $cacheFilePathReturn);
		}
		foreach ($resourcesArray as $resource){
			$path = str_replace(HOME, __SITE_PATH.'/', $resource);

			if ($type=='css'){
				$resourceString .= generate::compressCSS(baseFile::readFile($path));
			}elseif ($type=='js'){
				$resourceString .= generate::compressJS(baseFile::readFile($path))."\r\n";
			}else{
				$resourceString = baseFile::readFile($path);
			}			
			
			$resourcePathPom = str_replace(__SITE_PATH.'/', '', $resource);
			$resourcePathPomArray = explode('/', $resourcePathPom);
			unset($resourcePathPomArray[count($resourcePathPomArray)-1]);
			unset($resourcePathPomArray[count($resourcePathPomArray)-1]);
			$resourcePathReplace = null;
			foreach ($resourcePathPomArray as $part) {
				$resourcePathReplace.=$part.'/';
			}
			
			$resourcePathReplace = HOME.$resourcePathReplace;	
		
			if ($type=='css') {
				$resourceString = str_replace('../', $resourcePathReplace, $resourceString);
				$resourceString = str_replace('{$HOME}/', HOME, $resourceString);
			}
		}

		baseFile::saveFile($cacheFilePath, $resourceString);
		
		return array('cache.'.$bucket => $cacheFilePathReturn);
	}

	public static function loadResource($resources, $bucket, $type, $forceCache = false,$forceNoCache = false) {
		if (!is_array($resources) and !count($resources)>0) {return null;}
		
		foreach ($resources as $key => $resource){
			$resourcePath = str_replace('{$HOME}', __SITE_PATH.'/', $resource);
			if ( filesize($resourcePath)>3) {
				if (file_exists($resourcePath)){
					if (((preg_match('/nocache.*/', $key) or config::get('cacheResources')==0) and $forceCache!=true) or $forceNoCache==true) {
						$resourceListNoCache[$key] = str_replace(__SITE_PATH.'/', HOME, $resourcePath);
					}else{
						$resourceListCache[$key] =  $resourcePath;
					}	
				}
			}
		}

		if (is_array($resourceListNoCache)){ksort($resourceListNoCache,SORT_NUMERIC);}
		if (is_array($resourceListCache)){
			ksort($resourceListCache,SORT_NUMERIC);
			$resourceListCache = self::cacheResources($resourceListCache, $bucket, $type);
		}
		if (is_array($resourceListCache) and is_array($resourceListNoCache)) {
			$finalResourcesArray = array_merge($resourceListCache,$resourceListNoCache);
		}elseif (is_array($resourceListCache)){
			$finalResourcesArray = $resourceListCache;
		}else{
			$finalResourcesArray = $resourceListNoCache;
		}
		
		return $finalResourcesArray;
	}
	
	public static function loadFrontCSS() {

		if (cache::fileIsCached('css',themesDB::getThemeName().__HOME_NOGET) and !ISADMINLOGGED){
			$resourcesCSS = unserialize(cache::fileRead('css',themesDB::getThemeName().__HOME_NOGET));
		}else{
			$plugins = explode(',', FRONT_PLUGINS);

			$resourcesCSS = array_merge(
				(array)self::loadResourceByPlugins($plugins,'front-system','css'),
                array(str_replace(__SITE_PATH.'/',HOME,resourceManager::getCssWidgetsPath())),
				(array)self::loadResource(themesDB::getAllResources('css'),'front-theme', 'css')
			);
			$resourcesCSS = self::addVersionNum($resourcesCSS);
            cache::fileWrite('css',themesDB::getThemeName().__HOME_NOGET,serialize($resourcesCSS));
		}
		$user = usersDB::getLoggedUser('AdminUser');
		if (ISADMINLOGGED==1 and config::get('leftOpenMenu')==1 and config::get('showLeftEditor'.$user->id)==1) {
			$resourcesCSS[] = HOME.'app/resources/bootstrap/css/bootstrap-colorpicker.css';
			$resourcesCSS[] = HOME.'app/plugins/front/resources/css/editor.css';
		}
		return $resourcesCSS;
	}
	public static function loadFrontLESS() {

		if (cache::fileIsCached('css',themesDB::getThemeName().__HOME_NOGET.'less') and !ISADMINLOGGED){
			$resourcesCSS = unserialize(cache::fileRead('css',themesDB::getThemeName().__HOME_NOGET.'less'));
		}else{
			$resourcesCSS = (array)self::loadResource(themesDB::getAllResources('css_less'),'less', 'css',false,true);
			$resourcesCSS = self::addVersionNum($resourcesCSS);
            cache::fileWrite('css',themesDB::getThemeName().__HOME_NOGET.'less',serialize($resourcesCSS));
		}

		return $resourcesCSS;
	}	
	public static function loadFrontJS(){
		if (cache::fileIsCached('js','frontlist-'.themesDB::getThemeName().HOME)){
	 		$resourcesJS = unserialize(cache::fileRead('js','frontlist-'.themesDB::getThemeName().HOME));
		}else{
			$plugins = explode(',', FRONT_PLUGINS);
			$resourcesJS = array_merge(
				(array)self::loadResourceByPlugins($plugins,'front-system','js'),
				(array)self::loadResource(themesDB::getAllResources('js'),'front-theme', 'js')
			);
            cache::fileWrite('js','frontlist-'.themesDB::getThemeName().HOME,serialize($resourcesJS));
		}

		$user = usersDB::getLoggedUser('AdminUser');

		if (ISADMINLOGGED==1 and config::get('leftOpenMenu')==1 and config::get('showLeftEditor'.$user->id)==1){
			$inplaceConfigVarName =  "inPlaceEditor{$user->id}";
			if (config::get($inplaceConfigVarName)==1) {
				$resourcesJS = array_merge($resourcesJS,array(
						HOME.'app/plugins/html/resources/ckeditor/ckeditor.js',
						HOME.'app/plugins/html/resources/js/ckeditor.inline.config.js'
				));
			}			
			
			$resourcesJS[] = HOME.'app/plugins/html/resources/js/jeditable.min.js';
			$resourcesJS[] = HOME.'app/resources/js/jquery-ui.js';
			
			$user = usersDB::getLoggedUser('AdminUser');
			$resourcesJS[] = HOME.'app/resources/bootstrap/js/bootstrap-colorpicker.js';
			$resourcesJS[] = HOME.'app/plugins/front/resources/js/editor.js';	
			
			if(config::get("showInPlaceImagesBox$user->id")==1){		
				$resourcesJS[] = HOME.'app/plugins/front/resources/js/editorImg.js';
			}	
		}
		
		return $resourcesJS;
	}
	public static function loadAdminCSS(){
		if (cache::fileIsCached('css','admin-list-'.HOME)){
			$admincsslist = unserialize(cache::fileRead('css','admin-list-'.HOME));
		}else{
			$plugins = explode(',', ADMIN_PLUGINS);
			$admincsslist = self::loadResourceByPlugins($plugins,'admin','css',CACHE_ADMIN_RESOURCES);
            cache::fileWrite('css','admin-list-'.HOME,serialize($admincsslist));
		}
		return $admincsslist;
	}
	public static function loadAdminJS(){
		if (cache::fileIsCached('js','admin-list-'.HOME)){
			$adminjslist = unserialize(cache::fileRead('js','admin-list-'.HOME));
		}else{
			$plugins = explode(',', ADMIN_PLUGINS);
			$adminjslist = self::loadResourceByPlugins($plugins,'admin','js',CACHE_ADMIN_RESOURCES);

            cache::fileWrite('js','admin-list-'.HOME,serialize($adminjslist));
		}
		return $adminjslist;		
	}
	public static function addVersionNum($resourceList){
		$version = intval(config::get('resourcesVersion'));
		foreach ($resourceList as $resource){
			$resourceFinalList[] = $resource.'?ver='.$version;
		}	
		return $resourceFinalList;
	}
}
?>