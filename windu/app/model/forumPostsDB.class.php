<?php /*windu.org model*/
class forumPostsDB extends ekeyDB
{
	public function add($data) {
		$data['status'] = 1;
		$data['authorId'] = usersDB::getLoggedUser()->id;
		$this->insert($data);
		
		//Actualize counter
		$forumTopicsDB = new forumTopicsDB();
		$topicId = $data['topicId'];
		$forumTopicsDB->set($topicId, 'postsCount', intval($forumTopicsDB->get($topicId, 'postsCount'))+1);			
		
		$forumGroupsDB = new forumGroupsDB();
		$groupId = $forumTopicsDB->get($topicId, 'groupId');
		$forumGroupsDB->set($groupId, 'postsCount', intval($forumGroupsDB->get($groupId, 'postsCount'))+1);			
		
		$forumsDB = new forumsDB();
		$forumId = $forumGroupsDB->get($groupId, 'forumId');
		$forumsDB->set($forumId, 'postsCount', intval($forumsDB->get($forumId, 'postsCount'))+1);	

		$user = usersDB::getLoggedUser();
		$forumReadedLog = new forumReadedLogDB();
		$forumReadedLog->deleteRows("userId!={$user->id} and topicId={$topicId}");		
	}	
	public function deleteById($id) {
		
		//Actualize counter
		$forumTopicsDB = new forumTopicsDB();
		$topicId = $this->get($id, 'topicId');
		$forumTopicsDB->set($topicId, 'postsCount', intval($forumTopicsDB->get($topicId, 'postsCount'))-1);
		
		$forumGroupsDB = new forumGroupsDB();
		$groupId = $forumTopicsDB->get($topicId, 'groupId');
		$forumGroupsDB->set($groupId, 'postsCount', intval($forumGroupsDB->get($groupId, 'postsCount'))-1);			
		
		$forumsDB = new forumsDB();
		$forumId = $forumGroupsDB->get($groupId, 'forumId');
		$forumsDB->set($forumId, 'postsCount', intval($forumsDB->get($forumId, 'postsCount'))-1);			
		
		return $this->delete($id);
	}	
	public function deleteByTopicId($topicId) {
		$posts = $this->fetchAll("topicId = {$topicId}");
		
		foreach ($posts as $post){
			$this->deleteById($post->id);
		}
		return true;
	}
	public function getPost($where = null, $order = null, $what = '*', $bindValues = array(), $fetchType = PDO::FETCH_OBJ) {
		$usersDB = new usersDB();
		$post = $this->fetchRow($where, $order, $what, $bindValues, $fetchType);

		if ($post->authorId!=null) {
			$post->author = $usersDB->fetchRow("id={$post->authorId}");
		}

		return $post;
	}
	public function getPosts($topicId) {
		$usersDB = new usersDB();
		$posts = $this->fetchAll("topicId={$topicId} and status!=0","id ASC");

		foreach ($posts as $post){
			if (is_numeric($post->authorId)) {
				$post->author = $usersDB->fetchRow("id={$post->authorId}");
			}else{
				$post->author = null;
			}
			$finalPosts[] = $post;
		}
		return $finalPosts;
	}
}
?>