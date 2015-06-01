<?php /*windu.org admin controller*/
Class adminCheckController extends adminMainController
{	
	public function index()
	{
        $chechMethodString = '';
		foreach (check::$allCheckMethods as $method){
			$chechMethodString .= '"'.$method.'",';
		}
		$chechMethodString = rtrim($chechMethodString,',');
		$backUrl = $this->request->getVariable('back');
		if ($backUrl==null) {
			$backUrl = HOME.'admin/';
		}else{
			$backUrlPom = str_replace('admin/login/', 'admin/', ltrim(base64_decode($backUrl),'/'));
			$backUrl = HOME.$backUrlPom;
		}
		
		$this->smarty->assign('backUrl',$backUrl);
		$this->smarty->assign('methodsToCheckSerialized',$chechMethodString);
		$this->pageDisplayHook('check.tpl','mainSimple.tpl');
	}

}
?>
