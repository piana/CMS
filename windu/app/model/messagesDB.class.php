<?php /*windu.org model*/
class messagesDB extends ekeyDB
{
	public function add($data) {
		$this->insert($data);
	}	
	public function deleteById($id) {
		$this->delete($id);
	}
}
?>