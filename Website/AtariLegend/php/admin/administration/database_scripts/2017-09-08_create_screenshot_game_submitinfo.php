<?php
/***************************************************************************
*                                2017-09-08_create_screenshot_game_submitinfo.php
*                            ----------------------------------------------
*   begin                : 2017-09-08
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        :
*
*   Id: 2017-09-08_create_screenshot_game_submitinfo.php,v 0.10 2017-09-08 STG
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 102;

// Description of what the change will do.
$update_description = "Create screenshot cross table for the game submissions";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.columns
WHERE table_schema = '$db_databasename' AND table_name = 'screenshot_game_submitinfo' LIMIT 1";

// Database change
$database_update_sql = "CREATE TABLE IF NOT EXISTS `screenshot_game_submitinfo` (
  `screenshot_game_submitinfo_id` int(11) NOT NULL AUTO_INCREMENT,
  `game_submitinfo_id` int(11),
  `screenshot_id` int(11),
  PRIMARY KEY (`screenshot_game_submitinfo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
