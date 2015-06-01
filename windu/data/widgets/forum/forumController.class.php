<?php /*windu.org model*/
Class forumController extends widgetMainController
{		
	public function run() {
		$fType = $this->request->getVariable('ftype');
		$fekey = $this->request->getVariable('fekey');
		$pageUrlKey = $this->request->getVariable('urlKey');
		
		$forumsDB = new forumsDB();
		$forumGroupsDB = new forumGroupsDB();
		$forumTopicsDB = new forumTopicsDB();
		$forumPostsDB = new forumPostsDB();
		$forumReadedLog = new forumReadedLogDB();
		$user = usersDB::getLoggedUser();
		
		if (!ctype_alpha($fekey)) {$fekey = null;}
		if (!ctype_alpha($fType)) {$fType = null;}		
		
		if ($fType=='topic') {
			$forumTopicsDB->addView($fekey);
			if ($user!=null) {
				$topic = $forumTopicsDB->getByEkey($fekey);
				$forumReadedLog->add($user->id,$topic->id,$topic->groupId);
			}
		}	
		$readedArray = array();
		if ($user!=null and $fType=='group') {
			$readedArray = $forumReadedLog->getReadedArrayByUser($user->id);
		}			

		//Add Topic//////////////////////////////////////////////////////////////////////
		$formAddTopic = new form('addTopic','addTopicSuccess',$_POST,'POST');
		$formAddTopic->add('name', 'input-text','Tytuł tematu');
		$formAddTopic->addRule('name', 'required', null, lang::read('admin.content.controller.giveelementname'));
        $formAddTopic->add('HTML', '<br>');
		$formAddTopic->add('content', 'textareaCKEditor','',' ',array('editorType'=>'minimal'));
		$formAddTopic->add('fekey', 'input-hidden','',$fekey);
		$formAddTopic->add('urlKey', 'input-hidden','',$this->request->getVariable('urlKey'));
        $formAddTopic->add('HTML', '<br>');
		$formAddTopic->addButton('submit','Dodaj temat','btn btn-primary');
		$formAddTopic->setHandler($this);
		$formAddTopic->handle();		
		
		//Add Post//////////////////////////////////////////////////////////////////////
		$formAddPost = new form('addPost','addPostSuccess',$_POST,'POST');
		$formAddPost->add('content', 'textareaCKEditor','',' ',array('editorType'=>'minimal'));
		$formAddPost->addRule('content', 'required', null, lang::read('admin.content.controller.giveelementname'));
		$formAddPost->add('fekey', 'input-hidden','',$fekey);
		$formAddPost->add('urlKey', 'input-hidden','',$this->request->getVariable('urlKey'));
        $formAddPost->add('HTML', '<br>');
		$formAddPost->addButton('submit','Wyślij','btn btn-primary');
		$formAddPost->setHandler($this);
		$formAddPost->handle();		
		
		return array("pageUrlKey" => $pageUrlKey,
					 "fekey" => $fekey,
					 "listData" => $listData,
					 "listType" => $fType,
					 "forumsDB" => $forumsDB,
					 "forumGroupsDB" => $forumGroupsDB,
					 "forumTopicsDB" => $forumTopicsDB,
					 "forumPostsDB" => $forumPostsDB,
					 "formAddTopic" => $formAddTopic,
					 "formAddPost" => $formAddPost,
					 "readedArray" => $readedArray,
					 "forumReadedLog" => $forumReadedLog,
					 "user" => $user
		);
	}
	public function addTopicSuccess($data) {

		if (usersDB::getLoggedUser()!=null) {
			$forumUrlKey = $this->request->getVariable('urlKey');
			$forumGroupsDB = new forumGroupsDB();
			$group = $forumGroupsDB->fetchRow("ekey = '{$data['fekey']}'");
			
			$name = generate::sqlInjesctionStringSecure(generate::clearHtml($data['name']));
			$content = generate::sqlInjesctionStringSecure(generate::clearHtmlNl2Br($data['content']));
			$forumTopicsDB = new forumTopicsDB();
			$forumTopicsDB->add(array('name'=>$name,'groupId'=>$group->id));
			$topic = $forumTopicsDB->fetchRow("groupId = {$group->id}",'id DESC');
			
			$forumPostsDB = new forumPostsDB();
			$forumPostsDB->add(array('content'=>$content,'topicId'=>$topic->id));
			router::redirect('indexUrlKey',array('urlKey'=>$data['urlKey'],'ftype'=>'topic','fekey'=>$topic->ekey));
		}	
	}
	public function addPostSuccess($data) {
		if (usersDB::getLoggedUser()!=null) {
			$forumTopicsDB = new forumTopicsDB();
			$topic = $forumTopicsDB->fetchRow("ekey = '{$data['fekey']}'");
			
			$content = generate::sqlInjesctionStringSecure(generate::clearHtmlNl2Br($data['content']));
			$forumPostsDB = new forumPostsDB();
			$forumPostsDB->add(array('content'=>$content,'topicId'=>$topic->id));
			router::redirect('indexUrlKey',array('urlKey'=>$data['urlKey'],'ftype'=>'topic','fekey'=>$topic->ekey));
		}	
	}	
}
?>