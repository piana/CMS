<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/pages.php');

	//Pages of this module
	function pages_pages() {
		global $lang;
		$pages[] = array(
			'func'  => 'pages_management',
			'title' => $lang['pages']['management']
		);
		$pages[] = array(
			'func'  => 'pages_add',
			'title' => $lang['pages']['add']
		);
		return $pages;
	}

	//
	//---------[ PAGES MANAGEMENT ]-------------------------------------------------
	//

	//-[ MAIN FUNCTION 1 ] --------------------------------------
	function pages_management() {
		global $lang, $db, $core;

		//Edit a page
		if(isset($_GET['edit'])) $result = pages_edit($_GET['edit']);
		else {
			//Get the default language
			if(!isset($_GET['lang'])) {
				$pages_lang = explode('_',$core->getSettings('site_lang'));
				$pages_lang = $pages_lang[0];
			}
			else $pages_lang = $_GET['lang'];

			//Delete a page
			if(isset($_GET['del'])) {
				if(is_numeric($_GET['del']) && $db->select('pages',array('id'=>$_GET['del']))) {
					if($db->delete('pages', array('id'=>$_GET['del']))) $core->notify($lang['pages']['delete page success'],1);
					else $core->notify($lang['pages']['delete page success'],2);
				} else $core->notify($lang['pages']['pages doesnt exist'],2);
			}

			//Change order to up
			if(isset($_GET['up'])) {
				if(is_numeric($_GET['up']) && ($query = $db->select('pages',array('id'=>$_GET['up'])))) {
					$record = $query[0];
					if($record['order'] != pages_getOrder('MIN',$record['menu'],$record['lang'],$record['parent'])) {
						if($recordTWO = pages_getNearestPage($record['id'], '<')) {
							$updateRecordONE = array($record['id'],$record['title'],$record['content'],$record['parent'],$record['menu'],$record['lang'],$recordTWO['order'],$record['desc'],$record['keys'],$record['tpl']);
							$db->update('pages',array('id'=>$record['id']),$updateRecordONE);
							$updateRecordTWO = array($recordTWO['id'],$recordTWO['title'],$recordTWO['content'],$recordTWO['parent'],$recordTWO['menu'],$recordTWO['lang'],$record['order'],$recordTWO['desc'],$recordTWO['keys'],$recordTWO['tpl']);
							$db->update('pages',array('id'=>$recordTWO['id']),$updateRecordTWO);
						}
					}
				}
			}

			//Change order to down
			if(isset($_GET['down'])) {
				if(is_numeric($_GET['down']) && ($query = $db->select('pages',array('id'=>$_GET['down'])))) {
					$record = $query[0];
					if($record['order'] != pages_getOrder('MAX',$record['menu'],$record['lang'],$record['parent'])) {
						if($recordTWO = pages_getNearestPage($record['id'], '>')) {
							$updateRecordONE = array($record['id'],$record['title'],$record['content'],$record['parent'],$record['menu'],$record['lang'],$recordTWO['order'],$record['desc'],$record['keys'],$record['tpl']);
							$db->update('pages',array('id'=>$record['id']),$updateRecordONE);
							$updateRecordTWO = array($recordTWO['id'],$recordTWO['title'],$recordTWO['content'],$recordTWO['parent'],$recordTWO['menu'],$recordTWO['lang'],$record['order'],$recordTWO['desc'],$recordTWO['keys'],$recordTWO['tpl']);
							$db->update('pages',array('id'=>$recordTWO['id']),$updateRecordTWO);
						}
					}
				}
			}

			//LANG SELECT
			$result = '<form name="selectLang" action="index.php" method="GET" style="padding:0;">
				<input type="hidden" name="go" value="pages"/> <input type="hidden" name="action" value="pages_management"/> 
				<select name="lang" style="width:100%;margin:0px 0px 10px 0px;" onchange="document.selectLang.submit();">
					'.pages_getLang('<option value="{{value}}" {{selected}}>{{name}}</option>',$pages_lang).'
				</select>
				</form>';

			//TOP MENU
			$result .= '<table>
							<thead>
								<tr>
									<td>'.$lang['pages']['top menu'].'</td> <td width="52px"></td> <td width="120px"></td>
								</tr>
							</thead>
							<tbody>';
			$result .= pages_get('<tr><td>{{title}}</td> <td style="text-align:right;">{{up_down}}</td> <td style="text-align:right;">{{actions}}</td></tr>','top',$pages_lang);
			$result .= '</tbody>
						</table>';

			//SIDE MENU
			$result .= '<table>
							<thead>
								<tr>
									<td>'.$lang['pages']['side menu'].'</td> <td width="52px"></td> <td width="120px"></td>
								</tr>
							</thead>
							<tbody>';
			$result .= pages_get('<tr><td>{{title}}</td> <td style="text-align:right;">{{up_down}}</td> <td style="text-align:right;">{{actions}}</td></tr>','side',$pages_lang);
			$result .= '</tbody>
						</table>';

			//WITHOUT MENU
			$result .= '<table>
							<thead>
								<tr>
									<td>'.$lang['pages']['without menu'].'</td> <td width="52px"></td> <td width="120px"></td>
								</tr>
							</thead>
							<tbody>';
			$result .= pages_get('<tr><td>{{title}}</td> <td style="text-align:right;">{{up_down}}</td> <td style="text-align:right;">{{actions}}</td></tr>','none',$pages_lang);
			$result .= '</tbody>
						</table>';
		}
		return $result;		
	} //End pages_management();

	//
	//---------[ EDIT A PAGE ]-------------------------------------------------
	//

	function pages_edit($id) {
		global $lang, $db, $core;

		//Update DB
		if(isset($_POST['save'])) {
			if(!empty($_POST['title']) && !empty($_POST['lang']) && !empty($_POST['content']) && !(trim($_POST['parent'])==='') && !empty($_POST['menu'])) {
				//Check for advanced options
				if($query = $db->select('pages',array('id'=>$id))) {
					$record = $query[0];
					if(isset($_POST['desc'])) $desc = $_POST['desc'];
					else {
						if($record['desc']) $desc = $record['desc'];
						else $desc = 0;
					}
					if(isset($_POST['keys'])) $keys = $_POST['keys'];
					else {
						if($record['keys']) $keys = $record['keys'];
						else $keys = 0;
					}
					if(isset($_POST['tpl'])) $tpl = $_POST['tpl'];
					else {
						if($record['tpl']) $tpl = $record['tpl'];
						else $tpl = 'template.html';
					}
				}

				//Define other elements
				$title = $_POST['title'];
				$content = htmlspecialchars_decode(trim(preg_replace("/\r\n|\r/", '\n', stripslashes($_POST['content']))));
				$parent = $_POST['parent'];
				$language = $_POST['lang'];
				$menu = $_POST['menu'];

				//Menu
				if($parent) {
					if($query = $db->select('pages',array('parent'=>$parent))) {
						$record = $query[0];
						if($menu!=$record['menu']) $menu = $record['menu'];
						else $menu = $_POST['menu'];
					}
				}

				//Get order
				if($query = $db->select('pages', array('id'=>$id))) {
					$record = $query[0];
					if($parent == $record['parent'] && $language == $record['lang']) $order = $record['order'];
					else {
						$order = 1;
						if($query = $db->select('pages', array('lang'=>$language))) {
							if($db->num_rows($query)>0) {
								foreach((array)$query as $record) {
									if($record['parent']==$parent && $record['menu']==$menu) {
										if($record['order']>=$order) $order = $record['order']+1;
										else $order = $order;
									}
								}
							}
						}
					}
				}

				//Run Query
				$condtion = array('id'=>$id);
				$updateRecord = array($id,$title,$content,$parent,$menu,$language,$order,$desc,$keys,$tpl);
				if($db->update('pages',$condtion,$updateRecord)) $core->notify($lang['pages']['update page success'],1);
				else $core->notify($lang['pages']['update page fail'],2);

			} else $core->notify($lang['pages']['empty inputs warning'],2);
		}
		
		//Replace pattern by module's element
		$core->append(pages_add2head(), 'head');

		if(is_numeric($id) && ($query = $db->select('pages', array('id'=>$id)))) {
			$record = $query[0];
			$result = '<form name="selectLang" method="get" action="index.php">
					<input type="hidden" name="go" value="pages"/> <input type="hidden" name="edit" value="'.$id.'"/> 
					<input type="hidden" name="lang" value="">
					</form>';
			$result .= '<form name="edit_page" method="post" action="'.$_SERVER['REQUEST_URI'].'">';
			$result .= '<label>'.$lang['pages']['title'].'
				<span class="small">'.$lang['pages']['title desc'].'</span>
				</label>
				<input type="text" name="title" value="'.$record['title'].'"/>
				<label>'.$lang['pages']['lang'].'
				<span class="small">'.$lang['pages']['lang desc'].'</span>
				</label>
				<select name="lang" onchange="document.selectLang.lang.value=this.value; document.selectLang.submit();">
					'.pages_getLang('<option value="{{value}}" {{selected}}>{{name}}</option>',(isset($_GET['lang'])?$_GET['lang']:$record['lang'])).'
				</select>';

			//Check for advanced settings
			if($core->getSettings('advanced_pages')) {
				$result .=	'<label>'.$lang['pages']['description'].'
					<span class="small">'.$lang['pages']['description desc'].'</span>
					</label>
					<input type="text" name="desc"  value="'.(!$record['desc']?'':$record['desc']).'" placeholder="'.$lang['pages']['can be empty'].'"/>
					<label>'.$lang['pages']['keys'].'
					<span class="small">'.$lang['pages']['keys desc'].'</span>
					</label>
					<input type="text" name="keys" value="'.(!$record['keys']?'':$record['keys']).'" placeholder="'.$lang['pages']['can be empty'].'"/>
					<label>'.$lang['pages']['template'].'
					<span class="small">'.$lang['pages']['template desc'].'</span>
					</label>
					<select name="tpl">
						'.pages_getTplFiles('<option value="{{value}}" {{selected}}>{{file}}</option>', $record['tpl']).'
					</select>';	
			}

			//Check for WYSIWYG
			if($core->getSettings('wysiwyg')) {
				$result .= '<label>'.$lang['pages']['content'].'
				<span class="small">WYSIWYG</span>
				</label>
				<div class="wysiwyg"><textarea name="content">'.htmlspecialchars(str_replace('\n', PHP_EOL, $record['content'])).'</textarea></div>
				<div class="clear"></div>';
			} else {
				$result .= '<label>'.$lang['pages']['content'].'
				<span class="small">HTML</span>
				</label>
				<textarea name="content">'.htmlspecialchars(str_replace('\n', PHP_EOL, $record['content'])).'</textarea>';
			}

			$result .=	'<label>'.$lang['pages']['parent'].'
				<span class="small">'.$lang['pages']['parent desc'].'</span>
				</label>
				<select name="parent">
					<option value="0">'.$lang['pages']['none'].'</option>
					'.pages_getParents('<option value="{{id}}" {{selected}}>{{title}}</option>',$record['parent'],$id,(isset($_GET['lang'])?$_GET['lang']:$record['lang'])).'
				</select>
				<label>'.$lang['pages']['menu'].'
				<span class="small">'.$lang['pages']['menu desc'].'</span>
				</label>
				<select name="menu">
					<option value="top" '.($record['menu']=='top'?' selected':'').'>'.$lang['pages']['top menu'].'</option>
					<option value="side" '.($record['menu']=='side'?' selected':'').'>'.$lang['pages']['side menu'].'</option>
					<option value="none" '.($record['menu']=='none'?' selected':'').'>'.$lang['pages']['without menu'].'</option>
				</select>
				<button name="save">'.$lang['pages']['save'].'</button>';
			$result .= '</form>';
		} else return $lang['pages']['pages doesnt exist'];

		return $result;
	} //End pages_add();


	//
	//---------[ ADD A NEW PAGE ]-------------------------------------------------
	//

	//-[ MAIN FUNCTION 2 ] --------------------------------------
	function pages_add() {
		global $lang, $db, $core;

		//Add to DB
		if(isset($_POST['add'])) {
			if(!empty($_POST['title']) && !empty($_POST['lang']) && !empty($_POST['content']) && !(trim($_POST['parent'])==='') && !empty($_POST['menu'])) {
				//Check for advanced options
				if(isset($_POST['desc']) && !empty($_POST['desc'])) $desc = $_POST['desc'];
				else $desc = '0';
				if(isset($_POST['keys']) && !empty($_POST['keys'])) $keys = $_POST['keys'];
				else $keys = '0';
				if(isset($_POST['tpl'])) $tpl = $_POST['tpl'];
				else $tpl = 'template.html';

				//Define other elements
				$title = $_POST['title'];
				$content = trim(preg_replace("/\r\n|\r/", '\n', stripslashes($_POST['content'])));
				$parent = $_POST['parent'];
				$language = $_POST['lang'];
				$menu = $_POST['menu'];

				//Menu
				if($parent) {
					if($query = $db->select('pages',array('parent'=>$parent))) {
						$record = $query[0];
						if($menu!=$record['menu']) $menu = $record['menu'];
						else $menu = $_POST['menu'];
					}
				}

				//Get order
				$order = 1;
				if($query = $db->select('pages', array('lang'=>$language))) {
					if($db->num_rows($query)>0) {
						foreach((array)$query as $record) {
							if($record['parent']==$parent && $record['menu']==$menu) {
								if($record['order']>=$order) $order = $record['order']+1;
								else $order = $order;
							}
						}
					}
				}

				//Run Query
				$newRecord = array(NULL,$title,$content,$parent,$menu,$language,$order,$desc,$keys,$tpl);
				if($db->insert('pages',$newRecord)) $core->notify($lang['pages']['add page success'],1);
				else $core->notify($lang['pages']['add page fail'],2);

			} else $core->notify($lang['pages']['empty inputs warning'],2);
		}
		
		//Replace pattern by module's element
		$core->append(pages_add2head(), 'head');

		$result = '<form name="selectLang" method="get" action="index.php">
					<input type="hidden" name="go" value="pages"/> <input type="hidden" name="action" value="pages_add"/> 
					<input type="hidden" name="lang" value="">
					</form>';
		$result .= '<form name="add_page" method="post" action="'.$_SERVER['REQUEST_URI'].'">';
		$result .= '<label>'.$lang['pages']['title'].'
			<span class="small">'.$lang['pages']['title desc'].'</span>
			</label>
			<input type="text" name="title"/>
			<label>'.$lang['pages']['lang'].'
			<span class="small">'.$lang['pages']['lang desc'].'</span>
			</label>
			<select name="lang" onchange="document.selectLang.lang.value=this.value; document.selectLang.submit()">
				'.pages_getLang('<option value="{{value}}" {{selected}}>{{name}}</option>',@$_GET['lang']).'
			</select>';

		//Check for advanced settings
		if($core->getSettings('advanced_pages')) {
			$result .=	'<label>'.$lang['pages']['description'].'
				<span class="small">'.$lang['pages']['description desc'].'</span>
				</label>
				<input type="text" name="desc" placeholder="'.$lang['pages']['can be empty'].'"/>
				<label>'.$lang['pages']['keys'].'
				<span class="small">'.$lang['pages']['keys desc'].'</span>
				</label>
				<input type="text" name="keys" placeholder="'.$lang['pages']['can be empty'].'"/>
				<label>'.$lang['pages']['template'].'
				<span class="small">'.$lang['pages']['template desc'].'</span>
				</label>
				<select name="tpl">
					'.pages_getTplFiles('<option value="{{value}}" {{selected}}>{{file}}</option>').'
				</select>';
		}

		//Check for WYSIWYG
		if($core->getSettings('wysiwyg')) {
			$result .= '<label>'.$lang['pages']['content'].'
			<span class="small">WYSIWYG</span>
			</label>
			<div class="wysiwyg"><textarea name="content"></textarea></div>
			<div class="clear"></div>';
		} else {
			$result .= '<label>'.$lang['pages']['content'].'
			<span class="small">HTML</span>
			</label>
			<textarea name="content"></textarea>';
		}

		$result .=	'<label>'.$lang['pages']['parent'].'
			<span class="small">'.$lang['pages']['parent desc'].'</span>
			</label>
			<select name="parent">
				<option value="0">'.$lang['pages']['none'].'</option>
				'.pages_getParents('<option value="{{id}}">{{title}}</option>', NULL, NULL, @$_GET['lang']).'
			</select>
			<label>'.$lang['pages']['menu'].'
			<span class="small">'.$lang['pages']['menu desc'].'</span>
			</label>
			<select name="menu">
				<option value="top">'.$lang['pages']['top menu'].'</option>
				<option value="side">'.$lang['pages']['side menu'].'</option>
				<option value="none">'.$lang['pages']['without menu'].'</option>
			</select>
			<button name="add">'.$lang['pages']['add'].'</button>';
		$result .= '</form>';

		return $result;
	} //End pages_add();

	//
	//---------[ ADDITIONAL FUNCTIONS ]-------------------------------------------------
	//
	
	//New element in head section
	function pages_add2head() {
		global $core;
		$head = "\t".'<style type="text/css">
			.LCMS form label {
				width: 12%;
			}
			.LCMS form input[type="text"], .LCMS form textarea {
				width: 80%;
			}
			.LCMS form select {
				width: 81.5%;
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
		</style>'."\n";
		if($core->getSettings('wysiwyg')) {
			$head .= "\t<link rel=\"stylesheet\" type=\"text/css\" href=\"../inc/jscripts/CLEditor/jquery.cleditor.css\" />\n";
			$head .= "\t<script type=\"text/javascript\" src=\"../inc/jscripts/CLEditor/jquery.cleditor.min.js\"></script>\n";
			$head .= "\t<script type=\"text/javascript\">$(document).ready(function () { $('textarea').cleditor(); });</script>";
		} else {
			$head .= "\t<script type=\"text/javascript\" src=\"../inc/jscripts/behave.min.js\"></script>\n";
			$head .= "\t<script type=\"text/javascript\">
				window.onload = function(){
					var editor = new Behave({
						textarea: document.getElementsByName('content')[0]
					});
				};
			</script>";
		}
		return $head;
	} //End pages_add2head();

	//Get pages
	function pages_get($pattern, $menu, $page_lang) {
		global $db, $core, $lang;
		$result = NULL; $unSortedArray = array();
		if($query = $db->select('pages', array('menu'=>$menu))) {
			if($db->num_rows($query)>0) {
				foreach((array)$query as $record) {
					if($record['lang']==$page_lang && !$record['parent']) {
						$replaced = str_replace('{{title}}', '<a href="'.$core->fixGet('up&down&del&edit:=').$record['id'].'">'.$record['title'].'</a>', $pattern);
						//Up
						if($record['order']==pages_getOrder('MIN',$record['menu'],$record['lang'],$record['parent'])) $up = '<span class="icon unactive">U</span>';
						else $up = '<a href="'.$core->fixGet('edit&del&down&up:=').$record['id'].'" class="icon">U</a>';
						//Down
						if($record['order']==pages_getOrder('MAX',$record['menu'],$record['lang'],$record['parent'])) $down = '<span class="icon unactive">V</span>';
						else $down = '<a href="'.$core->fixGet('edit&del&up&down:=').$record['id'].'" class="icon">V</a>';
						//Up&Down
						$replaced = str_replace('{{up_down}}', $up.' '.$down, $replaced);
						$replaced = str_replace('{{actions}}', '<a href="'.$core->fixGet('up&down&del&edit:=').$record['id'].'" class="icon">Z</a> <a href="../index.php?go='.$record['id'].'&lang='.$record['lang'].'" target="_blank" class="icon">H</a> <a href="'.$core->fixGet('up&down&edit&del:=').$record['id'].'" onclick="return confirm(\''.$lang['pages']['delete confirm'].'\')" class="icon">l</a>', $replaced);
						$unSortedArray[$record['order']] = array('id'=>$record['id'], 'code'=>$replaced);
					}
				}
			}
		}
		if(count($unSortedArray)>0) {
			$sortedArray = pages_sortArray($unSortedArray);
			foreach($sortedArray as $page) {
				$result .= pages_addChildren($pattern, $page['code'], $page['id']);
			}
		}
		return $result;
	} //End pages_get();

	//Add children do parents
	function pages_addChildren($pattern, $code, $id) {
		global $db, $core, $lang;
		$unSortedArray = array();
		if($query = $db->select('pages', array('parent'=>$id))) {
			if($db->num_rows($query)>0) {
				foreach((array)$query as $record) {
					$replaced = str_replace('{{title}}', '&nbsp &rarr; <a href="'.$core->fixGet('up&down&del&edit:=').$record['id'].'">'.$record['title'].'</a>', $pattern);
					//Up
					if($record['order']==pages_getOrder('MIN',$record['menu'],$record['lang'],$record['parent'])) $up = '<span class="icon unactive">U</span>';
					else $up = '<a href="'.$core->fixGet('edit&del&down&up:=').$record['id'].'" class="icon">U</a>';
					//Down
					if($record['order']==pages_getOrder('MAX',$record['menu'],$record['lang'],$record['parent'])) $down = '<span class="icon unactive">V</span>';
					else $down = '<a href="'.$core->fixGet('edit&del&up&down:=').$record['id'].'" class="icon">V</a>';
					//Up&Down
					$replaced = str_replace('{{up_down}}', $up.' '.$down, $replaced);
					$replaced = str_replace('{{actions}}', '<a href="'.$core->fixGet('up&down&del&edit:=').$record['id'].'" class="icon">Z</a> <a href="../index.php?go='.$record['id'].'&lang='.$record['lang'].'" target="_blank" class="icon">H</a> <a href="'.$core->fixGet('up&down&edit&del:=').$record['id'].'" onclick="return confirm(\''.$lang['pages']['delete confirm'].'\')" class="icon">l</a>', $replaced);
					$unSortedArray[$record['order']] = $replaced;
				}
			}
		}
		if(count($unSortedArray)>0) {
			$sortedArray = pages_sortArray($unSortedArray);
			foreach($sortedArray as $children)
				$code .= $children; 
		}
		return $code;
	} //End pages_addChildren();

	//Get page order
	function pages_getOrder($type,$menu,$lang,$parent=0) {
		global $core, $db;
		$result = NULL;
		if($type=='MAX') {
			if($query = $db->select('pages',array('menu'=>$menu))) {
				foreach($query as $record) {
					if($record['lang']==$lang) {
						if($record['parent']==$parent) $order[] = $record['order'];
					}
				}
				$result = max($order);
			}
		} elseif($type=='MIN') {
			if($query = $db->select('pages',array('menu'=>$menu))) {
				foreach($query as $record) {
					if($record['lang']==$lang) {
						if($record['parent']==$parent) $order[] = $record['order'];
					}
				}
				$result = min($order);
			}	
		}
		return $result;
	} //End pages_getOrder();
	
	function pages_getNearestPage($pageID, $type) {
		global $core, $db;
		$orders = array(); $nearest = FALSE; $page = FALSE;
		
		if($query = $db->select('pages')) {
			$queryTWO = $db->select('pages', array('id'=>$pageID));
			$recordTWO = $queryTWO[0];
			
			foreach($query as $record) {
				$orders[] = $record['order'];
			}
			if(count($orders)>0) {
				if($type=='>') {
					sort($orders);
					foreach ($orders as $a) {
						if($a > $recordTWO['order']) { 
							$nearest = $a;
							break;
						}
					}
					if($nearest) {
						$query = $db->select('pages', array('order'=>$nearest));
						foreach($query as $record) {
							if($record['lang']==$recordTWO['lang'] && $record['parent']==$recordTWO['parent'] && $record['menu']==$recordTWO['menu']) {
								$page = $record;
							}
						} 
					}
				} else if($type=='<') {
					arsort($orders);
					foreach ($orders as $a) {
						if($a < $recordTWO['order']) { 
							$nearest = $a;
							break;
						}
					}
					if($nearest) {
						$query = $db->select('pages', array('order'=>$nearest));
						foreach($query as $record) {
							if($record['lang']==$recordTWO['lang'] && $record['parent']==$recordTWO['parent'] && $record['menu']==$recordTWO['menu']) {
								$page = $record;
							}
						}
					}	
				}
			}
		}
		return $page;
	}

	//Sort array
	function pages_sortArray($array) {
		$result = NULL;
		if(count($array)>0) {
			ksort($array);
			$result = $array;
		}
		return $result;
	} //End pages_sortArray();

	//Get pages languages
	function pages_getLang($pattern, $prefLang = NULL) {
		$result = NULL;
		$dir = opendir('../inc/lang/');
		while($file = readdir($dir)) {
			if(is_dir('../inc/lang/'.$file) && $file != "." && $file != "..") {
				$ex = explode('_', $file);
				$replaced = str_replace('{{name}}', $ex[1], $pattern);
				$replaced = str_replace('{{value}}', $ex[0], $replaced);
				if(!empty($prefLang) && $prefLang==$ex[0]) $replaced = str_replace('{{selected}}', 'selected', $replaced);
				else $replaced = str_replace('{{selected}}', '', $replaced);
				$result .= $replaced;
			}
		}
		return $result;
	} //End pages_getLang();

	//Get Parents
	function pages_getParents($pattern, $prefParent = NULL, $editPageID = NULL, $prefLang = NULL) {
		global $db, $core;
		$result = NULL;
		if($prefLang==NULL || !isset($prefLang)) {
			$prefLang = explode('_',$core->getSettings('site_lang'));
			$prefLang = $prefLang[0];
		}
			if($query = $db->select('pages', array('parent'=>'0'))) {
				if($db->num_rows($query)>0) {
					foreach((array)$query as $record) {
						if($prefLang==$record['lang']) {
							if($editPageID!=$record['id']) {
								$replaced = str_replace('{{title}}', $record['title'], $pattern);
								$replaced = str_replace('{{id}}', $record['id'], $replaced);
								if(!empty($prefParent) && $prefParent==$record['id']) $replaced = str_replace('{{selected}}', 'selected', $replaced);
								else $replaced = str_replace('{{selected}}', '', $replaced);
								$result .= $replaced;
							}
						}
					}
				}
			}
		return $result;
	} //End pages_getParents();
	
	//Get Template files 
	function pages_getTplFiles($pattern, $prefTpl = NULL) {
		global $core;
		$result = NULL;
		$dir = '../'.THEMES.$core->getSettings('theme');
		
		if($array = glob($dir.'/*.html')) {
			foreach($array as $file) {
				$fileInfo = pathinfo($file);
				$replaced = str_replace('{{file}}', $fileInfo['basename'], $pattern);
				$replaced = str_replace('{{value}}', $fileInfo['basename'], $replaced);
				if(!empty($prefTpl) && $prefTpl==$fileInfo['basename']) $replaced = str_replace('{{selected}}', 'selected', $replaced);
				else $replaced = str_replace('{{selected}}', '', $replaced);
				$result .= $replaced;
			}
		}
		return $result;
	} //End pages_getTplFiles();

?>
