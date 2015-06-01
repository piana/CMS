<?php
class filesDB extends ekeyDB
{
	public function getByBucket($bucket) {
		$files = $this->fetchAll("bucket = '{$bucket}'");
		return $files;
	}
	public function delete($id,$noLogDelete = false) {
		$this->deleteRows("id={$id}");
		if (!$noLogDelete) {
			$filesLog = new filesLogDB();
			$filesLog->deleteByFileId($id);
		}

	}	
	public function getEkeyByName($name){
		return $this->fetchRow("name='{$name}'")->ekey;
	}
	
}
?>