<?php
/***************************************************************************
*                                2017-11-20_demo_attributes_table.php
*                            -----------------------
*   begin                : 2017-11-20
*   copyright            : (C) 2017 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        :
*
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 119;

// Description of what the change will do.
$update_description = "Create demo_attributes table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables
WHERE table_schema = '$db_databasename' AND table_name = 'demo_attributes' LIMIT 1";

// Database change
$database_update_sql = "
CREATE TABLE `demo_attributes` (
  `demo_attributes_id` int(11) NOT NULL AUTO_INCREMENT,
  `demo_id` int(11) NOT NULL,
  `attribute_typ_id` int(11) NOT NULL,
  PRIMARY KEY (`demo_attributes_id`),
  KEY `demo_id` (`demo_id`),
  KEY `attribute_typ_id` (`attribute_typ_id`),
  CONSTRAINT `demo_attributes_ibfk_1` FOREIGN KEY (`demo_id`) REFERENCES `demo` (`demo_id`),
  CONSTRAINT `demo_attributes_ibfk_2` FOREIGN KEY (`attribute_typ_id`) REFERENCES `attribute_type` (`attribute_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
