<?php /*windu.org model*/
Class tagsListNormalController extends widgetMainController
{		
	public function run() {
		$pagesDB = new pagesDB();
		return array("pagesDB" => $pagesDB);
	}
}
?>