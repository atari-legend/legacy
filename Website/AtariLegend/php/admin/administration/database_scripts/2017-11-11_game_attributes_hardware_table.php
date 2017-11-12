<?php
/***************************************************************************
*                                2017-11-11_game_attributes_hardware_table.php
*                            -----------------------
*   begin                : 2017-11-11
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        :
*
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 113;

// Description of what the change will do.
$update_description = "Create game_attributes_hardware table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables
WHERE table_schema = '$db_databasename' AND table_name = 'game_attributes_hardware' LIMIT 1";

// Database change
$database_update_sql = "
CREATE TABLE `game_attributes_hardware` (
  `game_attributes_hardware_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_hardware_type_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`game_attributes_hardware_id`),
  KEY `attribute_hardware_type_id` (`attribute_hardware_type_id`),
  KEY `game_id` (`game_id`),
  CONSTRAINT `game_attributes_hardware_ibfk_1` FOREIGN KEY (`attribute_hardware_type_id`) REFERENCES `attribute_hardware_type` (`attribute_hardware_type_id`),
  CONSTRAINT `game_attributes_hardware_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `game` (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
