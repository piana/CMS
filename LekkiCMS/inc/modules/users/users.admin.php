<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/users.php');

	//Pages of this module
	function users_pages() {
		global $lang;
		$pages[] = array(
			'func'  => 'users_management',
			'title' => $lang['users']['management']
		);
		$pages[] = array(
			'func'  => 'users_add',
			'title' => $lang['users']['add']
		);
		return $pages;
	}

	//
	//---------[ USERS MANAGEMENT ]-------------------------------------------------
	//

	//-[ MAIN FUNCTION 1 ] --------------------------------------
	function users_management() {
		global $lang, $db, $core;

		//User delete
		if(isset($_GET['del']) && !empty($_GET['del'])) users_del($_GET['del']);
		//User edit
		if(isset($_GET['edit']) && !empty($_GET['edit'])) $result = users_edit($_GET['edit']);
		else {
		$result = '<table>
						<thead>
							<tr>
								<td>'.$lang['users']['login'].'</td> <td>'.$lang['users']['mail'].'</td> <td>'.$lang['users']['options'].'</td>
							</tr>
						</thead>
						<tbody>';
		$result .= users_get('<tr><td>{{login}}</td> <td>{{mail}}</td> <td>{{actions}}</td>');
		$result .= '</tbody>
					</table>';
		}
		return $result;		
	} //End users_management();

	//Get users
	function users_get($pattern) {
		global $db, $core;
		$result = NULL;
		if($query = $db->select('users')) {
			if($db->num_rows($query)>0) {
				foreach((array)$query as $record) {
					$replaced = str_replace('{{login}}', '<a href="'.$core->fixGet('del&edit:=').$record['id'].'">'.$record['login'].'</a>', $pattern);
					$replaced = str_replace('{{mail}}', $record['mail'], $replaced);
					$replaced = str_replace('{{actions}}', '<a href="'.$core->fixGet('del&edit:=').$record['id'].'" class="icon">Z</a>'.($record['id']==1 ? ' <span class="icon unactive">S</span>' : ' <a href="'.$core->fixGet('del:=').$record['id'].'" class="icon">S</a>'), $replaced);
					$result .= $replaced;
				}
			}
		}
		return $result;
	} //End users_get();

	//Delete a user
	function users_del($id) {
		global $db, $core, $lang;
		if(is_numeric($id) && $id!=1) {
			if($db->select('users', array('id'=>$id))) {
				if($db->delete('users', array('id'=>$id))) $core->notify($lang['users']['delete_success'],1);
				else $core->notify($lang['users']['delete_fail'],2);
			} else $core->notify($lang['users']['user_doesnt_exist'],2);
		}
	} //End users_del();
	
	function users_getModules($pattern, $allowed = NULL) {
		global $lang, $core, $db;
		$result = NULL;
		
		if($query = $db->select('modules')) {
			foreach((array)$query as $record) {
				$moduleInfo = $core->getModuleInfo($record['dir']);
				$replaced = str_replace('{{name}}', $moduleInfo['name'], $pattern);
				$replaced = str_replace('{{cname}}', $record['dir'], $replaced);
				if(!empty($allowed)) {
					if(in_array($record['dir'], $allowed)) $replaced = str_replace('{{selected}}', 'selected', $replaced);
					else $replaced = str_replace('{{selected}}', '', $replaced);
				}
				$result .= $replaced;
			}
		}
		return $result;
	}

	//Edit a user
	function users_edit($id) {
		global $db, $core, $lang;

		//Save
		if(isset($_POST['save'])) {
			if(!empty($_POST['login']) && !empty($_POST['mail'])) {
				$error = 0;
				$login = $_POST['login'];
				$mail = $_POST['mail'];
				
				//Password
				if(empty($_POST['pass'])) {
					$query = $db->select('users', array('id'=>$id));
					$record = $query[0];
					$pass = $record['pass'];
				}
				else {
					if(strlen($_POST['pass'])<5) { $core->notify($lang['users']['invalid_pass'],2); $error++; }
					$pass = md5($_POST['pass'].$core->getSettings('pepper'));
				} 
				//End of password
				
				//Allowed modules
				if($id==1) $allowed = 'all';
				else $allowed = implode(',', $_POST['allowed']);
				//End of allowed modules

				if(!filter_var($mail,FILTER_VALIDATE_EMAIL)) { $core->notify($lang['users']['invalid_mail'],2); $error++; }

				if($error==0) {
					$condtion = array('id'=>$id);
					$newRecord = array($id,$login,$pass,$mail,$allowed);
					if($db->update('users', $condtion, $newRecord)) $core->notify($lang['users']['update_success'],1);
					else $core->notify($lang['users']['update_fail'],2);
				}

			} else $core->notify($lang['users']['empty_inputs_warning'],2);
		}

		$result = NULL;
		if(is_numeric($id)) {
			if($query = $db->select('users', array('id'=>$id))) {
				$record = $query[0];
				$allowed = explode(',', $record['allowed']);
				$result = '<form name="edit_from" method="post" action="'.$_SERVER['REQUEST_URI'].'">
				<label>'.$lang['users']['login'].'
				<span class="small">'.$lang['users']['login_desc'].'</span>
				</label>
				<input type="text" name="login" value="'.$record['login'].'" />

				<label>'.$lang['users']['mail'].'
				<span class="small">'.$lang['users']['mail_desc'].'</span>
				</label>
				<input type="text" name="mail" value="'.$record['mail'].'" />

				<label>'.$lang['users']['pass'].'
				<span class="small">'.$lang['users']['pass_desc'].'</span>
				</label>
				<input type="password" name="pass" />
				
				<label>'.$lang['users']['allowed'].'
				<span class="small">'.$lang['users']['allowed desc'].'</span>
				</label>
				<select name="allowed[]" multiple="multiple" '.($id==1?'disabled="disabled"':'').'>
				'.users_getModules('<option value="{{cname}}" {{selected}}>{{name}}</option>', $allowed).'
				</select>
				
				<button type="submit" name="save">'.$lang['users']['save'].'</button>
				</form>';
			} else $result = $lang['users']['user_doesnt_exist'];
		}
		return $result;
	} //End users_edit();

	//
	//---------[ ADD A NEW USER ]-------------------------------------------------
	//

	//-[ MAIN FUNCTION 2 ] --------------------------------------
	function users_add() {
		global $lang, $db, $core;

		if(isset($_POST['add'])) {
			if(!empty($_POST['login']) && !empty($_POST['mail']) && !empty($_POST['pass']) && !empty($_POST['allowed'])) {
				$error = 0;
				$login = $_POST['login'];
				$mail = $_POST['mail'];
				$pass = md5($_POST['pass'].$core->getSettings('pepper'));
				$allowed = implode(',', $_POST['allowed']);

				if(!filter_var($mail,FILTER_VALIDATE_EMAIL)) { $core->notify($lang['users']['invalid_mail'],2); $error++; }
				if(strlen($_POST['pass'])<5) { $core->notify($lang['users']['invalid_pass'],2); $error++; }
				if($db->select('users', array('login'=>$login))) { $core->notify($lang['users']['login_exist'],2); $error++; }

				if($error==0) {
					$newRecord = array(NULL,$login,$pass,$mail,$allowed);
					if($db->insert('users', $newRecord)) $core->notify($lang['users']['add_success'],1);
					else $core->notify($lang['users']['add_fail'],2);
				}

			} else $core->notify($lang['users']['empty_inputs_warning'],2);
		}

		$result = '<form name="add_from" method="post" action="'.$_SERVER['REQUEST_URI'].'">
			<label>'.$lang['users']['login'].'
			<span class="small">'.$lang['users']['login_desc'].'</span>
			</label>
			<input type="text" name="login" />

			<label>'.$lang['users']['mail'].'
			<span class="small">'.$lang['users']['mail_desc'].'</span>
			</label>
			<input type="text" name="mail" />

			<label>'.$lang['users']['pass'].'
			<span class="small">'.$lang['users']['pass_desc'].'</span>
			</label>
			<input type="password" name="pass" />
			
			<label>'.$lang['users']['allowed'].'
			<span class="small">'.$lang['users']['allowed desc'].'</span>
			</label>
			<select name="allowed[]" multiple="multiple">
			'.users_getModules('<option value="{{cname}}" selected>{{name}}</option>').'
			</select>
			
			<button type="submit" name="add">'.$lang['users']['add'].'</button>
			</form>';
		return $result;
	} //End users_add();

?>
