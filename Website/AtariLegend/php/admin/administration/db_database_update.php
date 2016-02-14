<?php
/***************************************************************************
*                                db_database_update.php
*                            -----------------------
*   begin                : 2016-02-14
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*						  
*							
*
*   Id: db_database_update.php,v 1.00 2016-02-14 Silver Surfer
*
***************************************************************************/

// This script does database queries for the database update facility.
// We are using the action var to separate all the queries.

include("../../includes/common.php");
include("../../includes/admin.php");

if(isset($action) and $action=="update_database")
{
	//****************************************************************************************
	// Start with getting the update script and do tests
	//**************************************************************************************** 

	// use glob and a foreach loop to search the database_scripts folder for update files
	foreach (glob("../../admin/administration/database_scripts/*.php") as $filename) {
	
	// import update script
	require_once("$filename");
	
	// take all variables from the update script and place in an array
	$database_update[] = array(
	"database_update_id" => $database_update_id,
	"update_description" => $update_description,
	"execute_condition" => $execute_condition,
	"test_condition" => $test_condition,
	"database_update_sql" => $database_update_sql,
	"update_filename" => $filename,
	);

}
	// Sort array
	asort($database_update);

	foreach ($database_update as $key)
	{	
			if ($key['database_update_id']==$update_script_id) 
			{
		// Run the test condition query
			$test_query = $mysqli->query("$key[test_condition]");
			
			// check if the condition query returns true or false
			if ($test_query->fetch_row()==true)  
				{ $test_result="test_success";}
			elseif ($test_query->fetch_row()==false) 
				{ $test_result="test_fail";}
				
				// if the execute condition is met, execute update
				if ($key['execute_condition']==$test_result)
					{
						$mysqli->query("$key[database_update_sql]");
						
						// Add info to the database_change table
						// Set the timestamp
						$timestamp = time();
						
						// Pull the entire script into a string
						$filename = $key['update_filename'];
						$script_string = file_get_contents("$filename");
						$script_string = addslashes($script_string);
						
						//addslashes to update description
						$update_description = addslashes($key['update_description']);
						
						$mysqli->query("INSERT INTO database_change 
						(database_update_id, update_description, execute_timestamp, implementation_state, update_filename, database_change_script)
						 VALUES ('$key[database_update_id]', '$update_description','$timestamp', 'implemented', '$key[update_filename]', '$script_string')")
						or die("Unable to insert into database_change table");  
						
						$_SESSION['edit_message'] = "Database altered";
					}
				}
	}



	header("Location: ../administration/database_update.php");
}

?>
