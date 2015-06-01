<?php /*windu.org admin controller*/
Class adminAjaxNotesController Extends adminAjaxController{
	public function __construct($request){
		parent::__construct($request);
		$this->usersDB = new usersDB();
		$this->noteDB = new notesDB();
		$this->user = $this->usersDB->getLoggedIn();
		
		$notes = $this->noteDB->getNotesByUser($this->user->id);
		
		
		
		$this->smarty->assign('notes',$notes);
	}
	public function index()
	{	
		
	}	
	public function showNotes()
	{	
		$form = new form('addnote','addNoteSuccess',$_POST,'POST','no-margin');
		$form->add('HTML','<div class="pad">');
		$form->add('content', 'textarea','',null,array('editorType'=>'basic'));
		$form->addRule('content', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$form->add('HTML','</div>');
		$form->setHandler($this);
		$form->handle();
		$form->addButton('note',lang::read('admin.ajax.notes.controller.addnote'),'btn btn-primary margin-right');
		
		$this->smarty->assign('form',$form);		

		$this->pageDisplay('notesModal');
	}
	public function edit()
	{	
		$note = $this->noteDB->fetchRow("id={$this->request->getVariable('id')}");
		
		$form = new form('editnote','editNoteSuccess',$_POST,'POST','no-margin');
		$form->add('HTML','<div class="pad">');
		$form->add('content', 'textarea','',$note->content,array('editorType'=>'basic'));
		$form->addRule('content', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$form->add('HTML','</div>');
		$form->setHandler($this);
		$form->handle();
		$form->addButton('note',lang::read('admin.ajax.notes.controller.save'),'btn btn-primary margin-right');
		
		$this->smarty->assign('form',$form);		
		$this->pageDisplay('notesModal');
	}	
	public function addNoteSuccess($data) {
		$data = array_merge($data,array('userId'=>$this->user->id));
		
		$this->noteDB->add($data);
		router::redirect('admin-notes-ajax-action',array('action'=>'showNotes'));
	}
	public function editNoteSuccess($data) {
		$data = array_merge($data,array('userId'=>$this->user->id));
		
		$this->noteDB->updateRow($data,"id={$this->request->getVariable('id')}");
		router::reload();
	}	
	public function deleteNote() {
		$this->noteDB->delete($this->request->getVariable('id'));
		router::redirect('admin-notes-ajax-action',array('action'=>'showNotes'));
	}

}
?>
