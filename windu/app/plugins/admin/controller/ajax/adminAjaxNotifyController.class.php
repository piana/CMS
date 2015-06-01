<?php /*windu.org admin controller*/
Class adminAjaxNotifyController Extends adminAjaxController{
	public function __construct($request){
		parent::__construct($request);
		$notifyDB = new notifyDB();
		$notifications = $notifyDB->fetchAll('closed = 0','priority DESC,insertTime DESC');
		$this->smarty->assign('notifications',$notifications);			
	}
	public function index()
	{	
		$this->pageDisplay('notifyModal');
	}	
}
?>
