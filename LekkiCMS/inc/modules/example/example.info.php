<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Informations about this module
	function example_info() {
		return array(
			'name'	=>	'example',
			'description'	=>	'An example of a simple module',
			'author'	=>	'Klocek',
			'version'	=>	'0.1',
			'add2nav'	=>	TRUE
		);
	}
	
?>
