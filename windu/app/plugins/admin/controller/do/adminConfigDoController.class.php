<?php /*windu.org admin controller*/
Class adminConfigDoController Extends adminAuthDoController{
	public function delete(){
		$configDB = new configDB();
		$bucket = $configDB->get($this->request->getVariable('id'), 'bucket');
		$configDB->delete($this->request->getVariable('id'));
		router::back($this->request);
	}	
}
?>
