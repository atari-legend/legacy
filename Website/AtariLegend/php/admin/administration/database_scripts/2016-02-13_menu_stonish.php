<?php
/***************************************************************************
*                                2016-02-13_menu_stonish.php
*                            -----------------------
*   begin                : 2016-02-13
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        :
*
*
*
*   Id: 2016-02-13_menu_stonish.php,v 0.10 2016-02-13 Silver Surfer
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 5;

// Description of what the change will do.
$update_description = "Create helper table for stonish import";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables
WHERE table_schema = '$db_databasename' AND table_name = 'menu_stonish' LIMIT 1";

// Database change
$database_update_sql = "CREATE TABLE IF NOT EXISTS `menu_stonish` (
  `menu_stonish_id` int(255) NOT NULL AUTO_INCREMENT,
  `sofware_type_id` int(255) NOT NULL,
  `software_name` varchar(255) NOT NULL,
  `id_software` int(255) NOT NULL,
  `menu_disk_id` int(255) NOT NULL,
  `iddemozoo` int(255) NOT NULL,
  PRIMARY KEY (`menu_stonish_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "no";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "yes";
