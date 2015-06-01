<?php /*windu.org image controller*/
Class imageController extends controller
{	
	public function index(){
		$ekey = $this->request->getVariable('ekey');
					
		if($this->request->getVariable('transform') == 'original'){
			$imagesDB = new imagesDB();
			$image = $imagesDB->getByEkey($ekey);
			
			$imagePath = DATA_PATH.'/files/'.$image->path.'/'.$image->fileName;
			$imageOpen = fopen($imagePath,'rb');
			
			if (!cache::fileIsCached('img', __HOME)) {
				cache::fileWrite('img',__HOME,$image);
				cache::fileWrite('img-thumb',__HOME,array('path'=>FILES_DIR.$image->path.'/'.$image->fileName,'width'=>$image->width, 'height'=>$image->height));

				baseFile::saveFile( CACHE_PATH.'system/img-alllist-'.md5(HOME).'.tmp', __HOME."\n",FILE_APPEND);
			}
			
		}else{
			if (cache::fileIsCached('img', __HOME)) {
				$image = cache::fileRead('img',__HOME);
				$imagePath = __SITE_PATH.'/'.$image->fullThumbPath;
				$imageOpen = fopen($imagePath,'rb');
			}else{			
				$transform = $this->request->getVariable('transform');
				$filters = $this->request->getVariable('filters');
				$quality = $this->request->getVariable('quality');
				$width = $this->request->getVariable('width');
				$height = $this->request->getVariable('height');			
				
				if ($transform!=null){$transform = $transform;}else{$transform = 'natural';}
				if ($filters!=null){$filters = $filters;}else{$filters = 'original';}
				if ($quality!=null){$quality = $quality;}else{$quality = config::get('imgQuality');}
		
				$image = image::getByEkey($ekey,$width,$height,$transform,$filters,$quality);
				$imagePath = __SITE_PATH.'/'.$image->fullThumbPath;
				$imageOpen = fopen($imagePath,'rb');

				
				cache::fileWrite('img',__HOME,$image);
				cache::fileWrite('img-thumb',__HOME,array('path'=>$image->fullThumbPath,'width'=>$width, 'height'=>$height));				
								
				baseFile::saveFile( CACHE_PATH.'system/img-alllist-'.md5(HOME).'.tmp', __HOME."\n",FILE_APPEND);
			}
		}
		$fileSize = filesize($imagePath);
		$type = $image->type;
		
		header("Pragma: ");
   		header("Cache-Control: max-age");
		header('Content-Type: image/'.$type);
		header("Content-Disposition:inline; filename='{$image->name}_{$image->fileName}'");
		header("Content-length: {$fileSize}");
		header("Connection: close");
		fpassthru($imageOpen);
		fclose($imageOpen);
	}
}
?>
