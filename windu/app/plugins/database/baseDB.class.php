<?php /*windu.org database*/
/**
 * Class for executig sql queries
 * @author Krzysztof Ruszczyński <http://www.ruszczak.eu>
 * @author Adam Czajkowski
 */

class baseDB extends DB
{
    /**
      * for date function
    */
    const MYSQLDATETIMEFORMAT = 'Y-m-d H:i:s';
    
	/**
	 * @var String
	 */
	public $tab;

	/**
	 * @var PDO
	 */
	protected $db;
	
	public $otherDbFile;

	function __construct($customMySQL = array())
	{
		$this->tab = str_replace('db', '', strtolower(get_class($this)));
		if ($customMySQL!=array()) {
			$this->setDb( parent::getInstance('Migration',$customMySQL) );
		}else{
			if ($this->otherDbFile!=null) {
				$this->setDb( parent::getInstance($this->otherDbFile) );
			}else{
				$this->setDb( parent::getInstance() );
			}
		}
	}

	/**
	 * Function created in order to change database connection during tests
	 * @param mixed $db
	 */
	public function setDb( $db )
	{
		$this->db = $db;
	}

	/**
	 * @param String $sql sql query
	 * @param array $bindValues
	 *
	 * @return PDOStatement
	 */
	protected function _createStatement( $sql, $bindValues )
	{
		$stmt = $this->db->prepare( $sql );

		foreach( $bindValues as $key=>$value )
		{
			if( is_numeric($key) )
			{
				$key++;
			}
			else if( $key{0} <> ':' )
			{
				$key = ':' . $key;
			}

			$stmt->bindValue( $key, $value );
		}
		return $stmt;
	}

	/**
	 * @param string $where
	 * @param string $order
	 * @param string $what
	 * @param string $limit
	 * @param string $groupby
	 * @param array $bindValues
	 * @return PDOStatement
	 */
	public function select($where = null, $order = null, $what = '*',$limit = null, $groupby = null, $bindValues = array() )
	{
		if ($where!=null){$where='WHERE '.$where;}
		if ($order!=null){$order='ORDER BY '.$order;}
		if ($limit!=null){$limit='LIMIT '.$limit;}
		if ($groupby!=null){$groupby='GROUP BY '.$groupby;}

		if (is_array($what)) {
			$what = implode(",", $what);
		}

		$sql = "SELECT $what FROM $this->tab $where $order $limit $groupby";

		if(!empty($bindValues))
		{
			return $this->_createStatement($sql, $bindValues);
		}

		return $this->db->query($sql);
	}

	/**
	 * @param array $data
	 * @return void
	 */
	public function insert(array $data = array())
	{
		if (DB_READ_ONLY_MODE==1) {
			if (!$this->canWrite()) {return null;}
		}	
		
		if( !is_array( current($data) ) )
		{
			return $this->_insertOneRow( $data );
		}
		else
		{
			$this->db->beginTransaction();
			foreach ($data as $row)
			{
				if (is_array($row)) {
					$this->_insertOneRow( $row );
				}
			}
			$this->db->commit();
		}
	}

	/**
	 * @param array $row
	 * @return void
	 */
	protected function _insertOneRow( $row )
	{
		if (DB_READ_ONLY_MODE==1) {
			if (!$this->canWrite()) {return null;}
		}		
		
		$bindValues = array();
		$keys='';
		$values='';
		foreach($row as $key=>$val)
		{
			$val = str_replace("'", "&#39;", $val);
			$keys.='`'.$key.'`,';
			$values.=":$key,";
			$bindValues[":$key"] = $val;
        }
		$values=rtrim($values, ',');
		$keys=rtrim($keys, ',');

		$sql = "INSERT INTO $this->tab($keys) VALUES ($values)";
		$stmt = $this->db->prepare($sql);
		$stmt->execute( $bindValues );

        log::writeHistory(serialize($row),$this->tab,logDB::BUCKET_USER_ACTIONS_ADD);

		return $row;
	}
	/**
	 * Method not safe! use only if you insert 100 or more rows in one time!
	 * @param array $array
	 */
	public function insertMultipleFast(array $array){
		if (count($array)>=1) {
			$this->db->beginTransaction();
			$keys='';
			foreach($array[0] as $key=>$val){
				$keys.='`'.$key.'`,';
			}
			$keys=rtrim($keys, ',');
			 
			foreach ($array as $row){
				$values = '';
				foreach($row as $key=>$val){
					$val = str_replace("'", '', $val);
					$values.="'".$val."',";
				}
				$values=rtrim($values, ',');
				if ($values!='' and $keys!='') {
					$sql = "INSERT INTO {$this->tab}({$keys}) VALUES ({$values})";
					$this->db->exec($sql);
				}
			}
			$this->db->commit();
		}
			
	}
	/**
	 *
	 * @param string $column
	 * @param string $value
	 * @param string $where
	 * @param array $bindValues
	 * @return void
	 */
	public function update($column, $value, $where, $bindValues = array() )
	{
		if (DB_READ_ONLY_MODE==1) {
			if (!$this->canWrite()) {return true;}
		}		
		
		$value = str_replace("'", "&#39;", $value);
		$where='WHERE '.$where;
		$sql = "UPDATE {$this->tab} SET {$column}=:{$column} {$where}";
		$bindValues[":$column"] = $value;

		$this->_createStatement( $sql, $bindValues )->execute();


        log::writeHistory(serialize(array("column"=>$column,"value"=>$value,"where"=>$where,"bind values"=>$bindValues)),$this->tab,logDB::BUCKET_USER_ACTIONS_EDIT);
	}

