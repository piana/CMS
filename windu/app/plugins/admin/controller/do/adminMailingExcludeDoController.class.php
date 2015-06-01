<?php /*windu.org admin controller*/
Class adminMailingExcludeDoController Extends controller{
	public function exclude(){
		$contactDB = new contactDB();
		$contactDB->exclude($this->request->getVariable('ekey'));
		//TODO przekeirowanie na wiadomosc o tym ze email usuniety
		router::redirect('front');
	}				
}
?>
