<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/snippets.php');

	//Informations about this module
	function snippets_info() {
		global $lang;
		return array(
			'name'	=>	$lang['snippets']['snippets'],
			'description'	=>	$lang['snippets']['snippets desc'],
			'author'	=>	'Klocek',
			'version'	=>	'0.1',
			'add2nav'	=>	TRUE
		);
	}

	//Installation
	function snippets_install() {
		global $db;
		$fields = array(array('name'=>'id','auto_increment'=>true),array('name'=>'name'),array('name'=>'namec'),array('name'=>'code'));
		$tablename = 'snippets';
		if (!$db->_table_exists('db', $tablename)){
		    if($db->create_table($tablename,$fields)){
		    	$newRecord = array(NULL,'example','example','This is example of snippet');
		        $db->insert($tablename, $newRecord);
		    }
		}
	}

	//Uninstallation
	function snippets_uninstall() {
		global $db;
		$db->drop_table('snippets');
	}
	
?>