	/**
	 * @param array $data
	 * @param string $where
	 * @param array $bindValues
	 * @return void
	 */
	public function updateRow($data, $where, $bindValues = array() )
	{
		if (DB_READ_ONLY_MODE==1) {
			if (!$this->canWrite()) {return true;}
		}
		
		$sql = "UPDATE {$this->tab} SET ";
			
		foreach ($data as $key => $val)
		{
			$val = str_replace("'", "&#39;", $val);
			$keyColumn = ':set' . $key;
			$sql .= "`$key`=$keyColumn, ";
			$bindValues[$keyColumn] = $val;
		}

		$sql = rtrim($sql,', ');
		$sql .= ' WHERE '.$where.';';
		$this->_createStatement( $sql, $bindValues )->execute();

        log::writeHistory(serialize(array("data"=>$data,"where"=>$where,"bind values"=>$bindValues)),$this->tab,logDB::BUCKET_USER_ACTIONS_EDIT);
	}

	/**
	 * @param string $where
	 * @param array $bindValues
	 * @return void
	 */
	public function deleteRows($where, $bindValues = array() )
	{
		if (DB_READ_ONLY_MODE==1) {
			if (!$this->canWrite()) {return true;}
		}		
		
		$where='WHERE '.$where;
		$sql = "DELETE FROM $this->tab $where";

		if( !empty($bindValues) )
		{
			$this->_createStatement( $sql, $bindValues )->execute();
            log::writeHistory(serialize(array("where"=>$where,"bind values"=>$bindValues)),$this->tab,logDB::BUCKET_USER_ACTIONS_DELETE);
			return;
		}

		$this->db->exec($sql);
        log::writeHistory(serialize(array("where"=>$where,"bind values"=>$bindValues)),$this->tab,logDB::BUCKET_USER_ACTIONS_DELETE);
	}

	/**
	 * @param Integer $id
	 * @return void
	 */
	public function delete($id) {
        log::writeHistory(serialize($id),$this->tab,logDB::BUCKET_USER_ACTIONS_DELETE);
		return $this->deleteRows("id=:id", array(':id' => $id) );
	}

	/**
	 * @param string $where
	 * @param string $order
	 * @param string $what
	 * @param array $bindValues
	 * @return StdClass return false if no record found
	 */
	public function fetchRow($where = null, $order = null, $what = '*', $bindValues = array(), $fetchType = PDO::FETCH_OBJ) {
		$stmt = $this->select($where, $order, $what, $limit = 1, null, $bindValues);
		$stmt->execute();
		return $stmt->fetch( $fetchType );
	}

	/**
	 * @param string $where
	 * @param string $order (default null)
	 * @param string $what (default '*')
	 * @param integer $limit (default null)
	 * @param string $groupby (default null)
	 * @param array $bindValues (default array)
	 * @return array return empty array if no record found
	 */
	public function fetchAll($where = null, $order = null, $what = '*', $limit = null, $groupby = null, $bindValues = array(),$fetchType = PDO::FETCH_OBJ) {
		$stmt = $this->select($where, $order, $what, $limit, $groupby, $bindValues);
		$stmt->execute();
		return $stmt->fetchAll( $fetchType );
	}

