<?php
/***************************************************************************
 * Rename the columns of table developer_rold
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 158;

// Description of what the change will do.
$update_description = "Rename the game_extra_info columns to developer_role columns";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM information_schema.columns
WHERE table_schema = '$db_databasename'
AND table_name = 'developer_role'
AND column_name = 'game_extra_info_id' LIMIT 1";

// Database change
$database_update_sql = "ALTER TABLE developer_role
	CHANGE game_extra_info_id id int(11),
    CHANGE game_extra_info role varchar(50) COMMENT 'Name of a role',
    ADD PRIMARY KEY (id)";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
