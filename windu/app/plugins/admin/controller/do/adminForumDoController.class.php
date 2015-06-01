<?php /*windu.org admin controller*/
Class adminForumDoController Extends adminAuthDoController{
	public function deleteForum() {
		$forumsDB = new forumsDB();
		$forumsDB->deleteById($this->request->getVariable('id'));
	}
	public function deleteGroup() {
		$forumGroupsDB = new forumGroupsDB();
		$forumGroupsDB->deleteById($this->request->getVariable('id'));
	}	
	public function deleteTopic() {
		$forumTopicsDB = new forumTopicsDB();
		$forumTopicsDB->deleteById($this->request->getVariable('id'));
	}		
	public function deletePost() {
		$forumPostsDB = new forumPostsDB();
		$forumPostsDB->deleteById($this->request->getVariable('id'));
	}	
	
	public function forumUp() {
		$forumsDB = new forumsDB();
		
		$elementToMove = $forumsDB->fetchRow("id = {$this->request->getVariable('id')}");
		$elementBefore = $forumsDB->fetchRow("position<{$elementToMove->position}",'position DESC');
		
		if ($elementBefore!=null) {
			$forumsDB->set($elementBefore->id, 'position', $elementToMove->position);
			$forumsDB->set($elementToMove->id, 'position', $elementBefore->position);
		}
		router::back($this->request);
	}	
	
	public function forumDown() {
		$forumsDB = new forumsDB();
		
		$elementToMove = $forumsDB->fetchRow("id = {$this->request->getVariable('id')}");
		$elementAfter = $forumsDB->fetchRow("position>{$elementToMove->position}",'position ASC');
		
		if ($elementAfter!=null) {
			$forumsDB->set($elementAfter->id, 'position', $elementToMove->position);
			$forumsDB->set($elementToMove->id, 'position', $elementAfter->position);
		}
		router::back($this->request);
	}	
	
	public function groupUp() {
		$forumGroupsDB = new forumGroupsDB();
		
		$elementToMove = $forumGroupsDB->fetchRow("id = {$this->request->getVariable('id')}");
		$elementBefore = $forumGroupsDB->fetchRow("position<{$elementToMove->position} and forumId = {$elementToMove->forumId}",'position DESC');
		
		if ($elementBefore!=null) {
			$forumGroupsDB->set($elementBefore->id, 'position', $elementToMove->position);
			$forumGroupsDB->set($elementToMove->id, 'position', $elementBefore->position);
		}
		router::back($this->request);
	}	
	
	public function groupDown() {
		$forumGroupsDB = new forumGroupsDB();
		
		$elementToMove = $forumGroupsDB->fetchRow("id = {$this->request->getVariable('id')}");
		$elementAfter = $forumGroupsDB->fetchRow("position>{$elementToMove->position} and forumId = {$elementToMove->forumId}",'position ASC');
		
		if ($elementAfter!=null) {
			$forumGroupsDB->set($elementAfter->id, 'position', $elementToMove->position);
			$forumGroupsDB->set($elementToMove->id, 'position', $elementAfter->position);
		}
		router::back($this->request);
	}		
}
?>
