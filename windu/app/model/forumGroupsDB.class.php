<?php /*windu.org model*/
class forumGroupsDB extends ekeyDB
{
	public function add($data) {
		$data['status'] = 1;
		$data['postsCount'] = 0;
		$data['topicsCount'] = 0;
		
		$lastGroup = $this->fetchRow("forumId = {$data['forumId']}",'id DESC');
		$data['position'] = intval($lastGroup->position) + 1;		
		
		$this->insert($data);
		
		$forumsDB = new forumsDB();
		$forumsDB->set($data['forumId'], 'groupsCount', intval($forumsDB->get($data['forumId'], 'groupsCount'))+1);
	}
	public function deleteById($id) {
		$forumTopicsDB = new forumTopicsDB();
		$forumTopicsDB->deleteByGroupId($id);

		//Actualize counter
		$forumsDB = new forumsDB();
		$forumId = $this->get($id, 'forumId');
		$forumsDB->set($forumId, 'groupsCount', intval($forumsDB->get($forumId, 'groupsCount'))-1);
		
		return $this->delete($id);
	}
	public function deleteByForumId($forumId) {
		$groups = $this->fetchAll("forumId = {$forumId}");
		foreach ($groups as $group){
			$this->deleteById($group->id);
		}
		return true;
	}	
	public function getLastPost($groupId) {
		$forumTopicsDB = new forumTopicsDB();
		$topics = $forumTopicsDB->fetchAll("status!=0 and groupId={$groupId}");
		
		foreach ($topics as $topic){
			$ids.=$topic->id.',';
		}
		$topicsIds = rtrim($ids,',');
		
		$forumPostsDB = new forumPostsDB();
		$lastPost = $forumPostsDB->getPost("topicId in({$topicsIds}) and status!=0",'createTime DESC');
		
		return $lastPost;
	}
}
?>