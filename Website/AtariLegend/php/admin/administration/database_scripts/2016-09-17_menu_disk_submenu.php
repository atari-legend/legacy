<?php
/***************************************************************************
*                                2016-09-17_menu_disk_submenu.php
*                            ------------------------------------------
*   begin                : 2016-09-17
*   copyright            : (C) 2016 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : creation of file	
*							 
*   Id: 2016-09-17_menu_disk_submenu.php,v 0.10 2016-09-17 ST Graveyard
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 22; 

// Description of what the change will do.
$update_description = "Create the menu_disk_submenu table"; 

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail"; 

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables 
WHERE table_schema = '$db_databasename' AND table_name = 'menu_disk_submenu' LIMIT 1";

// Database change 
$database_update_sql = "CREATE TABLE IF NOT EXISTS `menu_disk_submenu` (
  `menu_disk_submenu_id` int(11) NOT NULL AUTO_INCREMENT,		
  `menu_disk_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_disk_submenu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

// If the update should auto execute without user interaction set to "yes".    
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
?>
