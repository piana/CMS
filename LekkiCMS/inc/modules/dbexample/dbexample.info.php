<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Informations about this module
	function dbexample_info() {
		return array(
			'name'	=>	'DBexample',
			'description'	=>	'An example of a module using DB',
			'author'	=>	'Klocek',
			'version'	=>	'0.1',
			'add2nav'	=>	TRUE
		);
	}

	//Installation
	function dbexample_install() {
		global $db;
		//Create array with database's fields/columns 
		//Field can be auto increment, ex. `id`
		$fields = array(array('name'=>'id','auto_increment'=>true),array('name'=>'firstname'),array('name'=>'lastname'));
		//Set the name of the new table
		$tablename = 'example_table';
		//Check if the table already exists
		if (!$db->_table_exists('db', $tablename)){
			//Do a query that creates a table
		    if($db->create_table($tablename,$fields)){
		    	//Create array with elements of new record
		    	$newRecord = array(NULL,'John','Kowalsky');
		    	//Insert a new record to new table
		        $db->insert($tablename, $newRecord);
		    }
		}
	}

	//Uninstallation
	function dbexample_uninstall() {
		global $db;
		//Delete the table
		$db->drop_table('example_table');
	}
	
?>
