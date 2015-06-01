<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require(LANG.'contact.php');

	//Replace by function
	$core->replace('{{contact.form}}', contact());

	//Main function
	function contact() {
		global $core, $db, $lang;
		$result = NULL; $notify = NULL;

		if($query = $db->select('contact')) {
			$record = $query[0];

			//Get admin e-mail
			if(is_numeric($record['mail_user'])) {
				if($query = $db->select('users', array('id'=>$record['mail_user']))) {
					$record = $query[0];
					$adminMail = $record['mail'];
				}
			} else $adminMail = $record['mail_user'];

			if(isset($_POST['send'])) {
				if(empty($_POST['captcha'])) {
					if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['mail']) && !empty($_POST['subject']) && !empty($_POST['content'])) {
						if(!filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)) $notify = '<div id="notify">'.$lang['contact']['invalid mail'].'</div>';
						else {
							$headers  = "MIME-Version: 1.0"."\r\n";
							$headers .= "Content-Type: text/html;charset=utf-8\n";
							$headers .= "Content-Transfer-Encoding: 8bit\n";
							$headers .= "FROM: ".$_POST['firstname']." ".$_POST['lastname']." <".$_POST['mail'].">";
		                    $subject = '['.$core->getSettings('title').'] '.$_POST['subject'];
		                    $content = nl2br($_POST['content']);
		                    //Send e-mail
		                    if(mail($adminMail, $subject, $content, $headers)) { 
		                    	$notify = '<div id="notify">'.$lang['contact']['send success'].'</div>';
		                    	$_POST = array(); 
		                    } else $notify = '<div id="notify">'.$lang['contact']['send fail'].'</div>';
						}

					} else $notify = '<div id="notify">'.$lang['contact']['empty inputs'].'</div>';
				}
			}
		}

		$result .= $notify;
		$result .= contact_form($_POST);
		return $result;
	} //End contact();

	//Form
	function contact_form($data = array()) {
		global $core, $db, $lang;

		$result = '<form name="contact" method="post" action="'.$_SERVER['REQUEST_URI'].'">';
		//First name
		$result .= '<label>'.$lang['contact']['firstname'].'</label>';
		$result .= '<input type="text" name="firstname" value="'.htmlspecialchars(@$data['firstname']).'" />';
		//Last name
		$result .= '<label>'.$lang['contact']['lastname'].'</label>';
		$result .= '<input type="text" name="lastname" value="'.htmlspecialchars(@$data['lastname']).'" />';
		//E-Mail
		$result .= '<label>'.$lang['contact']['mail'].'</label>';
		$result .= '<input type="text" name="mail" value="'.@$data['mail'].'" />';
		//Subject
		$result .= '<label>'.$lang['contact']['subject'].'</label>';
		$result .= '<input type="text" name="subject" value="'.htmlspecialchars(@$data['subject']).'" />';
		//Content
		$result .= '<label>'.$lang['contact']['content'].'</label>';
		$result .= '<textarea name="content">'.htmlspecialchars(@$data['content']).'</textarea>';
		//Hidden input
		$result .= '<input type="text" name="captcha" style="display:none;" />';
		//Bottom
		$result .= '<button type="submit" name="send">'.$lang['contact']['send'].'</button>';
		$result .= '</form>';
		return $result;
	} //End contact_form();

?>
