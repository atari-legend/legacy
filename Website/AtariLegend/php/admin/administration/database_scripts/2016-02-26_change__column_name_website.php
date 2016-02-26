<?php
/***************************************************************************
*                                2016-02-26_change__column_name_website.php
*                            -----------------------
*   begin                : 2016-02-26
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : 	
*							 
*							
*
*   Id: 2016-02-26_change__column_name_website.php,v 0.10 2016-02-26 Silver Surfer
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 33; 

// Description of what the change will do.
$update_description = "Change field website_user_sub to user_id in website"; 

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.columns 
WHERE table_schema = '$db_databasename' AND table_name = 'website' AND column_name = 'website_user_sub' LIMIT 1";

// Database change 
$database_update_sql = "ALTER TABLE `website` CHANGE `website_user_sub` `user_id`INT( 11 )";

// If the update should auto execute without user interaction set to "yes".    
$database_autoexecute = "no";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
?>
