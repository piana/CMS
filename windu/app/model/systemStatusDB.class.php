<?php /*windu.org model*/
class systemStatusDB extends baseDB
{
    public function insert($data)
    {
    	$time = date('Y-m-d',strtotime('now'));
		$data['date'] = $time;

    	parent::insert($data);
    } 
	public function addStatus(array $data){
		$this->insert($data);
	}  
	public function haveTodayStatus(){
		$last = $this->fetchRow(null,'id DESC');

		if ($last->date == date('Y-m-d',strtotime('now'))) {
			return true;
		}
		return false;
	}
   	public function clean($date){
   		$date = generate::sqlDate($date);
   		$this->deleteRows("date <= '{$date}'");
   	}		
   	public function getTrend($colName) {
        $last = $this->fetchRow('id>0','id DESC');
        $lastNum = intval($last->$colName);
        $lastBefore = intval($this->fetchRow("id<{$last->id}",'id DESC')->$colName);

        return $lastNum - $lastBefore;
    }
}
?>