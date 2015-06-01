<?php /*windu.org model*/
Class forumHotTopicsController extends widgetMainController
{		
	public function run() {
		$forumPostsDB = new forumPostsDB();
        $forumTopicsDB = new forumTopicsDB();
        $forumGroupsDB = new forumGroupsDB();
        $usersDB = new usersDB();

        //debugger::dprint($this->request->getVariable('urlKey'));
        //debugger::dprint($forumPostsDB->fetchRow("topicId", 'updateTime DESC'));
		return array("forumPostsDB" => $forumPostsDB, "forumTopicsDB" => $forumTopicsDB,"forumGroupsDB" => $forumGroupsDB,"usersDB" => $usersDB);
	}
}
?>