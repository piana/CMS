<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Function call
	gallery_replace();

	//Pattern replacing --------------------------------------
	function gallery_replace() {
		global $core, $db, $lang;
		$result = NULL;

		if($query = $db->select('gallery')) {
			foreach($query as $record) {
				$core->replace('{{gallery.'.$record['namec'].'}}', gallery_display($record));
			}
		}
		if(count($query)>0) $core->append(gallery_head(), 'head');
	} //End gallery_replace();
	
	//Display gallery --------------------------------------
	function gallery_display($data) {
		global $core, $db, $lang, $gallery_dir;
		
		//Defines
		$result = NULL;
		$gallery_dir = 'uploads/gallery_'.$data['id'];
		$thumbs_dir = 'uploads/gallery_'.$data['id'].'/thumbs';
		$dir = opendir($gallery_dir);
		$allows = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'gif', 'GIF');
		$thumbs_size = explode('x', $data['thumbs_size']);
		$page = @$_GET['g'.$data['id'].'-page'];
		
		//Create array with images
		$array = NULL;
		while ($file = readdir($dir)) {
			if (is_file($gallery_dir.'/'.$file) && $file != "." && $file != "..") {
				$file_info = pathinfo($gallery_dir.'/'.$file);
				if(in_array($file_info['extension'],$allows)) {
					$textData = explode('||', file_get_contents($gallery_dir.'/'.$file.'.txt')); //Get order
					$array[] = array('order'=>$textData[0], 'file'=>$file);
				}
			}
		}
		
		if($array) { //If there are any images...
			if(empty($page) || !isset($page) || !is_numeric($page) || $page>ceil(count($array)/$data['img_on_page'])) $page = 1;
			//Sort by order
			usort($array, create_function('$a,$b', 'return $a["order"]>$b["order"];'));
			
			//Segmentation
			$images = array_chunk($array, $data['img_on_page']);
			
			//List of images
			$result .= '<div class="gallery">';
			foreach($images[$page-1] as $key => $image) {
				//Get image info
				$textData = explode('||', file_get_contents($gallery_dir.'/'.$image['file'].'.txt'));
				//Get image
				$result .= '<div class="thumb">';
				if($thumbs_size[0]>400 || $thumbs_size[1]>400) {
					$result .= '<a href="'.$gallery_dir.'/'.$image['file'].'" data-lightbox="'.$data['namec'].'"><img src="'.$gallery_dir.'/'.$image['file'].'" style="width:'.$thumbs_size[0].'px;height:'.$thumbs_size[1].'px;" /></a>';
				} else {
					$result .= '<a href="'.$gallery_dir.'/'.$image['file'].'" data-lightbox="'.$data['namec'].'"><img src="'.$thumbs_dir.'/'.$image['file'].'" style="width:'.$thumbs_size[0].'px;height:'.$thumbs_size[1].'px;" /></a>';
				}
				if($data['titles']) $result .= '<span class="title">'.$textData[1].'</span>';
				$result .= '</div>';
			}
			$result .= '</div>';
			
			//Dispaly pagination
			if(count($array)>$data['img_on_page']) {
				if(empty($_GET['lang']) && empty($_GET['go'])) {
					$_GET['lang'] = $core->getSettings('site_lang');
					$_GET['go'] = $core->getSettings('start_page');
				}
				$result .= '<div class="pagination">';
				for($i = 1; $i < count($images)+1; $i++)
					$result .= '<a href="index.php?go='.@$_GET['go'].'&lang='.@$_GET['lang'].'&g'.$data['id'].'-page='.$i.'" '.($page==$i?'class="current"':'').'>'.$i.'</a> ';
				$result .= '</div>';
			}
			
		}
		
		return $result;
	} //End gallery_display();
	
	//Replace head section by scripts  --------------------------------------
	function gallery_head() {
		$head = "<script type=\"text/javascript\" src=\"inc/jscripts/lightbox/jquery.lightbox.min.js\"></script>\n";
		$head .= "<script>\n$(document).ready(function(){\n\t$('a[data-lightbox]').lightbox({\n\t\t'backgroundOpacity' : 0.7\n\t});\n});\n</script>";
		return $head;
	} //End gallery_head();

?>
