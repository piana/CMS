<?php /*windu.org admin controller*/
Class adminContentDoController Extends adminAuthDoController{
	//Poll/////////////////////////////////////////////////
	public function deletePoll() {
		$pollDB = new pollsDB();
		$pollDB->delete($this->request->getVariable('id'));
		router::back($this->request);
	}
	public function deleteQuestion() {
		$questionsDB = new pollQuestionsDB();
		$questionsDB->delete($this->request->getVariable('id'));
		router::back($this->request);
	}	
	public function toggleActivationPoll(){
		$id = $this->request->getVariable('id');
		$pollDB = new pollsDB();
		if($pollDB->get($id,'status')==0){
			$pollDB->updateRow(array('status'=>1),"id=$id");
		}else{
			$pollDB->updateRow(array('status'=>0),"id=$id");
		}
	}	

	//Baners/////////////////////////////////////////////////
	public function deleteBannerArea() {
		$bannerAreaDB = new bannersareasDB();
		$bannerAreaDB->deleteArea($this->request->getVariable('id'));
		router::back($this->request);
	}
	public function deleteBanner() {
		$bannerDB = new bannersDB();
		$banner = $bannerDB->fetchRow("id={$this->request->getVariable('id')}");
		$bannerDB->deleteBanner($this->request->getVariable('id'));
		router::redirect('admin-content-action-id',array('action'=>'showBanners','id'=>$banner->areaId,'subpage'=>'banners'));
	}	
	public function toggleBannersActivate(){
		$id = $this->request->getVariable('id');
		$banenrsAreaDB = new bannersareasDB();
		if($banenrsAreaDB->get($id,'status')==0){
			$banenrsAreaDB->updateRow(array('status'=>1),"id=$id");
		}else{
			$banenrsAreaDB->updateRow(array('status'=>0),"id=$id");
		}
	}	
	public function toggleBannerActivate(){
		$id = $this->request->getVariable('id');
		$bannersDB = new bannersDB();
		
		if($bannersDB->get($id,'status')==0){
			$bannersDB->updateRow(array('status'=>1),"id=$id");
		}else{
			$bannersDB->updateRow(array('status'=>0),"id=$id");
		}
	}
	public function toggleBannerCookie(){
		$id = $this->request->getVariable('id');
		$bannersDB = new bannersDB();
		
		if($bannersDB->get($id,'cookieCheck')==0){
			$bannersDB->updateRow(array('cookieCheck'=>1),"id=$id");
		}else{
			$bannersDB->updateRow(array('cookieCheck'=>0),"id=$id");
		}
	}
	
	public function duplicateItem() {
		$pagesDB = new pagesDB();
		$pagesDB->duplicateItem($this->request->getVariable('id'));
		router::back($this->request);
	}
	
	public function saveFromJsList() {
		$data = $_POST['data'];
		$pagesDB = new pagesDB();
        $upPositionMem = 0;

		foreach($data as $element){
			$position = $upPositionMem+1;
			$langId = $pagesDB->fetchRow("id={$element['parent']}")->langId;
            $ownLangId = $pagesDB->fetchRow("id={$element['id']}")->langId;

			if ($langId>0 and $langId!=$ownLangId) {
				$pagesDB->updateRow(array('parentId' => $element['parent'],'position' => $position,'langId' => $langId),"id = {$element['id']}");
                $pagesDB->updateLangId($element['id'],$langId);
			}else{
				$pagesDB->updateRow(array('parentId' => $element['parent'],'position' => $position),"id = {$element['id']}");
			}

			$upPositionMem = $this->getPosition($element['id'],$pagesDB);
		}
	}


	public function saveFromJsListGallery() {
		$data = $_POST['data'];
		$imagesDb = new imagesDB();
        $upPositionMem = 0;

		foreach($data as $element){
			$position = $upPositionMem+1;
			$imagesDb->updateRow(array('position' => $position),"id = {$element['id']}");
			$upPositionMem = $this->getPosition($element['id'],$imagesDb);
		}
	}	

	public function saveFromJsListNews() {
		$data = $_POST['data'];
		$pagesDb = new pagesDB();
        $upPositionMem = 0;

		foreach($data as $element){
			$position = $upPositionMem+1;
			$pagesDb->updateRow(array('position' => $position),"id = {$element['id']}");
			$upPositionMem = $this->getPosition($element['id'],$pagesDb);
		}
	}	
	
	private function getPosition($id,$db) {
		if ($id==null) return 0;
		$row = $db->fetchRow("id={$id}");
		return $row->position;
	}
	
	public function delete(){
		$pagesDB = new pagesDB();
		$pagesDB->deleteTreeItems($this->request->getVariable('id'));
	}	
	public function deleteLang(){
		$pagesDB = new pagesDB();
		$pagesDB->deleteTreeItems($this->request->getVariable('id'));
		router::back($this->request);
	}			
	public function toggleHide(){
		$pagesDB = new pagesDB();
		if($pagesDB->get($this->request->getVariable('id'), 'status')==pagesDB::STATUS_HIDE){
			$pagesDB->set($this->request->getVariable('id'),'status',pagesDB::STATUS_ACTIVE);
		}else{
			$pagesDB->set($this->request->getVariable('id'),'status',pagesDB::STATUS_HIDE);
		}
	}
	public function toggleHideParent(){
		$pagesDB = new pagesDB();
		if($pagesDB->get($this->request->getVariable('id'), 'status')==pagesDB::STATUS_HIDE){
			$pagesDB->set($this->request->getVariable('id'),'status',pagesDB::STATUS_ACTIVE);
		}else{
			$pagesDB->set($this->request->getVariable('id'),'status',pagesDB::STATUS_HIDE);
		}
		router::reloadParent();
	}	
	
	public function toggleSearchable(){
		$pagesDB = new pagesDB();
		if($pagesDB->get($this->request->getVariable('id'), 'searchable')==1){
			$pagesDB->set($this->request->getVariable('id'),'searchable',0);
		}else{
			$pagesDB->set($this->request->getVariable('id'),'searchable',1);
		}
	}
	public function toggleLoggedContent(){
		$pagesDB = new pagesDB();
		if($pagesDB->get($this->request->getVariable('id'), 'logged')==1){
			$pagesDB->set($this->request->getVariable('id'),'logged',0);
		}else{
			$pagesDB->set($this->request->getVariable('id'),'logged',1);
		}
	}
	
	
	public function toggleLock(){
		$pagesDB = new pagesDB();
		if($pagesDB->get($this->request->getVariable('id'),'lock')==1){
			$pagesDB->set($this->request->getVariable('id'),'lock',0);
		}else{
			$pagesDB->set($this->request->getVariable('id'),'lock',1);
		}
	}	
	public function deleteImage() {
		image::deleteImageById($this->request->getVariable('id'));
		router::back($this->request);
	}
	public function deleteImageAjax() {
		image::deleteImageById($this->request->getVariable('id'));
	}	
	public function deleteMainImage(){
		image::deleteImageByBucket($this->request->getVariable('id'));
		$type = explode('-', $this->request->getVariable('id'));
		$pagesDB = new pagesDB();
		if ($type[0]=='icon') {
			$pagesDB->set($type[1],'hasIcon',0);
		}elseif($type[0]=='main'){
			$pagesDB->set($type[1],'hasImage',0);
		}
		router::back($this->request);
	}
	//show treelist element
	public static function showTreelistStatic($id) {
		$openIdArray = unserialize(cookie::readCookie('contentOpenId'));
		if(isset($openIdArray[$id])){
			$pagesDB = new pagesDB();
			$children = $pagesDB->getDependentIdListString($id);
			$childernArray = explode(',',$children);
			unset($openIdArray[$id]);
			foreach ($childernArray as $child){
				unset($openIdArray[$child]);
			}
		}else{
			$openIdArray[$id] = 1;
		}
		
		cookie::setCookie('contentOpenId',serialize($openIdArray),0);
	}
	public function showTreelist() {
		self::showTreelistStatic($this->request->getVariable('id'));
		router::back($this->request);
	}
	public function goEdit() {
		$id = $this->request->getVariable('id');
		self::showTreelistStatic($id);
		router::redirect('admin-content-action-id',array('action'=>'edit','id'=>$id,'subpage'=>'pages'));
	}
	
	//hide treelist element
	public function hideTreelistAll() {
		cookie::setCookie('contentOpenId',null,0);
		router::back($this->request);
	}	

	public function saveInPlaceEditorContent() {
		$content = $_POST['content'];

		$pagesDB = new pagesDB();
		$idArr = explode('_',$_POST['id']);
		
		$column = $idArr[0];
		$id = $idArr[1]; 
		
		$content = str_replace('<pre class="inline-widget">','',$content);
		$content = str_replace('&#123;&#123;','{{',$content);
		$content = str_replace('}}</pre>','}}',$content);
		$content = str_replace('&#125;&#125;','}}',$content);
		$content = str_replace(HOME,'{{$HOME}}', $content);
		
		$data=array($column=>stripslashes($content));
		
		$pagesDB->updatePage($data,"id={$id}",false);
		echo $content;
	}
	public function restorePage(){
		$pagesBackupDB = new pagesbackupsDB();
		$pageFromBackup = $pagesBackupDB->getBackupedPage("id={$this->request->getVariable('id')}");
		$dataFromBackup = array('content'=>$pageFromBackup['content']);

		$pagesDB = new pagesDB();
		$pagesDB->updatePage($dataFromBackup,"id={$pagesBackupDB->get($this->request->getVariable('id'),'pageId')}", false, false);
		router::back($this->request);		
	}
	public function deletePageVersion(){
		$pagesBackupDB = new pagesbackupsDB();
		$pagesBackupDB->deleteRows("id={$this->request->getVariable('id')}");
		router::back($this->request);		
	}
	public function compactPageVersions(){
		$pagesBackupDB = new pagesbackupsDB();
		$pagesBackupDB->compact($this->request->getVariable('id'));
		router::back($this->request);		
	}	
	public function compactAllVersions(){
		$pagesBackupDB = new pagesbackupsDB();
		$pagesBackupDB->compactAllVersions();
		router::back($this->request);		
	}		
	public function editAjaxSuccess() {
		$data = array_map( 'stripslashes', $_POST );
		$pagesDB = new pagesDB();

		//check that cache must be clean
		$newTagsCount = preg_match_all('/\{\{/', str_replace(HOME, '{{$HOME}}', $data['content']));
		$oldTagsCount = preg_match_all('/\{\{/', $pagesDB->get($this->request->getVariable('id'),'content'));

		if ($oldTagsCount!=$newTagsCount) {
			cache::setCleanCacheFlag();
		}	
		
		$pagesDB->updatePage($data,"id={$this->request->getVariable('id')}");
	}	
	public function autosaveSuccess() {
		$data = array_map( 'stripslashes', $_POST );
		$dataFinal['pageContent'] = serialize($data);
		$dataFinal['pageId'] = 0;
		
    	$usersDB = new usersDB();
    	$user = $usersDB->getLoggedIn();
    	$dataFinal['createUser'] = $user->id;
    			
		$pagesBackupDB = new pagesbackupsDB();
		$pagesBackupDB->insert($dataFinal);
		
		$autosaveCounter = config::get('autosaveCounter');
		if ($autosaveCounter>=10){
			$pagesBackupDB->compact(0);
			if ($pagesBackupDB->fetchCount("pageId=0")>20) {
				$allAutosaves = $pagesBackupDB->fetchAll("pageId=0","id DESC");
				$counter=0;
				foreach ($allAutosaves as $autoSave){
					$counter=$counter+1;
					if ($counter>=20) {
						$pagesBackupDB->delete($autoSave->id);
					}
				}
			}
			config::set('autosaveCounter',0);
		}else{
			config::set('autosaveCounter',$autosaveCounter+1);
		}
		
		
	}		
	public function cleanImagesThumbs() {
		image::deleteImageThumbsAll();
		cache::flushAllCache();
		router::back($this->request);
	}	
	public function cleanImagesDatabase() {
		
		$imagesDB = new imagesDB();
		$allImages = $imagesDB->fetchAll();
		
		foreach ($allImages as $img){
			$path = __SITE_PATH.'/'.FILES_DIR.$img->path.'/'.$img->fileName	;
			if (!file_exists($path)) {
				$imagesDB->delete($img->id);
			}		
		}
		router::back($this->request);
	}	
	
	//Calendar//////////////////////////////////////
	public function toggleCalendarActivate() {
		$id = $this->request->getVariable('id');
		$callendarDB = new calendarDB();
		
		if($callendarDB->get($id,'status')==0){
			$callendarDB->updateRow(array('status'=>1),"id=$id");
		}else{
			$callendarDB->updateRow(array('status'=>0),"id=$id");
		}
	}
	public function toggleCalendarEvent() {
		$id = $this->request->getVariable('id');
		$callendarEventDB = new calendarEventsDB();
		
		if($callendarEventDB->get($id,'status')==0){
			$callendarEventDB->updateRow(array('status'=>1),"id=$id");
		}else{
			$callendarEventDB->updateRow(array('status'=>0),"id=$id");
		}
	}
	public function deleteCalendar() {
		$id = $this->request->getVariable('id');
		$callendarDB = new calendarDB();
		$callendarDB->deleteCalendar($id);
		router::back($this->request);
	}	
	public function deleteCalendarEvent() {
		$id = $this->request->getVariable('id');
		$callendarEventsDB = new calendarEventsDB();
		$callendarEventsDB->delete($id);
		router::back($this->request);
	}
	public function saveJeditableContent(){
		lang::set('front');
		
		$name = $this->request->getVariable('id');
		$value = $this->request->getVariable('value');
		
		lang::replaceVar($name,$value,LANG);
		echo $value;
	}
	
	//Autosave//////////////////////////////////////
	public function deleteAllAutosaves() {
		$pagesBackupDB = new pagesbackupsDB();
		$pagesBackupDB->deleteAllByBucket(0);
		router::back($this->request);
	}
	
	//Languages/////////////////////////////////////
	public function deleteLanguageVariable() {
		$key = str_replace('_','.',$this->request->getVariable('id'));
		$pagesDB = new pagesDB();
		$langs = $pagesDB->fetchAll("type=".pagesDB::TYPE_LANG_CATALOG." and status !=".pagesDB::STATUS_DELETE,'id ASC','*');
		foreach ($langs as $lang){
			$name = strtolower($lang->name);
			$fileLangPath = LANGUAGES_PATH.$name.'/front.txt';			
			baseFile::saveFile($fileLangPath, lang::replaceVariableValue($fileLangPath,$key,'',1));
		}
	}

	public function vacummLanguages() {
		$pagesDB = new pagesDB();
		$languages = $pagesDB->fetchAll("type=".pagesDB::TYPE_LANG_CATALOG);
		
		foreach ($languages as $lang){
			$langName = strtolower($lang->name);
			$langPath = DATA_PATH.'languages/'.$langName.'/front.txt';
			if (file_exists($langPath)) {
				lang::organizeLanguageFile($langPath);
			}
			
			$langPath = DATA_PATH.'languages/'.$langName.'/admin.txt';
			if (file_exists($langPath)) {
				lang::organizeLanguageFile($langPath);
			}			
			
			foreach (widgetsDB::getWidgetArray() as $widget){
				$langPath = WIDGET_PATH.$widget.'/lang/'.$langName.'.txt';
				if (file_exists($langPath)) {
					lang::organizeLanguageFile($langPath);
				}
			}
		}
		router::back($this->request);
	}
}
?>
