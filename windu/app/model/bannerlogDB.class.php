<?php /*windu.org model*/
class bannerlogDB extends baseDB
{
	function __construct($customMySQL = array())
	{
		$this->otherDbFile = FILE_DB_LOG_FILE;
		parent::__construct($customMySQL);
	}
   	public function addView($bannerId,$cookieCheck = false){
   		if ($cookieCheck==false or cookie::readCookie('viewBanner'.$bannerId)==null and is_numeric($bannerId)) {
   			$bannersDB = new bannersDB();
   			$bannerViews =  $bannersDB->get($bannerId, 'viewsLimit'); 
   			 			
	   		$data['date'] = generate::sqlDate();
	   		$data['bannerId'] = $bannerId;
	   		
	   		$actualRow = $this->fetchRow("date='{$data['date']}' and bannerId='{$bannerId}'");
	   		if ($actualRow!=null) {
	   			$this->updateRow(array('views'=>$actualRow->views+1), "id={$actualRow->id}");
	   		}else{
	   			$data['views'] = 1;
	   			$data['clicks'] = 0;
	   			$this->insert($data);
	   		}
	   		$bannersDB->updateRow(array('viewsLimit'=>$bannerViews-1), "id='{$bannerId}'");
	   		cookie::setCookie('viewBanner'.$bannerId,1,7*24*3600);
   		}
   	}	
   	public function addClick($bannerId){
   		if (is_numeric($bannerId)) {
	   		$bannersDB = new bannersDB();
	   		$clicksLimit=  $bannersDB->get($bannerId, 'clicksLimit'); 
	   			 			
		   	$data['date'] = generate::sqlDate();
		   	$data['bannerId'] = $bannerId;
		   		
		   	$actualRow = $this->fetchRow("date='{$data['date']}' and bannerId='{$bannerId}'");
		   	if ($actualRow!=null) {
		   		$this->updateRow(array('clicks'=>$actualRow->clicks+1), "id={$actualRow->id}");
		   	}else{
		   		$data['clicks'] = 1;
		   		$this->insert($data);
		   	}
		   	$bannersDB->updateRow(array('clicksLimit'=>$clicksLimit-1), "id='{$bannerId}'");
   		}
   	}   	
}
?>