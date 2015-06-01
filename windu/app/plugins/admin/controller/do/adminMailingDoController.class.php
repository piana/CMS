<?php /*windu.org admin controller*/
Class adminMailingDoController Extends adminAuthDoController{
	public function deleteContactGroup() {
		$contactgroupsDB = new contactgroupsDB();
		$contactgroupsDB->delete($this->request->getVariable('id'));
		
		$contactDB = new contactDB();
		$contactDB->deleteByBucket($this->request->getVariable('id'));
		
		$mailingsDB = new mailingsDB();
		$mailingsDB->deleteRows("contactGroup={$this->request->getVariable('id')}");
		router::back($this->request);
	}
	public function deleteTemplate(){
		$mailingtemplatesDB = new mailingtemplatesDB();
		$mailingtemplatesDB->delete($this->request->getVariable('id'));

		$mailingsDB = new mailingsDB();
		$mailingsDB->deleteRows("contentId={$this->request->getVariable('id')}");		
		
		router::back($this->request);
	}
	public function deleteEmail(){
		$contactDB= new contactDB();
		$contactDB->delete($this->request->getVariable('id'));
		router::back($this->request);
	}	
	public function deleteMailing(){
		$mailingsDB = new mailingsDB();
		$mailingsDB->delete($this->request->getVariable('id'));
		router::back($this->request);
	}	
	public function sendMailing(){
		$mailingsDB = new mailingsDB();
		$mailingsDB->sendMailing($this->request->getVariable('id'));
		router::back($this->request);
	}		
	public function sendAllMailings(){
		$mailingsDB = new mailingsDB();
		$allActiveMailings = $mailingsDB->getActive();

		foreach ($allActiveMailings as $mailing){
			$mailingsDB->sendMailing($mailing->id);
		}
		router::back($this->request);
	}		
	public static function sendAllActiveMailings() {
		$mailingsDB = new mailingsDB();
		$allActiveMailings = $mailingsDB->getActive();
		$sendedEmails = 0;
		foreach ($allActiveMailings as $mailing){
			$sendMailing = $mailingsDB->sendMailing($mailing->id);
			$sendedEmails = $sendedEmails + intval($sendMailing);
		}
		return 'admin.mailingdocontrollersendmailing_'.$sendedEmails;
	}	
}
?>
