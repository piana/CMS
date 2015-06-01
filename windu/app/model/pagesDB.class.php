<?php /*windu.org model*/
class pagesDB extends ekeyDB
{
	const STATUS_DELETE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_HIDE = 2;

	const PARENTID_NOPARENT = -1;
	const PARENTID_LANGUAGE = 0;

	const TYPE_PAGE = 1;
	const TYPE_NEWS = 2;
	const TYPE_URL = 3;

	const TYPE_LANG_CATALOG = 10;
	const TYPE_CATALOG = 11;
	const TYPE_GALLERY = 12;
	const TYPE_NEWS_GROUP = 13;
		
	private $types = array(
		self::TYPE_PAGE => "app.pagesdb.site",
		self::TYPE_CATALOG => "app.pagesdb.group",
		self::TYPE_GALLERY => "app.pagesdb.gallery",
		self::TYPE_NEWS_GROUP => "app.pagesdb.news",
		self::TYPE_URL => "app.pagesdb.link"
	);
	
	public function getContent($id) {
		$page = $this->fetchRow("id={$id}");
		$page = $this->prepareInPlaceEditorContent($page);
		return $page->content;
	}
	public function getPageByUrlKeySmart($urlKey = null) {
		if($urlKey!=null){
			$page = $this->getPageByUrlKey($urlKey);
		}else{
			$bindValues[':type'] = self::TYPE_LANG_CATALOG;
			if (is_numeric(LANG)) {
				$mainPageLangWhere = " AND id=:id";
				$bindValues[':id'] = LANG;
			}
			$usersDB = new usersDB();
				
			if ($usersDB->getLoggedIn('AdminUser')!=null){
				$page = $this->fetchRow( "type = :type" . $mainPageLangWhere, 'position ASC', '*', $bindValues );
			}elseif($usersDB->getLoggedIn()!=null){
				$bindValues[':status'] = self::STATUS_ACTIVE;
				$page = $this->fetchRow( "type = :type AND status = :status" . $mainPageLangWhere, 'position ASC', '*', $bindValues );
			}else{
				$bindValues[':logged'] = 0;
				$bindValues[':status'] = self::STATUS_ACTIVE;
				$page = $this->fetchRow("type = :type AND status = :status  AND logged = :logged" . $mainPageLangWhere, 'position ASC', '*', $bindValues );
			}
			$page = $this->prepareInPlaceEditorContent($page);
		}
		return $page;
	}

	public function getPageByUrlKey($urlKey = null) {
		$usersDB = new usersDB();
		if ($usersDB->getLoggedIn('AdminUser')!=null) {
			$page = $this->fetchRow("urlKey = :urlKey", null, '*', array( ':urlKey' => $urlKey ) );
			$page = $this->prepareInPlaceEditorContent($page);
			return $page;
		}elseif($usersDB->getLoggedIn()!=null){
			$page = $this->fetchRow("urlKey = :urlKey AND status = :status", null, '*', array( ':urlKey' => $urlKey , ':status' => pagesDB::STATUS_ACTIVE ) );
			$page = $this->prepareInPlaceEditorContent($page);
			return $page;			
		}
		$page = $this->fetchRow("urlKey = :urlKey AND status = :status AND logged = :logged", null, '*', array( ':urlKey' => $urlKey, ':status' => pagesDB::STATUS_ACTIVE, ':logged' => 0) );
		$page = $this->prepareInPlaceEditorContent($page);
		return $page;
	}
	public function getPagesByParent($parentId=0,$where=null,$sort='position ASC',$what='*',$limit = null,$group=null,$status=false,$bindValues=array()){
		$usersDB = new usersDB();
		if ($where!=null){$where = " AND ".$where;}
		if ($status==true)
		{
			$where = " AND status = :status" . $where;
			$bindValues[':status']  = self::STATUS_ACTIVE;
		}
		if($usersDB->getLoggedIn()==null){
			$where = " AND logged = :logged" . $where;
			$bindValues[':logged'] = 0;
		}

		$bindValues[':parentId']  = $parentId;
		$pages = $this->fetchAll("parentId = :parentId $where",$sort,$what,$limit,$group,$bindValues);
		return $pages;
	}
	public function getPagesByParentMulti($parentId,$where=null,$sort='position ASC',$what='*',$limit = null,$group=null,$status=false,$bindValues=array()){
		$usersDB = new usersDB();
		if ($where!=null){$where = " AND ".$where;}
		if ($status==true)
		{
			$where = " AND status = :status" . ' '.$where;
			$bindValues[':status'] = self::STATUS_ACTIVE;
		}
		if($usersDB->getLoggedIn()==null){
			$where = " AND logged = :logged" . $where;
			$bindValues[':logged'] = 0;
		}	
		if (is_array($parentId)){
            $parentIds = '';
			foreach ($parentId as $pid){
				$parentIds .= intval($pid).',';
			}
			$parentIds = rtrim($parentIds,',');
		}else{
			$parentIds = $parentId;
		}
		$pages = $this->fetchAll("parentId in ({$parentIds}) $where",$sort,$what,$limit,$group,$bindValues);
		return $pages;
	}

