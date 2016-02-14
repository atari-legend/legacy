<?php
/***************************************************************************
*                                2016-02-14_theme_table.php
*                            -----------------------
*   begin                : 2016-02-14
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : 	
*							 
*							
*
*   Id: 2016-02-14_theme_table.php,v 0.10 2016-02-14 Silver Surfer
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 11; 

// Description of what the change will do.
$update_description = "Create theme table"; 

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail"; 

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables 
WHERE table_schema = 'atarilegend' AND table_name = 'theme' LIMIT 1";

// Database change 
$database_update_sql = "CREATE TABLE IF NOT EXISTS `theme` (
  `theme_id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(255) NOT NULL,
  `theme_style_id` int(11) NOT NULL,
  `theme_template_id` int(11) NOT NULL,
  PRIMARY KEY (`theme_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

// If the update should auto execute without user interaction set to "yes".    
$database_autoexecute = "no";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
?>
