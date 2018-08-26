<?php
/***************************************************************************
 *   Update script to fix the website table to add a default value
 *   to the inactive column and convert it to a boolean type
 *
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 123;

// Description of what the change will do.
$update_description = "Fix website inactive column";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM information_schema.columns
WHERE table_schema = '$db_databasename'
AND table_name = 'website'
AND column_name = 'inactive'
AND column_default = '0' LIMIT 1";

// Database change
$database_update_sql = "ALTER TABLE `website` CHANGE `inactive` `inactive` BOOL NOT NULL default FALSE";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
