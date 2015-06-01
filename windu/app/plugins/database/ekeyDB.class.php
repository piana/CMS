<?php /*windu.org database*/

class ekeyDB extends traceDB
{
	const EKEYFIELD = 'ekey';
	
    public function insert(array $data = array())
    {
		if ($data[self::EKEYFIELD]=='') {
			$data[self::EKEYFIELD] = generate::ekey($this);
		}
    	return parent::insert($data);
    }  
    public function getByEkey($ekey) {
    	return $this->fetchRow(self::EKEYFIELD." = :" . self::EKEYFIELD, null, '*', array( self::EKEYFIELD => $ekey ) );
    }
}

?>
