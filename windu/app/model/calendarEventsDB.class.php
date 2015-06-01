<?php /*windu.org model*/
class calendarEventsDB extends baseDB
{
	public function insert($data){
		$data['status'] = 1;
		return parent::insert($data);
	}	
	public function add($data) {
		$this->insert($data);
	}
}
?>