	//return pages by language
	public function getPages($parentId=0,$where=null,$sort='position ASC',$what='*',$limit = null,$group=null,$status=false,$bindValues=array()){
		$parentId = $this->getLanguage($parentId);
		return $this->getPagesByParent($parentId,$where,$sort,$what,$limit,$group,$status,$bindValues);
	}
	public function getNews($parentId,$limit=null,$start=0,$where=null) {
		if ($limit==null){$limit = config::get('newsCount');}
		$limit = $start.','.$limit;
		if(!is_array($parentId)){
			$parentId = array($parentId);
		}
		return $this->getPagesByParentMulti($parentId,"date <= '".generate::sqlDatetime()."' AND status = ".self::STATUS_ACTIVE,'date DESC, id DESC','*',$limit);
	}
	public function hasChild($id,$typeWhere=null){
		if ($typeWhere!=null) {
			$typeWhere = ' and '.$typeWhere;
		}
		if ($this->fetchCount("parentId = :id and status!=".self::STATUS_DELETE.$typeWhere, array( ':id' => $id ) )>0){return TRUE;}else{return FALSE;}
	}
	public function hasActivePagesIdArray($urlKey) {
		if ($urlKey==null) return array();
		$page = $this->fetchRow("urlKey = :urlKey",null,'*',array( ':urlKey' => $urlKey ) );

		$ids[] = $page->id;
		while ($page->parentId != 0) {
			$page = $this->fetchRow("id = $page->parentId");
			$ids[] = $page->id;
		}

		return $ids;
	}
	public function insert(array $data = array(),$startData = true)
	{
		$usersDB = new usersDB();
		
		if(is_numeric($data['status'])){
			$data['status'] = $data['status'];
		}else{
			$data['status'] = self::STATUS_ACTIVE;
		}
		
		$data['urlKey'] = generate::urlKey($data['name'],$this);
		
		if ($startData) {
			$data['lock'] = 0;
			if ($data['position']==null) {
				$lastGroup = $this->fetchRow("parentId = {$data['parentId']}",'position DESC');
				$data['position'] = intval($lastGroup->position) + 1;
			}

			$data['rate'] = 0;
			$data['hasIcon'] = 0;
			$data['hasImage'] = 0;
			$data['authorId'] = $usersDB->getLoggedIn()->id;
			$data['langId'] = $this->checkLanguageById($data['parentId']);
			$data['logged'] = 0;
			
			if ($data['type']<10){
				$data['searchable'] = 1;
			}else{
				$data['searchable'] = 0;
			}
	
			if ($data['tpl'] == ''){
				$defaultTpl = $this->get($data['parentId'], 'defaultTpl');
				if($defaultTpl!=null){
					$data['tpl']=$defaultTpl;
				}else{
					$data['tpl']=themesDB::$basicTpl;
				}
			}
			if (!empty($data['tags'])) {
				$data['tags'] = $this->prepareTags($data['tags']);
			}			
		}
		
		parent::insert($data);

		$thisPageId = $this->fetchRow("urlKey = :urlKey","id DESC", "*", array( ':urlKey' => $data['urlKey'] ) )->id;
		if ($startData) {
			if ($data['type'] == self::TYPE_GALLERY){
				$dataUpdate['content']='{{W name=galleryFancybox images=$imagesDB->getByBucket('.$thisPageId.')}}';
			}elseif ($data['type'] == self::TYPE_NEWS_GROUP){
				$dataUpdate['content']='{{W name=newsNormal newsGroup='.$thisPageId.'}}';
			}elseif($data['content']==''){
				$dataUpdate['content']=' ';
			}else{
				$dataUpdate['content']=$data['content'];
			}
			$dataUpdate['content'] =  html_entity_decode($dataUpdate['content']);
			$this->updateRow($dataUpdate,"id={$thisPageId}");
            cache::setCleanCacheFlag();
        }
		return $thisPageId;
	}
	public function updatePage($column, $where = null, $urlKeyRegenerate = true, $pageBackup = true, $bindValues = array() )
	{
		$column['content'] = str_replace(HOME, '{{$HOME}}', $column['content']);
		$page = $this->fetchRow($where, null, '*', $bindValues);
		if ($column['content'] != $this->fetchRow($where, null, '*', $bindValues)->content and $pageBackup) {
			$pagesBackupDB = new pagesbackupsDB();
			$pagesBackupDB->backupPage($where);
		}

		if($urlKeyRegenerate){

			$actualPage = $this->fetchRow($where, null, '*', $bindValues);
			
			$actualEkey = $actualPage->urlKey;
			$generatedEkey = generate::urlKey($column['name'],$this);
			$name = $actualPage->name;

			if($column['urlKey']==null){
				$column['urlKey'] = $generatedEkey;
			}elseif($name != $column['name'] and (substr($actualEkey, 0, -2)==substr(generate::urlKey($name,$this), 0, -2) or $actualEkey==substr(generate::urlKey($name,$this), 0, -2)) and $actualPage->parentId!=0){
				$column['urlKey'] = $generatedEkey;
			}elseif($this->fetchCount("id!={$actualPage->id} and urlKey='{$column['urlKey']}'")!=0){
				$column['urlKey'] = $generatedEkey;				
			}else{
				$column['urlKey'] = generate::prepareUrlKey($column['urlKey']);
			}
		}
		if (strlen($column['tags'])>2) {
			$column['tags'] = $this->prepareTags($column['tags']);
		}
		
		$column['content'] =  html_entity_decode($column['content']);
		
		
		if ($page->type == self::TYPE_LANG_CATALOG and $column['name']!=$page->name and $column['name']!='') {
			
			$column['name'] = strtoupper(generate::cleanFileName($column['name']));
			
			$oldname = LANGUAGES_PATH.$page->name.'/';
			$newname = LANGUAGES_PATH.$column['name'].'/';
			
			baseFile::rename($oldname, strtolower($newname));
		}		
		
		parent::updateRow($column, $where);
        cache::setCleanCacheFlag();

    }
	public function addLang($data) {
		$data = array_merge($data,array('parentId'=>0,'type'=>self::TYPE_LANG_CATALOG));

		$langName = strtolower($data['name']);
		baseFile::createDir(LANGUAGES_PATH.$langName.'/');
		foreach (lang::$langFiles as $file){
			baseFile::saveFile(LANGUAGES_PATH.$langName.'/'.$file, file_get_contents(LANGUAGES_PATH.LANG.'/'.$file));
		}
		$data['name'] = strtoupper($data['name']);
		$this->insert($data);
		$addedLanguage = $this->fetchRow("parentId=0 and name='{$data['name']}'","id desc");
		$this->updateRow(array('langId'=>$addedLanguage->id),"id={$addedLanguage->id}");
	}
	public function deleteTreeItems($id,$finalDelte = false) {
		$page = $this->fetchRow("id=:id", null, '*', array( ':id' => $id ) );
		if($finalDelte==true){
			$this->delete($id);
		}else{
			$this->set($id,'status',self::STATUS_DELETE);
		}
		$dependentItems = $this->fetchAll("parentId = {$page->id}");
		foreach ($dependentItems as $item){
			$this->deleteTreeItems($item->id,$finalDelte);
		}
	}
	public function deleteTrashItems(){

		$idS = $this->fetchAll('status = '.self::STATUS_DELETE,null,'id');
        $idString = '';
		foreach ($idS as $id){
			$idString .= $id->id.',';
		}
		$idString = rtrim($idString,',');
		image::deleteImage("bucket in({$idString})");

		return $this->deletePages('status = '.self::STATUS_DELETE);
	}
	public function delete($id) {
		$id = $this->fetchRow("id=:id", null, '*', array( ':id' => $id ))->id;

		//Delete page images
		image::deleteImage("bucket = '{$id}' or bucket = 'main-{$id}' or bucket = 'icon-{$id}' or bucket = 'slider-{$id}'");

		//Delete page backups
		$pagebackupsDB = new pagesbackupsDB();
		$pagebackupsDB->deleteAllByBucket($id);

		//Delete page comments
		$commentsDB = new commentsDB();
		$commentsDB->deleteAllByBucket($id);

		parent::delete($id);
	}
	public function deletePages($where, $bindValues = array()) {
		$pagesToDelete = $this->fetchAll($where, null, '*', null, null, $bindValues);
		foreach($pagesToDelete as $page){
			$this->delete($page->id);
		}
	}

