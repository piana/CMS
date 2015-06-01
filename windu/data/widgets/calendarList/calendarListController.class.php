<?php /*windu.org model*/
Class calendarListController extends widgetMainController
{		
	public function run() {
		$calendarDB = new calendarDB();
		$calendarEventsDB = new calendarEventsDB();
		
		$id = $this->params['id'];
		
		if ($id!=null) {
			$calendar = $calendarDB->fetchRow("id = {$id}");
			if ($calendar!=null) {
				$events = $calendarEventsDB->fetchAll("calendarId = {$calendar->id}","date DESC");
			}
		}
		
		return array("events" => $events,"calendar" => $calendar);
	}
}
?>