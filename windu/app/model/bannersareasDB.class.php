<?php /*windu.org model*/
class bannersareasDB extends traceDB
{
	public function insert($data){
		$data['status'] = 1;
		return parent::insert($data);
	}	

	public function add($data){
		return $this->insert($data);
	}
	public function update($data,$id){
		return $this->updateRow($data,"id={$id}");
	}	

	public function deleteArea($id){
		$bannersDB = new bannersDB();
		$dependentBanners = $bannersDB->fetchAll("areaId={$id}");
		foreach($dependentBanners as $banner){
			$bannersDB->deleteBanner($banner->id);
		}
		return $this->delete($id);
	}
	public function getIdArrayForWidgetInserter() {
		$areas = $this->fetchAll();
		foreach ($areas as $area){
			$finalData[$area->id] = $area->name;			
		}
		return $finalData;
	}
}
?>
