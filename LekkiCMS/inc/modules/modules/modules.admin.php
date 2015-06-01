<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/modules.php');

	//Pages of this module
	function modules_pages() {
		global $lang;
		$pages[] = array(
			'func'  => 'modules_active',
			'title' => $lang['modules']['active']
		);
		$pages[] = array(
			'func'  => 'modules_unactive',
			'title' => $lang['modules']['unactive']
		);
		return $pages;
	}

	//
	//---------[ ACTIVE ]-------------------------------------------------
	//

	//-[ MAIN FUNCTION 1 ] --------------------------------------
	function modules_active() {
		global $lang, $db, $core;

		//Deactivation
		if(isset($_GET['deactive']) && !empty($_GET['deactive'])) {
			$condtion = array('dir'=>$_GET['deactive']);
			if($query = $db->select('modules',$condtion)) {
				$record = $query[0];
				if(!$record['basic']) {
					//Uninstall
					require_once('../'.MODULES.$_GET['deactive'].'/'.$_GET['deactive'].'.info.php');
					if(function_exists($_GET['deactive'].'_uninstall')) {
						call_user_func($_GET['deactive'].'_uninstall');
					}
					//Delete data from DB
                	if($db->delete('modules', $condtion)) $core->notify($lang['modules']['module deactive success'],1);
               		else $core->notify($lang['modules']['module deactive fail'],2);
            	} else $core->notify($lang['modules']['cant deactive'],2);
			} else $core->notify($lang['modules']['module doesnt exist'],2);
		}

		$result = '<table>
						<thead>
							<tr>
								<td>'.$lang['modules']['name'].'</td> <td>'.$lang['modules']['desc'].'</td> <td>'.$lang['modules']['author'].'</td> <td>'.$lang['modules']['options'].'</td>
							</tr>
						</thead>
						<tbody>';
		$result .= modules_get('<tr><td>{{name}} {{ver}}</td> <td>{{desc}}</td> <td>{{author}}</td> <td>{{actions}}</td>',1);
		$result .= '</tbody>
					</table>';
		return $result;
	} //End modules_active();

	//Get modules
	function modules_get($pattern, $type=1) {
		global $lang, $db, $core;
		$result = NULL;
		$count = 0;
		if($type==1) { //active modules
			if($query = $db->select('modules')) {
				if($db->num_rows($query)>0) {
					foreach((array)$query as $record) {
						$moduleInfo = $core->getModuleInfo($record['dir']);
						if(is_file('../'.MODULES.$record['dir'].'/'.$record['dir'].'.admin.php')) {
							$replaced = str_replace('{{name}}', '<a href="?go='.$record['dir'].'">'.$moduleInfo['name'], $pattern);
							$replaced = str_replace('{{ver}}', $moduleInfo['version'].'</a>', $replaced);
						} else {
							$replaced = str_replace('{{name}}', $moduleInfo['name'], $pattern);
							$replaced = str_replace('{{ver}}', $moduleInfo['version'], $replaced);
						}
						$replaced = str_replace('{{desc}}', $moduleInfo['description'], $replaced);
						$replaced = str_replace('{{author}}', $moduleInfo['author'], $replaced);
						$replaced = str_replace('{{actions}}', ($record['basic'] ? '<span class="icon unactive">N</span>' : '<a href="'.$core->fixGet('deactive:=').$record['dir'].'" class="icon">N</a>'), $replaced);
						$result .= $replaced;
						$count ++;
					}
				}
			}
		} elseif($type==0) { //unactive modules
			$dir = opendir('../inc/modules');
			while ($cat = readdir($dir)) {
				if (is_dir('../inc/modules/'.$cat) && $cat != "." && $cat != "..") {
				$allModules[] = $cat;
				}
			}
			if($query = $db->select('modules')) {
				if($db->num_rows($query)>0) {
					foreach((array)$query as $record) {
						$activeModules[] = $record['dir'];
					}
				}
			}
			foreach($allModules as $module) {
				if(!in_array($module,$activeModules)) {
					$moduleInfo = $core->getModuleInfo($module);
					$replaced = str_replace('{{name}}', $moduleInfo['name'], $pattern);
					$replaced = str_replace('{{ver}}', $moduleInfo['version'], $replaced);
					$replaced = str_replace('{{desc}}', $moduleInfo['description'], $replaced);
					$replaced = str_replace('{{author}}', $moduleInfo['author'], $replaced);
					$replaced = str_replace('{{actions}}', '<a href="'.$core->fixGet('active:=').$module.'" class="icon">M</a>', $replaced);
					$result .= $replaced;
					$count++;
				}
			}
		}
		if(!$count) {
			$replaced = str_replace('{{name}}', '---', $pattern);
			$replaced = str_replace('{{ver}}', '', $replaced);
			$replaced = str_replace('{{desc}}', '---', $replaced);
			$replaced = str_replace('{{author}}', '---', $replaced);
			$replaced = str_replace('{{actions}}', '---', $replaced);
			$result = $replaced;
		}
		return $result;
	} //End modules_get();

	//
	//---------[ UNACTIVE ]-------------------------------------------------
	//

	//-[ MAIN FUNCTION 2 ] --------------------------------------
	function modules_unactive() {
		global $lang, $db, $core;

		//Activation
		if(isset($_GET['active']) && !empty($_GET['active'])) {
			if($core->getModuleInfo($_GET['active'])) {
				$condtion = array('dir'=>$_GET['active']);
				if(!$db->select('modules',$condtion)) {
					//Intallation
					require_once('../'.MODULES.'/'.$_GET['active'].'/'.$_GET['active'].'.info.php');
					if(function_exists($_GET['active'].'_install')) {
						call_user_func($_GET['active'].'_install');
					}
					//Add data to DB
					$newRecord = array(NULL,$_GET['active'],'0');
		            if($db->insert('modules', $newRecord)) $core->notify($lang['modules']['module active success'],1);
		            else $core->notify($lang['modules']['module active fail'],2);
            	} else $core->notify($lang['modules']['module already active'],2);
			} else $core->notify($lang['modules']['module doesnt exist'],2);
		}

		$result = '<table>
						<thead>
							<tr>
								<td>'.$lang['modules']['name'].'</td> <td>'.$lang['modules']['desc'].'</td> <td>'.$lang['modules']['author'].'</td> <td>'.$lang['modules']['options'].'</td>
							</tr>
						</thead>
						<tbody>';
		$result .= modules_get('<tr><td>{{name}} {{ver}}</td> <td>{{desc}}</td> <td>{{author}}</td> <td>{{actions}}</td>',0);
		$result .= '</tbody>
					</table>';
		return $result;
	} //End modules_unactive();

?>
