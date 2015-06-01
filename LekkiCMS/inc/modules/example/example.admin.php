<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/example.php');

	//Pages of this module
	function example_pages() {
		$pages[] = array(
			'func'  => 'example_first',
			'title' => 'Test'
		);
		$pages[] = array(
			'func'  => 'example_second',
			'title' => 'Test 2'
		);
		return $pages;
	}

	//Your functions --------------------------------------
	function example_first() {
		global $lang, $db, $core;

		$test = $lang['example']['Hello World'].'!';
		return $test;
	}

	function example_second() {
		global $lang, $db, $core;

		$test = $lang['example']['Hello World'].'2!';
		return $test;
	}

?>
