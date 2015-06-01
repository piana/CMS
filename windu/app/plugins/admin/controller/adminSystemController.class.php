<?php /*windu.org admin controller*/
Class adminSystemController Extends adminMainConfigController{
	public function __construct($request){
		parent::__construct($request);

		$configDB = new configDB();
		$config = $configDB->getByGroup(configDB::CONFIG_BUCKET_SYSTEM);	
		$this->smarty->assign('configList',$config);		
		
		$logDB = new logDB();
		$this->smarty->assign('logDB',$logDB);
		
		$this->smarty->assign('dataFoldersPath',__SITE_PATH.'/');	
		
		$this->smarty->assign('backups',baseFile::getFilesList(__SITE_PATH . '/data/backups/','dir',false));	
		
		$notifyDB = new notifyDB();
		$notificationsClosed = $notifyDB->fetchAll('closed = 1','priority DESC,insertTime DESC');
		
		$this->smarty->assign('notificationsClosed',$notificationsClosed);
		
		$this->smarty->assign('pagesDB',new pagesDB());
		$this->smarty->assign('logDB',new logDB());
		$this->smarty->assign('imagesDB',new imagesDB());
		$this->smarty->assign('filesDB',new filesDB());
		
		$this->smarty->assign('pagesbackupsDB',new pagesbackupsDB());
		$this->smarty->assign('commentsDB',new commentsDB()); 
		$this->smarty->assign('ratesDB',new ratesDB());
		
		$this->smarty->assign('usersDB',new usersDB());
		$this->smarty->assign('filesLogDB',new filesLogDB());
		$this->smarty->assign('mailDB',new mailDB());
		$this->smarty->assign('systemStatusDB',new systemStatusDB());
		$this->smarty->assign('cronlogDB',new cronlogDB());
		$this->smarty->assign('accesslogDB',new accesslogDB());
		$this->smarty->assign('firewallDB',new firewallDB());		
		
		if (!license::hasPro()) {
			$licenseForm = new form('license','licenseSuccess',$_POST,'POST','form-license');
			$licenseForm->add('key', 'input-text',null,null,array('class'=>'input-xlarge'));
			$licenseForm->addRule('key', 'required', null,lang::read('admin.system.controller.givelicensekey'));
			$licenseForm->addRule('key', 'numeric', null,lang::read('admin.system.controller.givelicensekey'));	
			$licenseForm->addRule('key', 'stringLength', array(32,32),lang::read('admin.system.controller.givelicensekey'));	
			$licenseForm->addButton('submit',lang::read('form.button.title.activate.license'),'btn btn-primary btn-large');
		
			$licenseForm->setHandler($this);
			$licenseForm->handle();

			$this->smarty->assign('licenseForm',$licenseForm);			
		}else{
			$this->smarty->assign('license',license::get());
		}

		//Firewall///////////////////////////
		$formFirewall = new form('firewall','firewallSuccess',$_POST,'POST','form-horizontal');
		
		$formFirewall->add('firewallRequestLimit', 'input-text',lang::read('admin.common.pro.firewall.tpl.limit'),config::get('firewallRequestLimit'));
		$formFirewall->add('firewallEmail', 'input-text',lang::read('admin.common.pro.firewall.tpl.email'),config::get('firewallEmail'));
				
		$formFirewall->setHandler($this);
		$formFirewall->handle();
		$this->smarty->assign('formFirewall',$formFirewall);	
		$this->smarty->assign('subpage',$this->request->getVariable('subpage'));	
		$this->smarty->assign('controllerShortName','system');
	}
	public function licenseSuccess($data) {
		if (license::activate($data['key'])) {
			router::redirect('admin-update-action',array('action'=>'downloadUpdate'));
		}else{
			router::reload('admin.message.wrong.licence.key','mn');
		}
	}
	public function index()
	{			
		$this->pageDisplay('system');
	}
	public function editConfig() {
		parent::editConfig();
		$this->pageDisplay('system');
	}	
	public function showLogs() {
		$id = $this->request->getVariable('id');
		$idArr = explode('_', $id);
        $idFinish = '';
		foreach ($idArr as $idVal) {
			$idFinish .= 'bucket='.$idVal.' OR ';
		}
		$idFinish = rtrim($idFinish,' OR ');

		$this->smarty->assign('logId',$idFinish);
		$this->pageDisplay('system');
	}
	public function showLogsByError() {
		$logDB = new logDB();
		$id = $this->request->getVariable('id');
		$data = $logDB->fetchRow("id={$id}")->data;
		
		$this->smarty->assign('logId',"data='{$data}'");
		$this->smarty->assign('errorLogsByError',"data='{$data}'");
		$this->pageDisplay('system');
	}	
	////////////////////////////////
	/////AccessLog//////////////////
	////////////////////////////////
	
	public function showAccessLogs() {
		$pageCount = 100;
		$accessLogsDB = new accesslogDB();
		$page = $pageCount*$this->request->getVariable('p');
		
		$filter = $this->request->getVariable('id');
		if ($filter!=null) {
			$pageCount = 100;
			$accessLogs = $accessLogsDB->fetchCountGroup($filter,null,null,'*',$pageCount);
			$this->smarty->assign('filtercname','COUNT('.$filter.')');
			$accessLogsCount = 0;
		}else{
			$accessLogs = $accessLogsDB->fetchAll(null,'insertTime DESC','*',"{$page},{$pageCount}");
			$accessLogsCount = $accessLogsDB->fetchCount();
		}
		
		$this->smarty->assign('filter',$filter);
		$this->smarty->assign('accesLogs',$accessLogs);
		$this->smarty->assign('accesLogsCount',$accessLogsCount);
		$this->smarty->assign('pageCount',$pageCount);
		$this->pageDisplay('system');
	}
	public function showIpAccessLogs() {
		$pageCount = 100;
		$accessLogsDB = new accesslogDB();
		$page = $pageCount*$this->request->getVariable('p');
		
		$ip = $this->request->getVariable('id');
		
		$accessLogs = $accessLogsDB->fetchAll("ip='{$ip}'",'insertTime DESC','*',"{$page},{$pageCount}");
		$accessLogsCount = $accessLogsDB->fetchCount();

		$this->smarty->assign('accesLogs',$accessLogs);
		$this->smarty->assign('accesLogsCount',$accessLogsCount);
		$this->smarty->assign('pageCount',$pageCount);
		$this->pageDisplay('system');
	}
	public function firewallSuccess($data) {
		config::set('firewallRequestLimit', $data['firewallRequestLimit']);
		config::set('firewallEmail', $data['firewallEmail']);
		router::reload();
	}

	public function firewallIpInfo(){
		$firewallDB = new firewallDB();
		$accesslogDB = new accesslogDB();
		
		$ipRow = $firewallDB->fetchRow("id={$this->request->getVariable('id')}");
		
		$firewallIpInfo = $accesslogDB->fetchCountGroup("strftime('%Y%m%d%H', insertTime)","ip='{$ipRow->createIp}'",'insertTime');
		$this->smarty->assign('firewallIpInfo',$firewallIpInfo);
		$this->smarty->assign('ip',$ipRow->createIp);
		
		$this->pageDisplay('system');
	}	
}
?>
