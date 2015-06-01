<?php /*windu.org model*/
Class bannerController extends widgetMainController
{		
	public function run() {
		$areaId = intval($this->params['area']);
		
		$bannersDB = new bannersDB();
		$bannerAreasDB = new bannersareasDB();
		$filesDB = new filesDB();
		
		$banner = $bannersDB->getRand($areaId);
		$bannerArea = $bannerAreasDB->fetchRow("id={$areaId}");
		$file = $filesDB->getByEkey($banner->fileEkey);
		
		$width = $bannerArea->width;
		$height = $bannerArea->height;
		
		return array("file" => $file,"banner" => $banner,"width" => $width, "height" => $height);
	}
}
?>