	/**
	 * @param string $searchText
	 * @param string $columns
	 * @param string $where
	 * @param string $order
	 * @param string $what
	 * @param integer $limit
	 * @param string $groupby
	 * @param array $bindValues
	 * @return array
	 */
	public function fetchTextSearch($searchText,array $columns, $where = null, $order = null, $what = '*', $limit = null, $groupby = null, $bindValues = array() ) {
        $whereFin = '';
		foreach ($columns as $column){
			$whereFin .= "{$column} LIKE '%{$searchText}%' OR ";
		}
		
		$whereFin = rtrim($whereFin,' OR ');
		if ($where !=null) {
			$whereFin = " ( ".$whereFin." ) "." AND ( ".$where." )";
		}

		$results = $this->fetchAll($whereFin,$order,$what,$limit,$groupby,$bindValues);
		if(empty($results))return null;

		foreach ($results as $key => $result) {
			$string = null;
			foreach ($columns as $column) {
				$string .= $result->$column;
			};
			$string = strtolower($string);

			if ($string!='' and $searchText!=''){
				$results[$key]->searchElementsCount = substr_count(strtolower($string), strtolower($searchText));
			}else{
				$results[$key]->searchElementsCount = 0;
			}
			
		}
		$results = generate::subvalArrayObjectsSort($results, 'searchElementsCount', 'arsort'); 
		return $results;
	}

	/**
	 * @param string $where
	 * @param array $bindValues
	 * @return integer
	 */
	public function fetchCount($where = null, $bindValues = array() ) {
		if ($where!=null){$where='WHERE '.$where;}
		$sql = "SELECT count(*) FROM $this->tab $where";

		if( !empty( $bindValues ) )
		{
			$stmt = $this->_createStatement( $sql, $bindValues );
		}
		else
		{
			$stmt = $this->db->query($sql);
		}

		$stmt->execute();
		return intval($stmt->fetchColumn());
	}

	/**
	 * @param string $groupBy
	 * @param string $where
	 * @param string $order
	 * @param string $what
	 * @param integer $limit
	 * @param array $bindValues
	 * @return array
	 */
	public function fetchCountGroup($groupBy,$where = null,$order = null,$what = '*', $limit = null, $bindValues = array() ) {
		if ($where!=null){$where='WHERE '.$where;}
		if ($order!=null){$order='ORDER BY '.$order;}else{$order="ORDER BY COUNT($groupBy) DESC";}
		if ($limit!=null){$limit='LIMIT '.intval($limit);}

		$sql = "SELECT *, COUNT($groupBy) FROM {$this->tab} $where GROUP BY {$groupBy} $order $limit";

		if( !empty( $bindValues ) )
		{
			$stmt = $this->_createStatement( $sql, $bindValues );
		}
		else
		{
			$stmt = $this->db->query($sql);
		}
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
	/**
	 * @param string $sumColumn
	 * @param string $where
	 * @param string $order
	 * @param string $what
	 * @param integer $limit
	 * @param array $bindValues
	 * @return integer
	 */
	public function fetchSum($sumColumn,$where = null,$order = null,$what = '*', $limit = null, $bindValues = array() ) {
		if ($where!=null){$where='WHERE '.$where;}
		if ($order!=null){$order='ORDER BY '.$order;}
		if ($limit!=null){$limit='LIMIT '.intval($limit);}

		$sql = "SELECT sum({$sumColumn}) AS sum FROM {$this->tab} $where $order $limit";

		if( !empty( $bindValues ) )
		{
			$stmt = $this->_createStatement( $sql, $bindValues );
		}
		else
		{
			$stmt = $this->db->query($sql);
		}
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ)->sum;
	}

	/**
	 * @param string $groupBy
	 * @param string $where
	 * @param string $order
	 * @param string $what
	 * @param integer $limit
	 * @param array $bindValues
	 * @return array
	 */
	public function fetchGroup($groupBy, $where = null, $order = null, $what = '*', $limit = null, $bindValues = array()) {
		$groups = $this->select($where, null, $groupBy, null, $groupBy, $bindValues);
		$groups->execute();
		$groups = $groups->fetchAll( PDO::FETCH_OBJ );

		if ($where!=null){$where=$where.' AND ';}
		foreach ($groups as $group) {
			$rows = $this->select($where."{$groupBy} = '{$group->$groupBy}'", $order, $what, $limit, null, $bindValues);
			$rows->execute();
			$rows = $rows->fetchAll( PDO::FETCH_OBJ );

			if($rows!=null){
				$data[$group->$groupBy] = $rows;
			}
			$rows = null;
		}
		return $data;
	}

