<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Pages of this module
	function dbexample_pages() {
		$pages[] = array(
			'func'  => 'dbexample_list',
			'title' => 'List of people'
		);
		$pages[] = array(
			'func'  => 'dbexample_add',
			'title' => 'Add a new person'
		);
		return $pages;
	}

	/*** Main functions ********************************************************************************************/

	//List of people
	function dbexample_list() {
		global $lang, $db, $core;
		$result = NULL;

		//Check for isset $_GET['q'] and $_GET['id']
		if(isset($_GET['q']) && isset($_GET['id'])) {
			$condtion = array('id'=>$_GET['id']); //Create array with conditions about request record
            $query = $db->select('example_table', $condtion); //Run query and get data
            if($query) { //Check if record exist (if doesn't, $query return 'false')
				/*--- BEGIN: EDIT SECTION ---------------------*/
				if($_GET['q']=='edit') {
					//If isset $_POST['save'] we can save the data
					if(isset($_POST['save'])) {
						//Check for empty inputs
						if(!empty($_POST['firstname']) && !empty($_POST['lastname'])) { //If everything is filled...
							//...create array with updated record
							$updateRecord = array($_POST['id'], $_POST['firstname'], $_POST['lastname']);
							if($db->update('example_table', $condtion, $updateRecord)) {
								//If the data has been correctly updated, we can display notification with success info
								$core->notify('The data has been saved',1); //1 - success, 2 - fail
							}
						}
					} else {
						//Return only form
						$condtion = array('id'=>$_GET['id']);
           				$query = $db->select('example_table', $condtion);
						$record = $query[0]; //Get the first record with sent `id`
						$result .= dbexample_form($record); //Show form
					}
				}
				/*--- END: EDIT SECTION -----------------------*/

				/*--- BEGIN: DELETE SECTION -------------------*/
				if($_GET['q']=='del') {
					if($db->delete('example_table', $condtion)) {
						//If the record has been correctly deleted, we can display notification with success info
						$core->notify('The record has been deleted',1); //1 - success, 2 - fail
					}
				}
				/*--- END: DELETE SECTION ---------------------*/
			} else $core->notify("The record doesn't exist",2);
		}

		//Select table 'example_table' from DB
		$query = $db->select('example_table');
		//Create a table
		$result .= '<table> <thead>';
		$result .= '<tr> <td>First name</td> <td>Last name</td> <td>Options</td> </tr>';
		$result .= '</thead> <tbody>';
		//Get the records
		foreach($query as $record) {
			$result .= '<tr> <td>'.$record['firstname'].'</td> <td>'.$record['lastname'].'</td> <td><a href="?go=dbexample&q=edit&id='.$record['id'].'" class="icon">Z</a> <a href="?go=dbexample&q=del&id='.$record['id'].'" class="icon">l</a></td> </tr>';
		}
		$result .= '</tbody> </table>';

		//Return result to LCMS
		return $result;

	} //End dbexample_list();

	//Add a new person to DB
	function dbexample_add() {
		global $lang, $db, $core;
		$result = NULL;

		//Show a form
		$result = dbexample_form();

		//Get POST request
		if(isset($_POST['save'])) {
			//Check for empty inputs
			if(!empty($_POST['firstname']) && !empty($_POST['lastname'])) { //If everything is filled...
				//...create array with new record
				//$new record = array(`ID`, `FIRSTNAME`, `LASTNAME`); <- structure of table 'example_table'
				$newRecord = array(NULL, $_POST['firstname'], $_POST['lastname']); //First field can be empty, because this is auto_increment `id`
				//And finally we add a new record to DB
				if($db->insert('example_table', $newRecord)) {
					//If the data has been correctly added, we can display notification with success info
					$core->notify('The data has been added',1); //1 - success, 2 - fail
				}
			} else {
				//If some of inputs are empty, we can display notification with error
				$core->notify("Inputs can't be empty",2); //1 - success, 2 - fail
			}
		}
		//Return result to LCMS
		return $result;
	} //End dbexample_add();

	/*** Additional functions ********************************************************************************************/

	function dbexample_form($data = array()) {
		$result = '<form name="example" method="post" action="'.$_SERVER['REQUEST_URI'].'">';
		$result .= '<label>First name <span>Enter the first name</span></label>';
		$result .= '<input type="text" name="firstname" value="'.@$data['firstname'].'" />';
		$result .= '<label>Last name <span>Enter the last name</span></label>';
		$result .= '<input type="text" name="lastname" value="'.@$data['lastname'].'" />';
		$result .= '<button type="submit" name="save">Save</button>';
		if($data) $result .= '<input type="hidden" name="id" value="'.$data['id'].'" />';
        $result .= '</form>';
        return $result;
	}

?>
