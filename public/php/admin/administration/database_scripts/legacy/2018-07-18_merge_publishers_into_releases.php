<?php
/***************************************************************************
 * Merge publishers into game releases
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 155;

// Description of what the change will do.
$update_description = "Merge publishers into game releases";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM game_release
WHERE `type` IS NOT NULL
AND continent_id IS NOT NULL
AND pub_dev_id IS NOT NULL
LIMIT 1";

// Database change
$database_update_sql = "../../admin/administration/database_scripts/legacy/2018-07-18_merge_publishers_into_releases_addition.php";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
