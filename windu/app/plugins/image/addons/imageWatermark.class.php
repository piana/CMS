<?php
class imageWatermark{
	public static function add($imageData) {
		$stamp = imagecreatefrompng(DATA_PATH."files/watermark.png");
		$im = $imageData;

		
		$mainImageWidth = imagesx($imageData);
		$margin = round($mainImageWidth*0.01*2);
		
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);
		

		
		$stampWidth = round(0.01*config::get('imgWatermarkWidth')*$mainImageWidth);
		$ratio = $stampWidth/imagesx($stamp);

		$stampHeight = round($ratio*imagesy($stamp));

		$position = config::get('imgWatermarkPosition');
		$transparent = config::get('transparent');

		if ($position=='right bottom') {
			//right bottom
			$positionX = imagesx($im) - $stampWidth - $margin;
			$positionY = imagesy($im) - $stampHeight - $margin;
		}elseif ($position=='left top'){
			//left top
			$positionX = $margin;
			$positionY = $margin;			
		}elseif ($position=='left bottom'){
			//left bottom
			$positionX = $margin;
			$positionY = imagesy($im) - $stampHeight - $margin;			
		}elseif ($position=='left top'){
			//left top
			$positionX = imagesx($im) - $stampWidth - $margin;
			$positionY = $margin;				
		}elseif ($position=='center center'){
			//center center
			$positionX = imagesx($im)/2 - $stampWidth/2;
			$positionY = imagesy($im)/2 - $stampHeight/2;			
		}
	
		
		imagecopyresampled($im, $stamp, $positionX, $positionY, 0, 0, $stampWidth, $stampHeight, $sx, $sy);


		return $im;
	}

}

?>