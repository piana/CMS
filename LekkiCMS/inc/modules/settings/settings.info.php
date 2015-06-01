<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/settings.php');

	//Informations about this module
	function settings_info() {
		global $lang;
		return array(
			'name'	=>	$lang['settings']['settings'],
			'description'	=>	$lang['settings']['settings desc'],
			'author'	=>	'Klocek',
			'version'	=>	'0.3',
			'add2nav'	=>	TRUE
		);
	}
	
?>
