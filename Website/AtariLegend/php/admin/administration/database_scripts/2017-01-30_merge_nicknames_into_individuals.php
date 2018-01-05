<?php
/************************************************************************************
*                                2017-01-30_merge_nicknames_into_individuals.php
*                            ---------------------------------------------------------
*   begin                : 2017-01-30
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        :
*
*   Id: 2017-01-30_merge_nicknames_into_individuals.php,v 0.10 2017-01-30 STG
*
*************************************************************************************/

// Unique identifier set by developer.
$database_update_id = 68;

// Description of what the change will do.
$update_description = "Merge nicknames into individuals table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.columns
WHERE table_schema = '$db_databasename' AND table_name = 'individuals' LIMIT 1";

// Database change
$database_update_sql = '../../admin/administration/database_scripts/2017-01-30_merge_nicknames_into_individuals-addition.php';

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
