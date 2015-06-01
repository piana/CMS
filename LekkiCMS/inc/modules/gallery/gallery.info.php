<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/gallery.php');

	//Informations about this module
	function gallery_info() {
		global $lang;
		return array(
			'name'	=>	$lang['gallery']['galleries'],
			'description'	=>	$lang['gallery']['gallery desc'],
			'author'	=>	'Klocek',
			'version'	=>	'0.3',
			'add2nav'	=>	TRUE
		);
	}

	//Installation
	function gallery_install() {
		global $db;
		$fields = array(array('name'=>'id','auto_increment'=>true),array('name'=>'name'),array('name'=>'namec'),array('name'=>'thumbs_size'),array('name'=>'img_on_page'),array('name'=>'titles'));
		$tablename = 'gallery';
		if (!$db->_table_exists('db', $tablename)){
		    $db->create_table($tablename,$fields);
		}
	}

	//Uninstallation
	function gallery_uninstall() {
		global $db;
		$db->drop_table('gallery');
	}
	
?>
