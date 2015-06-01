<?php /*windu.org model*/
class ratesDB extends baseDB
{
	function __construct($customMySQL = array())
	{
		$this->otherDbFile = FILE_DB_LOG_FILE;
		parent::__construct($customMySQL);
	}	
	public function add($data) {
		$data['createIp'] = generate::ip();
		$data['createTime'] = generate::sqlDatetime();
		return $this->insert($data);
	}
	public function checkUnique($elementId,$bucket){
		$usersDB = new usersDB();
		$user = $usersDB->getLoggedIn();
		
		if (!empty($user)) {
			$userWhere = "and userId={$user->id}";
		}else{
			$ip = generate::ip();
			$userWhere = "and createIp='{$ip}'";
		}

		if (!is_numeric($elementId)){
			$tableName = $bucket;
			$tableDB = new $tableName();
			$elementId = $tableDB->getByEkey($elementId)->id;
		}
		$count = $this->fetchCount("elementId = {$elementId} and bucket = '{$bucket}' {$userWhere}");
		if($count<=0)return true;
		return false;
	}
	public function getRatesByElement($elementId,$bucket) {
		if (!is_numeric($elementId)){
			$tableName = $bucket;
			$tableDB = new $tableName();
			$elementId = $tableDB->getByEkey($elementId)->id;
		}

		$rates = $this->fetchCountGroup("rate","elementId = {$elementId} and bucket = '{$bucket}'");
		return $rates;
	}
	public function getElementRate($elementId,$bucket) {
		if (!is_numeric($elementId)){
			$tableName = $bucket;
			$tableDB = new $tableName();
			$elementId = $tableDB->getByEkey($elementId)->id;
		}
		$rates = $this->fetchSum("rate","elementId = {$elementId} and bucket = '{$bucket}'");
		return $rates;
	}	
}
?>
