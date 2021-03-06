<?php
/***************************************************************************
*                                2017-06-04_clean_users.php
*                            ----------------------------------------------
*   begin                : 2017-06-04
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : creation of script
*
*   Id: 2017-06-04_clean_users.php,v 0.10 2017-06-04 STG
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 97;

// Description of what the change will do.
$update_description = "Clean the fb, twitter and af columns of Users table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.columns
WHERE table_schema = '$db_databasename' AND table_name = 'users' LIMIT 1";

// Database change
$database_update_sql = "UPDATE users SET user_af=NULL, user_fb=NULL, user_twitter=NULL;";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
