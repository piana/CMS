<?php
class imagesDB extends ekeyDB
{
	public function getByEkey($ekey){
		return $this->fetchRow("ekey = :ekey", null, '*', array(':ekey' => $ekey) );
	}
	public function getByBucket($bucketId,$order = 'position ASC',$what = '*', $limit = null) {
		return $this->fetchAll("bucket = :bucketId",$order, $what, $limit, null, array( ':bucketId' => $bucketId ) );
	}
	public function getFirstByBucket($bucketId,$order = 'position ASC',$what = '*') {
		return $this->fetchRow("bucket= :bucketId",$order, $what, array( ':bucketId' => $bucketId ) );
	}	
	public function insert(array $data = array())
	{
		$data['position'] = 999999;
		return parent::insert($data);
	}
	public function getRealPathByEkey($ekey) {
		$image = $this->getByEkey($ekey);
		$path = DATA_PATH.$image->path.'/'.$image->fileName;
		return $path;
	}
}
?>