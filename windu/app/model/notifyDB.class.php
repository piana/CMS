<?php /*windu.org model*/
class notifyDB extends baseDB
{
	const STATUS_INFO = 0;
	const STATUS_LIGHT = 1;
	const STATUS_WORNING = 2;
	const STATUS_DANGER = 3;
	const STATUS_ERROR = 4;
	
	public static function add($data,$priority,$url = null)
	{
		$dataFinal['content'] = $data;
		$dataFinal['insertTime'] = generate::sqlDatetime();
		$dataFinal['updateTime'] = generate::sqlDatetime();
		$dataFinal['closed'] = 0;
		$dataFinal['priority'] = $priority;
		$dataFinal['url'] = $url;
		
		$notifyDB = new notifyDB();
		$oldNotify = $notifyDB->fetchRow("content = '".$dataFinal['content']."'");
		
		if ($oldNotify!=null) {
			unset($dataFinal['insertTime']);
			unset($dataFinal['updateTime']);
			if ($priority == 1) {
				$dataFinal['closed'] = $oldNotify->closed;
			}			
			
			$notifyDB->updateRow($dataFinal,"content = '".$dataFinal['content']."'");
		}else{
			$notifyDB->insert($dataFinal);
		}
	}
	public function close($id)
	{
		$this->updateRow(array('closed' => 1),"id = {$id}");
	}	
	public static function closeByName($name)
	{
		$notifyDB = new notifyDB();
		$notifyDB->updateRow(array('closed' => 1),"content = '{$name}'");
	}	
	public function closeAll()
	{
		$this->updateRow(array('closed' => 1),"closed<>1");
	}	
	public function updateRow($data, $where = null) {
		$data['updateTime'] = generate::sqlDatetime();
		parent::updateRow($data, $where);
	}
	public static function count($closed = false) {
		$notifyDB = new notifyDB();
		if ($closed) {
			return $notifyDB->fetchCount('closed=1');
		}
		return $notifyDB->fetchCount('closed=0');
	}
}
?>