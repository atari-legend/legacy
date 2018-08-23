<?php
/***************************************************************************
 *   Update script to Add license column to game_release table
 *
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 136;

// Description of what the change will do.
$update_description = "Add license column to release";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM information_schema.columns
WHERE table_schema = '$db_databasename'
AND table_name = 'game_release'
AND column_name = 'license' LIMIT 1";

// Database change
$database_update_sql = "ALTER TABLE game_release ADD `license` ENUM('Commercial','Non-Commercial')";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
