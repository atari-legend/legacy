<?php
/***************************************************************************
*                                2016-09-10_menu_disk_title_type_removal.php
*                            ------------------------------------------
*   begin                : 2016-08-07
*   copyright            : (C) 2016 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : creation of file
*
*   Id: 2016-09-10_menu_disk_title_type_removal,v 0.10 2016-09-10 ST Graveyard
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 14;

// Description of what the change will do.
$update_description = "Remove field menu_disk_title_type from table menu_disk_title";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables
WHERE table_schema = '$db_databasename' AND table_name = 'menu_disk_title' LIMIT 1";

// Database change
$database_update_sql = "ALTER TABLE `menu_disk_title` DROP `menu_disk_title_type`";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "yes";
