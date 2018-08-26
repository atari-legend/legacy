<?php
/***************************************************************************
 *                                database_update_legacy.php
 *                            -----------------------
 *   begin                : 2016-02-13
 *   copyright            : (C) 2016 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        :
 *
 *   Id: database_update_legacy.php,v 0.10 2016-02-13 Silver Surfer
 *
 ****************************************************************************/
//The database update section was designed to run simple db table scripts.
//A script is created. This script contains a var called $database_update_sql which contains the SQL statement.
//However, sometimes it is need to run more complex scripts. Therefor I have 'raped' this php file a little.
//To run a more complex script containing php code, we need to do 2 things :
// 1) create a normal script file with the database update variables, however, this time the $database_update_sql variable
//    should contain a link to the more complex script file.
// 2) the actual script file must be place in the database_script/legacy folder as well, and its filename should contain the word 'addition'.
// a example of this way of working can be found in files 2017-01-30_merge_nicknames_into_individuals.php and 2017-01-30_merge_nicknames_into_individuals-addition.php

include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

// use glob and a foreach loop to search the database_scripts/legacy folder for update files
foreach (glob("../../admin/administration/database_scripts/legacy/*.php") as $filename) {
    // import update script

    //we don't want to execute additions just yet
    if (strpos($filename, 'addition') !== false) {
        //do nothing
    } else {
        require_once("$filename");

        // take all variables from the update script and place in an array
        $database_update[] = array(
            "database_update_id" => $database_update_id,
            "update_description" => $update_description,
            "execute_condition" => $execute_condition,
            "test_condition" => $test_condition,
            "database_update_sql" => $database_update_sql,
            "database_autoexecute" => $database_autoexecute,
            "update_filename" => $filename,
            "force_insert" => $force_insert
        );
    }
}

// Sort array
asort($database_update);

mysqli_begin_transaction($mysqli) or die("Error while starting transaction: ".$mysqli->error);

