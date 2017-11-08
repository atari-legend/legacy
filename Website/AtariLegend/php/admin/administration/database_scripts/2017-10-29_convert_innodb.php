<?php
/***************************************************************************
*                                2017-10-29_convert_innodb.php
*                            ----------------------------------------------
*   begin                : 2017-10-29
*   copyright            : (C) 2017 Atari Legend
*   email                : nicolas+github@guillaumin.me
*
*   Update script to convert all tables to the InnoDB storage engine
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 108;

// Description of what the change will do.
$update_description = "Convert all tables to InnoDB";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM information_schema.tables
WHERE table_schema = '$db_databasename'
AND engine != 'InnoDB' LIMIT 1";

// Database change
$database_update_sql = "../../admin/administration/database_scripts/2017-10-29_convert_innodb-addition.php";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "no";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
