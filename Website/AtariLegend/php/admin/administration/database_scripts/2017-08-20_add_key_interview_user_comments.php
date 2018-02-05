<?php
/***************************************************************************
*                                2017-08-20_add_key_interview_user_comments.php
*                            ----------------------------------------------
*   begin                : 2017-08-20
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        :
*
*   Id: 2017-08-20_add_key_interview_user_comments.php,v 0.10 2017-08-20 STG
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 100;

// Description of what the change will do.
$update_description = "Add primary key to interview_user_comments";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.columns
WHERE table_schema = '$db_databasename' AND table_name = 'interview_user_comments' LIMIT 1";

// Database change
$database_update_sql = "ALTER TABLE `interview_user_comments` ADD PRIMARY KEY(`interview_user_comments_id`);";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
