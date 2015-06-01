<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/modules.php');

	//Informations about this module
	function modules_info() {
		global $lang;
		return array(
			'name'	=>	$lang['modules']['modules'],
			'description'	=>	$lang['modules']['modules_desc'],
			'author'	=>	'Klocek',
			'version'	=>	'0.1',
			'add2nav'	=>	TRUE
		);
	}
	
?>
