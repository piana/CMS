<?php
	ob_start();
	
	header('Content-Type:text/html;charset=utf-8');
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	session_start();

	//Check if LCMS has been installed
	if (file_exists('install.php')) {
		header('Location: install.php');
		exit;
	}

	//Load LCMS DataBase
	require_once('inc/engine/JuneTxtDb.php');
	$db = new JuneTxtDB(array('db_root_dir'=>'inc/data/'));
	$db->select_db('db');

	//Load LCMS Core
	require_once('inc/engine/core.site.php');
	$core = new core();
	
	ob_end_flush();
?>