	public function restoreTreeItems($id){
		$page = $this->fetchRow("id=:id", null, '*', array( ':id' => $id ));
		$this->set($id,'status',self::STATUS_ACTIVE);

		if($page->type == self::TYPE_LANG_CATALOG){
			$this->set($id,'parentId',self::PARENTID_LANGUAGE);
		}
		elseif($this->fetchCount("id={$page->parentId} and status!=0")==0){
			$this->set($id,'parentId',self::PARENTID_NOPARENT);
		}
		$dependentItems = $this->fetchAll("parentId = {$page->id}");
		if($dependentItems!=null)
		{
			foreach ($dependentItems as $item){
				$this->restoreTreeItems($item->id);
			}
		}

	}

	//TODO - ustawianie metatagow poprawnie jak puste
	public function meta($page) {
		$meta = new stdClass();
		if ($page->title != null) {
			$meta->title = $page->title;
		}else{
			$meta->title = $page->name;
		}

		if ($page->description != null) {
			$meta->description = $page->description;
		}else{
			$meta->description = $page->name;
		}

		if ($page->keywords != null) {
			$meta->keywords = $page->keywords;
		}else{
			$meta->keywords = $page->name;
		}

		return $meta;
	}
	public function addView($id){
		$page = $this->fetchRow("id=:id", null, '*', array( ':id' => $id ) );
		$this->set($id, 'views', $page->views + 1);
	}
	public function checkParentsOpen($clickedIdArray,$page){
		if ($clickedIdArray[$page->id]==1) {
			return TRUE;
		}else{
			if (is_array($clickedIdArray)) {
				foreach ($clickedIdArray as $key => $value){
					$actualPage = $this->fetchRow("id = :id", null, '*', array( ':id' => $key ));
					while ($actualPage != null) {
						$actualPage = $this->fetchRow("id = :id", null, '*', array( ':id' => $actualPage->parentId ) );
						if($page->id == $actualPage->id){
							return TRUE;
						}
					}
				}
			}
		}
		return FALSE;
	}
    public function updateLangId($id,$langId){
        $parentPages = $this->fetchAll("parentId={$id}");
        if(count($parentPages)>0){
            foreach($parentPages as $page){
                $this->update('langId',$langId,"id={$page->id}");
                if($this->fetchCount("parentId={$page->id}")>0){
                    $this->updateLangId($page->id,$langId);
                }
            }
        }
    }


