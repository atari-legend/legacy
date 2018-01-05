<?php
/***************************************************************************
*                                2017-03-02_create_download_main.php
*                            ----------------------------------------------
*   begin                : 2017-03-02
*   copyright            : (C) 2016 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        :
*
*   Id: 2017-03-02_create_download_main.php,v 0.10 2017-03-02 STG
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 20;

// Description of what the change will do.
$update_description = "Create main download table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.columns
WHERE table_schema = '$db_databasename' AND table_name = 'download_main' LIMIT 1";

// Database change
$database_update_sql = "CREATE TABLE IF NOT EXISTS `download_main` (
  `download_id` int(11) NOT NULL AUTO_INCREMENT,
  `download_ext` varchar(3),
  `user_id` int(11),
  `date` int(11),
  `sha512` varchar(128),
  `disable` int(1),
  PRIMARY KEY (`download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
