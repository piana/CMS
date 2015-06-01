<?php /*windu.org model*/
class forumsDB extends ekeyDB
{
	public function add($data) {
		$data['status'] = 1;
		$data['postsCount'] = 0;
		$data['topicsCount'] = 0;
		$data['groupsCount'] = 0;
		
		$lastForum = $this->fetchRow('id>0','id DESC');
		$data['position'] = intval($lastForum->position) + 1;
		
		$this->insert($data);
	}
	public function deleteById($id) {
		$forumGroupsDB = new forumGroupsDB();
		$forumGroupsDB->deleteByForumId($id);
		return $this->delete($id);
	}
	public function getSelectArray() {
		foreach ($this->fetchAll() as $forum){
			$finalArray[$forum->id] = $forum->name;
		}
		return $finalArray;
	}
}
?>