<?php

		//Make sure the file isn't accessed directly
		defined('IN_LCMS') or exit('Access denied!');
		
		//Get settings values
		$settings = settings_values();
		
		//Replace pattern by value
		$core->replace('{{theme.path}}', $settings['theme_path']);
		$core->replace('{{site.title}}', $settings['title']);
		$core->replace('{{site.description}}', $settings['description']);
		$core->replace('{{site.keywords}}', $settings['keywords']);
		$core->replace('{{site.footer}}', $settings['footer']);
		$core->replace('{{lcms.footer}}', $settings['lcms_footer']);
		$core->replace('{{site.lang}}', $settings['langSelect']);

		//Main function --------------------------------------
		function settings_values() {
			global $db;

			//Get settings from DB
			if($query = $db->select('settings')) {
				foreach((array)$query as $record) $settings[$record['field']] = $record['value'];
				//Lang Select
				$langSelect = '<form method="get" name="langSelect" action="index.php"><select name="lang" onchange="document.langSelect.submit();">';
						$dir = opendir('inc/lang/');
						while ($file = readdir($dir)) {
							if(is_dir('inc/lang/'.$file) && $file != "." && $file != "..") {
								$ex = explode('_', $file);
								if(isset($_GET['lang']) && !empty($_GET['lang'])) {
									if($ex[0]==$_GET['lang']) $selected = 'selected';
									else $selected = '';
								} else {
									if($settings['site_lang']==$file) $selected = 'selected';
									else $selected = '';
								}
								$langSelect .= '<option value="'.$ex[0].'" '.$selected.'>'.$ex[1].'</option>';
							}
						}
				$langSelect .= '</select></form>';
				//Description & keywords
				if(isset($_GET['go']) && !empty($_GET['go']) && is_numeric($_GET['go'])) {
					if($query = $db->select('pages',array('id'=>$_GET['go']))) {
						$record = $query[0];
						if($record['desc']) $desc = $record['desc'];
						else $desc = $settings['description'];

						if($record['keys']) $keys = $record['keys'];
						else $keys = $settings['keywords'];
					} else {
						$desc = $settings['description'];
						$keys = $settings['keywords'];
					}
				} else {
					$desc = $settings['description'];
					$keys = $settings['keywords'];
				}

				//Array with definitions
				$return['langSelect'] = $langSelect;
				$return['title'] = $settings['title'];
				$return['description'] = $desc;
				$return['keywords'] = $keys;
				$return['footer'] = $settings['footer'];
				$return['lcms_footer'] = $settings['lcms_footer'];
				$return['theme_path'] = THEMES.$settings['theme'];

				return $return;
			}
		} //End settings_replacing();

?>