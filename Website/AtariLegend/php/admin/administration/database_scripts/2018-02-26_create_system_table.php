<?php
/***************************************************************************
 *   Initial creation of the system table
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 111;

// Description of what the change will do.
$update_description = "Create system table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM information_schema.tables
WHERE table_schema = '$db_databasename'
AND table_name = 'system' LIMIT 1";

// Database change
$database_update_sql = "CREATE TABLE system (
    `system_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Unique ID of a system',
    `system_name` VARCHAR(255) NOT NULL COMMENT 'Name of computer system',
    PRIMARY KEY (`system_id`)
)
ENGINE = InnoDB
CHARSET = utf8
COMMENT = 'System table used for setting enhancements or compability'";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