foreach ($database_update as $key) {
    //No way around hardcoding database_update table itself...
    if ($key['database_update_id'] == 1) {
        // Run the test condition query
        $test_query = $mysqli->query("$key[test_condition]") or die("Database update $key[database_update_id] Test condition failed: ".$mysqli->error);

        // check if the condition query returns true or false
        if ($test_query->fetch_row() == true) {
            $test_result = "test_success";
        } elseif ($test_query->fetch_row() == false) {
            $test_result = "test_fail";
        }

        // if the execute condition is met, execute update
        if ($key['execute_condition'] == $test_result) {
            //overhere we check if we are dealing with an addition - a script containing more than just SQL
            if (strncmp($key['database_update_sql'], "..", 2) === 0) {
                include $key['database_update_sql'];
            } else {
                $mysqli->query("$key[database_update_sql]") or die("Database update $key[database_update_id] failed: ".$mysqli->error);
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
             VALUES ('$key[database_update_id]', '$update_description','$timestamp', 'implemented', '$key[update_filename]', '$script_string')") or die("Unable to insert into database_change table: ".$mysqli->error);
        }
    } //end hardcode database update table.

    // Checking if the database_update_id already exist in the database to avoid issues later on.

    $result_change = $mysqli->query("SELECT * from database_change WHERE database_update_id=$key[database_update_id]") or die("Unable to select change: ".$mysqli->error);
    $row_change    = $result_change->fetch_array(MYSQLI_ASSOC);

    $row_cnt = $result_change->num_rows;
    if ($row_cnt < 1) {
        // What should happend if the script is not in the database
        // We begin with any script that is set to autoexecute
        if ($key['database_autoexecute'] == "yes") { // Run the test condition query
            $test_query = $mysqli->query("$key[test_condition]") or die("Database update $key[database_update_id] Test condition failed: ".$mysqli->error);

            // check if the condition query returns true or false
            if ($test_query->fetch_row() == true) {
                $test_result = "test_success";
            } elseif ($test_query->fetch_row() == false) {
                $test_result = "test_fail";
            }

            // if the execute condition is met, execute update
            if ($key['execute_condition'] == $test_result) {
                //overhere we check if we are dealing with an addition - a script containing more than just SQL
                if (strncmp($key['database_update_sql'], "..", 2) === 0) {
                    include $key['database_update_sql'];
                } else {
                    $mysqli->query("$key[database_update_sql]") or die("Database update $key[database_update_id] failed: ".$mysqli->error);
                }

                // Add info to the database_change table
                // Set the timestamp
                $timestamp = time();

                // Pull the entire script into a string
                $filename      = $key['update_filename'];
                $script_string = file_get_contents("$filename");
                $script_string = $mysqli->real_escape_string($script_string);

                //addslashes to update description
                $update_description = $mysqli->real_escape_string($key['update_description']);

                $mysqli->query("INSERT INTO database_change
            (database_update_id, update_description, execute_timestamp, implementation_state, update_filename, database_change_script)
             VALUES ('$key[database_update_id]', '$update_description','$timestamp', 'implemented', '$key[update_filename]', '$script_string')") or die("Unable to insert into database_change table: ".$mysqli->error);
            }
        } // End autoexecute

        // There are certain corner cases where there is no entry in the change database and the execute condition can't be met.
        // One such corner case would be where the database change has already been implemented without the cpanel database change facility
        // For this particular scenario we use the $force_insert variable. This will only insert the update to the change database and not run
        // the query. I would suggest caution when using this.

        // Run the test condition query
        $test_query = $mysqli->query("$key[test_condition]") or die("Database update $key[database_update_id] Test condition failed: ".$mysqli->error);

        // check if the condition query returns true or false
        if ($test_query->fetch_row() == true) {
            $test_result = "test_success";
        } elseif ($test_query->fetch_row() == false) {
            $test_result = "test_fail";
        }

        if ($key['execute_condition'] !== $test_result) {
            // Execute condition can't be met, see if $force_insert is set to "yes"
            if ($key['force_insert'] == "yes") {
                // This is a case where the script is not in the database and the execute condition can't be met and force insert is set to yes
                // Insert the script as implemented in the database change table.

                // Add info to the database_change table
                // Set the timestamp
                $timestamp = time();

                // Pull the entire script into a string
                $filename      = $key['update_filename'];
                $script_string = file_get_contents("$filename");
                $script_string = $mysqli->real_escape_string($script_string);

                //addslashes to update description
                $update_description = $mysqli->real_escape_string($key['update_description']);

                $mysqli->query("INSERT INTO database_change
              (database_update_id, update_description, execute_timestamp, implementation_state, update_filename, database_change_script)
              VALUES ('$key[database_update_id]', '$update_description','$timestamp', 'implemented', '$key[update_filename]', '$script_string')") or die("Unable to insert corner cases into database_change table: ".$mysqli->error);
            }
        }
    } // End if statement for rowcount nothing in database

    // Lets do some matching against the database
    $result_change = $mysqli->query("SELECT * from database_change WHERE database_update_id=$key[database_update_id]") or die("Unable to select change: ".$mysqli->error);
    $row_change    = $result_change->fetch_array(MYSQLI_ASSOC);

    $row_cnt = $result_change->num_rows;
    if ($row_cnt == 1) {
        $implementation_state = $row_change['implementation_state'];
        $test_result          = " ";
        $allow_execute        = "no";
        $file_name            = "";
    } else {
        $implementation_state = "pending";

        // Do condition test
        $test_query = $mysqli->query("$key[test_condition]") or die("Database update $key[database_update_id] Test condition failed: ".$mysqli->error);

        if ($test_query->fetch_row() == true) {
            $test_result = "test_success";
        } elseif ($test_query->fetch_row() == false) {
            $test_result = "test_fail";
        }

        if ($key['execute_condition'] == $test_result) {
            $test_result   = "Ready to Execute";
            $allow_execute = "yes";
            $file_name     = urlencode($key['update_filename']);
        } else {
            $test_result   = "test failed";
            $allow_execute = "no";
            $file_name     = "";
        }
    }

    $smarty->append('database_update', array(
        'database_update_id' => $key['database_update_id'],
        'update_description' => $key['update_description'],
        'implementation_state' => $implementation_state,
        'allow_execute' => $allow_execute,
        'file_name' => $file_name,
        'test_result' => $test_result
    ));
}

mysqli_commit($mysqli) or die("Unable to commit transaction: ".$mysqli->error);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "database_update.html");
