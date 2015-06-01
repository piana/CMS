<?php

class imageProcessorLimit extends imageProcessor {
		
	public function process() {
	
		if ($this->width!=0){
			$dim = 'w';
			$size = $this->width;
		}else{
			$dim = 'h';
			$size = $this->height;
		}

		$imagedata = getimagesize($this->oryginalPath);
		$w = $imagedata[0];
		$h = $imagedata[1];

		if ($dim == "w" && $w < $size) return $this->imageData;
		if ($dim == "h" && $h < $size) return $this->imageData;
		
		$ratio = $dim=="w"?$size/$w:$size/$h;
		
		$thumb = ImageCreateTrueColor($ratio*$w, $ratio*$h);
		if($this->extension=='png'){
			imagealphablending($thumb, false);
			imagesavealpha($thumb, true);
		}		
		imagecopyResampled ($thumb, $this->imageData, 0, 0, 1, 1, $ratio*$w, $ratio*$h, $w-2, $h-2);

		return $thumb;
	}
}

?>