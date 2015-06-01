<?php
class mailDB extends traceDB
{
	function __construct($customMySQL = array())
	{
		$this->otherDbFile = FILE_DB_LOG_FILE;
		parent::__construct($customMySQL);
	}	
	public function add($to,$messageId) {
		$userDB = new usersDB();
		$user = $userDB->fetchRow("email = :mail", null, '*', array(':mail'=>$to));
		
		$data['senderId'] = 0;
		$data['recipientId'] = $user->id;
		$data['to'] = $to;
		$data['messageId'] = $messageId;
		
		return $this->insert($data);
	}
	public function getByRecipientId($id, $order = null, $what = '*', $limit = null) {
		return $this->fetchAll("recipientId = {$id}", $order = null, $what = '*', $limit = null);
	}
	public function getBySenderId($id, $order = null, $what = '*', $limit = null) {
		return $this->fetchAll("senderId = {$id}", $order = null, $what = '*', $limit = null);
	}	
}
?>