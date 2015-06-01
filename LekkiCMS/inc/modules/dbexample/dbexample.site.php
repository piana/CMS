<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	//require(LANG.'dbExample.php');

	//Replace pattern by function
	$core->replace('{{dbExample}}', dbExample());

	//Your functions --------------------------------------
	function dbExample() {
		global $core, $db, $lang;
		$result = NULL;

		//Select table 'example_table' from DB
		$query = $db->select('example_table');
		//Get the records
		foreach($query as $record) {
			$result .= $record['firstname'].' '.$record['lastname'].'<br/>';
		}
		//Return result to LCMS
		return $result;
	}

?>
