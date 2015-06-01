<?php

		//Make sure the file isn't accessed directly
		defined('IN_LCMS') or exit('Access denied!');

		//Load lang file of this module
		require(LANG.'example.php');

		//Replace pattern by function
		$core->replace('{{example}}', example());

		//Your functions --------------------------------------
		function example() {
			global $lang;

			$test = $lang['example']['Hello World'].'!';
			return $test;
		}

?>
