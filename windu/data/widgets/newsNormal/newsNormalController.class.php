<?php
Class newsNormalController extends widgetMainController
{		
	public function run() {
		$pagesDB = new pagesDB();
		$usersDB = new usersDB();
		return array("pagesDB" => $pagesDB,"usersDB" => $usersDB);
	}
}
?>

