<?php /*windu.org model*/
class calendarDB extends baseDB
{
	public function insert($data){
		$data['status'] = 1;
		return parent::insert($data);
	}	
	public function add($data) {
		return $this->insert($data);
	}
	public function deleteCalendar($id) {
		$calendarEventsDB = new calendarEventsDB();
		$calendarEventsDB->deleteRows("calendarId={$id}");
		
		return $this->delete($id);
	}
}
?>
