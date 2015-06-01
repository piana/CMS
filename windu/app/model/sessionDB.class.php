<?php /*windu.org model*/
class sessionDB extends baseDB
{
	//expire as string
	public function set($data,$expire,$usesNum = 100000000)
	{
		if ($data=='') {
			return null;
		}
		
		$dataFinal['dataKey'] = generate::ekey('sessionDB','dataKey',32,3);

		$dataFinal['data'] = $data;
		$dataFinal['expire'] = generate::sqlDatetime(time()+$expire);
		$dataFinal['usesNum'] = $usesNum;
		$dataFinal['insertIp'] = generate::ip();
		
		$insertedData = $this->insert($dataFinal);
		return $dataFinal['dataKey'];
	}
	public function delete($dataKey)
	{
		return $this->deleteRows("dataKey = '{$dataKey}'");
	}	
	public function clean()
	{
		$now = generate::sqlDatetime();
		return $this->deleteRows("expire < '{$now}' OR usesNum <= 0");
	}
	public function get($dataKey,$usesCheck = false,$ipCheck = false) {
		if ($dataKey=='') {
			return null;
		}
		$dataKey = generate::clean($dataKey);
		$now = generate::sqlDatetime();
		
		if ($ipCheck) {
			$ip = generate::ip();
			$ipWhere = " AND insertIp = '{$ip}'";
		}
		$data = $this->fetchRow("dataKey = '{$dataKey}' AND expire > '{$now}' $ipWhere");
		
		if ($usesCheck) {
			$uses = $data->usesNum-1;
			if ($uses < 0) {
				return 'noMoreUses';
			}
			$this->updateRow(array('usesNum' => $uses), "dataKey = '{$dataKey}'");
		}
		return $data->data;
	}	
	public function hasUses($dataKey) {
		$row = $this->fetchRow("dataKey = '{$dataKey}'");
		if ($row->usesNum>0) {
			return true;
		}
		return false;
	}
}
?>