<?php /*windu.org admin controller*/
Class adminTrashDoController Extends adminAuthDoController{
	
	public function delete(){
		$pagesDB = new pagesDB();
		$pagesDB->deleteTreeItems($this->request->getVariable('id'),true);
	}	
	public function restore(){
		$pagesDB = new pagesDB();
		$pagesDB->restoreTreeItems($this->request->getVariable('id'));
		router::back($this->request);
	}			
	public function emptyTrash() {
		$pagesDB = new pagesDB();
		$pagesDB->deleteTrashItems();
		router::redirect('admin-content',array('mp'=>'admin.message.operation.success','subpage'=>'trash'));
	}
}
?>
