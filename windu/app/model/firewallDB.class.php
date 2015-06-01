<?php /*windu.org model*/
class firewallDB extends baseDB
{
	function __construct($customMySQL = array())
	{
		$this->otherDbFile = FILE_DB_LOG_FILE;
		parent::__construct($customMySQL);
	}
	public function add() {
		if (config::getSystemRun('firewall')){
			$ip = generate::ip();
			$rowsAdded = $this->fetchCount("createIp='{$ip}'");
			if ($rowsAdded>0) {
				$denyRow = $this->fetchRow("createIp='{$ip}'");
				$data['status'] = $denyRow->status + 2;
				$this->updateRow($data,"createIp='{$ip}'");
				
				return $rowsAdded;
			}else{
				$data['status'] = 1;
				$data['createIp'] = $ip;
				$data['createTime'] = generate::sqlDatetime();
				
				$accesslogDB = new accesslogDB();
				$data['accessLog'] = serialize($accesslogDB->fetchAll("ip='{$ip}'"));
				$this->insert($data);
				
				return 1;
			}
		}
		return false;
	}

}
?>