<?php /*windu.org admin controller*/
Class adminInstallController extends adminNoAuthController
{	
	function smartyGo()
	{
		parent::smartyGo();
		$this->smarty->template_dir = array(__SITE_PATH . '/app/plugins/admin/templates/');
	}
	public function __construct($request){
		if (config::get('install')!=0){
			router::redirect('admin');
			exit;
		}
		parent::__construct($request);
	}
	public function index()
	{	
		$this->smarty->assign('pagesDB',new pagesDB());	
		$this->smarty->assign('title','Select Language');	
		$this->pageDisplayHook('install.tpl','mainSimple.tpl');
	}
	public function setLanguage() {
		config::set('language-front', $this->request->getVariable('id'));
		config::set('language-admin', $this->request->getVariable('id'));
		
		$pagesDB = new pagesDB();
		$pagesDB->update('position','2', "parentId=0");
		$pagesDB->set($this->request->getVariable('id'),'position',1);
		
		router::redirect('admin-install-action',array("action" => "startInstallation"));
	}
	public function startInstallation()
	{	
		$this->smarty->assign('title',lang::read('admin.install.controller.welcome'));	
		$this->pageDisplayHook('install.tpl','mainSimple.tpl');
	}	
	public function selectDatabaseType() {
		$this->smarty->assign('load','15');		
		$this->smarty->assign('title',lang::read('admin.install.controller.selectdb'));	
		$this->pageDisplayHook('install.tpl','mainSimple.tpl');		
	}
	public function setupSQLite() {
		$configFilePath = __SITE_PATH.'/app/includes/configDB.php';
		$configContent = "<?php
		define('DB_TYPE', 'sqlite');
?>";
		
		baseFile::saveFile($configFilePath, $configContent);	
		router::redirect('admin-install-action',array("action" => "setAdministrator"));
	}
	public function setupMySQL() {
		
		$form = new form('setupMySQL','setupMySQLSuccess',$_POST,'POST');
		$form->add('host', 'input-text',null,null,array("class" => "input-medium","placeholder" => 'database host (localhost)'));
		$form->addRule('host', 'required', null, lang::read('validator.required'));

        $form->add('port', 'input-text',null,null,array("class" => "input-medium","placeholder" => 'database port (3306)'));
        $form->addRule('port', 'required', null, lang::read('validator.required'));

        $form->add('name', 'input-text',null,null,array("class" => "input-medium","placeholder" => 'database name'));
		$form->addRule('name', 'required', null, lang::read('validator.required'));

		$form->add('user', 'input-text',null,null,array("class" => "input-medium","placeholder" => 'username'));
		$form->addRule('user', 'required', null, lang::read('validator.required'));

		$form->add('password', 'input-text',null,null,array("class" => "input-medium","placeholder" => 'password'));
		$form->addRule('password', 'required', null, lang::read('validator.required'));		
		
		$form->addButton('save',lang::read('admin.install.controller.next'),'btn btn-primary btn-large', null, null, 'fa fa-upload ');
		
		$form->setHandler($this);
		$form->handle();		
		
		$this->smarty->assign('form',$form);
		$this->smarty->assign('load','30');		
		$this->smarty->assign('title',lang::read('admin.install.controller.setupmysql'));	
		$this->pageDisplayHook('install.tpl','mainSimple.tpl');		
	}
	public function setupMySQLSuccess($data) {
		$server   = $data['host'];
        $port     = $data['port'];
		$database = $data['name'];
		$username = $data['user'];
		$password = $data['password'];


        $mysqlConnection = @mysql_connect($server.':'.$port, $username, $password);


		mysql_select_db($database, $mysqlConnection);
		
		if (!$mysqlConnection){
			router::redirect('admin-install-action',array("action" => "setupMySQL","mn" => "admin.message.error.mysql.conection"));
		}else{
			$dbConfig['DB_HOST'] = $server;
            $dbConfig['DB_PORT'] = $port;
			$dbConfig['DB_NAME'] = $database;
			$dbConfig['DB_USER'] = $username;
			$dbConfig['DB_PASSWORD'] = $password;

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

 			$dbList = baseFile::getFilesList(__SITE_PATH . '/app/model/');
			foreach (explode(',',PLUGINS) as $plugin){
				if (is_dir(__SITE_PATH . '/app/plugins/'.$plugin.'/model/')) {
					$dbPluginList = baseFile::getFilesList(__SITE_PATH . '/app/plugins/'.$plugin.'/model/');
					if (is_array($dbPluginList)) {
						$dbList = array_merge($dbList,$dbPluginList);
					}
				}
			}	
			foreach($dbList as $table){
				$tableName = rtrim($table->name,'.class.php');
				if (method_exists($tableName, 'fetchAll')){
					$tableDB = new $tableName;

					$rows = $tableDB->fetchAll(null,null,'*',null,null,array(),PDO::FETCH_ASSOC);
					$newTable = new $tableName($dbConfig);

					$newTable->insertMultipleFast($rows);
				}	
			}			
 			
 			if ($error==1) {
 				router::redirect('admin-install-action',array("action" => "setupMySQL","mn" => "admin.message.errordbimport"));
 			}
			
			$configFilePath = __SITE_PATH.'/app/includes/configDB.php';
			
			$configContent = "<?php
	define('DB_TYPE', 'mysql'); 
	
	//MySQL Database
	define('DB_HOST', '{$server}');
	define('DB_PORT', '{$port}');
	define('DB_NAME', '{$database}');
	define('DB_USER', '{$username}');
	define('DB_PASSWORD', '{$password}'); 	
?>";

			baseFile::saveFile($configFilePath, $configContent);			
			router::redirect('admin-install-action',array("action" => "setAdministrator"));
		}		
	}	
	public function setAdministrator() {
		$usersDB = new usersDB();
		$form = new form('adduser','setAdministratorSuccess',$_POST,'POST');
		$form->add('email', 'input-text',null,null,array("tooltip" => lang::read('admin.login.controller.autogener'),"class" => "input-medium","placeholder" => lang::read('admin.login.controller.username')));
		$form->addRule('email', 'required', null, lang::read('admin.users.controller.giveemail'));	
		$form->addRule('email', 'email', null, lang::read('admin.users.controller.givecorrectemail'));	
		$form->addRule('email', 'unique', array('table'=>$usersDB), lang::read('admin.users.controller.emailtaken'));

		$form->add('password', 'input-password',null,null,array("tooltip" => lang::read('admin.users.controller.autogener'),"class" => "input-medium","placeholder" => lang::read('admin.users.controller.password')));
		$form->addRule('password', 'string', array(6,50),lang::read('admin.users.controller.toshortpass'));	
		$form->addRule('password', 'same','passwordCompare',lang::read('admin.users.controller.diffpasswords'));
		$form->add('passwordCompare', 'input-password',null,null,array("class" => "input-medium","placeholder" => lang::read('admin.users.controller.repeatpassword')));

		$form->addButton('adduser',lang::read('admin.install.controller.next'),'btn btn-primary btn-large', null, null, 'fa fa-upload ');
		
		$form->setHandler($this);
		$form->handle();
		 
		$this->smarty->assign('form',$form);	
		$this->smarty->assign('load','50');	
		$this->smarty->assign('title',lang::read('admin.install.controller.setadmin'));	
		$this->pageDisplayHook('install.tpl','mainSimple.tpl');
	}	
	public function setAdministratorSuccess($data) {
		if (config::get('salt')==''){config::set('salt', generate::randomCode(32,2));}
		unset($data['passwordCompare']);
		$data['type'] = 9;
		$data['superAdministrator'] = 1;
		$usersDB = new usersDB();
		$user = $usersDB->add($data,1);
		
		mail::send($data['email'], lang::read('admin.users.controller.youruserdata'),$this->pageFetchHook('mail/mailRegisterAdminUser.tpl','mail/mailBase.tpl','page',$data));
		
		//set firewall info email
		config::set('firewallEmail', $data['email']);
		
		$usersDB->login($data['email'], $data['password'],3600*24*7);
		log::write($data['email'],logDB::BUCKET_LOGIN_SUCCESS);
	
		router::redirect('admin-install-action',array("action" => "setBasicConfig"));
	}	
	
	public function setBasicConfig() {
		$usersDB = new usersDB();
		
		$form = new form('setBasicConfig','setBasicConfigSuccess',$_POST,'POST');
		$form->add('pageName', 'input-text',null,null,array("class" => "input-medium","placeholder" => lang::read('admin.install.controller.pagename')));
		$form->addRule('pageName', 'required', null, lang::read('admin.content.controller.giveelementname'));	

		$form->add('timezone', 'select',lang::read('admin.install.controller.timezone'),lang::read('defaultTimezone'),array("option"=>generate::timezonesArray()));
		$form->addRule('timezone', 'required', null, lang::read('admin.content.controller.giveelementname'));			
		
		$form->addButton('addbasicconfig',lang::read('admin.install.controller.next'),'btn btn-primary btn-large', null, null, 'fa fa-upload ');
		
		$form->setHandler($this);
		$form->handle();
		 
		$this->smarty->assign('form',$form);	
		$this->smarty->assign('load','75');	
		$this->smarty->assign('title',lang::read('admin.install.controller.setbasicconfig'));	
		$this->pageDisplayHook('install.tpl','mainSimple.tpl');
	}	
	public function setBasicConfigSuccess($data) {
		config::set('pageName', $data['pageName']);
		$pagesDB = new pagesDB();
		$pagesDB->update('title', $data['pageName'], "type=".pagesDB::TYPE_LANG_CATALOG);
		
		config::set('timezone', $data['timezone']);
		
		router::redirect('admin-install-action',array("action" => "finish"));
	}		
	public function finish() {
		$configDB = new configDB();
		config::set('install', 1);
			
		$this->smarty->assign('load','100');	
		$this->smarty->assign('title',lang::read('admin.install.controller.installend'));	
		$this->smarty->assign('finish',true);	
		$this->pageDisplayHook('install.tpl','mainSimple.tpl');
	}
}
?>
