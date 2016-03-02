<?php
/***************************************************************************
*                                2016-02-26_add_user_id_index_to_comments.php
*                            -----------------------
*   begin                : 2016-02-26
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : 	
*							 
*							
*
*   Id: 2016-02-26_add_user_id_index_to_comments,v 0.10 2016-02-26 Silver Surfer
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 27; 

// Description of what the change will do.
$update_description = "Add user_id index to comments"; 

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SHOW INDEX FROM comments WHERE KEY_NAME = 'user_id'";

// Database change 
$database_update_sql = "ALTER TABLE `comments` ADD INDEX `user_id` (`user_id`)";

// If the update should auto execute without user interaction set to "yes".    
$database_autoexecute = "no";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
?>
