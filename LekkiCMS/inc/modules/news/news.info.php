<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/news.php');

	//Informations about this module
	function news_info() {
		global $lang;
		return array(
			'name'	=>	'News',
			'description'	=>	$lang['news']['desc'],
			'author'	=>	'Klocek',
			'version'	=>	'0.4',
			'add2nav'	=>	TRUE
		);
	}

	//Installation
	function news_install() {
		global $db;
		$fields = array(array('name'=>'id','auto_increment'=>true),array('name'=>'title'),array('name'=>'content'),array('name'=>'date'));
		$tablename = 'news';
		if (!$db->_table_exists('db', $tablename)){
		    $db->create_table($tablename,$fields);
		}
		$fields = array(array('name'=>'id','auto_increment'=>true),array('name'=>'field'),array('name'=>'value'));
		$tablename = 'news_settings';
		if (!$db->_table_exists('db', $tablename)){
		    if($db->create_table($tablename,$fields)){
		    	$newRecord = array(NULL,'max_chars','320');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'posts_on_page','5');
		        $db->insert($tablename, $newRecord);
		    }
		}
	}

	//Uninstallation
	function news_uninstall() {
		global $db;
		$db->drop_table('news');
		$db->drop_table('news_settings');
	}
	
?>
