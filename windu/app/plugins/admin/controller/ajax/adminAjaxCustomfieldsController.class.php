<?php /*windu.org admin controller*/
Class adminAjaxCustomfieldsController Extends adminAjaxController{
	public function __construct($request){
		parent::__construct($request);
	}
	public function index()	{	
		$form = new form('custimFileds','addSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text','Nazwa pola');
		$form->addRule('name', 'required', null, 'Podaj nazwę pola');
		
		$form->add('type', 'select','Typ pola',null,array('option'=>array('string'=>'Tekst','numeric'=>'Liczba','datatime'=>'Data')));
		$form->addRule('type', 'required', null, 'Podaj typ pola');		
		
		$form->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary',null,null,'fa fa-plus-circle ');
				
		$form->setHandler($this);
		$form->handle();			
			
		$pagesDB = new pagesDB();
		$this->smarty->assign('pagesDB',$pagesDB);	
		$this->smarty->assign('form',$form);	
		$this->pageDisplay('customfieldsModal');
	}	
	public function addSuccess($data) {
		$fieldName = 'cf_'.generate::cleanClassName($data['name']).'_'.$data['type'];
		
		$pagesDB = new pagesDB();
		$pagesDB->addField($fieldName);
		router::redirect('admin-customfields-ajax-action',array('action'=>'index'));
	}
	public function deleteField() {
		$fieldName = $this->request->getVariable('id');
		
		$pagesDB = new pagesDB();
		$pagesDB->deleteField($fieldName);
		router::redirect('admin-customfields-ajax-action',array('action'=>'index'));
	}

}
?>
