<?php /*windu.org database*/

class detailTraceDB extends baseDB
{
    public function insert(array $data = array())
    {
		$data['createTime'] = generate::sqlDatetime();
		$data['updateTime'] = generate::sqlDatetime();
		$data['createIP'] = generate::ip();
		$data['updateIP'] = generate::ip();
		$data['createUserAgent'] = $_SERVER['HTTP_USER_AGENT'];
		$data['updateUserAgent'] = $_SERVER['HTTP_USER_AGENT'];
		
    	parent::insert($data);
    }  
    public function update($column, $value = null, $where = null)
    {
		$column['updateTime'] = generate::sqlDatetime();
		$column['updateIP'] = generate::ip();		
		$column['updateUserAgent'] = $_SERVER['HTTP_USER_AGENT'];
		
    	parent::update($column, $value, $where);
    } 
}

?>