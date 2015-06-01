<?php /*windu.org model*/
Class forumMostViewedController extends widgetMainController
{
    public function run() {
        $forumPostsDB = new forumPostsDB();
        $forumTopicsDB = new forumTopicsDB();
        $users = new usersDB();

        //debugger::dprint($forumTopicsDB->fetchCountGroup('id',null,'postsCount DESC','*', null));
        //debugger::dprint($forumTopicsDB->fetchCountGroup('id',null,'views DESC','*', null));

        return array("forumPostsDB" => $forumPostsDB, "forumTopicsDB" => $forumTopicsDB,"users" => $users);
    }
}
?>