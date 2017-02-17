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

include("../../config/common.php");
include("../../config/admin.php");

//****************************************************************************************
// Start with getting the update script and do tests
//****************************************************************************************
if (isset($action) and $action == "update_database") {
    // use glob and a foreach loop to search the database_scripts folder for update files
    foreach (glob("../../admin/administration/database_scripts/*.php") as $filename) {
        
        //we don't want to execute additions just yet
        if (strpos($filename, 'addition') !== false) 
        {
            //do nothing
        }
        else
        {
            // import update script
            require_once("$filename");

            // take all variables from the update script and place in an array
            $database_update[] = array(
                "database_update_id" => $database_update_id,
                "update_description" => $update_description,
                "execute_condition" => $execute_condition,
                "test_condition" => $test_condition,
                "database_update_sql" => $database_update_sql,
                "update_filename" => $filename
            );
        }
    }
    // Sort array
    asort($database_update);

    foreach ($database_update as $key) {
        if ($key['database_update_id'] == $update_script_id) {
            // Run the test condition query
            $test_query = $mysqli->query("$key[test_condition]") or die("Database update $key[database_update_id] Test condition failed");

            // check if the condition query returns true or false
            if ($test_query->fetch_row() == true) {
                $test_result = "test_success";
            } elseif ($test_query->fetch_row() == false) {
                $test_result = "test_fail";
            }

            // if the execute condition is met, execute update
            if ($key['execute_condition'] == $test_result) {
                
                //overhere we check if we are dealing with an addition - a script containing more than just SQL
                if (strncmp($key['database_update_sql'], "..", 2) === 0)
                {
                    include $key['database_update_sql'];
                }
                else  
                {
                    $mysqli->query("$key[database_update_sql]") or die("Database update $key[database_update_id] failed!");
                }

                // Add info to the database_change table
                // Set the timestamp
                $timestamp = time();

                // Pull the entire script into a string
                $filename      = $key['update_filename'];
                $script_string = file_get_contents("$filename");
                $script_string = $mysqli->real_escape_string($script_string);

                //escape string to update description
                $update_description = $mysqli->real_escape_string($key['update_description']);

                $mysqli->query("INSERT INTO database_change
            (database_update_id, update_description, execute_timestamp, implementation_state, update_filename, database_change_script)
             VALUES ('$key[database_update_id]', '$update_description','$timestamp', 'implemented', '$key[update_filename]', '$script_string')") or die("Unable to insert into database_change table");

                $_SESSION['edit_message'] = "Database altered";
            }
        }
    }
    header("Location: ../administration/database_update.php");
}
