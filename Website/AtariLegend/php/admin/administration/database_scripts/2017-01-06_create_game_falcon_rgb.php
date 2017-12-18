<?php
/***************************************************************************
*                                2017-01-06_create_game_falcon_rgb.php
*                            ----------------------------------------------
*   begin                : 2017-01-06
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        :
*
*   Id: 2017-01-06_create_game_falcon_rgb.php,v 0.10 2017-01-06 STG
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 56;

// Description of what the change will do.
$update_description = "create game_falcon_rgb table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.columns
WHERE table_schema = '$db_databasename' AND table_name = 'game_falcon_rgb' LIMIT 1";

// Database change
$database_update_sql = "CREATE TABLE IF NOT EXISTS `game_falcon_rgb` (
  `game_id` int(11) NOT NULL,
  `falcon_rgb` int(1) NOT NULL,
  PRIMARY KEY (`game_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
