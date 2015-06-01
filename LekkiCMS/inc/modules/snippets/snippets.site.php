<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Function call
	snippets();

	//Pattern replacing --------------------------------------
	function snippets() {
		global $core, $db, $lang;

		if($query = $db->select('snippets')) {
			foreach($query as $record) {
				$core->replace('{{snip.'.$record['namec'].'}}', str_replace('\n', "\n", $record['code']));
			}
		}
	} //End snippets();

?>
