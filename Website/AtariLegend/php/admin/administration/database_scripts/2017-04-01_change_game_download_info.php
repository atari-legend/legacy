<?php
/***************************************************************************
*                               2017-04-01_change_game_download_info.php
*                            ------------------------------------------
*   begin                : 2017-04-01
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : creation of file
*
*   Id: 2017-04-01_change_game_download_info.php,v 0.10 2017-04-01 ST Graveyard
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 92;

// Description of what the change will do.
$update_description = "Change table game_download_info";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables
WHERE table_schema = '$db_databasename' AND table_name = 'game_download_info' LIMIT 1";

// Database change
$database_update_sql = "ALTER TABLE `game_download_info` ADD `game_download_id` INT(11) NOT NULL";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
