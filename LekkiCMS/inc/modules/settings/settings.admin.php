<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/settings.php');

	//Pages of this module
	function settings_pages() {
		global $lang;

		$pages[] = array(
			'func'  => 'settings_general',
			'title' =>  $lang['settings']['general']
		);
		$pages[] = array(
			'func'  => 'settings_other',
			'title' => $lang['settings']['other']
		);
		$pages[] = array(
			'func'  => 'settings_theme',
			'title' => $lang['settings']['theme']
		);
		$pages[] = array(
			'func'  => 'settings_updates',
			'title' => $lang['settings']['updates']
		);
		return $pages;
	}

	/*** Main functions ********************************************************************************************/

	/* Main function: settings_general() ****/
	function settings_general() {
		global $lang, $db, $core;
		$result = NULL;

		if(isset($_POST['save'])) {
			if(!settings_emptyInputs($_POST)) {
				$error = 0;
				foreach($_POST as $key => $value) {
					if($key != 'save') {
						$query = $db->select('settings', array('field'=>$key));
						$record = $query[0];
						if(!$db->update('settings', array('field'=>$key), array($record['id'],$key,stripslashes($value)))) $error++;
					}
				}
				if($error) $core->notify($lang['settings']['update fail'],2);
				else $core->notify($lang['settings']['update success'],1);
			} else $core->notify($lang['settings']['empty inputs warning'],2);
		}

		//Get settings from DB
		if($query = $db->select('settings')) {
			foreach((array)$query as $record) $settings[$record['field']] = $record['value'];

			//Define all inputs
			$form['selectLang'] = '<form name="selectLang" method="get" action="index.php">
					<input type="hidden" name="go" value="settings"/> <input type="hidden" name="action" value="settings_general"/> 
					<input type="hidden" name="lang" value="">
					</form>';
			$form['top'] = '<form name="settings" method="post" action="'.$_SERVER['REQUEST_URI'].'">';
			$form['title'] = '<label>'.$lang['settings']['title'].'
				<span class="small">'.$lang['settings']['title desc'].'</span>
				</label>
				<input type="text" name="title" value="'.htmlspecialchars($settings['title']).'" />';
			$form['description'] = '<label>'.$lang['settings']['description'].'
				<span class="small">'.$lang['settings']['description desc'].'</span>
				</label>
				<input type="text" name="description" value="'.$settings['description'].'" />';
			$form['keywords'] = '<label>'.$lang['settings']['keywords'].'
				<span class="small">'.$lang['settings']['keywords desc'].'</span>
				</label>
				<input type="text" name="keywords" value="'.$settings['keywords'].'" />';
			$form['footer'] = '<label>'.$lang['settings']['footer'].'
				<span class="small">'.$lang['settings']['footer desc'].'</span>
				</label>
				<input type="text" name="footer" value="'.htmlspecialchars($settings['footer']).'" />';
			$form['site_lang'] = '<label>'.$lang['settings']['site_lang'].'
				<span class="small">'.$lang['settings']['site_lang desc'].'</span>
				</label>
				<select name="site_lang" onchange="document.selectLang.lang.value=this.value; document.selectLang.submit();">
					'.settings_getLang('<option value="{{value}}" {{selected}}>{{name}}</option>',(isset($_GET['lang'])?$_GET['lang']:$settings['site_lang'])).'
				</select>';
			$form['start_page'] = '<label>'.$lang['settings']['start_page'].'
				<span class="small">'.$lang['settings']['start_page desc'].'</span>
				</label>
				<select name="start_page">
					'.settings_getPages('<option value="{{id}}" {{selected}}>{{title}}</option>', $settings['start_page'], (isset($_GET['lang'])?$_GET['lang']:$settings['site_lang'])).'
				</select>';
			$form['theme'] = '<label>'.$lang['settings']['theme'].'
				<span class="small">'.$lang['settings']['theme desc'].'</span>
				</label>
				<select name="theme">
					'.settings_getThemes('<option value="{{name}}" {{selected}}>{{name}}</option>', $settings['theme']).'
				</select>';
			$form['save'] = '<button type="submit" name="save" value="save">'.$lang['settings']['save'].'</button>';
			$form['bottom'] = '</form>';

			//Return form
			foreach($form as $input) $result .= $input."\n";
			return $result;
		}
	}

	/*** Main function: settings_other() ****/
	function settings_other() {
		global $lang, $db, $core;
		$result = NULL;

		if(isset($_POST['save'])) {
			if(!settings_emptyInputs($_POST)) {
				$error = 0;
				foreach($_POST as $key => $value) {
					if($key != 'save') {
						$query = $db->select('settings', array('field'=>$key));
						$record = $query[0];

						//SEO-Friendly
						if($key=='seo-friendly' && $value=='0') {
							if(is_file('../.htaccess')) file_put_contents('../.htaccess', '');
						} elseif($key=='seo-friendly' && $value=='1') {
							$rewrite = "RewriteEngine on \n";
							$rewrite .= "RewriteBase ".str_replace('admin','',dirname($_SERVER['PHP_SELF']))." \n";
							$rewrite .= "RewriteRule ^([^-]+),([^-]+),([a-z0-9._.-]+).html$ index.php?go=$1&lang=$2 [L]";
							file_put_contents('../.htaccess', $rewrite);
						}

						if(!$db->update('settings', array('field'=>$key), array($record['id'],$key,$value))) $error++;
					}
				}
				if($error) $core->notify($lang['settings']['update fail'],2);
				else $core->notify($lang['settings']['update success'],1);
			} else $core->notify($lang['settings']['empty inputs warning'],2);
		}

		//Get settings from DB
		if($query = $db->select('settings')) {
			foreach((array)$query as $record) $settings[$record['field']] = $record['value'];

			//Define all inputs
			$form['top'] = '<form name="settings" method="post" action="'.$_SERVER['REQUEST_URI'].'">';
			$form['admin_lang'] = '<label>'.$lang['settings']['admin_lang'].'
				<span class="small">'.$lang['settings']['admin_lang desc'].'</span>
				</label>
				<select name="admin_lang">
					'.settings_getLang('<option value="{{value}}" {{selected}}>{{name}}</option>',$settings['admin_lang']).'
				</select>';
			$form['advanced_pages'] = '<label>'.$lang['settings']['advanced_pages'].'
				<span class="small">'.$lang['settings']['advanced_pages desc'].'</span>
				</label>
				<div class="radio">
					<input type="radio" name="advanced_pages" value="0" '.(!$settings['advanced_pages']?'checked':'').'/>Podstawowa
					<input type="radio" name="advanced_pages" value="1" '.($settings['advanced_pages']?'checked':'').'/>Rozszerzona
				</div>';
			$form['editor'] = '<label>'.$lang['settings']['editor'].'
				<span class="small">'.$lang['settings']['editor desc'].'</span>
				</label>
				<div class="radio">
					<input type="radio" name="wysiwyg" value="0" '.(!$settings['wysiwyg']?'checked':'').'/>HTML
					<input type="radio" name="wysiwyg" value="1" '.($settings['wysiwyg']?'checked':'').'/>WYSIWYG
				</div>';
			$form['seo-friendly'] = '<label>'.$lang['settings']['seo-friendly'].'
				<span class="small">'.$lang['settings']['seo-friendly desc'].'</span>
				</label>
				<div class="radio">
					<input type="radio" name="seo-friendly" value="0" '.(!$settings['seo-friendly']?'checked':'').'/>Nie
					<input type="radio" name="seo-friendly" value="1" '.($settings['seo-friendly']?'checked':'').'/>Tak
				</div>';
			$form['save'] = '<button type="submit" name="save" value="save">'.$lang['settings']['save'].'</button>';
			$form['bottom'] = '</form>';

			//Return form
			foreach($form as $input) $result .= $input."\n";
			return $result;
		}
	}

	/* Main function: settings_theme() ****/
	function settings_theme() {
		global $lang, $db, $core;
		$result = NULL; $theme = $core->getSettings('theme');

		//Get filename
		if(!isset($_GET['file']) || empty($_GET['file'])) {
			$path = '../'.THEMES.$theme;
			$dir = opendir($path);
			while ($file = readdir($dir)) {
				if(is_file($path.'/'.$file) && $file != "." && $file != "..") {
					$_GET['file'] = $file;
					break;
				}
			}
		}
		//Save file
		if(isset($_POST['save'])) {
			if(file_put_contents('../'.THEMES.'/'.$theme.'/'.$_GET['file'], htmlspecialchars_decode(stripslashes($_POST['code'])))) {
				$core->notify($lang['settings']['update success'],1);
			} else $core->notify($lang['settings']['update fail'],2);
		}
		
		/* begin of code editor scripts */
		$jscripts = "\t<script type=\"text/javascript\" src=\"../inc/jscripts/behave.min.js\"></script>\n";
		$jscripts .= "\t<script type=\"text/javascript\">
			window.onload = function(){
				var editor = new Behave({
					textarea: document.getElementsByName('code')[0]
				});
			};
		</script>";
		$core->append($jscripts, 'head');
		/* end of code editor scripts */

		$form['filesList'] = '<form name="files" method="get" action="index.php">
						<input type="hidden" name="go" value="settings"/> <input type="hidden" name="action" value="settings_theme"/> 
						<select name="file" style="width:97%;" onchange="document.files.submit()">
							'.settings_getThemeFiles('<option value="{{file}}" {{selected}}>{{name}}</option>', $theme, @$_GET['file']).'
						</select>
						</form>';
		if(!settings_checkChmod('../'.THEMES.'/'.$theme.'/'.@$_GET['file'])) $button = $lang['settings']['chmod warning'];
		else $button = '<button type="submit" name="save" style="margin-left:10px;">'.$lang['settings']['save'].'</button>';
		$form['file'] = '<form name="file" method="post" action="'.$_SERVER['REQUEST_URI'].'">
						<textarea name="code" id="code" style="width:96%;height:250px">'.settings_loadFile($theme, @$_GET['file']).'</textarea>
						'.$button.'
						</form>';

		//Return form
		foreach($form as $input) $result .= $input."\n";
		return $result;
	}
	
	/*** Main function: settings_updates() ****/
	function settings_updates() {
		global $lang, $db, $core;

		$result = '<table>
						<thead>
							<tr>
								<td>'.$lang['settings']['name'].'</td> <td>'.$lang['settings']['status'].'</td>
							</tr>
						</thead>
						<tbody>';
		$result .= settings_getModules('<tr><td>{{name}} {{ver}}</td> <td>{{status}}</td>');
		$result .= '</tbody>
					</table>';
					
		$result .= '<span class="info">'.$lang['settings']['update info'].'</span>';
		
		return $result;
	}

	/*** Additional functions ********************************************************************************************/

	//Get pages
	function settings_getPages($pattern, $prefPage = NULL, $prefLang = NULL) {
		global $db, $core, $lang;
		$result = NULL;
		if($prefLang==NULL || !isset($prefLang)) {
			$prefLang = explode('_',$core->getSettings('site_lang'));
			$prefLang = $prefLang[0];
		}  else { 
				$prefLang = explode('_',$prefLang);
				$prefLang = $prefLang[0];
			}
			if($query = $db->select('pages')) {
				if($db->num_rows($query)>0) {
					$count = 0;
					foreach((array)$query as $record) {
						if($prefLang==$record['lang']) {
							$replaced = str_replace('{{title}}', $record['title'], $pattern);
							$replaced = str_replace('{{id}}', $record['id'], $replaced);
							if(!empty($prefPage) && $prefPage==$record['id']) $replaced = str_replace('{{selected}}', 'selected', $replaced);
							else $replaced = str_replace('{{selected}}', '', $replaced);
							$result .= $replaced;
							$count ++;
						}
					}
					if($count==0) {
						$replaced = str_replace('{{title}}', $lang['settings']['no pages in selected lang'], $pattern);
						$replaced = str_replace('{{id}}', '', $replaced);
						$result .= $replaced;
					}
				}
			}
		return $result;
	} //End settings_getPages();

	//Get themes
	function settings_getThemes($pattern, $prefTheme = NULL) {
		$result = NULL;
		$dir = opendir('../themes/');
		while ($file = readdir($dir)) {
			if (is_dir('../themes/'.$file) && $file != "." && $file != ".." && $file != "admin") {
				$replaced = str_replace('{{name}}', $file, $pattern);
				if(!empty($prefTheme) && $prefTheme==$file) $replaced = str_replace('{{selected}}', 'selected', $replaced);
				else $replaced = str_replace('{{selected}}', '', $replaced);
				$result .= $replaced;
			}
		}
		return $result;
	} //End settings_getThemes();

	//Get languages
	function settings_getLang($pattern, $prefLang = NULL) {
		$result = NULL;
		$dir = opendir('../inc/lang/');
		while ($file = readdir($dir)) {
			if (is_dir('../inc/lang/'.$file) && $file != "." && $file != "..") {
				$ex = explode('_', $file);
				$replaced = str_replace('{{name}}', $ex[1], $pattern);
				$replaced = str_replace('{{value}}', $file, $replaced);
				if(!empty($prefLang) && $prefLang==$file) $replaced = str_replace('{{selected}}', 'selected', $replaced);
				else $replaced = str_replace('{{selected}}', '', $replaced);
				$result .= $replaced;
			}
		}
		return $result;
	} //End settings_getAdminLang();

	//Check empty inputs
	function settings_emptyInputs($array) {
		$empty = 0;
		foreach($array as $input) {
			if($input=='') $empty++;
		}
		return $empty;
	} //End settings_emptyInputs();

	//Get theme files
	function settings_getThemeFiles($pattern, $theme, $prefFile = NULL) {
		$result = NULL;
		$path = '../'.THEMES.$theme;
		$dir = opendir($path);
		while ($file = readdir($dir)) {
			if(is_file($path.'/'.$file) && $file != "." && $file != "..") {
				$replaced = str_replace('{{name}}', $path.'/'.$file, $pattern);
				$replaced = str_replace('{{file}}', $file, $replaced);
				if(!empty($prefFile) && $prefFile==$file) $replaced = str_replace('{{selected}}', 'selected', $replaced);
				else $replaced = str_replace('{{selected}}', '', $replaced);				
				$result .= $replaced;
			}
		}
		return $result;
	} //End settings_getThemeFiles();

	//Load request file
	function settings_loadFile($theme, $get) {
		global $lang, $core;
		$result = NULL;

		$path = '../'.THEMES.$theme;
		if(is_file($path.'/'.$get)) $result = htmlspecialchars(file_get_contents($path.'/'.$get));
		else $core->notify($lang['settings']['file doesnt exist'],2);
		return $result;
	} //End settings_loadFile();

	//Check files and their chmods
	function settings_checkChmod($file) {
		if(!is_writable($file) || !is_readable($file)) return FALSE;
		else return TRUE;
	} //End settings_checkChmod();
	
	//Get Modules
	function settings_getModules($pattern) {
		global $core, $lang;
		$result = NULL;
		
		$modules = simplexml_load_file('http://lekki.sruu.pl/modules.xml');
		if($modules) {
			foreach ($modules as $module) {
				if($module['name']=='core') {
					$replaced = str_replace('{{name}}', 'LCMS Core', $pattern);
					$replaced = str_replace('{{ver}}', LCMS_VERSION, $replaced);
					$replaced = str_replace('{{status}}', settings_getModuleStatus(LCMS_VERSION,$module->version), $replaced);
					$result .= $replaced;	
				}
				else {
					$moduleInfo = $core->getModuleInfo($module['name']);
					$replaced = str_replace('{{name}}', $moduleInfo['name'], $pattern);
					$replaced = str_replace('{{ver}}', $moduleInfo['version'], $replaced);
					$replaced = str_replace('{{status}}', settings_getModuleStatus($moduleInfo['version'],$module->version), $replaced);
					$result .= $replaced;
				}
			}
		} else $result = $lang['settings']['cant get data from server'];
		
		return $result;
	} //End settings_getModules();
	
	//Get module status 	
	function settings_getModuleStatus($localVersion, $remoteVersion) {
		global $lang;
		if(version_compare($localVersion, $remoteVersion) < 0)
			return '<span style="color:#BA3C46;">'.$lang['settings']['update true'].'</span>';
		else return '<span style="color:#5ea636;">'.$lang['settings']['update false'].'</span>';
	} //End settings_getModuleStatus(();
	
	
?>
