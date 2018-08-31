<?php
/***************************************************************************
 *   Populate the programming languages into the game_programming_language
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 181;

// Description of what the change will do.
$update_description = "Populate the programming languages into game_programming_language";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM information_schema.columns
WHERE table_schema = '$db_databasename'
AND table_name = 'game_programming_language'";

// Database change
$database_update_sql = "../../admin/administration/database_scripts/2018-08-26_populate_game_programming_language_addition.php";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
