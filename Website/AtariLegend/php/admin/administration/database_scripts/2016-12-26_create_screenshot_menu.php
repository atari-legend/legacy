<?php
/***************************************************************************
*                                2016-12-26_create_screenshot_menu.php
*                            ----------------------------------------------
*   begin                : 2016-12-26
*   copyright            : (C) 2016 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        :
*
*   Id: 2016-12-26_create_screenshot_menu.php,v 0.10 2016-12-26 STG
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 55;

// Description of what the change will do.
$update_description = "create screenshot_menu table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.columns
WHERE table_schema = '$db_databasename' AND table_name = 'screenshot_menu' LIMIT 1";

// Database change
$database_update_sql = "CREATE TABLE IF NOT EXISTS `screenshot_menu` (
  `screenshot_menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_disk_id` int(11) NOT NULL,
  `screenshot_id` int(11) NOT NULL,
  PRIMARY KEY (`screenshot_menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
