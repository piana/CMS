<?php /*windu.org front controller*/

Class frontMainController extends htmlController
{	
	public function __construct(request $request)
	{
		parent::__construct($request);
		
		//Checking system instalation
		if (config::get('install')==0){
			router::redirect('admin-install');
		}			
		cron::run();
	}
	public function smartyGo()
	{
		parent::smartyGo();
		$template = themesDB::getThemeName();
		$this->smarty->template_dir = array(__SITE_PATH.'/app/plugins/front/templates/',
											TEMPLATES_PATH.$template.'/tpl_main/',
											TEMPLATES_PATH.$template.'/tpl_common/',
											TEMPLATES_PATH.$template.'/tpl_mail/',
											TEMPLATES_PATH.$template.'/tpl_views/');	
		$this->smarty->left_delimiter = "{{";
		$this->smarty->right_delimiter = "}}";
		
		if (!ISADMINLOGGED){
			$this->smarty->setCaching(config::get('cache'));
			$this->smarty->setCacheLifetime(config::get('cacheLife'));
		}else{
			$this->smarty->setCaching(0);
		}

		$homeTemplate = str_replace(__SITE_PATH.'/', HOME, TEMPLATES_PATH);
		$this->smarty->assign('TEMPLATE_HOME',$homeTemplate.$template);
		$this->smarty->assign('TEMPLATE_PATH',TEMPLATES_PATH.$template.'/');
		$this->smarty->assign('TEMPLATE_IMG_PATH',TEMPLATES_PATH.$template.'/img/');
		
	}	
	public function index(){}
}
?>
