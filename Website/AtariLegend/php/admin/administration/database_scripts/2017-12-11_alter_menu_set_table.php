<?php
/***************************************************************************
*                                2017-12-11_alter_menu_set_table.php
*                            ----------------------------------------------
*   begin                : 2017-11-24
*   copyright            : (C) 2017 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        :
*
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 122;

// Description of what the change will do.
$update_description = "Alter menu_set table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.columns
WHERE table_schema = '$db_databasename' AND table_name = 'menu_set' AND COLUMN_NAME = 'publish' AND `COLUMN_DEFAULT` ='0' LIMIT 1";

// Database change
$database_update_sql = "ALTER TABLE `menu_set` CHANGE `publish` `publish` INT(1) NOT NULL DEFAULT '0';";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
