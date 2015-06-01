<?php /*windu.org admin controller*/
Class adminToolsController Extends adminMainConfigController{
	public function __construct($request){
		parent::__construct($request);
		$configDB = new configDB();
		$config = $configDB->getByGroup(configDB::CONFIG_BUCKET_TOOLS);
		$this->smarty->assign('configList',$config);

		$this->smarty->assign('sitePath',__SITE_PATH);
		

		//Mailing
		$mailingTemplatesDB = new mailingtemplatesDB();
		$this->mailingTemplatesList = $mailingTemplatesDB->fetchAll();
		$this->smarty->assign('mailingTemplatesList',$this->mailingTemplatesList);

		$contactgroupsDB = new contactgroupsDB();
		$this->contactsGroups = $contactgroupsDB->fetchAll();
		$this->smarty->assign('contactsGroups',$this->contactsGroups);

		$mailingsDB = new mailingsDB();
		$this->mailingList = $mailingsDB->fetchAll(null,"status DESC, createTime ASC");
		$this->smarty->assign('mailingList',$this->mailingList);
		
		$this->smarty->assign('pagesDB',new pagesDB());
		$this->smarty->assign('logDB',new logDB());
		$this->smarty->assign('ratesDB',new ratesDB());
		$this->smarty->assign('commentsDB',new commentsDB());
		$this->smarty->assign('filesDB',new filesDB());
		$this->smarty->assign('filesLogDB',new filesLogDB());
		$this->smarty->assign('imagesDB',new imagesDB());
		$this->smarty->assign('mailingsDB',new mailingsDB());
		$this->smarty->assign('mailDB',new mailDB());
		$this->smarty->assign('contactDB',new contactDB());
		$this->smarty->assign('redirectDB',new redirectDB());

		
		$systemStatusDB = new systemStatusDB();
		$systemStatusColumns = $systemStatusDB->fetchRow();
		unset($systemStatusColumns->id);
		unset($systemStatusColumns->date);

		$this->smarty->assign('systemStatusColumns',$systemStatusColumns);
		$this->smarty->assign('systemStatusDB',$systemStatusDB);
		
		
		
		$formAddFile = new form('addFile','addFileSuccess',$_POST,'POST','form-horizontal');
		$formAddFile->add('file', 'input-file',lang::read('admin.tools.controller.file'),null,array("tooltip" => lang::read('admin.tools.controller.filedescription')));	
		$formAddFile->setHandler($this);
		$formAddFile->handle();
		
		//SEO///////////////////////////
		$formSEO = new form('seo','seoSuccess',$_POST,'POST','form-horizontal');
		
		$formSEO->add('analiticsContent', 'input-text',lang::read('admin.common.seo.tpl.analcode'),config::get('analiticsCode'),array('class'=>'span11'));
		$formSEO->add('googleverifyContent', 'input-text',lang::read('admin.common.seo.tpl.verificationcode'),config::get('googleverifyCode'),array('class'=>'span11'));
		$formSEO->add('robotsContent', 'textarea',lang::read('admin.common.seo.tpl.robots'),baseFile::readFile(__SITE_PATH.'/robots.txt'),array('class'=>'span11 textarea-medium'));
				
		$formSEO->setHandler($this);
		$formSEO->handle();
		$this->smarty->assign('formSEO',$formSEO);
	
		
		$this->smarty->assign('formAddFile',$formAddFile);	
		
		if (cache::isCached('dbFileList')) {
			$dbList = cache::read('dbFileList');
		}else{
			$dbList = baseFile::getFilesList(__SITE_PATH . '/app/model/');
			foreach (explode(',',PLUGINS) as $plugin){
				if (is_dir(__SITE_PATH . '/app/plugins/'.$plugin.'/model/')) {
					$dbPluginList = baseFile::getFilesList(__SITE_PATH . '/app/plugins/'.$plugin.'/model/');
					if (is_array($dbPluginList)) {
						$dbList = array_merge($dbList,$dbPluginList);
					}
				}
			}
			cache::write('dbFileList', $dbList);
		}	
		$this->smarty->assign('dbList',$dbList);
		
		//RSS/////////////////////////////
		$formRSS = new form('rss','addRssSuccess',$_POST,'POST','form-horizontal');
		
		$formRSS->add('rssUrl', 'input-text',lang::read('admin.content.controller.rssfeed'));
		$formRSS->addRule('rssUrl', 'url', null,lang::read('admin.content.controller.givecorrecturl'));	
		
		$pagesDB = new pagesDB();
		$newsGroups = $pagesDB->fetchAll("status=".pagesDB::STATUS_ACTIVE." and type=".pagesDB::TYPE_NEWS_GROUP);
		foreach ($newsGroups as $newsGroup){
			$newsGroupArray[$newsGroup->id] = $newsGroup->name;			
		}
		$formRSS->add('rssParentId', 'select',lang::read('admin.content.controller.parentgroup'),config::get('rssParentId'),array('option' => $newsGroupArray,"tooltip" => lang::read('admin.content.controller.parentgrptooltip')));		
				
		$formRSS->setHandler($this);
		$formRSS->handle();
		$this->smarty->assign('formRSS',$formRSS);	
		
		
		//Database/////////////////////////////
		$formDatabaseSearch = new form('databaseSearch','databaseSearchSuccess',$_POST,'POST','form-inline');
		
		$formDatabaseSearch->add('searchText', 'input-text',null,null,array('placeholder'=>lang::read('admin.content.controller.searchedphrase')));
		$formDatabaseSearch->addRule('searchText', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$formDatabaseSearch->addButton('search',lang::read('admin.content.controller.search'),'btn btn-small');
		$formDatabaseSearch->setHandler($this);
		$formDatabaseSearch->handle();
		$this->smarty->assign('formDatabaseSearch',$formDatabaseSearch);		

		$this->smarty->assign('subpage',$this->request->getVariable('subpage'));	
		$this->smarty->assign('controllerShortName','tools');
		
		//Contact/////////////////////////////
		$formContactSearch = new form('searchContact','searchContactSuccess',$_POST,'POST','form-inline');
		
		$formContactSearch->add('searchText', 'input-text',null,null,array('placeholder'=>lang::read('admin.content.controller.searchedphrase')));
		$formContactSearch->addRule('searchText', 'required', null,lang::read('admin.content.controller.giveelementname'));
		$formContactSearch->addButton('search',lang::read('admin.content.controller.search'),'btn btn-small');
		$formContactSearch->setHandler($this);
		$formContactSearch->handle();
		$this->smarty->assign('formContactSearch',$formContactSearch);
	}
	public function databaseSearchSuccess($data){
		router::redirect('admin-tools-action-id',array('action'=>'searchResult','subpage'=>'database','id'=>base64_encode($data['searchText'])));
	}
	public function addRssSuccess($data) {
		$urls = unserialize(config::get('rssUrls'));
		$urls[] = $data['rssUrl'].'|'.$data['rssParentId'];
		config::set('rssUrls', serialize($urls));
		router::reload();
	}	
	
	public function editConfig() {
		parent::editConfig();
		$this->pageDisplay('tools');
	}		
	public function index(){
		$this->pageDisplay('tools');
	}
	
		
	
	public function redirectAdd() {
		$logDB = new logDB();
		$redirectDB = new redirectDB();

		$source = $logDB->fetchRow("id='{$this->request->getVariable('id')}'");
		$sourceUrl = str_replace(HOME,'{{$HOME}}', $source->data);
		$redirectId = $redirectDB->fetchRow("source='{$sourceUrl}'");
		
		$form = new form('redirectAdd','redirectAddSuccess',$_POST,'POST','form-horizontal');
		$form->add('source', 'input-text','Source',$source->data);
		$form->addRule('source', 'required', null,lang::read('admin.content.controller.giveelementname'));
		
		$pagesDB = new pagesDB();
		$pagesArray = $pagesDB->getGroupsArrayForWidgetInserter('type>=0','name');

		$form->add('target', 'select','Target',$redirectId->target,array('option'=>$pagesArray));
		$form->addRule('target', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formRedirect',$form);
		$this->pageDisplay('tools');
	}
	public function redirectAddSuccess($data) {
		$redirectDB = new redirectDB();
		$redirectDB->add($data);
		router::reload();
	}	
	
	public function seoSuccess($data) {
		config::set('analiticsCode', $data['analiticsContent']);
		config::set('googleverifyCode', $data['googleverifyContent']);
		baseFile::saveFile(__SITE_PATH.'/robots.txt',$data['robotsContent']);
		router::reload();
	}
				
	public function addFileSuccess($data) {
		if ($_FILES['file']['error']==0) {
			file::saveIncomingFile($_FILES['file']);
		}
		router::reload();
	}
	
	//////////////////////////////////////////////////////////////////////
	//Mailing/////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////
	public function addMailingTemplate() {
		$form = new form('add','addMailingTemplateSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.elementname'));
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$form->add('content', 'textareaCKEditor','',null,array('editorType'=>'basic'));

		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formMailing',$form);
		$this->smarty->assign('titleForm',lang::read('admin.tools.controller.addtemplate'));

		$this->pageDisplay('tools');
	}
	public function addMailingTemplateSuccess($data) {
		$mailingTemplatesDB = new mailingtemplatesDB();
		$mailingTemplatesDB->add($data);
		router::reload();
	}

	public function editMailingTemplate() {
		$mailingTemplatesDB = new mailingtemplatesDB();
		$template = $mailingTemplatesDB->fetchRow("id={$this->request->getVariable('id')}");

		$form = new form('add','editMailingTemplateSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.elementname'),$template->name);
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$form->add('content', 'textareaCKEditor','',$template->content,array('editorType'=>'basic'));

		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formMailing',$form);
		$this->smarty->assign('titleForm',lang::read('admin.tools.controller.edittemplate'));

		$this->pageDisplay('tools');
	}
	public function editMailingTemplateSuccess($data) {
		$mailingTemplatesDB = new mailingtemplatesDB();
		$mailingTemplatesDB->updateRow($data, "id={$this->request->getVariable('id')}");
		router::reload();
	}
	public function addMailingContactGroup() {
		$form = new form('add','addMailingContactGroupSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.elementname'));
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formMailing',$form);
		$this->smarty->assign('titleForm',lang::read('admin.tools.controller.addmailinggroup'));

		$this->pageDisplay('tools');
	}
	public function addMailingContactGroupSuccess($data) {
		$contactgroupsDB = new contactgroupsDB();
		$contactgroupsDB->add($data);
		router::reload();
	}
	public function editMailingContactGroup() {
		$contactGroupDB = new contactgroupsDB();
		$contactGroup = $contactGroupDB->fetchRow("id={$this->request->getVariable('id')}");

		$form = new form('add','editMailingContactGroupSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.elementname'),$contactGroup->name);
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formMailing',$form);
		$this->smarty->assign('titleForm',lang::read('admin.tools.controller.editmailinggroup'));

		$this->pageDisplay('tools');
	}
	public function editMailingContactGroupSuccess($data) {
		$contactGroupDB = new contactgroupsDB();
		$contactGroupDB->updateRow($data,"id={$this->request->getVariable('id')}");
		router::reload();
	}
	public function addMailingContact() {
		$form = new form('add','addMailingContactSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.elementname'));
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$form->add('email', 'input-text',lang::read('admin.users.controller.email'),null,array());
		$form->addRule('email', 'required', null, lang::read('admin.users.controller.giveemail'));
		$form->addRule('email', 'email', null, lang::read('admin.users.controller.givecorrectemail'));

		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formMailing',$form);
		$this->smarty->assign('titleForm',lang::read('admin.tools.controller.addcontact'));

		$this->pageDisplay('tools');
	}
	public function addMailing() {
		foreach($this->mailingTemplatesList as $mailingTemplate){
			$mailingTemplateListArray[$mailingTemplate->id]=$mailingTemplate->name;
		}
		foreach($this->contactsGroups as $contactsGroup){
			$contactsGroupsArray[$contactsGroup->id]=$contactsGroup->name;
		}

		$form = new form('add','addMailingSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.tools.mailing.controller.mailingname'));
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$form->add('contactGroup', 'select',lang::read('admin.tools.mailing.controller.contactsgroup'),$page->type, array("option"=>$contactsGroupsArray));
		$form->add('contentId', 'select',lang::read('admin.tools.mailing.controller.template'),$page->type, array("option"=>$mailingTemplateListArray));

		$form->add('subject', 'input-text',lang::read('admin.tools.mailing.controller.subject'));
		$form->addRule('subject', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$form->add('from', 'input-text',lang::read('admin.tools.mailing.controller.senderemail'),$contact->email,array());
		$form->addRule('from', 'required', null, lang::read('admin.users.controller.giveemail'));
		$form->addRule('from', 'email', null, lang::read('admin.users.controller.givecorrectemail'));

		$form->add('senderName', 'input-text',lang::read('admin.tools.mailing.controller.sendername'));
		$form->addRule('senderName', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formMailing',$form);

		$this->pageDisplay('tools');
	}
	public function addMailingSuccess($data) {
		$data['replay'] = $data['from'];
		$data['return'] = $data['from'];

		$mailingsDB = new mailingsDB();
		$mailingsDB->add($data);
		router::reload();
	}	
	
	public function addMailingContactSuccess($data) {
		$contactDB = new contactDB();
		$contactDB->add($data,$this->request->getVariable('id'));
		router::reload();
	}

	public function addMailingMassContact() {
		$form = new form('add','addMailingMassContactSuccess',$_POST,'POST','form-horizontal');
		$form->add('emails', 'textarea',lang::read('admin.system.controller.emails'));
		$form->addRule('emails', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formMailing',$form);
		$this->smarty->assign('titleForm',lang::read('admin.tools.controller.addmasscontact'));

		$this->pageDisplay('tools');
	}
	public function addMailingMassContactSuccess($data) {
		$contactDB = new contactDB();

		$data['emails'] = str_replace(' ','',$data['emails']);
		$emailArray = explode(',', $data['emails']);
		$bucket = $this->request->getVariable('id');

		foreach ($emailArray as $email) {
			$emailData['email'] = $email;
			$contactDB->add($emailData,$bucket);
		}
		router::reload();
	}
	
	public function addMailingMassContactFromUsers() {
		$form = new form('add','addMailingMassContactFromUsersSuccess',$_POST,'POST','form-horizontal');
		$form->add('where', 'textarea',lang::read('admin.system.controller.where'),"active=1");
	
		$form->setHandler($this);
		$form->handle();
	
		$this->smarty->assign('formMailing',$form);
		$this->smarty->assign('titleForm',lang::read('admin.tools.controller.addmasscontactusers'));
	
		$this->pageDisplay('tools');
	}
	public function addMailingMassContactFromUsersSuccess($data) {
		$usersDB = new usersDB();
		$contactDB = new contactDB();
		$users = $usersDB->fetchAll($data['where']);
		$bucket = $this->request->getVariable('id');
		
		foreach ($users as $user) {
			$emailData['email'] = $user->email;
			$contactDB->add($emailData,$bucket);
		}
		router::reload();
	}		
	//////////////////////////////////////////////////////////////////////
	//Contact - Mailings//////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////	
	public function addContact() {
		$form = new form('add','addMailingContactSuccess',$_POST,'POST','form-horizontal');
		$form->add('name', 'input-text',lang::read('admin.content.controller.elementname'));
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$form->add('email', 'input-text',lang::read('admin.users.controller.email'),null,array());
		$form->addRule('email', 'required', null, lang::read('admin.users.controller.giveemail'));
		$form->addRule('email', 'email', null, lang::read('admin.users.controller.givecorrectemail'));
		
		$form->add('telephone', 'input-text',lang::read('admin.tools.controller.telephone'));
		$form->add('mobile', 'input-text',lang::read('admin.tools.controller.mobile'));
		$form->add('adress', 'input-text',lang::read('admin.tools.controller.adress'));
		$form->add('city', 'input-text',lang::read('admin.tools.controller.city'));
		$form->add('code', 'input-text',lang::read('admin.tools.controller.code'));
		$form->add('country', 'input-text',lang::read('admin.tools.controller.country'));
		$form->add('taxid', 'input-text',lang::read('admin.tools.controller.taxid'));
		$form->add('other', 'input-text',lang::read('admin.tools.controller.other'));
		

		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formContact',$form);
		$this->smarty->assign(lang::read('admin.tools.controller.editcontact'),$title);

		$this->pageDisplay('tools');
	}	


	public function editContact() {
		$contactDB = new contactDB();
		$contact = $contactDB->fetchRow("id={$this->request->getVariable('id')}");
		$contactColumns = $contactDB->contactColumns;
		
		$form = new form('editContact','editContactSuccess',$_POST,'POST','form-horizontal');
		
		foreach ($contactColumns as $contactColumn){
			$form->add($contactColumn, 'input-text',$contactColumn,$contact->$contactColumn);
		}
		
		$form->add('name', 'input-text',lang::read('admin.content.controller.elementname'),$contact->name);
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$form->add('email', 'input-text',lang::read('admin.users.controller.email'),$contact->email,array());
		$form->addRule('email', 'required', null, lang::read('admin.users.controller.giveemail'));
		$form->addRule('email', 'email', null, lang::read('admin.users.controller.givecorrectemail'));		
		
		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formContact',$form);
		$this->smarty->assign(lang::read('admin.tools.controller.editcontact'),$title);

		$this->pageDisplay('tools');
	}	
	public function editMailingContact() {
		$contactDB = new contactDB();
		$contact = $contactDB->fetchRow("id={$this->request->getVariable('id')}");


		$form = new form('editMailingContact','editContactSuccess',$_POST,'POST','form-horizontal');

		$form->add('name', 'input-text',lang::read('admin.content.controller.elementname'),$contact->name);
		$form->addRule('name', 'required', null,lang::read('admin.content.controller.giveelementname'));

		$form->add('email', 'input-text',lang::read('admin.users.controller.email'),$contact->email,array());
		$form->addRule('email', 'required', null, lang::read('admin.users.controller.giveemail'));
		$form->addRule('email', 'email', null, lang::read('admin.users.controller.givecorrectemail'));		

		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formMailing',$form);
		$this->smarty->assign(lang::read('admin.tools.controller.editcontact'),$title);

		$this->pageDisplay('tools');
	}
	public function editContactSuccess($data) {
		$contactDB = new contactDB();
		$contactDB->updateRow($data,"id={$this->request->getVariable('id')}");
		router::reload();
	}
	public function showMailingContact() {
		$pageCount = 15;

		$contactDB = new contactDB();
		$page = $pageCount*$this->request->getVariable('p');
		$emails = $contactDB->getEmails($this->request->getVariable('id'),0,"{$page},{$pageCount}");
		$emailsCount = $contactDB->getEmailsCount($this->request->getVariable('id'));

		$this->smarty->assign('emails',$emails);
		$this->smarty->assign('emailsCount',$emailsCount);
		$this->smarty->assign('pageCount',$pageCount);
		$this->pageDisplay('tools');
	}
	public function showContacts() {
		$pageCount = 15;

		$contactDB = new contactDB();
		$page = $pageCount*$this->request->getVariable('p');
		$emails = $contactDB->getEmails($this->request->getVariable('id'),0,"{$page},{$pageCount}",1,0,'*');
		$emailsCount = $contactDB->getEmailsCount($this->request->getVariable('id'));

		$this->smarty->assign('emails',$emails);
		$this->smarty->assign('emailsCount',$emailsCount);
		$this->smarty->assign('pageCount',$pageCount);
		$this->pageDisplay('tools');
	}	

	////Search/////////////////////

	public function searchContactSuccess($data){
		router::redirect('admin-tools-action-id',array('action'=>'searchContact','subpage'=>'contacts','id'=>base64_encode($data['searchText'])));
	}
	public function searchContact() {
		$contactDB = new contactDB();
		$searchString = base64_decode($this->request->getVariable('id'));
		$searchResult=$contactDB->fetchTextSearch($searchString,array('name','email','bucket','telephone','mobile','adress','city','code','country','taxid','other','createTime','updateTime','createIP','updateIP','ekey'));
	
		$this->smarty->assign('searchString',$searchString);
		$this->smarty->assign('emails',$searchResult);
		$this->pageDisplay('tools');
	}


	
	////////////////////////////////
	/////CSV export inport//////////
	////////////////////////////////
	
	public function exportToCSVContacts() {
		$contactDB = new contactDB();
		$emailsArray = $contactDB->getEmails($this->request->getVariable('id'),0,100000,1,0,$contactDB->contactColumns,PDO::FETCH_ASSOC);
		$contactGroupsDB = new contactgroupsDB();
		$contactGroup = $contactGroupsDB->fetchRow("id={$this->request->getVariable('id')}");
		
		array_unshift($emailsArray, $contactDB->contactColumns);

		csv::getCsvFile(generate::cleanFileName($contactGroup->name.'_'.generate::sqlDatetime()), $emailsArray);
	}		
	
	public function importContactGroup() {
		$form = new form('import','importContactGroupSuccess',$_POST,'POST','form-horizontal');
		$form->add('csvFile', 'input-file',lang::read('admin.tools.controller.csv'),null,array("tooltip" => lang::read('admin.tools.controller.csv.description')));	
		
		$form->setHandler($this);
		$form->handle();

		$this->smarty->assign('formContact',$form);

		$this->pageDisplay('tools');
	}	
	public function importContactGroupSuccess($data) {
		if ($_FILES['csvFile']['error']==0) {
			$arrayFromCsv = csv::toArray($_FILES['csvFile']['tmp_name']);

			$contactDB = new contactDB();
			$contactGroupsDB = new contactgroupsDB();
			$contactGroupsDB->add(array('name'=>$_FILES['csvFile']['name']));
			
			$group = $contactGroupsDB->fetchRow("name = '{$_FILES['csvFile']['name']}'",'id DESC');
			unset($arrayFromCsv[0]);
			foreach ($arrayFromCsv as $row) {
				if (count($row)>=2) {
					$contactDB->add(array_combine($contactDB->contactColumns,$row), $group->id);
				}				
			}
			
		}
		router::reload();	
	}

	public function mergeContactGroup() {
		$contactGroupsDB = new contactgroupsDB();
		
		$form = new form('merge','mergeContactGroupSuccess',$_POST,'POST','form-horizontal');
		
		$form->add('list1', 'select',lang::read('admin.tools.mailing.controller.mailinglist').' 1',null,array('option' => $contactGroupsDB->getArray()));
		$form->add('list2', 'select',lang::read('admin.tools.mailing.controller.mailinglist').' 2',null,array('option' => $contactGroupsDB->getArray()));

		$form->setHandler($this);
		$form->handle();
		
		$this->smarty->assign('formContact',$form);

		$this->pageDisplay('tools');
	}	
	public function mergeContactGroupSuccess($data) {
		
		$groupId1 = $data['list1'];
		$groupId2 = $data['list2'];

		router::reload();	
	}	

	////////////////////////////////
	/////DB explorer////////////////
	////////////////////////////////
	
	public function showTable() {
		$tableName = $this->request->getVariable('id');
		$this->smarty->assign('dbTableObject',new $tableName());
		$this->pageDisplay('tools');
	}
	public function editRow() {
		
		$tableName = $this->request->getVariable('id');
		$this->smarty->assign('dbTableObject',new $tableName());		
		
		$tableName = $this->request->getVariable('id');
		$rowId =  $this->request->getVariable('secoundId');
		
		$table = new $tableName();
		$row = $table->fetchRow("id={$rowId}");
		unset($row->id);
		
		$formEdit = new form('editRow','editRowSuccess',$_POST,'POST','form-horizontal');
		foreach ($row as $key=>$val){
			if ($key=='content' or $key=='description') {
				$formEdit->add($key, 'textarea',$key,$val);
			}else{
				$formEdit->add($key, 'input-text',$key,$val);
			}
						
		}
		$formEdit->setHandler($this);
		$formEdit->handle();
		
		
		$this->smarty->assign('formTableRowEdit',$formEdit);
		$this->pageDisplay('tools');
	}
	public function editRowSuccess($data) {
		$tableName = $this->request->getVariable('id');
		$rowId =  $this->request->getVariable('secoundId');
		$table = new $tableName();
		unset($data['id']);
		
		$table->updateRow($data, "id={$rowId}");
		router::reload();
	}
	public function migrationConnectionSetup() {
		$form = new form('setupMySQL','migrationSetupMySQLSuccess',$_POST,'POST','form-vertical');
		$form->add('host', 'input-text',null,null,array("class" => "input-medium","placeholder" => 'database host'));
		$form->addRule('host', 'required', null, lang::read('validator.required'));
		
		$form->add('name', 'input-text',null,null,array("class" => "input-medium","placeholder" => 'database name'));
		$form->addRule('name', 'required', null, lang::read('validator.required'));
		
		$form->add('user', 'input-text',null,null,array("class" => "input-medium","placeholder" => 'username'));
		$form->addRule('user', 'required', null, lang::read('validator.required'));
		
		$form->add('password', 'input-text',null,null,array("class" => "input-medium","placeholder" => 'password'));
		$form->addRule('password', 'required', null, lang::read('validator.required'));
		
		$form->addButton('save','Rozpocznij migracje','btn btn-primary btn-large', null, null, 'fa fa-upload ');
		
		$form->setHandler($this);
		$form->handle();
		
		$this->smarty->assign('formMySQL',$form);		
				
		$this->pageDisplay('tools');
	}
	public function migrationSetupMySQLSuccess($data=null){
		if ($data==null) {
			$dataPom = unserialize(config::get('MySQLmigrationDatabaseConfig'));
			$server   = $dataPom['DB_HOST'];
			$database = $dataPom['DB_NAME'];
			$username = $dataPom['DB_USER'];
			$password = $dataPom['DB_PASSWORD'];			
		}else{
			$server   = $data['host'];
			$database = $data['name'];
			$username = $data['user'];
			$password = $data['password'];
		}
		$mysqlConnection = @mysql_connect($server, $username, $password);
		mysql_select_db($database, $mysqlConnection);
		
		if (!$mysqlConnection){
			config::set('MySQLmigrationDatabaseConfig',null);
			router::reload('admin.message.error.mysql.conection','mn');
		}else{		
			$dataFinal['DB_HOST'] = $server;
			$dataFinal['DB_NAME'] = $database;
			$dataFinal['DB_USER'] = $username;
			$dataFinal['DB_PASSWORD'] = $password;
			
			$sql = baseFile::readFile(__SITE_PATH.'/app/plugins/database/sql/db_structure.sql');
			$sqlParts = explode(';', $sql);
			unset($sqlParts[0]);
			unset($sqlParts[count($sqlParts)]);
			$error=0;
			foreach ($sqlParts as $sqlPart){
				if (mysql_query($sqlPart,$mysqlConnection)!=1) {
					$error=1;
				}
			}
			
			mysql_close($mysqlConnection);

			if ($error==1) {
				router::reload('admin.message.error.mysql.createstructure','mn');
			}			
			
			config::set('MySQLmigrationDatabaseConfig', $dataFinal);
			router::redirect('admin-tools-action',array('subpage'=>'database','action'=>'migrationCopyData'));
		}	
	}
	public function migrationCopyData() {
		$dbList = cache::read('dbFileList');
		$rowsCountPomSum = 0;
		foreach ($dbList as $dbFile){
			$tableName = rtrim($dbFile->name,'.class.php');
			if (method_exists($tableName, 'fetchAll')){
				$tablesToMigrateComma.='"'.$tableName.'",';
				
				$tablePom = new $tableName;
				$rowsCountPom = $tablePom->fetchCount();
				$rowsCountPomSum = $rowsCountPomSum+$rowsCountPom;
				$tablesToMigrateRowsCountComma.='"'.$tablePom->fetchCount().'",';
			}
		}
		$tablesToMigrateComma = rtrim($tablesToMigrateComma,',');
		$tablesToMigrateRowsCountComma = rtrim($tablesToMigrateRowsCountComma,',');
		
		$this->smarty->assign('rowsCountPomSum',$rowsCountPomSum);
		$this->smarty->assign('tablesToMigrateComma',$tablesToMigrateComma);
		$this->smarty->assign('tablesToMigrateRowsCountComma',$tablesToMigrateRowsCountComma);
		$this->pageDisplay('tools');
	}
	public function migrationCheck(){
		$dbList = cache::read('dbFileList');
		$dbConfig = unserialize(config::get('MySQLmigrationDatabaseConfig'));

		foreach ($dbList as $value) {
			
			$tableName = rtrim($value->name,'.class.php');
			if (method_exists($tableName, 'fetchAll')){
				$newTable = new $tableName($dbConfig);
				$tablesCheckResult[$tableName]['newCount'] = $newTable->fetchCount();
				
				$oldTable = new $tableName();
				$tablesCheckResult[$tableName]['oldCount'] = $oldTable->fetchCount();
			}	
		}
		$this->smarty->assign('tablesCheckResult',$tablesCheckResult);
		$this->pageDisplay('tools');
	}
	public function migrationFinish(){
		$dbConfig = unserialize(config::get('MySQLmigrationDatabaseConfig'));
		$server = $dbConfig['DB_HOST'];
		$database = $dbConfig['DB_NAME'];
		$username = $dbConfig['DB_USER'];
		$password = $dbConfig['DB_PASSWORD'];
		
		$configFilePath = __SITE_PATH.'/app/includes/configDB.php';
			
		$configContent = "<?php
		define('DB_TYPE', 'mysql');
		
		//MySQL Database
		define('DB_HOST', '{$server}');
		define('DB_NAME', '{$database}');
		define('DB_USER', '{$username}');
		define('DB_PASSWORD', '{$password}');
		?>";
		
		baseFile::saveFile($configFilePath, $configContent);
		router::redirect('admin');		
	}
	public function searchResult() {
		$excludedTables = array('cacheDB','sessionDB','accesslogDB');
		$searchString = base64_decode($this->request->getVariable('id'));
		
		$dbList = cache::read('dbFileList');
		foreach ($dbList as $table) {
			$tableName = str_replace('.class.php', '', $table->name);
			if (!in_array($tableName, $excludedTables)) {
				
				$table = @new $tableName();
				
				if (method_exists ( $table ,'fetchAll')) {
					$columnsPom = $table->fetchRow();
					if ($columnsPom!=null) {
						$columns = array();
						foreach ($columnsPom as $kay=>$column){
							$columns[] = '`'.$kay.'`';
						}
	
						$searchResult[$tableName]=$table->fetchTextSearch($searchString,$columns);
					}
				}
			}
		}
		$this->smarty->assign('searchString',$searchString);
		$this->smarty->assign('searchResult',$searchResult);
		$this->pageDisplay('tools');
	}	
	////////////////////////////////
	/////Monitoring/////////////////
	////////////////////////////////		
	
	public function showStatChart() {
		$chartType = $this->request->getVariable('id');
		$this->smarty->assign('chartType',$chartType);
		$this->pageDisplay('tools');
		
	}
}
?>
