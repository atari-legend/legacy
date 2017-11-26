<?php
/***************************************************************************
*                                2017-11-24_drop_old_cpanel_forum_tables.php
*                            ----------------------------------------------
*   begin                : 2017-11-24
*   copyright            : (C) 2017 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        :
*
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 120;

// Description of what the change will do.
$update_description = "Drop cpanel forum tables";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables
WHERE table_schema = '$db_databasename' AND (table_name = 'sb_messages'
OR table_name = 'sb_messages_text') LIMIT 1";

// Database change
$database_update_sql = "
DROP TABLE IF EXISTS
sb_messages,
sb_messages_text;";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
