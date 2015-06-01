<?php /*windu.org admin controller*/
Class adminAjaxMailingController Extends adminAjaxController{
	public function __construct($request){
		$this->usersDB = new usersDB();
		$this->noteDB = new notesDB();
		$this->user = $this->usersDB->getLoggedIn();
		
		parent::__construct($request);
	}
	public function index()
	{	
		
	}	
	public function sendMailing()
	{	
		
		$this->pageDisplay('mailingSend');
	}
}
?>
