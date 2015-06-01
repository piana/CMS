<?php /*windu.org model*/
Class menuIconsDroppyController extends widgetMainController
{		
	public function run() {
		$pagesDB = new pagesDB();
		$imagesDB = new imagesDB();
		return array("pagesDB" => $pagesDB,"imagesDB" => $imagesDB);
	}
}
?>