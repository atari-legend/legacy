<?php
/***************************************************************************
*                                2016-10-14_rename_tabel_doc_game.php
*                            ----------------------------------------------
*   begin                : 2016-10-14
*   copyright            : (C) 2016 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        :
*
*   Id: 2016-10-14_rename_tabel_doc_game.php,v 0.10 2016-10-14 STG
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 32;

// Description of what the change will do.
$update_description = "Rename table doc_game to doc_disk_game";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.columns
WHERE table_schema = '$db_databasename' AND table_name = 'doc_game' LIMIT 1";

// Database change
$database_update_sql = "RENAME TABLE $db_databasename.`doc_game` TO $db_databasename.`doc_disk_game`;";
// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
?>
