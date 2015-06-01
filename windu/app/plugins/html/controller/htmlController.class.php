<?php /*windu.org html controller*/
Class htmlController extends controller{
	public function smartyGo()
	{
		require_once( __SITE_PATH . '/app/plugins/html/smarty/SmartyBC.class.php'); 
		
		$this->smarty = new SmartyBC();
		$this->smarty->compile_dir  = CACHE_PATH . 'templates_c/';
		$this->smarty->cache_dir    = CACHE_PATH . 'cache/';
		$this->smarty->plugins_dir  = array(__SITE_PATH . '/app/plugins/html/smarty/plugins/',
											__SITE_PATH . '/app/plugins/html/smartyPlugins/',
											__SITE_PATH . '/data/functions/');

		$this->smarty->assign('HOME',HOME);
		$this->smarty->assign('SITE_PATH',__SITE_PATH);
	}	
	public function __construct(request $request)
	{
		parent::__construct($request);
		
		$this->smartyGo();
		$this->smarty->assign('REQUEST',$request);
	}
	
	//Display methods////////////////////////////
	public function pageDisplay($tpl,$cacheKey = null,$menuCode = null)
	{
		$output = $this->smarty->fetch($tpl,$cacheKey);
		$output = $this->replaceImagesLinks($output);
		if (strlen($menuCode)>10) {
			$output = $this->prepareAdminTopMenu($output,$menuCode);
		}

		echo $output;
	}	
	public function pageDisplayHook($tpl,$mainTpl,$hook = 'page',$cacheKey = null) {
		$this->smarty->assign($hook,$tpl);
		$output = $this->smarty->fetch($mainTpl,$cacheKey);
		$output = $this->replaceImagesLinks($output);

		echo $output;
	}	
	public function pageFetchHook($tpl,$mainTpl,$hook = 'page',$data,$cacheKey = null) {
		$this->smarty->assign($hook,$tpl);
		$this->smarty->assign('data',$data);
		$output = $this->smarty->fetch($mainTpl,$cacheKey);
		$output = $this->replaceImagesLinks($output);

		return $output;
	}

	public function replaceImagesLinks($output){
		$cacheFile = CACHE_PATH.'system/img-alllist-'.md5(HOME).'.tmp';
		if (file_exists($cacheFile)) {
			$cacheFileFileSize = filesize($cacheFile);
		}
		$cacheFilePathFinal = CACHE_PATH.'system/img-alllist-path-final-'.md5(HOME.$cacheFileFileSize).'.tmp';
		$cacheFilePathOriginalFinal = CACHE_PATH.'system/img-alllist-path-original-final-'.md5(HOME.$cacheFileFileSize).'.tmp';
		
		$userAdminLogged = usersDB::getLoggedUser('AdminUser');
		$inPnaceEditorConfigName = "inPlaceEditor{$userAdminLogged->id}";
		$inPnaceWidgetsConfigName = "showInPlaceWidgetsBox{$userAdminLogged->id}";
		$inPnaceImagesConfigName = "showInPlaceImagesBox{$userAdminLogged->id}";
		
		if (file_exists($cacheFile) and ($userAdminLogged==null or (get_parent_class($this)=='frontMainController' and config::get($inPnaceEditorConfigName)!=1 and config::get($inPnaceWidgetsConfigName)!=1 and config::get($inPnaceImagesConfigName)!=1))) {
			if(!file_exists($cacheFilePathFinal) or !file_exists($cacheFilePathOriginalFinal)){
				foreach (file($cacheFile) as $imgPath){
					$imgPath = trim(preg_replace('/\s\s+/', '', $imgPath));
					$imgOrginal = cache::fileRead('img-thumb', $imgPath);
					
					if (file_exists(__SITE_PATH.'/'.$imgOrginal['path'])) {
						$imgPathArray[] = '"'.$imgPath.'"';
						$dimensions = getimagesize(__SITE_PATH.'/'.$imgOrginal['path']);
						$imgOrginalPathArray[] = '"'.HOME.$imgOrginal['path'].'" '.$dimensions[3]; 	
					}
				}
				array_map( "unlink", glob(CACHE_PATH.'system/img-alllist-path-*'));
				baseFile::saveFile($cacheFilePathFinal, serialize($imgPathArray));
				baseFile::saveFile($cacheFilePathOriginalFinal, serialize($imgOrginalPathArray));
			}
			$output = str_replace(unserialize(baseFile::readFile($cacheFilePathFinal)), unserialize(baseFile::readFile($cacheFilePathOriginalFinal)), $output);	
		}			

		return $output;
	}

	private function prepareAdminTopMenu($output,$menuCode){
		$user = usersDB::getLoggedUser('AdminUser');
		if (cookie::readCookie('hideLeftMenu')==1){
			$output = $output;
		}elseif(config::get('showLeftEditor'.$user->id)==1){
			$output = str_replace('<body', '<body style="padding-left:250px;"', $output);
		}
		$output = str_replace('</body>', $menuCode.'</body>', $output);
		return $output;
	}	

}
?>
