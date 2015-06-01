<?php /*windu.org model*/
class configDB extends baseDB
{
	const CONFIG_BUCKET_OTHER = 0;
	const CONFIG_BUCKET_CONTENT = 1;
	const CONFIG_BUCKET_USERS = 2;
	const CONFIG_BUCKET_THEMES = 3;
	const CONFIG_BUCKET_TOOLS = 4;
	const CONFIG_BUCKET_SYSTEM = 5;
	
	public $bucketNames= array(
		 self::CONFIG_BUCKET_OTHER => "model.configdb.controller.general",
		 self::CONFIG_BUCKET_CONTENT => "model.configdb.controller.content",
		 self::CONFIG_BUCKET_USERS => "model.configdb.controller.users",
		 self::CONFIG_BUCKET_THEMES => "model.configdb.controller.gfx",
		 self::CONFIG_BUCKET_TOOLS => "model.configdb.controller.tools",
		 self::CONFIG_BUCKET_SYSTEM => "model.configdb.controller.system"
	);	
	public $types = array(
		'string' => 'String',
		'numeric' => 'Numeric',
		'bool' => 'Boolean'
	);	
	
	public function getByGroup($group) {
		return $this->fetchAll("bucket = :group",'name ASC', '*',  null, null, array( ':group'  => $group ) );
	}
	public function getByName($name) {
		return $this->fetchRow("name = :name", null, '*', array( ':name' => $name ) );
	}
	public function add($data) {
		return $this->insert($data);
	}
    public function insert(array $data = array())
    {
    	cache::fileClearByBucket('config');
		if($data['nodelete']==null){
			$data['nodelete'] = 0;
		}
    	if($data['bucket']==null){
			$data['bucket'] = 99;
		}	
			
    	parent::insert($data);
    }  
	public function update($column, $value, $where, $bindValues = array() )
	{
        config::cleanCache();
		parent::update($column, $value, $where,$bindValues);
	}
	public function updateRow($data, $where, $bindValues = array() )
	{
        config::cleanCache();
		parent::updateRow($data, $where, $bindValues = array() );
	}    
    public function delete($id) {
        config::cleanCache();
    	if ($this->get($id, 'nodelete'))return false;
    	else parent::delete($id);
    }
    public function getConfigSimpleArray() {

        foreach($this->fetchAll(null,null,'name,value') as $config){
            $finalArr[$config->name] = $config->value;
        }

        return $finalArr;

    }
}
?>
