<?php
/***************************************************************************
 * Add foreign key constraint on game_developer
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 161;

// Description of what the change will do.
$update_description = "Add foreign key constraint on game_developer";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE REFERENCED_TABLE_SCHEMA = '$db_databasename'
AND REFERENCED_TABLE_NAME = 'developer_role'
AND REFERENCED_COLUMN_NAME = 'id'
AND TABLE_NAME = 'game_developer'
AND COLUMN_NAME = 'developer_role_id'";

// Database change
$database_update_sql = "ALTER TABLE game_developer
ADD FOREIGN KEY (developer_role_id) REFERENCES developer_role(id)";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
