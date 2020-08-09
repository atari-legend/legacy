<?php
/***************************************************************************
 *   Populate the enhancements from the Falcon enhancements table
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 130;

// Description of what the change will do.
$update_description = "Populate falcon enhancements";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM information_schema.tables
WHERE table_schema = '$db_databasename'
AND table_name = 'game_release_system_enhanced' LIMIT 1";

// Database change
$database_update_sql ="../../admin/administration/database_scripts/legacy/2018-06-11_populate_release_enhan_falcon_addition.php";

/*"INSERT INTO game_release_system_enhanced(`system_id`, `game_release_id`)
SELECT
    1,
    game_release.id
FROM
    game_falcon_enhan
LEFT JOIN game_release ON game_falcon_enhan.game_id = game_release.game_id";*/

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
