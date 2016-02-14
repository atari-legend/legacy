<?php
/***************************************************************************
*                                2016-02-14_users_salt.php
*                            -----------------------
*   begin                : 2016-02-13
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : 	
*							 
*							
*
*   Id: 2016-02-14_users_salt.php,v 0.10 2016-02-14 Silver Surfer
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 9; 

// Description of what the change will do.
$update_description = "Add salt column in users table"; 

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.columns 
WHERE table_schema = 'atarilegend' AND table_name = 'users' AND column_name = 'salt' LIMIT 1";

// Database change 
$database_update_sql = "ALTER TABLE `users` ADD `salt` CHAR( 128 ) NULL AFTER `sha512_password`";

// If the update should auto execute without user interaction set to "yes".    
$database_autoexecute = "no";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "yes";
?>