	public static function getMainImageEkey($pageId,$type = 'main') {
		$imagesDB = new imagesDB();
		$image = $imagesDB->getFirstByBucket($type.'-'.$pageId);
		if (is_object($image)) {
			return $image->ekey;
		}else{
			return null;
		}
	}
	public static function getImages($pageId,$type = 'slider') {
		$imagesDB = new imagesDB();
		$images = $imagesDB->getByBucket($type.'-'.$pageId);
		return $images;
	}
	public static function getMainImageEkeySmart($pageId,$type = 'main') {
		$pagesDB = new pagesDB();
		$image = self::getMainImageEkey($pageId,$type);
		$parentId = $pagesDB->get($pageId, 'parentId');

		while ($image==null and $parentId!=0) {
			$image = self::getMainImageEkey($parentId,$type);
			$parentId = $pagesDB->get($parentId, 'parentId');
		}
		if ($image==null) {
			$image = self::getMainImageEkey($parentId,$type);
		}
		return $image;
	}
	public static function getSliderImagesSmart($pageId,$type = 'slider') {
		$pagesDB = new pagesDB();
		$image = self::getMainImageEkey($pageId,$type);
		$parentId = $pagesDB->get($pageId, 'parentId');

		while ($image==null and $parentId!=0) {
			$image = self::getMainImageEkey($parentId,$type);
			$parentId = $pagesDB->get($parentId, 'parentId');
		}
		if ($image==null) {
			$image = self::getMainImageEkey($parentId,$type);
		}
		return $image;
	}
	public function getContentByLangKey($langKey,$column) {
		$pageId = lang::read($langKey);
		if (is_numeric($pageId)) {
			return $this->get($pageId,$column);
		}
		return null;
	}
	public function prepareInPlaceEditorContent($page) {
		$user = usersDB::getLoggedUser('AdminUser');
		$inplaceConfigVarName =  "inPlaceEditor{$user->id}";

		if (config::get($inplaceConfigVarName) and $user!=null and $page->type != self::TYPE_URL and $page!=null and config::get('leftOpenMenu')==1 and config::get('showLeftEditor'.$user->id)==1) {
			$contentprepared = str_replace('{{$HOME}}',HOME, $page->content);
			$contentprepared = str_replace('{{', '<pre class="inline-widget">&#123;&#123;', $contentprepared);
			$contentprepared = str_replace('}}', '&#125;&#125;</pre>', $contentprepared);
				
			$page->content = "<div contenteditable='true' id='content_{$page->id}'>".$contentprepared."</div>
							  <div class='inline-save'>
							  <button class='btn btn-primary' onclick='saveInPlaceEditorContent({$page->id})'>Save</button>
							  	<a href='#modal' class='btn btn-margin-left' data-toggle='modal' data-target='#imagesModal'>Image</a>
								<a href='#modal' class='btn btn-margin-left' data-toggle='modal' data-target='#filesModal'>File</a>
								<a href='#modal' class='btn btn-margin-left' data-toggle='modal' data-target='#widgetsModal'>Widget</a>
							  <div class='inline-save-info' id='saveinfo_content_{$page->id}'></div></div>";
				
			return $page;
		}
		return $page;
	}

