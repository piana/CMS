<?php /*windu.org database*/

class traceDB extends baseDB
{
    const CREATETIMEFIELD = 'createTime';
    const UPDATETIMEFIELD = 'updateTime';
    const CREATEIPFIELD = 'createIP';
    const UPDATEIPFIELD = 'updateIP';
    
    public function insert(array $data = array())
    {
		$data[self::CREATETIMEFIELD] = generate::sqlDatetime();
		$data[self::UPDATETIMEFIELD] = generate::sqlDatetime();
		$data[self::CREATEIPFIELD] = generate::ip();
		$data[self::UPDATEIPFIELD] = generate::ip();
		
    	return parent::insert($data);
    }  
    public function updateRow($data, $where = null, $bindValues = array())
    {
		$data[self::UPDATETIMEFIELD] = generate::sqlDatetime();
		$data[self::UPDATEIPFIELD] = generate::ip();		
    	parent::updateRow($data, $where, $bindValues);
    } 

}

?>
