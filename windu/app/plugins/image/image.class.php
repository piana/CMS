<?php /*windu.org image*/

Class image extends imageBase
{		
	public static $imageFiltersArray = array('blur'=>'blur',
	'brighter'=>'brighter',
	'grayscale'=>'grayscale',
	'bw'=>'bw',
	'sepia'=>'sepia',
	'contrast'=>'contrast',
	'original'=>'original',
	'custom'=>'custom');
	
	public static $imageProcessorArray = array('fit'=>'fit',
	'fixed'=>'fixed',
	'limit'=>'limit',
	'smart'=>'smart',
	'smart_top'=>'smart_top',
	'smart_top_left'=>'smart_top_left',
	'smart_top_right'=>'smart_top_right');
	
	public static function get(stdClass $image,$width = 0,$height = 0,$processor = 'natural',$filter = 'original',$quality = '99') {
		$img = $image;
		$img->fullPath = FILES_DIR.$img->path.'/'.$img->fileName;
		$img->fullThumbPath = strtolower(FILES_DIR.$img->path.'/thumbs/'.$width.'_'.$height.'_'.$processor.'_'.$filter.'_'.$quality.'_'.$img->fileName);

		if (!file_exists($img->fullThumbPath))
		{
			if (!is_dir(FILES_DIR.$img->path.'/thumbs/'))
			{
				$oldumask = umask(0);
				mkdir(FILES_DIR.$img->path.'/thumbs/', 0755);
				umask($oldumask);					
			}
			self::prepare($image,$img->fullThumbPath, $width, $height, $processor, $filter, $quality);
		}
		return $img;
	}
	public static function getByEkey($ekey,$width = 0,$height = 0,$processor = 'Original',$filter = 'original', $quality = 99){
		$imgDB = new imagesDB();
		$img = $imgDB->getByEkey($ekey);
		$image = null;
		if (is_object($img)) {
			$image = self::get($img,$width,$height,$processor,$filter,$quality);
		}
		return $image;
	}
	public static function getById($id,$width = 0,$height = 0,$processor = 'natural',$filter = 'original', $quality = 99){
		$imgDB = new imagesDB();
		$img = $imgDB->fetchRow("id = {$id}");
		if (is_object($img)) {
			$image = self::get($img,$width,$height,$processor,$filter,$quality);
		}
		return $image;
	}
	
	//zwraca tablice z danymi obrazkow, sciezkami itd...
	public static function getAll($where,$width = 0,$height = 0,$processor = 'natural',$order = null,$limit = null)
	{
		$imgDB = new imagesDB();
		$images = $imgDB->fetchAll($where,$order,$what='*',$limit);
		$allImages = array();
		
		foreach ($images as $img)
		{
			$allImages[$img['id']] = self::get($img['id'], $width, $height, $processor = 'natural',$order = null);
		}
		return $allImages;
	}
	
	
	//zapisuje obrazki przychodzace z formularza, wszystkie ktore napotka
	public static function saveIncomingImages($bucket = 0,$returnObject = false)
	{
		$imgDB = new imagesDB();
		//przygotowywuje zmienna na wypadek multiuploadu
		
		$files = self::prepareFileVariable($_FILES);

		foreach ($files as $file)
		{	
			$images[] = self::saveIncomingImage($file,$bucket,$returnObject);
		}
		
		return $images;
	}
	

	//zapisuje pojedynczy obrazek ze zmiennej rpzekazanej nam
	public static function saveIncomingImage($file, $bucket = 0,$returnObject = false)
	{
		$imgDB = new imagesDB();
		//przygotowywuje zmienna na wypadek multiuploadu

		$data = self::saveImage($file);
		
		if ($data!=false)
		{
			$pomName = explode('.',$file['name']);
			$data['name'] = $pomName[0];
			$data['type'] = self::imgType($file['name']);
			$data['size'] = $file['size'];
			$data['bucket'] = $bucket;
			$size = getimagesize(__SITE_PATH.'/'.FILES_DIR.$data['path'].'/'.$data['fileName']);
			$data['width'] = $size[0];
			$data['height'] = $size[1];	
			$newFile = $imgDB->insert($data);		
			$data['ekey'] = $newFile['ekey'];
		}
		if ($returnObject == true) {
			$data['url'] = HOME.FILES_DIR.$data['path'].'/'.$data['fileName'];
			$data = (object)$data;
		}
		$image = $data;

		return $image;
	}	
	public function updateImage($id,$file,$data = array()) {
		$imagesDB = new imagesDB();
		$oldFile = $imagesDB->fetchRow("id={$id}"); 
		$newFile = image::saveIncomingImage($file,$oldFile->bucket);
		
		//delete old file
		self::deleteImage("ekey='{$oldFile->ekey}'");
		
		$data['id'] = $oldFile->id;
		$data['description'] = $oldFile->description;
		$data['ekey'] = $oldFile->ekey;
		$data['position'] = $oldFile->position;
		//replace new file data fron old file
		$imagesDB->updateRow($data,"ekey='{$newFile['ekey']}'");
		cache::flushSystemCache();
		return false;	
	}
	
	//usuwanie wsyztkich tam gdzie spelniony jest warunek where w bazie danych
	public static function deleteImage($where)
	{
		$imgDB = new imagesDB();
		$images = $imgDB->fetchAll($where);
		foreach ($images as $img)
		{
			if(self::deleteImageFiles($img->path,$img->fileName)==true)
			{
				$imgDB->deleteRows("id={$img->id}");
			}		
		}
	}
	public static function deleteImageById($id) {
		self::deleteImage("id = {$id}");
	}
	public static function deleteImageByBucket($bucketId) {
		self::deleteImage("bucket = '{$bucketId}'");
	}	
	public static function getThumbsCount() {
		$dirlist = scandir(DATA_PATH.'files/image/');
		$count = 0;
		foreach ($dirlist as $dir){
			if ($dir!='.svn' and $dir!='..' and $dir!='.') {
				$thumbsPath = DATA_PATH.'files/image/'.$dir.'/thumbs/';
				if (is_dir($thumbsPath)) {
					$count = $count + count(scandir($thumbsPath));
				}
			}
		}
		return $count;
	}	
	public static function deleteImageThumbsAll() {
		$dirlist = scandir(DATA_PATH.'files/image/');
		foreach ($dirlist as $dir){
			if ($dir!='.svn' and $dir!='..' and $dir!='.') {
				if (is_dir(DATA_PATH.'files/image/'.$dir.'/thumbs/')) {
					baseFile::truncateDir(DATA_PATH.'files/image/'.$dir.'/thumbs/');
				}
			}
		}
		cache::flushAllCache();
	}		
	public static function prepare(stdClass $image,$fullThumbPath, $width, $height, $processor, $filters, $quality) {
		$processorName = 'imageProcessor'.ucfirst($processor);
		
		$processor = new $processorName($image, $width, $height);
		$imageThumbData = $processor->process();
		$filters = explode('_', $filters);
		foreach($filters as $filter){
			if (preg_match('/custom*/', $filter)) {
				$filters = explode('.', $filter);
				unset($filters[0]);
				foreach ($filters as $filter){
					$params = explode(',', $filter);
					$imageThumbData = imageFilter::custom($imageThumbData,$params);
				}
			}else{
				$imageThumbData = imageFilter::$filter($imageThumbData);
			}
		}

		$write_image = 'image'.$image->type;
		if($image->type == 'png'){
			$quality=1;
			imagealphablending($imageThumbData, false);
			imagesavealpha($imageThumbData, true);
		}
		if (config::get('imgWatermark')==1 and config::get('imgWatermarkWidthLimit') < $width and config::get('imgWatermarkHeightLimit') < $height ) {
			$imageThumbData = imageWatermark::add($imageThumbData);
		}
		
		$write_image($imageThumbData, $fullThumbPath, $quality);
		imagedestroy($imageThumbData);	
		return true;
	}
	private static function imgType($name)
	{
		if((substr($name, -4, 4) == '.jpg' || substr($name, -4, 4) == 'jpeg') or (substr($name, -4, 4) == '.JPG' || substr($name, -4, 4) == 'JPEG'))
		{
			return "jpeg";
		}
		else if((substr($name, -4, 4) == '.gif') or (substr($name, -4, 4) == '.GIF'))
		{
			return "gif";
		}
		else if((substr($name, -4, 4) == '.png') or (substr($name, -4, 4) == '.PNG'))
		{
			return "png";
		}
	}
}
?>