	/**
	 * @param integer $id
	 * @param string $column
	 * @param string $value
	 * @return void
	 */
	public function set($id,$column,$value) {
		return $this->update($column,$value,"id=:id", array( ':id' => $id ) );
	}

	/**
	 * @param integer $id
	 * @param string $column
	 * @return string
	 */
	public function get($id,$column) {
		$stmt = $this->select("id=:id", null, $column, 1, null, array( ':id' => $id ) );
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ)->$column;
	}
	public function databaseSize() {
		echo $this->db; exit;
		$sql = "SHOW TABLE STATUS FROM {$this->db}";
		return $this->db->query($sql);
	}
        
        /**
         * @param string $sql
         * @return PDOStatement|array can be array of PDOStatement
         */
	public static function executeSql($sql) {
		if (DB_TYPE=='mysql'){
			$sql = str_replace(array('AUTOINCREMENT','autoincrement'), array('AUTO_INCREMENT','AUTO_INCREMENT'), $sql);
		}	
					
		$instance = parent::getInstance();
		$instanceLog = parent::getInstance(FILE_DB_LOG_FILE); 
		
		
		$sqlParts = explode(';',$sql);

		if (is_array($sqlParts) && count($sqlParts) > 1 ) {
			foreach ($sqlParts as $sql){
				if (strlen($sql)>6) {
					if (strpos($sql, '{logDB}')!==false) {
						$sql = str_replace('{logDB}', '', $sql);
						$returnedData[] = $instanceLog->query($sql);
					}else{
						$sql = str_replace('{mainDB}', '', $sql);
						$returnedData[] = $instance->query($sql);
					}
				}	
			}
		}else{
			if (strlen($sql)>6) {
				if (strpos($sql, '{logDB}')!==false) {
					$sql = str_replace('{logDB}', '', $sql);
					$returnedData = $instanceLog->query($sql);
				}else{
					$sql = str_replace('{mainDB}', '', $sql);
					$returnedData = $instance->query($sql);
				}	
			}			
		}

		return $returnedData;
	} 
        
    /**
     *
     * @param string $sql
     * @param array $bindValues
     * @param integer $fetchType (optional)
     * @return array
     */
    public function fetchAllSql( $sql, $bindValues = array(), $fetchType = PDO::FETCH_OBJ )
    {
        $stmt = $this->executeBindedSql($sql, $bindValues);
        $stmt->execute();
        return $stmt->fetchAll( $fetchType );
    }

    /**
     * works on MYSQL only
     * @return string|boolean if ended with success, returns current timestamp, false otherwise
     */
    public static function getCurrentDateTime()
    {
        $instance = parent::getInstance();

        if( DB_TYPE=='mysql' )
        {
            $stmt = $instance->query('SELECT NOW() as dtcolumn');
            $stmt->execute();
            return $stmt->fetch( PDO::FETCH_OBJ )->dtcolumn;
        }
    }

    /**
     * note: MyISAM engine does not support transactions
     */
    public static function beginTransaction()
    {
        parent::getInstance()->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);
        parent::getInstance()->beginTransaction();
    }

    public static function commitTransaction()
    {
        parent::getInstance()->commit();
        parent::getInstance()->setAttribute(PDO::ATTR_AUTOCOMMIT, TRUE);
    }

    /**
     * @param string $sql
     * @param array $bindValues (optional)
     * @return PDOStatement
     */
    public function executeBindedSql( $sql, $bindValues = array() )
    {
        return $this->_createStatement($sql, $bindValues);
    }

    public function getLastInsertId()
    {
        $this->db->lastInsertId();
    }
        
	public static function getRecordsCount($tableName,$where = null) {
		$table = new $tableName();
		return $table->fetchCount($where);
	}
	public static function getColumnsCount($tableName) {
		$table = new $tableName();
		return count($table->fetchRow( null, null, '*', array(), $fetchType = PDO::FETCH_ASSOC));
	}
	public static function getTableSize($tableName) {
		$table = new $tableName();
		return $table->fetchCount();
	}
	
	private function canWrite() {
		$tablesArray = explode(',', DB_READ_ONLY_EXCLUDED_TABLES);
		if (in_array($this->tab, $tablesArray)) {
			return true;
		}
		return false;
	}
	public function addField($fieldName,$type = 'varchar(255)') {
		$tab = $this->tab;
		$fieldName = generate::cleanSQLColumnName($fieldName);
		
		$oneRow = $this->fetchRow();
		if ($oneRow!=null) {
			foreach ($oneRow as $key=>$column){
				if ($key==$fieldName) {
					return false;
				}
			}
		}
		
		if (DB_TYPE=='mysql') {
			$sql = "ALTER TABLE `{$tab}` ADD `{$fieldName}` {$type};";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();	
		}else{
			$schema = $this->db->query("pragma table_info({$tab});")->fetchAll();
            $commaArray = '';
            $commaArraySimple = '';

			foreach ($schema as $column){
				if ($column['pk']==1) {
					$pk = ' PRIMARY KEY ';
				}else{
					$pk = ' ';
				}
				
				if ($column['notnull']==1) {
					$nn = ' NOT NULL ';
				}else{
					$nn = ' ';
				}	
	
				if ($column['dflt_value']!='') {
					$dv = ' DEFAULT ('.$column['dflt_value'].') ';
				}else{
					$dv = ' ';
				}	
							
				$commaArray .= '"'.$column['name'].'" '.$column['type'].$pk.$nn.$dv.',';
				$commaArraySimple .= '"'.$column['name'].'",';
			}
			
			$commaArrayNew = $commaArray.'"'.$fieldName.'" '.$type.',';

			$commaArray = rtrim($commaArray,',');
			$commaArraySimple = rtrim($commaArraySimple,',');
			
			$commaArrayNew = rtrim($commaArrayNew,',');

			$sql = "CREATE TEMPORARY TABLE {$tab}_backup ({$commaArray});
					INSERT INTO {$tab}_backup SELECT {$commaArraySimple} FROM {$tab};
					DROP TABLE {$tab};
					CREATE TABLE {$tab} ({$commaArrayNew});
					INSERT INTO {$tab}({$commaArraySimple}) SELECT {$commaArraySimple} FROM {$tab}_backup;
					DROP TABLE {$tab}_backup;";
			
			$sql = str_replace('   ', ' ', $sql);
			$sql = str_replace('  ', ' ', $sql);
	
			return $this->executeSql($sql);
		}	
	}
	public function deleteField($fieldName) {
		$tab = $this->tab;
		if (DB_TYPE=='mysql') {
			$sql = "ALTER TABLE `{$tab}` DROP `{$fieldName}`";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();		
		}else{		
			$schema = $this->db->query("pragma table_info({$tab});")->fetchAll();
            $commaArray = '';
            $commaArraySimple = '';

			foreach ($schema as $column){
				if ($column['name'] != $fieldName) {
					if ($column['pk']==1) {
						$pk = ' PRIMARY KEY ';
					}else{
						$pk = ' ';
					}
					
					if ($column['notnull']==1) {
						$nn = ' NOT NULL ';
					}else{
						$nn = ' ';
					}	
	
					if ($column['dflt_value']!='') {
						$dv = ' DEFAULT ('.$column['dflt_value'].') ';
					}else{
						$dv = ' ';
					}	
								
					$commaArray .= '"'.$column['name'].'" '.$column['type'].$pk.$nn.$dv.',';
					$commaArraySimple .= '"'.$column['name'].'",';
				}
			}
	
			$commaArray = rtrim($commaArray,',');
			$commaArraySimple = rtrim($commaArraySimple,',');
			
			$sql = "CREATE TEMPORARY TABLE {$tab}_backup ({$commaArray});
					INSERT INTO {$tab}_backup SELECT {$commaArraySimple} FROM {$tab};
					DROP TABLE {$tab};
					CREATE TABLE {$tab} ({$commaArray});
					INSERT INTO {$tab} SELECT {$commaArraySimple} FROM {$tab}_backup;
					DROP TABLE {$tab}_backup;";
			$sql = str_replace('   ', ' ', $sql);
			$sql = str_replace('  ', ' ', $sql);
	
			return $this->executeSql($sql);
		}	
	}
	public function getArrayForWidgetInserter($fieldName,$where,$sort = null){
		$groups = $this->fetchAll($where,$sort);
		if (!is_array($groups)) {
			return null;
		}
		foreach ($groups as $group){
			$groupArray[$group->id]=$group->$fieldName;
		}
		return $groupArray;
	}	
}

?>
