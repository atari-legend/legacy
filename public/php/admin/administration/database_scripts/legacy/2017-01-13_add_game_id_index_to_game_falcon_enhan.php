<?php
/***************************************************************************
*                                2017-01-13_add_game_id_index_to_game_falcon_enhan.php
*                            -----------------------
*   begin                : 2017-01-13
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        :
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 61;

// Description of what the change will do.
$update_description = "Add game_id index to game_falcon_enhan";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SHOW INDEX FROM game_falcon_enhan WHERE KEY_NAME = 'game_id'";

// Database change
$database_update_sql = "ALTER TABLE `game_falcon_enhan` ADD INDEX `game_id` (`game_id`)";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
