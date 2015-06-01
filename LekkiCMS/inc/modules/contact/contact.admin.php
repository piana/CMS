<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/contact.php');

	//Pages of this module
	function contact_pages() {
		global $lang;
		$pages[] = array(
			'func'  => 'contact_settings',
			'title' => $lang['contact']['options']
		);
		return $pages;
	}

	/*** Main functions ********************************************************************************************/

	//Settings
	function contact_settings() {
		global $lang, $db, $core;

		if(isset($_POST['save'])) {
			if(!empty($_POST['mail'])) {
				if(!filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)) $core->notify($lang['contact']['invalid mail'],2);
				else {
					if($db->update('contact',array('id'=>'1'),array('1',$_POST['mail']))) $core->notify($lang['contact']['save success'],1);
					else $core->notify($lang['contact']['save fail'],2);
				}
			} else {
				if($db->update('contact',array('id'=>'1'),array('1',$_POST['user']))) $core->notify($lang['contact']['save success'],1);
				else $core->notify($lang['contact']['save fail'],2);
			}
		}

		//Get actual mail
		if($query = $db->select('contact')) {
			$record = $query[0];
			$actualMail = $record['mail_user'];
		} else $actualMail = NULL;

		//Display form
		$result = '<form name="contact" method="post" action="'.$_SERVER['REQUEST_URI'].'">';
		$result .= '<label>'.$lang['contact']['user'].' <span>'.$lang['contact']['user desc'].'</span></label>';
		$result .= '<select name="user"> '.contact_getUsers('<option value="{{id}}" {{selected}}>{{login}} - {{mail}}</option>',$actualMail).' </select>';
		$result .= '<label>'.$lang['contact']['mail'].' <span>'.$lang['contact']['mail desc'].'</span></label>';
		$result .= '<input type="text" name="mail" placeholder="'.$lang['contact']['can be empty'].'" value="'.(!is_numeric($actualMail)?$actualMail:'').'" />';
		$result .= '<button type="submit" name="save">'.$lang['contact']['save'].'</button>';
        $result .= '</form>';
        $result .= '<span class="info">'.$lang['contact']['choice of e-mail'].' '.$lang['contact']['info'].'</span>';

		return $result;
	} //End contact_settings();

	/*** Additional functions ********************************************************************************************/

	function contact_getUsers($pattern, $selected){
		global $lang, $db, $core;
		if($query = $db->select('users')) {
			foreach($query as $record) {
				$replaced = str_replace('{{login}}', $record['login'], $pattern);
				$replaced = str_replace('{{mail}}', $record['mail'], $replaced);
				$replaced = str_replace('{{id}}', $record['id'], $replaced);
				if($selected == $record['id'] && is_numeric($selected)) $replaced = str_replace('{{selected}}', 'selected', $replaced);
				else $replaced = str_replace('{{selected}}', '', $replaced);
			}
			return $replaced;
		}
	}
?>
