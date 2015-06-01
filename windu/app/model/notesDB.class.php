<?php /*windu.org model*/
class notesDB extends traceDB
{
	public function add($data) {
		
		$data['content'] = str_replace("'",'"',$data['content']);
		$this->insert($data);
	}
	public function getNote($id) {
		return $this->fetchRow("id={$id}");
	}
	public function getNotesByUser($userId) {
		return $this->fetchAll("userId = {$userId}");
	}
	public function deleteNote($id) {
		$this->delete($id);
	}	
	public function deleteAllNotesByUser($userId) {
		$this->deleteRows("userId = {$userId}");
	}
	public static function count() {
		$notesDB = new notesDB();
		$userId = usersDB::getLoggedUser()->id;

		return $notesDB->fetchCount("userId={$userId}");
	}	
}
?>
