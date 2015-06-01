<?php /*windu.org model*/
class forumReadedLogDB extends baseDB
{
	function __construct($customMySQL = array())
	{
		$this->otherDbFile = FILE_DB_LOG_FILE;
		parent::__construct($customMySQL);
	}		
	public function add($userId,$topicId,$gorupId)
	{
		if ($this->fetchRow("userId = {$userId} and topicId = {$topicId}")==null) {
			$this->insert(array('userId'=>$userId,'topicId'=>$topicId,'groupId'=>$gorupId));
		}
	}
	public function getReadedArrayByUser($userId) {
		return $this->fetchAll("userId = {$userId}",null,'topicId',null,null,array(),PDO::FETCH_COLUMN);
	}
	public function getReadedGroupCountByUser($userId,$groupId) {
		return $this->fetchCount("userId = {$userId} and groupId = {$groupId}");
	}	
	public function setAllTopicReaded($userId,$groupEkey) {
		$forumGroupDB = new forumGroupsDB();
		$forumTopicsDB = new forumTopicsDB();
		
		$group = $forumGroupDB->fetchRow("ekey = '{$groupEkey}'");
		
		$topics = $forumTopicsDB->fetchAll("groupId = {$group->id}");
		foreach ($topics as $topic){
			$this->add($userId, $topic->id, $group->id);
		}
		return true;		
	}
}
?>