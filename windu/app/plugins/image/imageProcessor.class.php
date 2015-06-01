<?php  /*windu.org image*/

abstract class imageProcessor {

    protected $original;
    protected $parameters;
    protected $filter;
    protected $imageData;
    protected $extension;

    private static $imageCreateFromParams = array(
		"jpg" => 100,
		"jpeg" => 100,
		"png" => 0
	);
	
	public function __construct($image,$width, $height, $filter = array()) {
		$this->original = $image;
		$this->width = $width;
		$this->height = $height;
		$this->filter = $filter;
		$this->extension = $image->type;
		$this->oryginalPath = FILES_DIR.$image->path.'/'.$image->fileName;
		
		$imageFunction = "imagecreatefrom".$this->extension;
		$this->imageData = $imageFunction($this->oryginalPath);
	}
	
	public abstract function process();
}
?>