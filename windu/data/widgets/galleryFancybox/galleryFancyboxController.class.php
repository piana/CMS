<?php
Class galleryFancyboxController extends widgetMainController
{		
	public function run() {
		$imagesDB = new imagesDB();
		return array("imagesDB" => $imagesDB);
	}
}
?>