<?php /*windu.org model*/
Class tagsPageController extends widgetMainController
{		
	public function run() {
		$pagesDB = new pagesDB();
		return array("pagesDB" => $pagesDB);
	}
}
?>