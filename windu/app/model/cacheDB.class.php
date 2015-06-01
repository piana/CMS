<?php /*windu.org model*/
class cacheDB extends baseDB
{
    public function insert(array $data = array())
    {
		$data['updateTime'] = generate::sqlDatetime();
    	parent::insert($data);
    }  
    public function updateRow($data, $where = null, $bindValues = array() )
    {
		$data['updateTime'] = generate::sqlDatetime();
    	parent::updateRow($data, $where, $bindValues);
    }
    public function read($name) {
        return $this->fetchRow("name = :name", null, '*', array(':name' => $name) )->data;
    } 
    public function write($name,$data,$bucket,$serialized = 0) {
    	$row = $this->fetchRow("name = :name", null, '*', array(':name' => $name) );
    	
    	if (is_object($row)) {
    		return $this->updateRow(array("data"=>$data,"serialized"=>$serialized),"id = :id", array( ':id' => $row->id ) );
    	}else{
    		return $this->insert(array("data"=>$data,"name"=>$name,"bucket"=>$bucket,"serialized"=>$serialized));
    	}
    }   
    public function truncate() {
    	return $this->deleteRows("id>=0");
    }  
}
?>
