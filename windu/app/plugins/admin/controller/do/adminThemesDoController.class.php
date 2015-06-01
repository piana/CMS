<?php /*windu.org admin controller*/
Class adminThemesDoController Extends adminAuthDoController{
	
	public function delete(){
		$themesDB = new themesDB($this->request->getVariable('theme').'/'.$this->request->getVariable('tpldir'));
		$themesDB->delete($this->request->getVariable('tpl'));
	}		
	public function delete_file() {
		baseFile::delete(__SITE_PATH.base64_decode($this->request->getVariable('theme')));
	}
	public function delete_template() {
		$themesDB = new themesDB($this->request->getVariable('theme'));
		$themesDB->deleteTemplate();
	}
	public function delete_widget() {
		$widgetsDB = new widgetsDB($this->request->getVariable('theme'));
		$widgetsDB->deleteWidget();
	}
	public function deleteWidgetFile() {
		$path = WIDGET_PATH.$this->request->getVariable('theme').'/'.$this->request->getVariable('tpldir').'/'.$this->request->getVariable('tpl');
		baseFile::delete($path);
	}
	public function setTempleteActive() {
		config::set('template', $this->request->getVariable('theme'));
		router::back($this->request);
	}
	public function setTempleteActiveReload() {
		config::set('template', $this->request->getVariable('theme'));
		router::reloadParent();
	}	
	public function duplicateTemplate() {
		baseFile::copyDir(TEMPLATES_PATH.$this->request->getVariable('theme').'/', TEMPLATES_PATH.$this->request->getVariable('theme').'-copy/');
		router::back($this->request);
	}
	public function downloadTemplate() {
		compress::getZipFile($this->request->getVariable('theme'), TEMPLATES_PATH.$this->request->getVariable('theme'));
	}	
	public function downloadWidget() {
		if (is_dir(WIDGET_PATH.$this->request->getVariable('theme'))) {
			compress::getZipFile($this->request->getVariable('theme'), WIDGET_PATH.$this->request->getVariable('theme'));
		}else{
			compress::getZipFile($this->request->getVariable('theme'), WIDGET_OFF_PATH.$this->request->getVariable('theme'));
		}
	}
    public static function wasWidgetEdited($widget){
        if(file_exists(WIDGET_PATH.$widget.'/doc/wasedited.ini')){
            return true;
        }else{
            return false;
        }
    }
    public static function setWidgetEdited($widget){
        baseFile::saveFile(WIDGET_PATH.$widget.'/doc/wasedited.ini',generate::sqlDatetime());
    }
	private function updateWidgetAction($widget,$fileEkey) {
		$widgetsDB = new widgetsDB($widget);
		$widgetsDB->deleteWidget();
		$this->addWidgetFromAddonsServerAction($widget,$fileEkey);
		
		$updateFilePath = WIDGET_PATH.$widget.'/doc/lastupdate.ini';
		baseFile::saveFile($updateFilePath, generate::sqlDatetime());

		log::write("Update widget - ".$widget,logDB::BUCKET_UPDATE);
	}
	public function updateWidget() {
		$this->updateWidgetAction($this->request->getVariable('tpl'),$this->request->getVariable('theme'));
		cache::flushAllCache();
		router::back($this->request);
	}
	public function updateAllWidgets() {
		$widgetsToUpdate = widgetsDB::getUpdateList();
		
		foreach ($widgetsToUpdate as $widget) {
            if(!self::wasWidgetEdited($widget)){
			    $this->updateWidgetAction($widget['name'],$widget['fileEkey']);
            }
		}
		
		cache::flushAllCache();
		router::back($this->request);
	}
	public function duplicateWidget() {
		baseFile::copyDir(WIDGET_PATH.$this->request->getVariable('theme').'/', WIDGET_PATH.$this->request->getVariable('theme').'copy/');
		baseFile::rename( WIDGET_PATH.$this->request->getVariable('theme').'copy/'.$this->request->getVariable('theme').'Controller.class.php',
						  WIDGET_PATH.$this->request->getVariable('theme').'copy/'.$this->request->getVariable('theme').'copyController.class.php');
		baseFile::rename( WIDGET_PATH.$this->request->getVariable('theme').'copy/'.$this->request->getVariable('theme').'View.tpl',
						  WIDGET_PATH.$this->request->getVariable('theme').'copy/'.$this->request->getVariable('theme').'copyView.tpl');

		$controlerContent = file_get_contents(WIDGET_PATH.$this->request->getVariable('theme').'copy/'.$this->request->getVariable('theme').'copyController.class.php');
		$controlerContent = str_replace($this->request->getVariable('theme'), $this->request->getVariable('theme').'copy', $controlerContent);		
		file_put_contents(WIDGET_PATH.$this->request->getVariable('theme').'copy/'.$this->request->getVariable('theme').'copyController.class.php', $controlerContent) ;
        cache::setCleanCacheFlag();
		router::back($this->request);
	}		
	
	
	public function deactivateWidget() {
		baseFile::rename(WIDGET_PATH.$this->request->getVariable('theme'), WIDGET_OFF_PATH.$this->request->getVariable('theme'));
		cache::setCleanCacheFlag();	
		router::back($this->request);
	}	
	public function activateWidget() {
		baseFile::rename(WIDGET_OFF_PATH.$this->request->getVariable('theme'),WIDGET_PATH.$this->request->getVariable('theme'));
		cache::setCleanCacheFlag();	
		router::back($this->request);
	}		
	
	public function editAjaxSuccess() {
		$data = array_map( 'stripslashes', $_POST );
		$themesDB = new themesDB($this->request->getVariable('theme'));
		$themesDB->save($this->request->getVariable('tpldir').'/'.$this->request->getVariable('tpl'),$data['themeContent']);

		if ($this->request->getVariable('tpldir')=='css' or $this->request->getVariable('tpldir')=='css_less') {
			config::set('resourcesVersion', intval(config::get('resourcesVersion'))+1);
            cache::setCleanCacheFlag();
        }
	}	
	public function editAjaxWidgetSuccess() {
		$data = array_map( 'stripslashes', $_POST );
		$widgetsDB = new widgetsDB($this->request->getVariable('theme'));
		
		if ($this->request->getVariable('tpldir')!=null) {
			$tplDirPom = $this->request->getVariable('tpldir').'/';
		}
		
		$widgetsDB->save($tplDirPom.$this->request->getVariable('tpl'),$data['widgetContent']);
        self::setWidgetEdited($this->request->getVariable('theme'));

        cache::setCleanCacheFlag();
	}
	private function addThemeFromAddonsServerAction($creatorNoReplace = false) {
		$filePath = ADDONS_SERVER."file/original/{$this->request->getVariable('theme')}/";
		$destination = TEMPLATES_PATH.$this->request->getVariable('tpl').'/';
		$destination = str_replace(' ', '-', $destination);
		$destination = str_replace('%20', '-', $destination);

		$source = CACHE_PATH.'system/theme-zip-'.time().'.zip';
		
		if (!$creatorNoReplace) {
			$counter = 2;
			while (is_dir($destination)) {
				$destination = TEMPLATES_PATH.$this->request->getVariable('tpl')."-{$counter}/";
				$counter = $counter+1;
			}
		}

		if (!is_dir($destination)) {
			baseFile::createDir($destination);
			baseFile::saveFile($source, baseFile::getExternalFileContent($filePath));
			
			compress::unzip($source, $destination);
			baseFile::delete($source);

            $widgetServerArray = unserialize(baseFile::getExternalFileContent(ADDONS_SERVER_DATA.'getWidgets/'.config::get('language-admin').'/'));

            //install dependents widgets from addons server
            if(file_exists($destination.'widgets.ini')){
                $widgetsToInstall = explode(',',baseFile::readFile($destination.'widgets.ini'));
                if(count($widgetsToInstall)>0){
                    foreach($widgetsToInstall as $widgetName){
                        if(is_array($widgetServerArray[$widgetName]) and !is_dir(WIDGET_PATH.$widgetName.'/')){
                            $this->addWidgetFromAddonsServerAction($widgetName,$widgetServerArray[$widgetName]['fileEkey']);
                        }
                    }
                }
            }

            log::write("Themplate installed - ".$this->request->getVariable('tpl'),logDB::BUCKET_UPDATE);
		}
	}
	public function addThemeFromAddonsServer() {
		$this->addThemeFromAddonsServerAction();
		router::back($this->request);
	}
	public function addThemeFromAddonsServerCreator() {
		$this->addThemeFromAddonsServerAction(true);
		
		if (cache::isCached('addonsServerThemes',3600*24)) {
			$themesFromAddonsServer = cache::read('addonsServerThemes');
		}else{
			$themesFromAddonsServer = unserialize(baseFile::getExternalFileContent(ADDONS_SERVER_DATA.'getThemes/'));
			cache::write('addonsServerThemes', $themesFromAddonsServer);
		}		
		foreach ($themesFromAddonsServer as $theme){
			if ($theme['name'] == $this->request->getVariable('tpl')) {
				$templateImg = $theme['imageEkey'];
			}
		}
		config::set('templateImgKey', $templateImg);
		config::set('template', $this->request->getVariable('tpl'));
		router::redirect('admin-creator-action-id',array('action'=>'editImages','id'=>config::get('creatorSiteType')));
	}
	public function addWidgetFromAddonsServer() {
		$fileEkey = $this->request->getVariable('theme');
		$widgetName = $this->request->getVariable('tpl');
		
		$this->addWidgetFromAddonsServerAction($widgetName,$fileEkey);
		router::back($this->request);
	}	
	private function addWidgetFromAddonsServerAction($widgetName,$fileEkey) {
		$filePath = ADDONS_SERVER."file/original/{$fileEkey}/";
		$destination = WIDGET_PATH.$widgetName.'/';

		$source = CACHE_PATH.'system/widget-zip-'.time().'.zip';
		
		$counter = 2;
		while (is_dir($destination)) {
			$destination = WIDGET_PATH.$widgetName."-{$counter}/";
			$counter = $counter+1;
		}
		
		if (!is_dir($destination)) {
			baseFile::createDir($destination);
			baseFile::saveFile($source, baseFile::getExternalFileContent($filePath));
			
			compress::unzip($source, $destination);
			baseFile::delete($source);
            log::write("Widget installed - ".$widgetName,logDB::BUCKET_UPDATE);
		}
	}	
}
?>