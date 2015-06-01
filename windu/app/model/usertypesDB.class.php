<?php /*windu.org model*/
class usertypesDB extends baseDB
{
	const BUCKET_SYSTEM = 0;
	const BUCKET_PAGE = 1;
	const BUCKET_SHOP = 2;
	
	public static $panels = array();
	
	public $bucket = array(
		 self::BUCKET_SYSTEM => "admin.content.tpl.bucketsystem",
		 self::BUCKET_PAGE => "admin.content.tpl.bucketpages",
	);	
	
	//panels
	public $contentPanels = array(
		'pages'=>'admin.content.tpl.pages',
		'files'=>'admin.tools.tpl.file',
		'images'=>'admin.tools.tpl.images',
		'banners'=>'admin.tools.tpl.banners',
		'polls'=>'admin.tools.tpl.polls',
		'calendar'=>'admin.tools.tpl.calendar',
		'lang'=>'admin.content.common.tpl.languages',
		'trash'=>'admin.content.tpl.trash',
		'autosave'=>'admin.content.tpl.autosave',
		'configContent'=>'admin.menu.config'
	);	
	public $forumPanels = array(
		'forums'=>'admin.forum.tpl.forums',
		'posts'=>'admin.forum.tpl.posts',
		'stats'=>'admin.forum.tpl.stats',
		'configForum'=>'admin.menu.config'
	);		
	public $usersPanels = array(
		'moderator'=>'admin.tools.tpl.moderator',
		'admins'=>'admin.users.ctpl.admins',
		'users'=>'admin.users.ctpl.users',
		'authorization'=>'admin.users.ctpl.authorization',
        'history'=>'admin.users.ctpl.history',
		'configUsers'=>'admin.menu.config'
	);		
	public $themesPanels = array(
		'themes'=>'admin.themes.tpl.graphictemplates',
		'widgets'=>'admin.themes.tpl.widgets',
		'configThemes'=>'admin.menu.config'
	);	
	public $toolsPanels = array(
		'tools'=>'admin.tools.tpl.tools',
		'monitoring'=>'admin.tools.tpl.monitoring',
		'rss'=>'admin.tools.tpl.rss',
		'seo'=>'admin.tools.tpl.seo',
		'mailing'=>'admin.tools.tpl.mailing',
		'contacts'=>'admin.tools.tpl.contact',
		'database'=>'admin.tools.tpl.database',
		'configTools'=>'admin.menu.config'		
	);		
	public $systemPanels = array(
		'system'=>'admin.system.tpl.system',
		'stats'=>'admin.tools.tpl.stats',
		'notifications'=>'admin.system.tpl.notifications',
		'backup'=>'admin.tools.tpl.backup',
		'log'=>'admin.system.tpl.log',
		'cron'=>'admin.system.tpl.cron',
		'firewall'=>'admin.tools.tpl.firewall',
		'requestlog'=>'admin.tools.tpl.requestlog',
		'licence'=>'admin.system.tpl.license',
		'configSystem'=>'admin.menu.config'		
	);	
	public function getBuckets(){
		foreach ($this->bucket as $key=>$bucket){
			$finalBuckets[$key] = lang::read($bucket);
		}
		return $finalBuckets;
	}
	public static function havePanelPermission($panelName){

		$user = usersDB::getLoggedUser();
		if ($user->superAdministrator==1) {
			return true;
		}
		
		if (count(self::$panels)==0) {
			$userTypesDB = new usertypesDB();
			$panels = unserialize($userTypesDB->fetchRow("id={$user->type}")->panels);
			self::$panels = $panels;
		}

        if(count($panels)==0 or $panels==null){
            return true;
        }

		if (array_key_exists($panelName,self::$panels)) {
			return true;
		}
		return false;
	}
	
	public function add($data)
	{
		$this->insert($data);
	}

	//TODO dorobic logike do kasowania powiazan tak zeby wywalal cale drzewko a nei tylko jedno powiazanie
	public function deleteUserType($id) {
		$type = $this->fetchRow("id = '{$id}'");
		$usersDB = new usersDB();
		
		if($type->extends!=0){
			$usersDB->update('type', $type->extends, "type = '{$id}'");
		}else{
			$usersDB->update('type', $type->extends, "type = '{$id}'");
		}
		$this->update('extends', $type->extends,"extends = '{$id}'");
		$this->deleteRows("id = '{$id}'");
	}	
	public function getByBucket($bucketId,$order = null,$returnIds = false,$coma = false,$arrayByName = false) {
		$types = $this->fetchAll("bucket='{$bucketId}'",$order);
        $typeIds = '';
		if($returnIds or $arrayByName){
			foreach ($types as $type){
				if($coma){
					$typeIds .= $type->id.',';
				}elseif($arrayByName){
					$typeIds[$type->id] = $type->name;
				}else{
					$typeIds[] = $type->id;
				}
			}
			if($coma){$typeIds=rtrim($typeIds,',');}
			return $typeIds;
		}else{
			return $types;
		}
	}
	public function getArray($where = null,$order = null) {
		$types = $this->fetchAll($where,$order);
		$typeArray[0] = lang::read('usertype.db.brak');
		foreach ($types as $type){
			$typeArray[$type->id] = $type->name;
		}
		return $typeArray;
	}
	public function getDependentRegexp($parentId) {
		
		$parent = $this->fetchRow("id = {$parentId}");
		$all[] = $parent->regexp;

		while ($parent->extends != 0) {
			$parent = $this->fetchRow("id = {$parent->extends}");
			$all[]=$parent->regexp;
			if($parent->extends == $parentId) break;
		}
		return $all;
	}

	public function havePromission($user,$className) {
		if ($user->superAdministrator == 1) {
			return true;
		}
		$regexps = $this->getDependentRegexp($user->type);
		foreach ($regexps as $regex) {
			$regexps = explode(',', $regex);
			foreach ($regexps as $reg){
				if(preg_match('/'.$reg.'/', $className)){return true;}
			}
		}
		return false;
	}

}
?>