	//TODO dorobic cache
	public function getAllKeywords(){
		$whereFinal = "status = ".self::STATUS_ACTIVE." and (keywords!='' or keywords!=' ')";
		$keywords = $this->fetchAll($whereFinal,null,"id,keywords");
        $finalList = '';
		foreach ($keywords as $keyword){
			if (strlen($keyword->keywords)>2) {
				$finalList .= rtrim($keyword->keywords,',').',';
			}
		}
		rtrim($finalList,',');
		$keywordsArray = explode(',',$finalList);
		unset($keywordsArray[count($keywordsArray)-1]);
		return array_unique($keywordsArray);
	}
	
	public function getAllTags($where = null,$limit=null, $bindValues = array(), $simpleList = false) {
		if($where!=null){
			$whereFinal = $where.' AND ';
		}
		$whereFinal .= "status = ".self::STATUS_ACTIVE." and (tags!='' or tags!=' ')";

		$tags = $this->fetchAll($whereFinal,null,"id,tags",null,null,$bindValues);
        $finalList = '';
		if ($simpleList) {
			foreach ($tags as $tag){
				if (strlen($tag->tags)>2) {
					$finalList .= rtrim($tag->tags,',').',';
				}
			}
			rtrim($finalList,',');
			$tagsArray = explode(',',$finalList);
			unset($tagsArray[count($tagsArray)-1]);
			return array_unique($tagsArray);
		}

		if ($tags!=null) {
            $finalTags = null;
			foreach($tags as $tagPage){
				$tagPageArray = explode(',', $tagPage->tags);
				foreach ($tagPageArray as $singleTag){
					$singleTag = trim($singleTag,' ');
					$singleTagKey = generate::cleanLinkKey($singleTag);
					if (!empty($singleTag)) {
						if ($finalTags[$singleTagKey]['count'] > 0) {
							$finalTags[$singleTagKey]['count'] = $finalTags[$singleTagKey]['count'] + 1;
						}else{
							$finalTags[$singleTagKey]['count'] = 1;
							$finalTags[$singleTagKey]['name'] = $singleTag;
						}
					}
				}
			}
			$tagsList = generate::subvalArraySort($finalTags, 'count', 'arsort');
				
			if ($limit!=null) {
				$counter = 0;
				foreach ($tagsList as $key => $tag){
					$returnedTags[$key] = $tag;
					$counter = $counter+1;
					if($counter>=$limit){
						return $returnedTags;
					}
				}
			}
			return $tagsList;
		}else{
			return null;
		}
	}
	public function getPagesByTag($tagString,$where=null,$sort='createTime DESC',$what='*',$limit = null,$bindValues = array()) {

		$langId = $this->getLanguage();
		if($where!=null){
			$where = ' and '.$where;
		}
		$bindValues[':tagString'] = "%{$tagString}%";
		$bindValues[':langId'] = $langId;
		$pages = $this->fetchAll("(`tags` LIKE :tagString) and langId = :langId and status = ".self::STATUS_ACTIVE.$where,$sort,$what,$limit,null,$bindValues);
		return $pages;
	}
	//TODO dorobic liczenie znalezionych fraz
	public function fetchSearch($searchText,array $columns, $where = null, $order = null, $what = '*', $limit = null, $groupby = null, $bindValues = array() ) {
		$langId = $this->getLanguage();

		$whereSearchBasic = "(date <= '".generate::sqlDatetime()."' OR date is null) AND status=1 AND searchable=1 and langId = {$langId}";
        $whereFin = '';
		if($where==null){
			$whereFin.= $whereSearchBasic;
		}else{
			$whereFin.= $where." AND ".$whereSearchBasic;
		}

		$pages = $this->fetchTextSearch($searchText,$columns,$whereFin,$order,$what,$limit,$groupby,$bindValues);
		return $pages;
	}
	private function prepareTags($tagsString) {
		$tagsString = str_replace(', ', ',', $tagsString);
		$tagsString = str_replace(' ,', ',', $tagsString);
		$tagsString = generate::cleanLinkKey($tagsString);
		return $tagsString;
	}
	public function checkLanguageById($id){
		$parent = $id;
		while ($parent!=0) {
			$parentPom = $this->fetchRow("id = :parent", null, '*', array(':parent' => $parent));
			$parent = $parentPom->parentId;
		}
		return $parentPom->id;
	}
	public function getAllPagesSmart($where = null, $order = null, $what = '*', $limit = null, $groupby = null, $bindValues = array()) {
		$parentId = $this->getLanguage();
		$where = $where." AND langId = {$parentId} AND status = ".self::STATUS_ACTIVE;
		$where = ltrim($where,' AND ');

		$pages = $this->fetchAll($where, $order, $what, $limit, $groupby, $bindValues);
		return $pages;
	}
	public function getAllBucketPagesSmart($masterId=0,$where = null, $order = null, $what = '*', $limit = null, $groupby = null, $bindValues = array()) {
		$idS = rtrim($this->getDependentIdListString($masterId),',');
		if ($where!=null)$where = "id in({$idS}) AND ".$where; else $where = "id in({$idS})";

		$pages = $this->getAllPagesSmart($where, $order, $what, $limit, $groupby, $bindValues);
		return $pages;
	}
	private function getLanguage($parentId = 0) {
		if (LANG==null and $parentId==0) {
			$defLang = $this->fetchRow("parentId = 0","position ASC");
			$parentId = $defLang->id;
		}elseif($parentId==0){
			$parentId = LANG;
		}
		return $parentId;
	}
	public function getDependentIdListString($masterId) {
		$pages = $this->fetchAll("parentId = :masterId",null,'id',null,null,array( ':masterId' => $masterId ) );
        $idS = '';
		foreach ($pages as $page) {
			$idS .= $page->id.',';
			$idS .= $this->getDependentIdListString($page->id);
		}
		return $idS;
	}
	public function getGroupsArrayForWidgetInserter($type = 'type>=10',$sort = null){
		$groups = $this->fetchAll("{$type} AND status = ".self::STATUS_ACTIVE,$sort);
		if (!is_array($groups)) {
			return null;
		}
		foreach ($groups as $group){
			$groupArray[$group->id]=$group->name;
		}
		return $groupArray;
	}
	public function getTypes() {
		foreach ($this->types as $key=>$name){
			$finbisArray[$key] = lang::read($name);
		}
		return $finbisArray;
	}
	public function duplicateItem($id,$parentId = 0) {
		$mainPage = $this->fetchRow("id={$id}",null,'*',array(),PDO::FETCH_ASSOC);
		
		$mainPage['parentId'] = $parentId;

		if ($parentId==0) {
			$oldMainPageName = $mainPage['name'];
			$mainPage['name'] = $oldMainPageName.'-copy';
		}
		unset($mainPage['id']);
		unset($mainPage['createTime']);
		unset($mainPage['updateTime']);
		unset($mainPage['createIP']);
		unset($mainPage['updateIp']);
		unset($mainPage['urlKey']);
		
		$newId = $this->insert($mainPage,false);
		
		$dependentPages = $this->fetchAll("parentId={$id} and status!=".pagesDB::STATUS_DELETE);
		
		if (is_array($dependentPages)) {
			foreach ($dependentPages as $dependentPage) {
				$this->duplicateItem($dependentPage->id,$newId);
			}
		}
		
		if ($mainPage['type'] == self::TYPE_LANG_CATALOG) {
			$src = LANGUAGES_PATH.$oldMainPageName.'/';
			$dst = LANGUAGES_PATH.$mainPage['name'].'/';
			baseFile::copyDir($src, $dst);
		}		
	}
	public function getPageUsersContent($status) {
		$usersDB = new usersDB();
		$pageUsers = $usersDB->getUsers(usertypesDB::BUCKET_PAGE);
        $userIdStrings = '';
		foreach ($pageUsers as $user) {
			$userIdStrings .= $user->id.',';
		}
		$userIdStrings = rtrim($userIdStrings,',');
		if ($userIdStrings==null) {
			$pages = $this->fetchAll("status = {$status} and (authorId=null)");
		}else{
			$pages = $this->fetchAll("status = {$status} and (authorId=null or authorId in ({$userIdStrings}))");
		}
		

		return $pages;
	}
	public function getCustomFieldsArray() {
		foreach ($this->fetchRow() as $key => $val){
			if (preg_match('/cf_*/', $key)) {
				$parts = explode('_', $key);
				$finalArray[$parts[1]] = $parts[2];
			}
		}
		return $finalArray;
	}
	public static function getPageById($id) {
		$pagesDB = new pagesDB();
		return $pagesDB->fetchRow("id='{$id}'");
	}
}
?>
