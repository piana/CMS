<?php
Class commentsNormalController extends widgetMainController
{		
	public function run() {
		$usersDB = new usersDB();
		$form = new form('addComment','addCommentSuccess',$_POST,'POST','form-horizontal no-margin');
		
		if(!$usersDB->getLoggedIn()){
			$form->add('email', 'input-text',lang::read('comments.normal.email'),null,array());
			$form->addRule('email', 'required', null, lang::read('comments.normal.giveemail'));	
			$form->addRule('email', 'email', null, lang::read('comments.normal.giveemail'));	
			$form->addRule('email', 'unique', array('table'=>$usersDB), lang::read('comments.normal.loginemail'));			
		}
		$form->add('content', 'textarea', lang::read('comments.normal.content'));
		$form->addRule('content', 'required', null,lang::read('comments.normal.givecontent'));		
		$form->addButton('add',lang::read('comments.normal.post'),'btn btn-primary margin-right');
		$form->setHandler($this);
		$form->handle();
		
		$commentsDB = new commentsDB();
		$request = $this->request;
		$pagesDB = new pagesDB();
		$page = $pagesDB->getPageByUrlKeySmart($request->getVariable('urlKey'));
		
		$user = $usersDB->getLoggedIn();

		return array("form" => $form,"commentsDB" => $commentsDB, "bucket" => $page->id, "user" => $user);
	}
	public function addCommentSuccess($data) {
		$request = $this->request;
		$pagesDB = new pagesDB();

		$page = $pagesDB->getPageByUrlKeySmart($request->getVariable('urlKey'));
		
		$finishData['email'] = $data['email'];
		$finishData['bucket'] = $page->id;
		$finishData['content'] = generate::clearHtmlNl2Br($data['content']);
		$finishData['email'] = generate::clearHtml($data['email']);
		
		$commentsDB = new commentsDB();
		$commentsDB->add($finishData);
		router::reload();
	}   	
}
?>