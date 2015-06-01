<?php
class imageFilter{
	public static function blur($imageData) {
		imagefilter($imageData, IMG_FILTER_GAUSSIAN_BLUR);
		return $imageData;
	}
	public static function brighter($imageData) {
		imagefilter($imageData, IMG_FILTER_BRIGHTNESS, 30);
		return $imageData;
	}
	public static function grayscale($imageData) {
		imagefilter($imageData, IMG_FILTER_GRAYSCALE);
		return $imageData;
	}
	public static function bw($imageData) {
		imagefilter($imageData, IMG_FILTER_GRAYSCALE);
		return $imageData;
	}	
	public static function sepia($imageData) {
		imagefilter($imageData, IMG_FILTER_GRAYSCALE);
		imagefilter($imageData, IMG_FILTER_COLORIZE, 60, 40, 0);

		return $imageData;
	}	
	public static function contrast($imageData) {
		imagefilter($imageData, IMG_FILTER_BRIGHTNESS, 50);
		imagefilter($imageData, IMG_FILTER_CONTRAST,-30);
	
		return $imageData;
	}	
	public static function custom($imageData,$params) {
		switch (count($params)) {
		    case 1:imagefilter($imageData, $params[0]); break;
		    case 2:imagefilter($imageData, $params[0], $params[1]); break;
		    case 3:imagefilter($imageData, $params[0], $params[1], $params[2]); break;
		    case 4:imagefilter($imageData, $params[0], $params[1], $params[2], $params[3]); break;
		    case 5:imagefilter($imageData, $params[0], $params[1], $params[2], $params[3],$params[4]); break;		        		        
		}		
		return $imageData;
	}
	public static function original($imageData) {
		return $imageData; 
	}	
}

?>