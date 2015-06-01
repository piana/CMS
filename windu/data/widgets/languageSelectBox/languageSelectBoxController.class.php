<?php
Class languageSelectBoxController extends widgetMainController
{		
	public function run() {
		return array("pagesDB"=> new pagesDB());
	}
}
?>