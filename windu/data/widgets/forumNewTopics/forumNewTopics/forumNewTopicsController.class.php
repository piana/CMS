<?php /*windu.org model*/
Class forumNewTopicsController extends widgetMainController
{		
	public function run() {
		$forumTopicsDB = new forumTopicsDB();
        $forumPostsDB = new forumPostsDB();
        $usersDB = new usersDB();
        $pageUrlKey = $this->request->getVariable('urlKey');

		return array("forumTopicsDB" => $forumTopicsDB, "forumPostsDB" => $forumPostsDB, 'usersDB' => $usersDB, 'pageUrlKey' => $pageUrlKey);
	}
}
?>