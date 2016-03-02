<?php
/***************************************************************************
*                                2016-02-26_drop_table_demo_search.php
*                            -----------------------
*   begin                : 2016-02-26
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : 	
*							 
*							
*
*   Id: 2016-02-26_drop_table_game_search.php,v 0.10 2016-02-26 Silver Surfer
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 25; 

// Description of what the change will do.
$update_description = "Drop Table demo_search"; 

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables 
WHERE table_schema = '$db_databasename' AND table_name = 'demo_search' LIMIT 1";

// Database change 
$database_update_sql = "DROP TABLE `demo_search`";

// If the update should auto execute without user interaction set to "yes".    
$database_autoexecute = "no";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
?>
