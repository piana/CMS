<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/pages.php');

	//Informations about this module
	function pages_info() {
		global $lang;
		return array(
			'name'	=>	$lang['pages']['pages'],
			'description'	=>	$lang['pages']['pages desc'],
			'author'	=>	'Klocek',
			'version'	=>	'0.4',
			'add2nav'	=>	TRUE
		);
	}
	
?>
