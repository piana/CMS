<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/snippets.php');

	//Pages of this module
	function snippets_pages() {
		global $lang;
		$pages[] = array(
			'func'  => 'snippets_list',
			'title' => $lang['snippets']['list']
		);
		$pages[] = array(
			'func'  => 'snippets_add',
			'title' => $lang['snippets']['add']
		);
		return $pages;
	}

	/*** Main functions ********************************************************************************************/

	//List of snippets
	function snippets_list() {
		global $lang, $db, $core;
		$result = NULL;

		/*--- EDIT SECTION ---------------------*/
		if(isset($_GET['q']) && $_GET['q']=='edit' && isset($_GET['id'])) {
			$condtion = array('id'=>$_GET['id']); 
            $query = $db->select('snippets', $condtion);
            if($query) {
					if(isset($_POST['save'])) {
						if(!empty($_POST['name']) && !empty($_POST['code'])) {
							$snippetExist = FALSE;
							if($queryTWO = $db->select('snippets', array('name'=>$_POST['name']))) {
								$recordTWO = $queryTWO[0];
								if($_POST['id']==$recordTWO['id']) $snippetExist = FALSE;
								else $snippetExist = TRUE;
							}
							if(!$snippetExist) {
								$updateRecord = array($_POST['id'], $_POST['name'], changeSigns($_POST['name']), htmlspecialchars_decode(str_replace(PHP_EOL, '\n', stripslashes($_POST['code']))));
								if($db->update('snippets', $condtion, $updateRecord)) $core->notify($lang['snippets']['update success'],1);
								else $core->notify($lang['snippets']['update fail'],2);
							} else $core->notify($lang['snippets']['snippet exist'],2);
						}
					} 
					$condtion = array('id'=>$_GET['id']);
           			$query = $db->select('snippets', $condtion);
					$record = $query[0];
					$result .= snippets_form($record);
			} else $result .= $lang['snippets']['snippet doesnt exist'];
		} else {
			/*--- DELETE SECTION -------------------*/
			if(isset($_GET['q']) && $_GET['q']=='del' && isset($_GET['id'])) {
				$condtion = array('id'=>$_GET['id']); 
           		$query = $db->select('snippets', $condtion);
	            if($query) {
					if($db->delete('snippets', $condtion)) $core->notify($lang['snippets']['delete success'],1);
					else $core->notify($lang['snippets']['delete fail'],1);
				} else $core->notify($lang['snippets']['snippet doesnt exist'],2);
			}

			//Select table from DB
			$query = $db->select('snippets');
			$result .= '<table> <thead>';
			$result .= '<tr> <td>'.$lang['snippets']['name'].'</td> <td>'.$lang['snippets']['code'].'</td> <td width="52px">'.$lang['snippets']['actions'].'</td> </tr>';
			$result .= '</thead> <tbody>';
			//Get the records
			foreach($query as $record) {
				$result .= '<tr> <td><a href="?go=snippets&q=edit&id='.$record['id'].'">'.$record['name'].'</a></td> <td>{{snip.'.$record['namec'].'}}</td> <td><a href="?go=snippets&q=edit&id='.$record['id'].'" class="icon">Z</a> <a href="?go=snippets&q=del&id='.$record['id'].'" onclick="return confirm(\''.$lang['snippets']['delete confirm'].'\')" class="icon">l</a></td> </tr>';
			}
			$result .= '</tbody> </table>';
			//Display info about snippets
			$result .= '<span class="info">'.$lang['snippets']['info'].'</span>';
		}

		return $result;
	} //End snippets_list();

	//Add a new snippet to DB
	function snippets_add() {
		global $lang, $db, $core;
		$result = NULL;

		//Show a form
		$result = snippets_form();
		//Get POST request
		if(isset($_POST['add'])) {
			if(!empty($_POST['name']) && !empty($_POST['code'])) {
				if(!$db->select('snippets', array('name'=>$_POST['name']))) { //Check exist snippets
					$newRecord = array(NULL, $_POST['name'], changeSigns($_POST['name']), str_replace(PHP_EOL, '\n', stripslashes($_POST['code'])));
					if($db->insert('snippets', $newRecord)) $core->notify($lang['snippets']['add success'],1);
					else $core->notify($lang['snippets']['add fail'],2);
				} else $core->notify($lang['snippets']['snippet exist'],2);
			} else $core->notify($lang['snippets']['empty inputs warning'],2);
		}
		//Return result to LCMS
		return $result;
	} //End snippets_add();

	/*** Additional functions ********************************************************************************************/

	function snippets_form($data = array()) {
		global $lang;
		$result = '<form name="snippets" method="post" action="'.$_SERVER['REQUEST_URI'].'">';
		$result .= '<label>'.$lang['snippets']['name'].' <span>'.$lang['snippets']['name desc'].'</span></label>';
		$result .= '<input type="text" name="name" value="'.@$data['name'].'" />';
		$result .= '<label>'.$lang['snippets']['code'].' <span>'.$lang['snippets']['code desc'].'</span></label>';
		$result .= '<textarea name="code">'.htmlspecialchars(str_replace('\n', "\n", @$data['code'])).'</textarea>';
		if($data) $result .= '<input type="hidden" name="id" value="'.$data['id'].'" /> <button type="submit" name="save">'.$lang['snippets']['save'].'</button>';
		else $result .= '<button type="submit" name="add">'.$lang['snippets']['add'].'</button>';
        $result .= '</form>';
        return $result;
	}

	function changeSigns($text) {
		setlocale(LC_ALL, 'pl_PL');
        $text = str_replace(' ', '-', $text);
        $text = iconv('utf-8', 'ascii//translit', $text);
        $text = preg_replace('#[^a-z0-9\-\.]#si', '', $text);
        return strtolower(str_replace('\'', '', $text));
    } 

?>
