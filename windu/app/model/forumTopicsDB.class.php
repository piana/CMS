<?php /*windu.org model*/
class forumTopicsDB extends ekeyDB
{
	public function add($data) {
		$data['status'] = 1;
		$data['postsCount'] = 0;
		$data['views'] = 0;	
		
		$topic = $this->insert($data);
		
		//Actualize counter
		$forumGroupsDB = new forumGroupsDB();
		$groupId = $data['groupId'];
		$forumGroupsDB->set($groupId, 'topicsCount', intval($forumGroupsDB->get($groupId, 'topicsCount'))+1);			
		
		$forumsDB = new forumsDB();
		$forumId = $forumGroupsDB->get($groupId, 'forumId');
		$forumsDB->set($forumId, 'topicsCount', intval($forumsDB->get($forumId, 'topicsCount'))+1);		

		return $topic;
	}	
	public function deleteById($id) {
		$forumPostsDB = new forumPostsDB();
		$forumPostsDB->deleteByTopicId($id);
		
		//Actualize counter
		$forumGroupsDB = new forumGroupsDB();
		$groupId = $this->get($id, 'groupId');
		$forumGroupsDB->set($groupId, 'topicsCount', intval($forumGroupsDB->get($groupId, 'topicsCount'))-1);			
		
		$forumsDB = new forumsDB();
		$forumId = $forumGroupsDB->get($groupId, 'forumId');
		$forumsDB->set($forumId, 'topicsCount', intval($forumsDB->get($forumId, 'topicsCount'))-1);		
		
		return $this->delete($id);
	}	
	public function deleteByGroupId($groupId) {
		$topics = $this->fetchAll("groupId = {$groupId}");
		
		foreach ($topics as $topic){
			$this->deleteById($topic->id);
		}
		return true;
	}
	public function addView($topicEkey) {
		$views = intval($this->fetchRow("ekey = '{$topicEkey}'")->views);
		$this->updateRow(array('views'=>$views+1),"ekey = '{$topicEkey}'");
		return true;
	}
	public function getLastPost($topicId) {
		$forumPostsDB = new forumPostsDB();
		$lastPost = $forumPostsDB->getPost("topicId = {$topicId} and status!=0",'createTime DESC');
		
		return $lastPost;
	}	
}
?>