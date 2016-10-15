<?php
/***************************************************************************
*                                2016-10-14_change_fields_doc_disk_game.php
*                            ----------------------------------------------
*   begin                : 2016-10-14
*   copyright            : (C) 2016 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : 	
*							 
*   Id: 2016-10-14_change_fields_doc_disk_game.php,v 0.10 2016-10-14 STG
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 40; 

// Description of what the change will do.
$update_description = "Change id fields of doc_disk_game"; 

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.columns 
WHERE table_schema = '$db_databasename' AND table_name = 'doc_disk_game' LIMIT 1";

// Database change 
$database_update_sql = "ALTER TABLE `doc_disk_game` CHANGE `doc_games_id` `doc_disk_game_id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `doc_type_id` `doc_id` INT(11) NULL DEFAULT NULL; ";
// If the update should auto execute without user interaction set to "yes".    
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
?>
