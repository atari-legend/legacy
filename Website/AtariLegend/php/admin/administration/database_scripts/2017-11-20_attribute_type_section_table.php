<?php
/***************************************************************************
*                                2017-11-20_attribute_type_section_table.php
*                            -----------------------
*   begin                : 2017-11-20
*   copyright            : (C) 2017 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        :
*
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 118;

// Description of what the change will do.
$update_description = "Create attribute_type_section table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables
WHERE table_schema = '$db_databasename' AND table_name = 'attribute_type_section' LIMIT 1";

// Database change
$database_update_sql = "
CREATE TABLE `attribute_type_section` (
  `attribute_type_section_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_type_id` int(11) NOT NULL,
  `al_section_id` int(11) NOT NULL,
  PRIMARY KEY (`attribute_type_section_id`),
  KEY `attribute_type_id` (`attribute_type_id`),
  KEY `al_section_id` (`al_section_id`),
  CONSTRAINT `attribute_type_section_ibfk_1` FOREIGN KEY (`attribute_type_id`) REFERENCES `attribute_type` (`attribute_type_id`),
  CONSTRAINT `attribute_type_section_ibfk_2` FOREIGN KEY (`al_section_id`) REFERENCES `al_section` (`al_section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
