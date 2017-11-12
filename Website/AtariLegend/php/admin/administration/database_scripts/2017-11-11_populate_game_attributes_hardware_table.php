<?php
/***************************************************************************
*                                2017-11-11_populate_game_attributes_hardware_table.php
*                            ----------------------------------------------
*   begin                : 2017-11-11
*   copyright            : (C) 2017 Atari Legend
*   email                : silversurfer@atari-forum.com
*
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 117;

// Description of what the change will do.
$update_description = "Populate game_attributes_hardware table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables
WHERE table_schema = '$db_databasename' AND table_name = 'game_attributes_hardware' LIMIT 1";

// Database change
$database_update_sql = "../../admin/administration/database_scripts/2017-11-11_populate_game_attributes_hardware_table-addition.php";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
