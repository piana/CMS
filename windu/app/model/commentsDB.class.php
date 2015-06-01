<?php /*windu.org model*/
class commentsDB extends ekeyDB
{
	const STATUS_HIDE = 0;	
	const STATUS_ACTIVE = 1;

	public function add($data) {
		$usersDB = new usersDB();
		$user = $usersDB->getLoggedIn();
		if (is_object($user)) {
			$data['userId'] = $user->id;
			$data['name'] = $user->username;
			$data['email'] = $user->email;
		}elseif ($data['email']!=null){
			$name = explode('@', $data['name']);
			$data['name'] = $name[0];
			$data['userId'] = 0;
		}
		$data['rating'] = 0;
		$data['status'] = config::get('commentsStatus');
		$this->insert($data);
	}

	public function getByBucket($bucketId,$where = null, $order = "createTime DESC", $what = '*', $limit = null, $bindValues = array() ) {
		if ($where!=null) {
			$where = "bucket = :bucketId AND ".$where;
		}else{
			$where = "bucket = :bucketId";
		}
        $bindValues[':bucketId'] = $bucketId;
                
		return $this->fetchAll($where, $order, $what, $limit, null, $bindValues);
	}

	public function deleteAllByBucket($bucketId) {
         return $this->deleteRows("bucket = :bucketId", array( ':bucketId' => $bucketId) );
	}
}
?>
