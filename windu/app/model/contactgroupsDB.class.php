<?php /*windu.org model*/
class contactgroupsDB extends baseDB
{
	public function add($data) {
		$this->insert($data);
	}
	public function getArray() {
		$groups = $this->fetchAll();
		foreach($groups as $group){
			$array[$group->id]=$group->name;
		}
		return $array;
	}
	
}
?>
