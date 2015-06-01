<?php /*windu.org model*/
class bannersDB extends traceDB
{
	public function insert($data){
		$data['status'] = 1;
		$data['cookieCheck'] = 0;
		return parent::insert($data);
	}	
	
	public function getRand($areaId){
		$banenrsAreaDB = new bannersareasDB();
		$area = $banenrsAreaDB->fetchRow("id={$areaId}");
		
		if ($area->status!=1) {
			return null;
		}
		
		$now = generate::sqlDatetime();
		$banner = $this->fetchRow("areaId={$areaId} AND status=1 AND startDate<='{$now}' AND endDate>='{$now}' AND viewsLimit>0 AND clicksLimit>0","RANDOM()");
		
		$bannerLog = new bannerlogDB();
		$bannerLog->addView($banner->id,$banner->cookieCheck);
		
		return $banner;
	}	
	
	public function add($data,$areaId){
		$data['areaId'] = $areaId;
		$this->insert($data);
		return $this->fetchRow(null,'id DESC');
	}
	public function deleteBanner($id){
		$banner = $this->fetchRow("id={$id}");
		file::deleteFileByEkey($banner->fileEkey);
		return $this->delete($id);
	}
}
?>
