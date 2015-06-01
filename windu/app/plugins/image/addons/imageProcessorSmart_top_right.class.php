<?php
	
class imageProcessorSmart_top_right extends imageProcessor {
	
	public function process() {
	
		$dw = $this->width;
		$dh = $this->height;
		
		
		$imagedata = getimagesize($this->oryginalPath);
		$w = $imagedata[0];
		$h = $imagedata[1];
		
		$wRatio = $dw/$w;
		$hRatio = $dh/$h;

		$sx = 0;
		$sy = 0;

		if ($wRatio > $hRatio) {
			//scale by width
			$wNew = $dw/$wRatio;
			$hNew = $dh/$wRatio;
			
			//cut height
			$sy = 0;
		} else {
			//scale by height
			$wNew = $dw/$hRatio;
			$hNew = $dh/$hRatio;
			
			//cut width
			$sx = $w-$wNew;
		}

		
		$thumb = ImageCreateTrueColor($dw, $dh);
		if($this->extension=='png'){
			imagealphablending($thumb, false);
			imagesavealpha($thumb, true);
		}	
		imagecopyResampled ($thumb, $this->imageData, 0, 0, $sx+1, $sy+1, $dw, $dh, $wNew-2, $hNew-2);
		return $thumb;
	}
}

?>