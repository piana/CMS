<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/news.php');

	//Pages of this module
	function news_pages() {
		global $lang;
		$pages[] = array(
			'func'  => 'news_list',
			'title' => $lang['news']['list']
		);
		$pages[] = array(
			'func'  => 'news_add',
			'title' => $lang['news']['add']
		);
		$pages[] = array(
			'func'  => 'news_settings',
			'title' => $lang['news']['settings']
		);
		return $pages;
	}

	/*** Main functions ********************************************************************************************/

	//List of news
	function news_list() {
		global $lang, $db, $core;
		$result = NULL;

		/*--- EDIT SECTION ---------------------*/
		if(isset($_GET['q']) && $_GET['q']=='edit' && isset($_GET['id'])) {
			$core->append(news_add2head(), 'head');
			$condtion = array('id'=>$_GET['id']); 
            $query = $db->select('news', $condtion);
            if($query) {
					if(isset($_POST['save'])) {
						if(!empty($_POST['title']) && !empty($_POST['content'])) {
								$updateRecord = array($_POST['id'], $_POST['title'], htmlspecialchars_decode(str_replace(PHP_EOL, '\n', stripslashes($_POST['content']))), $_POST['date']);
								if($db->update('news', $condtion, $updateRecord)) $core->notify($lang['news']['update success'],1);
								else $core->notify($lang['news']['update fail'],2);
						}
					} 
					$query = $db->select('news', $condtion);
					$record = $query[0];
					$result .= news_form($record);
			} else $result .= $lang['news']['news doesnt exist'];
		} else {
			/*--- DELETE SECTION -------------------*/
			if(isset($_GET['q']) && $_GET['q']=='del' && isset($_GET['id'])) {
				$condtion = array('id'=>$_GET['id']); 
           		$query = $db->select('news', $condtion);
	            if($query) {
					if($db->delete('news', $condtion)) $core->notify($lang['news']['delete success'],1);
					else $core->notify($lang['news']['delete fail'],1);
				} else $core->notify($lang['news']['news doesnt exist'],2);
			}

			//Select table from DB
			$query = $db->select('news');
			$result .= '<table> <thead>';
			$result .= '<tr> <td>'.$lang['news']['title'].'</td> <td>'.$lang['news']['add date'].'</td> <td width="52px">'.$lang['news']['actions'].'</td> </tr>';
			$result .= '</thead> <tbody>';
			//Get the records
			krsort($query); //Sort
			foreach($query as $record) {
				$result .= '<tr> <td><a href="?go=news&q=edit&id='.$record['id'].'">'.$record['title'].'</a></td> <td>'.$record['date'].'</td> <td><a href="?go=news&q=edit&id='.$record['id'].'" class="icon">Z</a> <a href="?go=news&q=del&id='.$record['id'].'" onclick="return confirm(\''.$lang['news']['delete confirm'].'\')" class="icon">l</a></td> </tr>';
			}
			$result .= '</tbody> </table>';
			//Display info about news
			$result .= '<span class="info">'.$lang['news']['info'].'</span>';
		}

		return $result;
	} //End news_list();

	//Add a new post to DB
	function news_add() {
		global $lang, $db, $core;
		$result = NULL;
		$core->append(news_add2head(), 'head');

		//Show a form
		$result = news_form();
		//Get POST request
		if(isset($_POST['add'])) {
			if(!empty($_POST['title']) && !empty($_POST['content'])) {
				$newRecord = array(NULL, $_POST['title'], str_replace(PHP_EOL, '\n', stripslashes($_POST['content'])), date('Y-m-d H:i:s'));
				if($db->insert('news', $newRecord)) $core->notify($lang['news']['add success'],1);
				else $core->notify($lang['news']['add fail'],2);
			} else $core->notify($lang['news']['empty inputs warning'],2);
		}
		//Return result to LCMS
		return $result;
	} //End news_add();

	//Settings
	function news_settings() {
		global $lang, $db, $core;
		$result = NULL;

		if(isset($_POST['save'])) {
			if(!empty($_POST['posts_on_page']) && !empty($_POST['max_chars'])) {
				if(is_numeric($_POST['posts_on_page']) && is_numeric($_POST['max_chars'])) {
					$error = 0;
					foreach($_POST as $key => $value) {
						if($key != 'save') {
							$query = $db->select('news_settings', array('field'=>$key));
							$record = $query[0];
							if(!$db->update('news_settings', array('field'=>$key), array($record['id'],$key,stripslashes($value)))) $error++;
						}
					}
					if($error) $core->notify($lang['news']['update fail'],2);
					else $core->notify($lang['news']['update success'],1);
				} else $core->notify($lang['news']['non-numeric values warning'],2);
			} else $core->notify($lang['news']['empty inputs warning'],2);
		}

		//Get settings
		if($query = $db->select('news_settings')) {
			foreach((array)$query as $record) $settings[$record['field']] = $record['value'];

			$result .= '<form method="post" action="'.$_SERVER['REQUEST_URI'].'">';
			//Posts on page
			$result .= '<label>'.$lang['news']['posts on page'].' <span>'.$lang['news']['posts on page desc'].'</span></label>';
			$result .= '<input type="text" name="posts_on_page" value="'.$settings['posts_on_page'].'" />';
			//Max chars in post
			$result .= '<label>'.$lang['news']['max chars'].' <span>'.$lang['news']['max chars desc'].'</span></label>';
			$result .= '<input type="text" name="max_chars" value="'.$settings['max_chars'].'" />';
			//Bottom
			$result .= '<button type="submit" name="save">'.$lang['news']['save'].'</button>';
			$result .= '</form>';

		}

		return $result;
	} //End news_settings();

	/*** Additional functions ********************************************************************************************/

	function news_form($data = array()) {
		global $lang, $core;
		$result = '<form name="news" method="post" action="'.$_SERVER['REQUEST_URI'].'">';
		$result .= '<label>'.$lang['news']['title'].' <span>'.$lang['news']['title desc'].'</span></label>';
		$result .= '<input type="text" name="title" value="'.@$data['title'].'" />';
		$result .= '<label>'.$lang['news']['content'].' <span>'.$lang['news']['content desc'].'</span></label>';
		if($core->getSettings('wysiwyg')) $result .= '<div class="wysiwyg"><textarea name="content">'.htmlspecialchars(str_replace('\n', "\n",@$data['content'])).'</textarea></div>';
		else $result .= '<textarea name="content">'.htmlspecialchars(str_replace('\n', "\n",@$data['content'])).'</textarea>';
		if($data) $result .= '<input type="hidden" name="id" value="'.$data['id'].'" /> <input type="hidden" name="date" value="'.$data['date'].'" /> <button type="submit" name="save">'.$lang['news']['save'].'</button>';
		else $result .= '<button type="submit" name="add">'.$lang['news']['add'].'</button>';
        $result .= '</form>';
        return $result;
	}
	
	function news_add2head() {
		global $core;
		$head = '<style type="text/css">
			.LCMS form label {
				width: 12%;
			}
			.LCMS form input[type="text"], .LCMS form textarea {
				width: 80%;
			}
			.LCMS form input[type="submit"], .LCMS form button {
				margin-left: 14%;
			}
			.LCMS form textarea {
				height: 164px;
			}
			.LCMS form .wysiwyg {
				float: left;
				width: 81.5%;
				margin: 0px 0px 20px 10px;
			}
			.LCMS form .wysiwyg textarea {
				width: 100% !important;
				overflow: hidden;
				padding: 0px;
				margin: 0px;
				border: 0;
				font-size: 10pt;
			}
			.LCMS form .wysiwyg textarea:focus {
				box-shadow: none;
			}
		</style>';
		if($core->getSettings('wysiwyg')) {
			$head .= '<link rel="stylesheet" type="text/css" href="../inc/jscripts/CLEditor/jquery.cleditor.css" />
			<script type="text/javascript" src="../inc/jscripts/CLEditor/jquery.cleditor.min.js"></script>
			<script type="text/javascript">$(document).ready(function () { $("textarea").cleditor(); });</script>';
		}
		return $head;
	}

?>
