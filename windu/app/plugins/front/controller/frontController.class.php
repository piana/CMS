<?php /*windu.org front controller*/
Class frontController Extends frontMainController {
	public function index()
	{
		$pagesDB = new pagesDB();
		$imagesDB = new imagesDB();
		$usersDB = new usersDB();
		
		$urlKey = generate::clean($this->request->getVariable('urlKey'));
		lang::setFrontLanguage($urlKey);
		
		$page = $pagesDB->getPageByUrlKeySmart($urlKey);
		
		if ($page==null){
			router::get404Redirect(__HOME);
			log::write(__HOME,logDB::BUCKET_404);
			$this->pageDisplay('error404.tpl'); exit;
		}
		
		//Url redirect
		if ($page->type == pagesDB::TYPE_URL) {
			router::redirect(str_replace('{{$HOME}}', HOME, $page->content));
		}
		
		if(!$this->smarty->templateExists($page->tpl)){
		    $pageTpl = themesDB::$basicTpl;
		}else{
			$pageTpl = $page->tpl;
		}
		
		$this->smarty->assign('meta',$pagesDB->meta($page));
		$this->smarty->assign('page',$page);
		$this->smarty->assign('pageTpl',$pageTpl);
		$this->smarty->assign('pagesDB',$pagesDB);
		$this->smarty->assign('imagesDB',$imagesDB);
		$this->smarty->assign('usersDB',$usersDB);
		
		$displayAdminTopMenu = null;
		$adminUser = $usersDB->getLoggedIn('AdminUser');
		if ($adminUser and config::get('showLeftEditor'.$adminUser->id)==1) {
			$displayAdminMenu = $this->smarty->fetch("adminMenuLeft.tpl");
		}elseif($adminUser){
			$displayAdminMenu = '<a title="Editor" href="'.HOME.'admin/mainDo/toggleConfig/showLeftEditor'.$adminUser->id.'/" style="position:fixed; left:10px; bottom:10px; padding:4px; background:#37355a; background-image:url('.HOME.'/app/resources/img/pencil-icon.png); background-position:center center; border:3px solid white; display: inline-block; width:40px; height:40px; -webkit-border-radius: 40px; -moz-border-radius: 40px; border-radius: 40px;"></a>';
		}
		$this->pageDisplay('main.tpl',LANG.__HOME,$displayAdminMenu);
	}
}
?>