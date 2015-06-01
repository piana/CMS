<?php /*windu.org model*/
class pagesbackupsDB extends baseDB
{
    public function insert(array $data = array())
    {
		$data['createTime'] = generate::sqlDatetime();
		$data['createIP'] = generate::ip();
		
    	parent::insert($data);
    }  
    public function backupPage($where) {
    	$pagesDB = new pagesDB();
    	$page = $pagesDB->select($where, null, '*', $limit = 1)->fetch(PDO::FETCH_ASSOC);
    	$pageContent = serialize($page);
    	
    	$data['pageContent'] = $pageContent;
    	$data['pageId'] = $page['id'];
    	
    	$usersDB = new usersDB();
    	$user = $usersDB->getLoggedIn();
    	$data['createUser'] = $user->id;

    	$this->insert($data);
    }
    public function getBackupedPage($where) {
    	$page = $this->fetchRow($where);
		$content = unserialize($page->pageContent);
    	return $content;
    }    
    public function getBackupes($where){
    	return $this->fetchAll($where,'createTime DESC');
    }
    public function getBackupesArray($where){
    	$backups = $this->fetchAll($where,'createTime DESC','id,createTime');
    	
    	foreach ($backups as $value) {
    		$finalArray[$value->id] = $value->createTime;
    	}

    	return $finalArray;
    }
    public function hasRestorePoint($id) {
    	if ($this->fetchCount("pageId={$id}")>0) {
    		return TRUE;
    	};
    	return FALSE;
    }
    public function deleteAllByBucket($pageId){
    	return $this->deleteRows("pageId={$pageId}");
    }
    public function compact($pageId = null) {
    	if ($pageId!=null) {
    		$pageWhere = "pageId = {$pageId}";
    	}else{
    		$pageWhere = null;
    	}
    	$verions = $this->fetchAll($pageWhere);
    	if (!is_array($verions)) {
    		return false;
    	}
    	
    	foreach ($verions as $version){
    		$pageContent = unserialize($version->pageContent);
    		$version->pageContent = $pageContent;
    		$preparedVersions[$version->id]=$version;
    	}

    	
        if (!is_array($preparedVersions)) {
    		return false;
    	}    	
    	
    	foreach ($preparedVersions as $key=>$version){
    		unset($preparedVersions[$key]);
    		
    		foreach ($preparedVersions as $compareVersion){
    			if ($version->pageContent['content']==$compareVersion->pageContent['content']) {
    				$idsToDelete[$compareVersion->id]=1;
    			}
    		}
    	}
    	
        if (!is_array($idsToDelete)) {
    		return false;
    	}     	
    	
    	foreach ($idsToDelete as $key=>$val){
    		$this->delete($key);
    	}
    }
    public function compactAllVersions() {
    	$pages = $this->fetchGroup('pageId',null,null,'id');
    	if (is_array($pages)) {
    	    foreach ($pages as $key => $page){
	    		$this->compact($key);
	    	}
    	}

    }
	public static function compactAllPagesVersions() {
		$pagesBackupDB = new pagesbackupsDB();
		$pagesBackupDB->compactAllVersions();
		return lang::read('pages.backupsdb.class.pagever');
	}    
}
?>
