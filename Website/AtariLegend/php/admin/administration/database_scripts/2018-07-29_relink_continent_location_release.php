<?php
/***************************************************************************
 * Relink release continent to location
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 169;

// Description of what the change will do.
$update_description = "Relink release continent to location";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM game_release_location";

// Database change
$database_update_sql = "../../admin/administration/database_scripts/2018-07-29_relink_continent_location_release_addition.php";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
