<?php
	ob_start();
	
	header('Content-Type:text/html;charset=utf-8');
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	session_start();

	//Check if LCMS has been installed
	if (file_exists('../install.php')) {
		header('Location: ../install.php');
		exit;
	}
	
	//Load LCMS DataBase
	require_once('../inc/engine/JuneTxtDb.php');
	$db = new JuneTxtDB(array('db_root_dir'=>'../inc/data/'));
	$db->select_db('db');
	
	//Get pepper from DB
	if($query = $db->select('settings',array('field'=>'pepper')))
		$pepper = $query[0];

	//Check if user is logged in
	if(!isset($_SESSION[md5($_SERVER['REMOTE_ADDR'].$pepper['value'])]) || !is_array(unserialize($_SESSION[md5($_SERVER['REMOTE_ADDR'].$pepper['value'])]))) {
		header('Location: login.php');
		exit;
	}

	//Load LCMS Admin Core
	require_once('../inc/engine/core.admin.php');
	$core = new core();
	
	ob_end_flush();
?>