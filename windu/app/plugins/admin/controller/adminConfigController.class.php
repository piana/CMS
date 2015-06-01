<?php /*windu.org admin controller*/
Class adminConfigController Extends adminMainController{
	public function __construct($request){
		parent::__construct($request);
	
		$configDB = new configDB();
		$buckets = $configDB->fetchGroup('bucket','bucket!=99','name ASC');
		$this->smarty->assign('buckets',$buckets);
		
		foreach ($buckets as $key => $value) {
			$form = null;
			$form = new form("form{$key}",'addSuccess',$_POST,'POST','form-horizontal');
			$form->add('name', 'input-text',lang::read('admin.config.controller.name'));
			$form->addRule('name', 'required', null, lang::read('admin.config.controller.givename'));
			$form->add('value', 'input-text',lang::read('admin.config.controller.value'));
			$form->addRule('value', 'required', null, lang::read('admin.config.controller.addvalue'));		
			$form->add('type', 'select',lang::read('admin.config.controller.type'),null,array('option' => $configDB->types,"tooltip" => lang::read('admin.config.controller.typedescription')));

			$form->add('bucket', 'input-hidden',null,$key);
			
			$form->addButton('submit',lang::read('form.button.title.add'),'btn btn-primary', null, null, 'fa fa-plus ');	
			$form->setHandler($this);
			$form->handle();
			
			$this->formArr[$key] = $form;
		}
		$this->smarty->assign("forms",$this->formArr);	
		$this->smarty->assign('subpage',$this->request->getVariable('subpage'));
		$this->smarty->assign('controllerShortName','config');
	}
	public function addSuccess($data) {
		$validator = 'is_'.$data['type'];

		if ($validator($data['value'])) {
			$configDB = new configDB();
			$configDB->add($data);
			router::reload();
		}elseif ($data['type']=='bool'){
			if($data['value']==1 or $data['value']=='true'){
				$configDB = new configDB();
				$configDB->add($data);
				router::reload();								
			}elseif ($data['value']==0 or $data['value']=='false'){
				$configDB = new configDB();
				$configDB->add($data);
				router::reload();				
			}
		}
		router::reload('admn.message.negative.wrongvaluetype','mn');
	}
	public function edit() {
		$configDB = new configDB();
		$conf = $configDB->fetchRow("id = {$this->request->getVariable('id')}");
		$bucket = $conf->bucket;

		$form = new form("formEdit{$bucket}",'editSuccess',$_POST,'POST','form-horizontal');
		if(usersDB::isDeveloper()){
			$form->add('name', 'input-text',lang::read('admin.config.controller.name'),$conf->name);
			$form->addRule('name', 'required', null, lang::read('admin.config.controller.givename'));			
		}
		if($conf->type=='bool'){
			$form->add('value', 'select',lang::read('admin.config.controller.value'),$conf->value,array('option' => array(1=>lang::read('admin.config.controller.true'),0=>lang::read('admin.config.controller.false'))));
			$form->addRule('value', 'numeric', null, lang::read('admin.config.controller.addcorectvalue'));
		}else{
			$form->add('value', 'input-text',lang::read('admin.config.controller.value'),$conf->value);
			$form->addRule('value', $conf->type, null, lang::read('admin.config.controller.addcorectvalue'));
		}
		
		$form->addRule('value', 'required', null, lang::read('admin.config.controller.addvalue'));
				
		if(usersDB::isDeveloper()){	
			$form->add('type', 'select',lang::read('admin.config.controller.type'),$conf->type,array('option' => $configDB->types,"tooltip" => lang::read('admin.config.controller.typedescription')));
		}
		
		$form->add('bucket','input-hidden',null,$bucket);
		$form->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary', null, null, 'fa fa-upload ');	
		$form->addButton('cancel',lang::read('form.button.title.cancel'),'btn btn-margin-left',HOME.'admin/config/',null,'fa fa-ban');
		
		$form->setHandler($this);
		$form->handle();

		$this->formArr[$bucket] = $form;
		$this->smarty->assign("forms",$this->formArr);
		$this->pageDisplay('config');
	}
	public function editSuccess($data) {
		$configDB = new configDB();
		$type = $configDB->get($this->request->getVariable('id'),'type');
		
		$validator = 'is_'.$type;

		if ($validator($data['value']) or $type=='bool') {
			
			$configDB->updateRow($data,"id = {$this->request->getVariable('id')}");
			router::reload();
		}
		router::reload('admn.message.negative.wrongvaluetype','mn');		
	}	
	public function index()
	{			
		$this->pageDisplay('config');
	}	
}
?>
