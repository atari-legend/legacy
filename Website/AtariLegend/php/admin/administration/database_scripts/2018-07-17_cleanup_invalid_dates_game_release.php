<?php
/***************************************************************************
 * Cleanup invalid 0000-00-00 dates in game_release
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 150;

// Description of what the change will do.
$update_description = "Cleanup invalid 0000-00-00 dates in game_release";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT
    *
FROM
    game_release
WHERE
    `date` = 0
LIMIT 1";

// Database change
$database_update_sql = "UPDATE game_release SET `date` = NULL WHERE `date` = 0";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
