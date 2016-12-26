<?php
/***************************************************************************
*                                2016-10-14_create_doc_disk_tool.php
*                            ----------------------------------------------
*   begin                : 2016-10-14
*   copyright            : (C) 2016 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        :
*
*   Id: 2016-10-14_create_doc_disk_tool.php,v 0.10 2016-10-14 STG
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 34;

// Description of what the change will do.
$update_description = "create doc_disk_tool table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.columns
WHERE table_schema = '$db_databasename' AND table_name = 'doc_disk_tool' LIMIT 1";

// Database change
$database_update_sql = "CREATE TABLE IF NOT EXISTS `doc_disk_tool` (
  `doc_disk_tool_id` int(11) NOT NULL AUTO_INCREMENT,
  `tools_id` int(11) DEFAULT NULL,
  `doc_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`doc_disk_tool_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
