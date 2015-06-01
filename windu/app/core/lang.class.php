<?php /*windu.org core*/
class lang
{
	private static $lang;
	public static $langFiles = array('admin.txt','front.txt');
	
	public static function set($bucket,$forceLangId = null)
	{
		$pagesDB = new pagesDB();
		if (is_numeric($forceLangId) and $forceLangId!=null) {
			$lang = $forceLangId;
		}else{
			$lang = cookie::readCookie("lang-{$bucket}");
		}
		if (is_numeric($lang)) {
			$langDir = strtolower($pagesDB->get($lang,'name'));
		}	
		if ($lang!='' and is_dir(DATA_PATH.'languages/' . $langDir . '/')){
			define('LANG', $lang);
		}else{
			$user = usersDB::getLoggedUser();
			$langByUser = config::get('language-admin-'.$user->id);
			if (is_numeric($langByUser) and $langByUser!=null) {
				define('LANG', $langByUser);
			}else{
				define('LANG', config::get('language-'.$bucket));
			}
			
			$langDir = strtolower($pagesDB->get(LANG,'name'));
		}
	
		define('LANG_BUCKET', $bucket);

		if (!cache::isCached(LANG.$bucket.'langContent')) {
			cache::write(LANG.$bucket.'langContent', self::prepare($bucket,$langDir),'lang');
		}
	}
	public static function read($key)
	{
		$key = trim($key,' ');
		$data = cache::read(LANG.LANG_BUCKET.'langContent');
		if (isset($data[$key])) return $data[$key];
		//if (isset($data[$key]))return '';

		if (ISADMINLOGGED==1 and LANG_BUCKET=='front') {
			if (preg_match('/editable*/', $key)) {return '<span class="jeditable" id="'.$key.'">'.$data[$key].'</span>';}
			elseif (isset($data[$key])) return $data[$key];
			else return $key;
			//else return '?????? '.$key.' ??????';
		}elseif (isset($data[$key]))return $data[$key];
		//else return '<strong style=\'color:red\'>'.$key.'</strong>';
		else return $key;
		
		return 'No language file!';		
	}
	public static function exist($key) {
		$key = trim($key,' ');
		$data = cache::read(LANG.LANG_BUCKET.'langContent');
		if (isset($data[$key]))return true;
		else return false;
	}
	private static function prepare($bucket,$langName) {
		$pagesDB = new pagesDB();
		
		$langDir = strtolower($pagesDB->get(LANG,'name'));
		$mainArray = lang::prepareLanguageArray(DATA_PATH . 'languages/' . $langDir . '/'.$bucket.'.txt');
		
		if ($bucket=='front' or $bucket=='admin') {
			$widgetsArray = array();
			$widgetsArray = widgetsDB::getLanguage($langName);
			return array_merge($mainArray,$widgetsArray);
		}
		
		return $mainArray;
	}	
	public static function prepareLanguageArray($filePath){
		$finalArray = array();
		$contentArray = file($filePath,FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);

		foreach ($contentArray as $arrayRow){

			$row = explode('=',$arrayRow);
			if (count($row)==2) {
				$finalArray[trim($row[0])] = trim(trim($row[1]),'"');
			}elseif(count($row)>2){
				for ($i = 1; $i < count($row); $i++) {
					$finalArray[trim($row[0])] .= '='.$row[$i];
				}
				$finalArray[trim($row[0])] = ltrim(trim(trim($finalArray[trim($row[0])]),'"'),'=');
			}
		}
		return $finalArray;
	}
	public static function prepareLanguageString($filePath){
		$finalArray = array();
		$contentArray = file($filePath,FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
	
		foreach ($contentArray as $arrayRow){
	
			$row = explode('=',$arrayRow);
			if (count($row)==2) {
				$finalArray.= trim(trim($row[1]),'"');
			}elseif(count($row)>2){
				for ($i = 1; $i < count($row); $i++) {
					$finalArray .= '='.$row[$i];
				}
				$finalArray.= ltrim(trim(trim($finalArray[trim($row[0])]),'"'),'=');
			}
		}
		return $finalArray;
	}	
	public static function prepareLanguageMultiArray($bucket = 'front',$widgetName = null){
		$pagesDB = new pagesDB();
		$langs = $pagesDB->fetchAll("type=".pagesDB::TYPE_LANG_CATALOG." and status !=".pagesDB::STATUS_DELETE,'id ASC','*');
		$langsArray = array();
		
		//prepare all languages data
		foreach ($langs as $lang){
			$name = strtolower($lang->name);
			if ($bucket=='widget') {
				$fileLangPath = WIDGET_PATH.$widgetName.'/lang/'.$name.'.txt';
				if (!file_exists($fileLangPath)) {
					baseFile::saveFile($fileLangPath, ' ');
				}
			}else{
				$fileLangPath = LANGUAGES_PATH.$name.'/'.$bucket.'.txt';
			}
			
			$langsArray[$name] = lang::prepareLanguageArray($fileLangPath);
		}
		
		//prepare keys
		$mergedArrayKeyPom = array();
		foreach ($langsArray as $langArray){
			$mergedArrayKeyPom = array_merge($mergedArrayKeyPom, $langArray);
		}	
		$arrayKeys = array_keys($mergedArrayKeyPom);	
		
		//generate final array
		foreach ($arrayKeys as $key){
			foreach ($langsArray as $langKey => $langArray){
				$finalArray[$key][$langKey] = $langArray[$key];
			}
		}		
		return $finalArray;
	}
	public static function replaceVariableValue($filePath,$valKey,$value,$delete = false) {

		$content = file($filePath);
		$finalString = '';
		$pomReplaced = 0;
		foreach ($content as $line){
			$pomArray = explode('=', $line);
			$pomKey = trim($pomArray[0]);

			if ($pomKey==$valKey and strlen($valKey)>3) {
				if ($delete==1) {
					$pomReplaced = 1;
				}else{
					$finalString .= "{$valKey} = {$value}\n";
					$pomReplaced = 1;					
				}

			}else{
				$finalString .= "{$line}";
			}
		}
		if ($pomReplaced == 0) {
			$finalString .= "{$valKey} = {$value}\n";
		}
		
		return $finalString;
	}
	public static function setLangByDomain(array $domainLang) {
		define('LANG_BY_DOMAIN', serialize($domainLang));
		$actualDomain = str_replace('http://', '', __BASE);
		$actualDomain = str_replace('www.', '', $actualDomain);

		$langId = $domainLang[$actualDomain];
		if (is_numeric($langId)) {
			$pagesDB = new pagesDB();
			if($pagesDB->fetchCount("id={$langId}")==1){
				cookie::setCookie('lang-front',$langId,7776000);
				lang::set('front',$langId);
				return true;
			}
		}
		return false;
	}
	public static function preferedLanguage($available_languages,$http_accept_language="auto") { 

	    if ($http_accept_language == "auto") $http_accept_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : ''; 
	   
	    preg_match_all("/([[:alpha:]]{1,8})(-([[:alpha:]|-]{1,8}))?" . 
	                   "(\s*;\s*q\s*=\s*(1\.0{0,3}|0\.\d{0,3}))?\s*(,|$)/i", 
	                   $http_accept_language, $hits, PREG_SET_ORDER); 

	    $bestlang = $available_languages[0]; 
	    $bestqval = 0; 
	
	    foreach ($hits as $arr) { 

	        $langprefix = strtolower ($arr[1]); 
	        if (!empty($arr[3])) { 
	            $langrange = strtolower ($arr[3]); 
	            $language = $langprefix . "-" . $langrange; 
	        } 
	        else $language = $langprefix; 
	        $qvalue = 1.0; 
	        if (!empty($arr[5])) $qvalue = floatval($arr[5]); 

	        if (in_array($language,$available_languages) && ($qvalue > $bestqval)) { 
	            $bestlang = $language; 
	            $bestqval = $qvalue; 
	        } 

	        else if (in_array($langprefix,$available_languages) && (($qvalue*0.9) > $bestqval)) { 
	            $bestlang = $langprefix; 
	            $bestqval = $qvalue*0.9; 
	        } 
	    } 
	    return $bestlang; 
	} 

	public static function setFrontLanguage($urlKey,$domainLang = array(),$guessLang = true){
		if ($domainLang!=array()) {
			if(self::setLangByDomain($domainLang)){
				return true;
			}
		}
		$langCookie = cookie::read('lang-front');
		$pagesDB = new pagesDB();
		if ($guessLang and $urlKey=='' and $langCookie==null) {
			foreach ($pagesDB->fetchAll("parentId=0 and status=".pagesDB::STATUS_ACTIVE) as $lang){
				$langArray[] = strtolower($lang->name);
			}
			$langString = strtolower(self::preferedLanguage($langArray));
			
			$langId = $pagesDB->fetchRow("LOWER(name)='{$langString}'")->id;

			if (is_numeric($langId) and $langId!=null) {
				self::set('front',$langId);
				cookie::setCookie('lang-front',$langId,7776000);
				return true;
			}
		}elseif (is_numeric($langCookie) and $urlKey==''){
			self::set('front',$langCookie);
			return true;
		}
		$page = $pagesDB->getPageByUrlKey($urlKey);
		self::set('front',$page->langId);
		cookie::setCookie('lang-front',$page->langId,7776000);
		return true;	
	}
	public static function replaceVar($name,$value,$langId,$bucket = 'front') {
		$pagesDB = new pagesDB();
		$langDir = strtolower($pagesDB->get($langId,'name'));
		$langFilePath = DATA_PATH . 'languages/' . $langDir . '/'.$bucket.'.txt';
		$lines = file($langFilePath);

        $finalString = '';
		foreach ($lines as $line){
			if(preg_match("/{$name}*/", $line)){
				$finalString .= $name.' = '.$value."\n";
			}else{
				$finalString .= $line.'';
			}
		}
		baseFile::saveFile($langFilePath, $finalString);
		cache::clearBucket('lang');
		return true;
	}
	
	//TODO
	public static function organizeLanguageFile($langFilePath) {
		$lines = file($langFilePath,FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
		asort($lines);
		debugger::dprint($lines);
	}
}
?>
