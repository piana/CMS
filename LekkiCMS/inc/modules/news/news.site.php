<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require(LANG.'news.php');

	//Replacing
	$core->replace('{{news}}', news(@$_GET['news'], @$_GET['page']));

	//Main function --------------------------------------
	function news($news, $page) {
		global $core, $db, $lang;
		$result = NULL;

		//Get settings
		if($query = $db->select('news_settings')) foreach((array)$query as $record) $settings[$record['field']] = $record['value'];

		if(!isset($news) || empty($news)) {
			if($query = $db->select('news')) {
				if(empty($page) || !isset($page) || !is_numeric($page) || $page>ceil($db->num_rows($query)/$settings['posts_on_page'])) $page = 1;
				//Sort
				krsort($query);
				//Segmentation
				$news = array_chunk($query, $settings['posts_on_page']);
				
				//Get lang and pages settings if they are empty
				if(empty($_GET['lang']) && empty($_GET['go'])) {
					$_GET['lang'] = preg_replace('/([a-z]{2,3})\_([a-z]+)/','$1',$core->getSettings('site_lang'));
					$_GET['go'] = $core->getSettings('start_page');
				}

				//Display all news
				foreach($news[$page-1] as $record) {
					$result .= '<div class="news">';
					$result .= '<h2><a href="index.php?go='.@$_GET['go'].'&lang='.@$_GET['lang'].'&news='.$record['id'].'">'.$record['title'].'</a></h2>';
					$date = new DateTime($record['date']); //Change date format
					$result .= '<span class="date">'.$date->format("Y-m-d H:i").'</span>';
					//Reduction
					$record['content'] = news_strcut($record['content'], $settings['max_chars']);
					$record['content'] = str_replace('{{read.more}}', '<a href="index.php?go='.@$_GET['go'].'&lang='.@$_GET['lang'].'&news='.$record['id'].'" class="more">'.$lang['news']['read more'].'</a>', $record['content']);
					$result .= str_replace('\n', "\n", '<p>'.$record['content'].'</p>');
					$result .= '</div>';
				}

				//Display pagination
				if($db->num_rows($query)>$settings['posts_on_page']) {
					$result .= '<div class="pagination">';
					for($i = 1; $i < count($news)+1; $i++)
						$result .= '<a href="index.php?go='.@$_GET['go'].'&lang='.@$_GET['lang'].'&page='.$i.'" '.($page==$i?'class="current"':'').'>'.$i.'</a> ';
					$result .= '</div>';
				}
			}
		} else { //Display a single news
			if($query = $db->select('news', array('id'=>$news))) {
				$record = $query[0];
				$core->append(' - '.$record['title'], 'title');
				$result .= '<div class="news single">';
				$result .= '<h2>'.$record['title'].'</h2>';
				$date = new DateTime($record['date']); //Change date format
				$result .= '<span class="date">'.$date->format("Y-m-d H:i").'</span>';
				$result .= str_replace('\n', "\n", '<p>'.$record['content'].'</p>');
				$result .= '</div>';
			} else $result .= $lang['news']['news doesnt exist'];
		}

		return $result;
	} //End news();
	
	//Additional function --------------------------------------
	function news_strcut($string, $max_chars) {
		$string = strip_tags($string, '<a><b><u><i><img><span><strong><font>');
		$i = 0;
		$tags = array();
		preg_match_all('/<[^>]+>([^<]*)/', $string, $m, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
		foreach($m as $o) {
			if($o[0][1] - $i >= $max_chars) break;
			$t = substr(strtok($o[0][0], " \t\n\r\0\x0B>"), 1);
			if($t[0] != '/' && $t != 'img') $tags[] = $t;
			elseif(end($tags) == substr($t, 1)) array_pop($tags);
			$i += $o[1][1] - $o[0][1];
		}
		$result = mb_substr($string, 0, $max_chars = min(strlen($string), $max_chars + $i), 'utf-8');
		$result .= (count($tags = array_reverse($tags)) ? '</' . implode('></', $tags) . '>' : '');
		if(strlen($string)>strlen($result)) $result .= '... {{read.more}}';
		return $result;
	}

?>