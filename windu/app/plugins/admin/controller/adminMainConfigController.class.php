<?php /*windu.org admin controller*/
Class adminMainConfigController extends adminMainController 
{	
	public function __construct(request $request, $plugins = array())
	{
		parent::__construct($request);
	}	
	public function editConfig() {
		
		$configDB = new configDB();
		if($this->request->getVariable('id')!=null){
			$id = $this->request->getVariable('id');
		}elseif ($this->request->getVariable('theme')!=null){
			$id = $this->request->getVariable('theme');
		}
		$conf = $configDB->fetchRow("id = {$id}");
		$bucket = $conf->bucket;

		$form = new form("formEditConfig",'editConfigSuccess',$_POST,'POST','form-horizontal');

		if($conf->type=='bool'){
			$form->add('value', 'select',lang::read('admin.config.controller.value'),$conf->value,array('class'=>'input-small','option' => array(1=>lang::read('admin.config.controller.true'),0=>lang::read('admin.config.controller.false'))));
			$form->addRule('value', 'numeric', null, lang::read('admin.config.controller.addcorectvalue'));
		}else{
			$form->add('value', 'input-text',lang::read('admin.config.controller.value'),$conf->value,array('class'=>'span10'));
			$form->addRule('value', $conf->type, null, lang::read('admin.config.controller.addcorectvalue'));
		}
		
		$form->addRule('value', 'required', null, lang::read('admin.config.controller.addvalue'));

		$form->add('bucket', 'input-hidden',null,$bucket);
		
		$form->addButton('submit',lang::read('form.button.title.save'),'btn btn-primary',null,null,'fa fa-upload ');
		$form->setHandler($this);
		$form->handle();
		
		$this->smarty->assign("formConfig",$form);		
	}	
	public function editConfigSuccess($data) {
		$configDB = new configDB();
		if($this->request->getVariable('id')!=null){
			$id = $this->request->getVariable('id');
		}elseif ($this->request->getVariable('theme')!=null){
			$id = $this->request->getVariable('theme');
		}		
		$configDB->updateRow($data,"id = {$id}");
		router::reload();
	}
}
?>
