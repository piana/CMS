<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/users.php');

	//Informations about this module
	function users_info() {
		global $lang;
		return array(
			'name'	=>	$lang['users']['users'],
			'description'	=>	$lang['users']['users_desc'],
			'author'	=>	'Klocek',
			'version'	=>	'0.2',
			'add2nav'	=>	TRUE
		);
	}
	
?>
