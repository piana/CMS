<?php /*windu.org admin controller*/
Class adminUsersDoController Extends adminAuthDoController{
	public function deleteSystemUser(){
		$usersDB = new usersDB();
		$usersDB->deleteUser($this->request->getVariable('id'));
		router::back($this->request);
	}		
	public function deletePageUser(){
		$usersDB = new usersDB();
		$usersDB->deleteUser($this->request->getVariable('id'));
		router::back($this->request);
	}		
	public function deleteUserType(){
		$usersTypeDB = new usertypesDB();
		$usersTypeDB->deleteUserType($this->request->getVariable('id'));
		router::back($this->request);
	}	
	public function toggleUserActivate(){
		$usersDB = new usersDB();
		if($usersDB->get($this->request->getVariable('id'), 'active')==1){
			$usersDB->set($this->request->getVariable('id'),'active',0);
		}else{
			$usersDB->set($this->request->getVariable('id'),'active',1);
		}
		router::back($this->request);
	}	
	
	//Comments/////////////
	public function toggleCommentsStatus(){
		$commentsDB = new commentsDB();
		if($commentsDB->get($this->request->getVariable('id'), 'status')==1){
			$commentsDB->set($this->request->getVariable('id'),'status',0);
		}else{
			$commentsDB->set($this->request->getVariable('id'),'status',1);
		}
		router::back($this->request);
	}
	public function deleteComment(){
		$commentsDB = new commentsDB();
		$commentsDB->delete($this->request->getVariable('id'));
		router::back($this->request);
	}			
}
?>
