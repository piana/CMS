<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/contact.php');

	//Informations about this module
	function contact_info() {
		global $lang;
		return array(
			'name'	=>	$lang['contact']['contact'],
			'description'	=>	$lang['contact']['contact desc'],
			'author'	=>	'Klocek',
			'version'	=>	'0.2',
			'add2nav'	=>	TRUE
		);
	}

	//Installation
	function contact_install() {
		global $db;
		$fields = array(array('name'=>'id','auto_increment'=>true),array('name'=>'mail_user'));
		$tablename = 'contact';
		if (!$db->_table_exists('db', $tablename)){
		    if($db->create_table($tablename,$fields)) {
		    	$db->insert($tablename, array(NULL,'1'));
		    }
		}
	}

	//Uninstallation
	function contact_uninstall() {
		global $db;
		$db->drop_table('contact');
	}
	
?>
