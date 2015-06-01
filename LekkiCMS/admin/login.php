<?php
	ob_start();
	header('Content-Type:text/html;charset=utf-8');
	session_start();
	
	//Load LCMS DataBase
	require_once('../inc/engine/JuneTxtDb.php');
	$db = new JuneTxtDB(array('db_root_dir'=>'../inc/data/'));
	$db->select_db('db');
	
	//Get pepper from DB
	if($query = $db->select('settings',array('field'=>'pepper')))
		$pepper = $query[0];
	
	//Check if user is logged in
	if(isset($_SESSION[md5($_SERVER['REMOTE_ADDR'].$pepper['value'])]) && is_array(unserialize($_SESSION[md5($_SERVER['REMOTE_ADDR'].$pepper['value'])]))) {
		header('Location: index.php');
		exit;
	}

	//Load login template
	$pattern = file_get_contents('../themes/admin/template.login.html');

	//Login
	$error = NULL;
	if(isset($_POST['login'])) {
		if(!empty($_POST['username']) && !empty($_POST['password'])) {
			$login = htmlspecialchars(trim($_POST['username']));
			$password = md5($_POST['password'].$pepper['value']);
			if($user = $db->select('users',array('login'=>$login))) {
				$record = $user[0];
				if($record['pass'] == $password) {
					$_SESSION[md5($_SERVER['REMOTE_ADDR'].$pepper['value'])] = serialize(array('lcms_user'=>$record['id']));
					header('Location: index.php');
				} else $error = '<div id="top_error">Wprowadzono niepoprawne dane</div>';
			} else $error = '<div id="top_error">Wprowadzono niepoprawne dane</div>';
		} else $error = '<div id="top_error">Nie uzupełniono wszystkich pól</div>';
	}

	//Replace error notice in template
	$pattern = str_replace('{{error}}', $error, $pattern);
	//Display template
	echo $pattern;

	ob_end_flush();
?>