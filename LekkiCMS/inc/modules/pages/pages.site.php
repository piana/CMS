<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require(LANG.'pages.php');
	
	//Define template
	$core->pattern = $core->loadPattern(getPage(@$_GET['go'],@$_GET['lang'],'template'));

	//Replace pattern by function
	$core->replace('{{page.title}}', getPage(@$_GET['go'],@$_GET['lang'],'title'));
	$core->replace('{{page.content}}', getPage(@$_GET['go'],@$_GET['lang'],'content'));
	$core->replace('{{menu.top}}', getMenu(@$_GET['lang'],'top'));
	$core->replace('{{menu.side}}', getMenu(@$_GET['lang'],'side'));

	/*** MAIN FUNCTIONS **************************************************************/
	//Get Pages
	function getPage($get, $siteLang, $element) {
		global $db, $core, $lang;
		$title = NULL; $content = NULL;

		//Get the start page
		if((!isset($get) || empty($get))) {
			$settingsLang = explode('_',$core->getSettings('site_lang'));
			if(!isset($siteLang) || $siteLang==$settingsLang[0]) {
				$startPage = $core->getSettings('start_page');
				if($query = $db->select('pages',array('id'=>$startPage))) {
					$record = $query[0];
					$title = $record['title'];
					$content = $record['content'];
					$template = $record['tpl'];
				} else {
					if($query = $db->select('pages')) {
						$record = $query[0];
						$title = $record['title'];
						$content = $record['content'];
						$template = $record['tpl'];
					} else {
						$title = $lang['pages']['no pages'];
						$content = $lang['pages']['no pages desc'];
						$template = 'template.html';
					}
				}
			} else {
				if($query = $db->select('pages',array('lang'=>$siteLang))) {
					$record = $query[0];
					$title = $record['title'];
					$content = $record['content'];	
					$template = $record['tpl'];
				} else {
					$title = $lang['pages']['no pages'];
					$content = $lang['pages']['no pages desc'];
					$template = 'template.html';					
				}
			}
		} else { //Get other pages
			if(is_numeric($get) && $query = $db->select('pages',array('id'=>$get))) {
				$record = $query[0];
				$title = $record['title'];
				$content = $record['content'];
				$template = $record['tpl'];
			} else {
				$title = $lang['pages']['error 404'];
				$content = $lang['pages']['error 404 desc'];
				$template = 'template.html';				
			}
		}

		//Return elements
		if($element == 'title') return $title;
		elseif($element == 'content') return str_replace('\n', "\n", $content);
		elseif($element == 'template') return $template;
	} //End getPage();

	//Get Menu
	function getMenu($siteLang, $type) {
		global $db, $core, $lang;
		$unSortedArray = NULL;
		$settingsLang = explode('_',$core->getSettings('site_lang'));

		if($query = $db->select('pages',array('menu'=>$type))) {
			if($db->num_rows($query)>0) {
				if(!isset($siteLang) || empty($siteLang) || !glob('inc/lang/'.$siteLang.'_*', GLOB_ONLYDIR)) $siteLang = $settingsLang[0];
				foreach((array)$query as $record) {
					if($siteLang == $record['lang'] && $record['parent']==0) {
						$active = '';
						if(isset($_GET['go']) && !empty($_GET['go'])) {
							if($_GET['go']==$record['id'] && is_numeric($_GET['go'])) $active = ' class="active"';
						} elseif(!isset($siteLang) || $siteLang==$settingsLang[0]) {
							if($core->getSettings('start_page')==$record['id']) $active = ' class="active"';
						} else {
							if($queryTWO = $db->select('pages',array('lang'=>$siteLang))) {
								$recordTWO = $queryTWO[0];
								if($recordTWO['id']==$record['id']) $active = ' class="active"';
							}
						}
						$code = '<li'.$active.'><a href="'.rewrite($record['id'],$record['title'],$siteLang).'">'.$record['title'].'</a>';
						$unSortedArray[$record['order']] = getMenuChildren($record['id'], $code, $siteLang);
						$unSortedArray[$record['order']] .= '</li>';
					}
				}
			}
		}
		return pages_sortArray($unSortedArray);
	} //End getMenu();

	//Get menu children
	function getMenuChildren($id, $code, $siteLang) {
		global $core, $db;
		$unSortedArray = array(); $children = NULL;

		if($query = $db->select('pages', array('parent'=>$id))) {
			if($db->num_rows($query)>0) {
				foreach((array)$query as $record) {
					$unSortedArray[$record['order']] = '<li><a href="'.rewrite($record['id'],$record['title'],$siteLang).'">'.$record['title'].'</a></li>';
				}
			$children = '<ul class="submenu">'.pages_sortArray($unSortedArray).'</ul>';
			}
		}
		return $code.$children;
	} //End getMenuChildren();

	//Sort array
	function pages_sortArray($array) {
		$result = NULL;
		if(count($array)>0) {
			ksort($array);
			foreach((array)$array as $value) $result .= $value;
		}
		return $result;
	} //End pages_sortArray();

	//SEO URLs
	function rewrite($id, $title, $siteLang) {
		global $core;
		if($core->getSettings('seo-friendly')) {
			$result = $id.','.$siteLang.','.changeSigns($title).'.html';
		} else $result = '?go='.$id.'&lang='.$siteLang;
		return $result;
	}

	//Change polish signs and special chars
	function changeSigns($text) {
		setlocale(LC_ALL, 'pl_PL');
        $text = str_replace(' ', '-', $text);
        $text = iconv('utf-8', 'ascii//translit', $text);
        $text = preg_replace('#[^a-z0-9\-\.]#si', '', $text);
        return strtolower(str_replace('\'', '', $text));
    }  //End changeSigns


?>