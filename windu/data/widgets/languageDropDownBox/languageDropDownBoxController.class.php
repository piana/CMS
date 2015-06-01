<?php
Class languageDropDownBoxController extends widgetMainController
{		
	public function run() {
		return array("pagesDB"=> new pagesDB());
	}
}
?>