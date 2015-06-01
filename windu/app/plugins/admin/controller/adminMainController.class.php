<?php /*windu.org admin controller*/
Class adminMainController extends adminAuthController
{	
	public function __construct(request $request, $plugins = array())
	{
		//Checking system instalation
		if (config::get('install')==0){
			router::redirect('admin-install');
		}		
		
		parent::__construct($request);
		$notifyDB = new notifyDB();
		$notifications = $notifyDB->fetchAll('closed = 0','priority DESC,insertTime DESC');
		$this->smarty->assign('notifications',$notifications);	
		$this->smarty->assign('configDB',new configDB());		
		$this->smarty->assign('pagesDB',new pagesDB());
		$this->smarty->assign('loggedUser',usersDB::getLoggedUser());
		
		$pinsIconsArray = array(
				'pages'=>'icons-clipboard-list',
				'images'=>'icons-inbox-slide',
				'files'=>'icons-blue-folder-horizontal',
				'banners'=>'icons-caution-board',
				'polls'=>'icons-document-task',
				'calendar'=>'icons-calendar-list',
				'lang'=>'icons-direction',
				'trash'=>'icons-popcorn',
				'autosave'=>'icons-disk-black',
				'forums'=>'icons-application-list',
				'posts'=>'icons-balloon-white-left',
				'stats'=>'icons-balloon-white-left',
				'moderator'=>'icons-balloon-white-left',
				'admins'=>'icons-user-black',
				'users'=>'icons-user-yellow',
				'authorization'=>'icons-wallet',
				'themes'=>'icons-resource-monitor',
				'widgets'=>'icons-resource-monitor-protector',
				'tools'=>'icons-wooden-box',
				'monitoring'=>'icons-application-monitor',
				'rss'=>'icons-printer',
				'seo'=>'icons-globe',
				'mailing'=>'icons-mail--arrow',
				'contacts'=>'icons-inbox-document-text',
				'database'=>'icons-databases',
				'config'=>'icons-gear',
				'0'=>'icons-gear',
				'1'=>'icons-gear',
				'2'=>'icons-gear',
				'3'=>'icons-gear',
				'4'=>'icons-gear',
				'5'=>'icons-gear',
				'system'=>'icons-system-monitor',
				'stats'=>'icons-chart-up',
				'notifications'=>'icons-caution-board',
				'backup'=>'icons-wooden-box-label',
				'log'=>'icons-rocket',
				'cron'=>'icons-clipboard-invoice',
				'firewall'=>'icons-network-ethernet',
				'requestlog'=>'icons-system-monitor-network',
				'showLogs'=>'icons-system-monitor-network',
				'licence'=>'icons-money'
		);		
		
		$this->smarty->assign('pinsIconsArray',$pinsIconsArray);
	}
	function smartyGo()
	{
		parent::smartyGo();
		$this->smarty->template_dir = array(__SITE_PATH . '/app/plugins/admin/templates/',
											__SITE_PATH . '/app/plugins/admin/templates/mail/');
        if(!DEV_MODE){
            $this->smarty->compile_check = FALSE;
        }
        $this->smarty->setCaching(1);


        $this->smarty->assign('usersDB',$this->usersDB);
		$this->smarty->assign('loggedIn',$this->user);		
		$this->smarty->assign('now',generate::sqlDatetime());							
	}	
	public function pageDisplay($tpl)
	{
		$this->smarty->assign('page_content',$tpl.'.tpl');
		$output = $this->smarty->fetch('main.tpl',usersDB::getLoggedUser()->id.$tpl.$this->request->getVariable('subpage'));
		$output = $this->replaceImagesLinks($output);
		echo $output;
	}		
	public function index(){}
}
?>
