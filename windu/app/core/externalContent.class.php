<?php /*windu.org core*/
class externalContent
{
	public static function get($url,array $postValues = array(),$timeOut = 5,$lowSpeedTimeOut = 15)
	{
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeOut); 
		curl_setopt($ch, CURLOPT_LOW_SPEED_TIME, $lowSpeedTimeOut); 
		
		if ($postValues!=array()) {
			foreach($postValues as $key => $value){
				$fields_string .= $key.'='.urlencode($value).'&';
			}
			rtrim($fields_string, '&');
			
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		}

		$data = curl_exec($ch);
		curl_close($ch);
		
		return $data;
	}		

}
?>
