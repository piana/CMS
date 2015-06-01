<?php /*windu.org admin controller*/
Class adminForumController Extends adminMainConfigController {
	public function __construct($request){
		parent::__construct($request);
		
		$forumsDB = new forumsDB();
		$forums = $forumsDB->fetchAll('id>0','position ASC');
		$this->smarty->assign('forums',$forums);	
		
		$this->smarty->assign('forumGroupsDB', new forumGroupsDB());	
		$this->smarty->assign('forumTopicsDB', new forumTopicsDB());
		$this->smarty->assign('forumPostsDB', new forumPostsDB());
		$this->smarty->assign('subpage',$this->request->getVariable('subpage'));
		$this->smarty->assign('controllerShortName','forum');
		
		//Search/////////////////////////////
		$formSearch = new form('search','searchSuccess',$_POST,'POST','form-inline');
		
		$formSearch->add('searchText', 'input-text',null,null,array('placeholder'=>lang::read('admin.content.controller.searchedphrase')));
		$formSearch->addRule('searchText', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$formSearch->addButton('search',lang::read('admin.content.controller.search'),'btn btn-small');
		$formSearch->setHandler($this);
		$formSearch->handle();
		$this->smarty->assign('formSearch',$formSearch);		
		
	}
	public function index()
	{
		$this->pageDisplay('forum');
	}	
	////////////////////////////////////////////////////////
	////Search//////////////////////////////////////////////
	////////////////////////////////////////////////////////
	public function searchSuccess($data){
		router::redirect('admin-forum-action-id',array('action'=>'searchResult','subpage'=>'posts','id'=>base64_encode($data['searchText'])));
	}
	public function searchResult() {
		$forumPostsDB = new forumPostsDB();
		$searchString = base64_decode($this->request->getVariable('id'));
	
		$searchResult=$forumPostsDB->fetchTextSearch($searchString,array('content','createTime','updateTime','createIP','updateIP','ekey'));

		$this->smarty->assign('searchString',$searchString);
		$this->smarty->assign('searchResult',$searchResult);
		$this->pageDisplay('forum');
	}	
	////////////////////////////////////////////////////////
	////Forum///////////////////////////////////////////////
	////////////////////////////////////////////////////////	
	public function addForum() {
		$form = new form('addForum','addForumSuccess',$_POST,'POST','form-horizontal');

		
		$form->add('name', 'input-text','Nazwa forum');
		$form->addRule('name', 'required', null, lang::read('admin.content.controller.giveelementname'));
        $form->add('HTML', '<br>');
		$form->add('description', 'textareaCKEditor',null,' ',array('editorType'=>'minimal'));
		
		$form->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus ');
		$form->setHandler($this);
		$form->handle();
		
		$this->smarty->assign('form',$form);	
		
		$this->pageDisplay('forum');
	}
	public function addForumSuccess($data) {
		$forumsDB = new forumsDB();
		$forumsDB->add($data);
		router::reload();
	}
	public function editForum() {
		$forumsDB = new forumsDB();
		$forum = $forumsDB->fetchRow("id = {$this->request->getVariable('id')}");
		
		$form = new form('editForum','editForumSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text','Nazwa forum',$forum->name);
		$form->addRule('name', 'required', null, lang::read('admin.content.controller.giveelementname'));
        $form->add('HTML', '<br>');
		$form->add('description', 'textareaCKEditor',null,$forum->description,array('editorType'=>'minimal'));

		
		$form->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus ');
		$form->setHandler($this);
		$form->handle();
		
		$this->smarty->assign('form',$form);	
		
		$this->pageDisplay('forum');
	}
	public function editForumSuccess($data) {
		$forumsDB = new forumsDB();
		$forumsDB->updateRow($data,"id = {$this->request->getVariable('id')}");
		router::reload();
	}	
	
	////////////////////////////////////////////////////////
	////Group///////////////////////////////////////////////
	////////////////////////////////////////////////////////
	public function addGroup() {
		$form = new form('addGroup','addGroupSuccess',$_POST,'POST','form-horizontal');
		
		$form->add('name', 'input-text','Nazwa grupy');
		$form->addRule('name', 'required', null, lang::read('admin.content.controller.giveelementname'));
        $form->add('HTML', '<br>');
		$form->add('description', 'textareaCKEditor',null,' ',array('editorType'=>'minimal'));
		$form->add('forumId', 'input-hidden',null,$this->request->getVariable('id'));
		
		$form->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus ');
		$form->setHandler($this);
		$form->handle();
		
		$this->smarty->assign('form',$form);	
		
		$this->pageDisplay('forum');
	}
	public function addGroupSuccess($data) {
		$forumGroupsDB = new forumGroupsDB();
		$forumGroupsDB->add($data);
		router::reload();
	}	
	public function editGroup() {
		$forumsDB = new forumsDB();
		$forumGroupsDB = new forumGroupsDB();
		$group = $forumGroupsDB->fetchRow("id = {$this->request->getVariable('id')}");
		
		$form = new form('editGroup','editGroupSuccess',$_POST,'POST','form-horizontal');

		$form->add('name', 'input-text','Nazwa grupy',$group->name);
		$form->addRule('name', 'required', null, lang::read('admin.content.controller.giveelementname'));
		
		$form->add('forumId', 'select','Forum',$group->forumId,array('option'=>$forumsDB->getSelectArray()));

        $form->add('HTML', '<br>');
		$form->add('description', 'textareaCKEditor',null,$group->description,array('editorType'=>'minimal'));
		
		$form->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus ');
		$form->setHandler($this);
		$form->handle();
		
		$this->smarty->assign('form',$form);	
		
		$this->pageDisplay('forum');
	}	
	public function editGroupSuccess($data) {
		$forumGroupsDB = new forumGroupsDB();
		$forumGroupsDB->updateRow($data,"id = {$this->request->getVariable('id')}");
		router::reload();
	}
    ////////////////////////////////////////////////////////
    ////Posts///////////////////////////////////////////////
    ////////////////////////////////////////////////////////
    public function editPost() {
        $forumsDB = new forumsDB();
        $forumPostsDB = new forumPostsDB();
        $post = $forumPostsDB->fetchRow("id = {$this->request->getVariable('id')}");

        $form = new form('editPost','editPostSuccess',$_POST,'POST','form-horizontal');

        $form->add('content', 'textareaCKEditor',null,$post->content,array('editorType'=>'minimal'));

        $form->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus');
        $form->setHandler($this);
        $form->handle();

        $this->smarty->assign('form',$form);

        $this->pageDisplay('forum');
    }
    public function editPostSuccess($data) {
        $forumPostsDB = new forumPostsDB();
        $forumPostsDB->updateRow($data,"id = {$this->request->getVariable('id')}");
        router::reload();
    }
	////////////////////////////////////////////////////////
	////Other///////////////////////////////////////////////
	////////////////////////////////////////////////////////	
	public function editConfig() {
		parent::editConfig();
		$this->pageDisplay('forum');
	}	

}
?>
