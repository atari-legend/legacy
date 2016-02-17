<?php
/***************************************************************************
*                                2016-02-13_database_change_table.php
*                            -----------------------
*   begin                : 2016-02-13
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : 	
*							 
*							
*
*   Id: 2016-02-13_database_change_table.php,v 0.10 2016-02-13 Silver Surfer
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 1; 

// Description of what the change will do.
$update_description = "Create the database change table"; 

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail"; 

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables 
WHERE table_schema = 'atarilegend' AND table_name = 'database_change' LIMIT 1";

// Database change 
$database_update_sql = "CREATE TABLE IF NOT EXISTS `database_change` (
  `database_change_id` int(11) NOT NULL AUTO_INCREMENT,
  `database_update_id` int(11) NOT NULL,
  `update_description` text NOT NULL,
  `execute_timestamp` int(11) NOT NULL,
  `implementation_state` varchar(256) NOT NULL,
  `update_filename` varchar(256) NOT NULL,
  `database_change_script` text NOT NULL,
  PRIMARY KEY (`database_change_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

// If the update should auto execute without user interaction set to "yes".    
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
?>
