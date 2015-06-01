<?php /*windu.org front controller*/
Class rssController Extends htmlController {
	function smartyGo()
	{
		parent::smartyGo();
		$this->smarty->template_dir = array(__SITE_PATH . '/app/plugins/rss/templates/');
	}
	public function index()
	{
        lang::setFrontLanguage('');

		$pagesDB = new pagesDB();
		
		$limit = config::get('rssLimit');
        if(!is_numeric($limit)){
            $limit = 10;
        }

		$pages = $pagesDB->fetchAll("langId = ".LANG." AND createTime <= '".generate::sqlDatetime()."' AND status=".pagesDB::STATUS_ACTIVE." AND type=".pagesDB::TYPE_NEWS,'date DESC,createTime DESC','*',$limit);
		foreach ($pages as $page){
			$page->content = str_replace('{{$HOME}}', HOME, $page->content);
			$finalPagesArr[] = $page;
		}

		$pageInfo = new stdClass();
		
		$pageInfo->name = config::get('pageName');
		$pageInfo->description = config::get('pageDescription');
		
		$this->smarty->assign('pages',$finalPagesArr);
		$this->smarty->assign('pageInfo',$pageInfo);
        $this->smarty->assign('usersDB',new usersDB());
		$this->pageDisplay('standard.tpl');
	}
}
?>
