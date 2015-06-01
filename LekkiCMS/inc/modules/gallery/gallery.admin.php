<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/gallery.php');

	//Pages of this module
	function gallery_pages() {
		global $lang;
		$pages[] = array(
			'func'  => 'gallery_manage',
			'title' => $lang['gallery']['management']
		);
		$pages[] = array(
			'func'  => 'gallery_add',
			'title' => $lang['gallery']['add']
		);
		return $pages;
	}

	/*** Main functions ********************************************************************************************/

	//List of galleries
	function gallery_manage() {
		global $lang, $db, $core;
		$result = NULL;
		
		//Edit
		if(isset($_GET['edit']) && !empty($_GET['edit']) && is_numeric($_GET['edit'])) {
			$result = gallery_edit($_GET['edit']);
		} else {
			//Delete
			if(isset($_GET['del']) && !empty($_GET['del']) && is_numeric($_GET['del'])) {
				if(is_dir('../uploads/gallery_'.$_GET['del'])) {
					if(removeDir('../uploads/gallery_'.$_GET['del'])) {
						if($db->delete('gallery', array('id'=>$_GET['del']))) $core->notify($lang['gallery']['gallery delete success'],1);
						else $core->notify($lang['gallery']['gallery delete fail'],2);
					} else $core->notify($lang['gallery']['gallery delete fail'],2);
				} else $core->notify($lang['gallery']['gallery doesnt exist'],2);
			}
			//Select table from DB
			$query = $db->select('gallery');
			$result .= '<table> <thead>';
			$result .= '<tr> <td>'.$lang['gallery']['name'].'</td> <td>'.$lang['gallery']['code'].'</td> <td width="52px">'.$lang['gallery']['actions'].'</td> </tr>';
			$result .= '</thead> <tbody>';
			//Get the records
			foreach($query as $record) {
				$result .= '<tr> <td><a href="?go=gallery&edit='.$record['id'].'">'.$record['name'].'</a></td> <td>{{gallery.'.$record['namec'].'}}</td> <td><a href="?go=gallery&edit='.$record['id'].'" class="icon">Z</a> <a href="?go=gallery&del='.$record['id'].'" onclick="return confirm(\''.$lang['gallery']['delete confirm'].'\')" class="icon">l</a></td> </tr>';
			}
			$result .= '</tbody> </table>';
			//Display info about galleries
			$result .= '<span class="info">'.$lang['gallery']['info'].'</span>';
		}

		return $result;
	} //End gallery_manage();
	
	//Edit gallery
	function gallery_edit($id) {
		global $lang, $db, $core;
		$result = NULL;
		
		//Save settings
		if(isset($_POST['save'])) {
			if(!empty($_POST['name']) && !empty($_POST['thumbs_x']) && !empty($_POST['thumbs_y']) && !empty($_POST['img_on_page']) && $_POST['titles']!='') {
				if(is_numeric($_POST['thumbs_x']) && is_numeric($_POST['thumbs_y']) && is_numeric($_POST['img_on_page'])) {
					$thumbs_size = $_POST['thumbs_x'].'x'.$_POST['thumbs_y'];
					$updateRecord = array($id, $_POST['name'], changeSigns($_POST['name']), $thumbs_size, $_POST['img_on_page'], $_POST['titles']);
					if($db->update('gallery', array('id'=>$id), $updateRecord)) $core->notify($lang['gallery']['update success'],1);
					else $core->notify($lang['gallery']['update fail'],2);
				} else $core->notify($lang['gallery']['un-numeric values'],2);
			} else $core->notify($lang['gallery']['empty inputs warning'],2);
		} //End of save settings
		
		//Save image changes
		elseif(isset($_POST['save_images'])) {
			$error = 0;
			foreach($_POST['title'] as $key => $value) {
				if(!file_put_contents('../uploads/gallery_'.$id.'/'.$key.'.txt', $_POST['order'][$key].'||'.htmlspecialchars($value))) $error++;
			}
			if(!$error) $core->notify($lang['gallery']['update success'],1);
			else $core->notify($lang['gallery']['update fail'],2);
		} //End of save image changes
		
		//Delete
		elseif(isset($_GET['del']) && !empty($_GET['del'])) {
			if(is_file('../uploads/gallery_'.$id.'/'.$_GET['del'])) {
				$error = 0;
				if(!unlink('../uploads/gallery_'.$id.'/'.$_GET['del'])) $error++;
				if(!unlink('../uploads/gallery_'.$id.'/'.$_GET['del'].'.txt')) $error++;
				if(!unlink('../uploads/gallery_'.$id.'/thumbs/'.$_GET['del'])) $error++;
				if(!$error) header('Location:index.php?go=gallery&edit='.$id);
				else $core->notify($lang['gallery']['image delete fail'],2);
			} else $core->notify($lang['gallery']['image doesnt exist'],2);
		} //End of delete
		
		//Upload image
		elseif(isset($_FILES['image']) && !empty($_FILES['image'])) {
			gallery_uploadImage($_FILES['image'], $id);
		} //End of upload image
			
		//Get data
		if($query = $db->select('gallery', array('id'=>$id))) {
		
			$record = $query[0];
			$result .= gallery_form($record);
			
			//Add style and script  to head
			$head = '<style type="text/css">
			img {
				width: 70px;
				height: 50px;
				margin: 3px 3px 3px 0px;
			}
			img#uploadPreview {
				background: #DDDDDD;
				display: block;
				margin-bottom: 3px;
			}
			.LCMS table td:first-of-type {
				width: 148px;
			}
			.LCMS table td:last-of-type {
				text-align: right;
			}
			.LCMS table input[type="text"] {
				float: none;
				width: 92%;
			}
			.LCMS table input.order {
				width: 17px;
				text-align: center;
			}
			.LCMS table input[type="file"] {
				margin: 4px 0px 0px 0px;
			}
			</style>
			<script type="text/javascript">
				function PreviewImage() {
					oFReader = new FileReader();
					oFReader.readAsDataURL(document.getElementsByName("image")[0].files[0]);

					oFReader.onload = function (oFREvent) {
						document.getElementById("uploadPreview").src = oFREvent.target.result;
					};
				};
			</script>';
			$core->append($head, 'head');
			
			//Get images
			if(count(glob('../uploads/gallery_'.$id.'/*.{jpg,jpeg,png,gif}', GLOB_BRACE))) {
				$result .= '<form method="post" action="'.$_SERVER['REQUEST_URI'].'">';
				$result .= '<table> <thead>';
				$result .= '<tr> <td>'.$lang['gallery']['thumbnail'].'</td> <td>'.$lang['gallery']['title'].' / '.$lang['gallery']['order'].'</td> <td>'.$lang['gallery']['actions'].'</td>';
				$result .= '</thead> <tbody>';
				//List of images
				$result .= gallery_getImages('<tr> <td>{{thumb}}</td> <td>{{input}}</td> <td>{{actions}}</td> </tr>', $id);
				$result .= '</tbody> </table>';
				$result .= '<button type="submit" name="save_images">'.$lang['gallery']['save'].'</button>';
				$result .= '</form>';
			}
			//Upload new image
			$result .= '<h2>Dodaj<span>Obraz</span></h2>';
			$result .= '<table> <thead>';
			$result .= '<tr> <td>'.$lang['gallery']['thumbnail'].'</td> <td>'.$lang['gallery']['file'].'</td> <td>'.$lang['gallery']['actions'].'</td>';
			$result .= '</thead> <tbody>';
			$result .= '<tr> <td><img id="uploadPreview"/></td> <td><form method="post" name="upload" enctype="multipart/form-data"><input type="file" name="image" onchange="PreviewImage();" /></form></td> <td><a href="#" onclick="document.upload.submit();" class="icon">M</a></td> </tr>';
			$result .= '</tbody> </table>';
			
		} else $result .= $lang['gallery']['gallery doesnt exist'];
		//End of get data
		
		return $result;
	} //End gallery_edit();

	//Add a new gallery
	function gallery_add() {
		global $lang, $db, $core;
		$result = NULL;

		if(isset($_POST['add'])) {
			if(!empty($_POST['name']) && !empty($_POST['thumbs_x']) && !empty($_POST['thumbs_y']) && !empty($_POST['img_on_page']) && $_POST['titles']!='') {
				if(is_numeric($_POST['thumbs_x']) && is_numeric($_POST['thumbs_y']) && is_numeric($_POST['img_on_page'])) {
					$thumbs_size = $_POST['thumbs_x'].'x'.$_POST['thumbs_y'];
					if($db->insert('gallery', array(NULL, $_POST['name'], changeSigns($_POST['name']), $thumbs_size, $_POST['img_on_page'], $_POST['titles']))) {
						//Create dir with gallery images
						$query = $db->select('gallery');
						$record = end($query);
						if(!is_dir('../uploads/gallery_'.$record['id'])) {
							if(mkdir('../uploads/gallery_'.$record['id'], 0777)) {
								if(mkdir('../uploads/gallery_'.$record['id'].'/thumbs', 0777)) $core->notify($lang['gallery']['add success'],1);
							} else $core->notify($lang['gallery']['add fail'],2);
						} else $core->notify($lang['gallery']['add success'],1);
					}
				} else $core->notify($lang['gallery']['un-numeric values'],2);
			} else $core->notify($lang['gallery']['empty inputs warning'],2);
		}

		$result .= gallery_form();

		return $result;
	} //End gallery_add();

	/*** Additional functions ********************************************************************************************/
	
	//Gallery form
	function gallery_form($data = array()) {
		global $core, $lang;
		//Thumbs size
		if(isset($data['thumbs_size'])) {
			$thumbs_size = explode('x', $data['thumbs_size']);
		}
		$result = '<form name="add_gallery" method="post" action="'.$_SERVER['REQUEST_URI'].'">';
		//Name
		$result .= '<label>'.$lang['gallery']['name'].' <span>'.$lang['gallery']['name desc'].'</span></label>';
		$result .= '<input type="text" name="name" value="'.@$data['name'].'" />';
		//Thumbnails size
		$result .= '<label>'.$lang['gallery']['thumbnails size'].' <span>'.$lang['gallery']['thumbnails size desc'].'</span></label>';
		$result .= '<input type="text" name="thumbs_x" style="width:31.3%;" value="'.($data?@$thumbs_size[0]:'160').'" />'; //X
		$result .= '<div style="float:left;margin-left:10px;margin-top:6px;font-size:20px;" class="icon">S</div>';
		$result .= '<input type="text" name="thumbs_y" style="width:31.3%;" value="'.($data?@$thumbs_size[1]:'120').'" />'; //Y
		//Images on page
		$result .= '<label>'.$lang['gallery']['img on page'].' <span>'.$lang['gallery']['img on page desc'].'</span></label>';
		$result .= '<input type="text" name="img_on_page" value="'.@$data['img_on_page'].'" />'; //X
		//Titles
		$result .= '<label>'.$lang['gallery']['titles'].' <span>'.$lang['gallery']['titles desc'].'</span></label>';
		if($data) {
			$result .= '<div class="radio">
				<input type="radio" name="titles" value="1" '.(@$data['titles']?'checked':'').'/>'.$lang['gallery']['yes'].'
				<input type="radio" name="titles" value="0" '.(!@$data['titles']?'checked':'').'/>'.$lang['gallery']['no'].'
			</div>';
			//Button
			$result .= '<button type="submit" name="save">'.$lang['gallery']['save'].'</button>';
		}
		else {
			$result .= '<div class="radio">
				<input type="radio" name="titles" value="1" />'.$lang['gallery']['yes'].'
				<input type="radio" name="titles" value="0" checked />'.$lang['gallery']['no'].'
			</div>';
			//Button
			$result .= '<button type="submit" name="add">'.$lang['gallery']['add'].'</button>';
		}
		$result .= '</form>';
		return $result;
	} //End gallery_form();
	
	//Get gallery's images
	function gallery_getImages($pattern, $id) {
		global $lang, $core;
		$gallery_dir = '../uploads/gallery_'.$id;
		$thumbs_dir = '../uploads/gallery_'.$id.'/thumbs';
		$dir = opendir($gallery_dir);
		$allows = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'gif', 'GIF');
		//List images
		$result = NULL; $unSortedArray = array();
		while ($file = readdir($dir)) {
			if (is_file($gallery_dir.'/'.$file) && $file != "." && $file != "..") {
				$file_info = pathinfo($gallery_dir.'/'.$file);
				if(in_array($file_info['extension'],$allows)) {
					//Thumb
					$replaced = str_replace('{{thumb}}', '<img src="'.$thumbs_dir.'/'.$file.'" />', $pattern);
					//Input
					if($textData = explode('||', file_get_contents($gallery_dir.'/'.$file.'.txt'))) {
						$order = $textData[0];	$title = $textData[1];
					} else { $order = 0; $title = NULL; }
					$replaced = str_replace('{{input}}', '<input type="text" name="title['.$file.']" value="'.$title.'" /> <input type="text" name="order['.$file.']" value="'.$order.'" class="order"/>', $replaced);
					//Actions
					$replaced = str_replace('{{actions}}', '<a href="'.$core->fixGet('del:=').$file.'" onclick="return confirm(\''.$lang['gallery']['delete confirm'].'\')" class="icon">l</a>', $replaced);
					$replaced = str_replace('{{filename}}', $file, $replaced);
					$unSortedArray[] = array('order'=>$order, 'content'=>$replaced);
				}
			}
		}
		if($unSortedArray) {
			usort($unSortedArray, create_function('$a,$b', 'return $a["order"]>$b["order"];'));
		  
			foreach($unSortedArray as $element)
				$result .= $element['content'];
		}
		
		return $result;
	} //End gallery_getImages();
	
	//Upload a file
	function gallery_uploadImage($file, $galleryID) {
		global $lang, $core;
		$gallery_dir = '../uploads/gallery_'.$galleryID.'/';
		$thumbs_dir = '../uploads/gallery_'.$galleryID.'/thumbs';
		$allows = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'gif', 'GIF');
		$file_info = pathinfo($file['name']);
		
		if(in_array($file_info['extension'],$allows)) {
			//Check for errors
			if($file["error"] == 0) {
				//Check for image with this same name
				if(!file_exists($gallery_dir.changeSigns($file['name']))) {
					//Move file to gallery dir
					if(move_uploaded_file($file['tmp_name'], $gallery_dir.changeSigns($file['name']))) {
						//Create txt file
						if(file_put_contents($gallery_dir.changeSigns($file['name']).'.txt', (gallery_getMaxOrder($galleryID)+1).'||'.$file_info['filename'])) {
							//Create thumb
							if(gallery_imageResize($gallery_dir.changeSigns($file['name']), $thumbs_dir, 400, 400)) $core->notify($lang['gallery']['upload image success'],1);
							else $core->notify($lang['gallery']['upload image fail'],2);
						} else $core->notify($lang['gallery']['upload image fail'],2);
					} else $core->notify($lang['gallery']['upload image fail'],2);
				} else $core->notify($lang['gallery']['image already exist'],2);
			} else $core->notify($lang['gallery']['upload image fail'],2);
		} else $core->notify($lang['gallery']['unauthorized extension'],2);
	} //End gallery_uploadImages();
	
	//Get max image order
	function gallery_getMaxOrder($galleryID) {
		$txtFiles = glob('../uploads/gallery_'.$galleryID.'/*.txt');
		if($txtFiles) {
			foreach($txtFiles as $file) {
				$textData = explode('||', file_get_contents($file));
				$array[] = $textData[0];
			}
		} else $array[0] = 0;
		return max($array);
	} //End gallery_getMaxOrder();
	
	//Image resize
	function gallery_imageResize($image, $dirToSave, $maxWidth, $maxHeight) {
		$details = getimagesize($image); 
		$file_info = pathinfo($image);
		$result = false;
		//Create ratio (0 = width; 1 = height)
		if($details[1] > $details[0]) {   
			$ratio = $maxHeight / $details[1];  
			$newHeight = $maxHeight;
			$newWidth = $details[0] * $ratio; 
		} else {
			$ratio = $maxWidth / $details[0];   
			$newWidth = $maxWidth;  
			$newHeight = $details[1] * $ratio;   
		}
		//Create thumb
		$thumb = imagecreatetruecolor($newWidth, $newHeight);
		switch($details['mime']) { 
            case 'image/jpeg': 
				$source = imagecreatefromjpeg($image); 
				imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $details[0], $details[1]);
				if(imagejpeg($thumb, $dirToSave.'/'.$file_info['filename'].'.'.$file_info['extension'], 75)) $result = true;
				break; 
            case 'image/gif': 
				$source = imagecreatefromgif($image); 
				imagefill($thumb, 0, 0, imagecolortransparent($thumb));
				imagecolortransparent($thumb, imagecolortransparent($thumb));
				imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $details[0], $details[1]);
				if(imagegif($thumb, $dirToSave.'/'.$file_info['filename'].'.'.$file_info['extension'], 8)) $result = true;
				break; 
            case 'image/png': 
				$source = imagecreatefrompng($image);
				imagealphablending($thumb, false);
				imagesavealpha($thumb, true);
				imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $details[0], $details[1]);
				if(imagepng($thumb, $dirToSave.'/'.$file_info['filename'].'.'.$file_info['extension'])) $result = true;
				break; 
        }
		return $result;
	} //End gallery_imageResize();

	function changeSigns($text) {
		setlocale(LC_ALL, 'pl_PL');
        $text = str_replace(' ', '-', $text);
        $text = iconv('utf-8', 'ascii//translit', $text);
        $text = preg_replace('#[^a-z0-9\-\.]#si', '', $text);
        return strtolower(str_replace('\'', '', $text));
    } 
	
	function removeDir($dir) {
		if (!file_exists($dir)) return true;
		if (!is_dir($dir)) return unlink($dir);
		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..') continue;
			if (!removeDir($dir.DIRECTORY_SEPARATOR.$item)) return false;
		}
		return rmdir($dir);
	}

?>
