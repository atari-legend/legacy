<?php
/***************************************************************************
*                                2017-11-23_game_origin_cross_table.php
*                            -----------------------
*   begin                : 2017-11-23
*   copyright            : (C) 2017 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        :
*
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 112;

// Description of what the change will do.
$update_description = "Create game_origin_cross table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables
WHERE table_schema = '$db_databasename' AND table_name = 'game_origin_cross' LIMIT 1";

// Database change
$database_update_sql = "
CREATE TABLE `game_origin_cross` (
  `game_id` int(11) NOT NULL,
  `software_origin_id` int(11) NOT NULL,
  KEY `game_id` (`game_id`),
  KEY `software_origin_id` (`software_origin_id`),
  CONSTRAINT `game_origin_cross_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `game` (`game_id`),
  CONSTRAINT `game_origin_cross_ibfk_2` FOREIGN KEY (`software_origin_id`) REFERENCES `software_origin` (`software_origin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
