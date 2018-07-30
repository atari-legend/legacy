<?php
/***************************************************************************
 * Rename the column game_extra_info_id to developer_role_id
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 159;

// Description of what the change will do.
$update_description = "Rename the column game_extra_info_id to developer_role_id of table game_developer";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM information_schema.columns
WHERE table_schema = '$db_databasename'
AND table_name = 'game_developer'
AND column_name = 'game_extra_info_id' LIMIT 1";

// Database change
$database_update_sql = "ALTER TABLE game_developer
    CHANGE game_extra_info_id developer_role_id int(11) COMMENT 'Role the developer had on the game'";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
