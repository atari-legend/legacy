<?php
/***************************************************************************
*                                2017-11-13_drop_boolean_tables.php
*                            -----------------------
*   begin                : 2017-11-11
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        :
*
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 118;

// Description of what the change will do.
$update_description = "Drop old game attributes tables";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables
WHERE table_schema = '$db_databasename' AND table_name = 'attribute_type' LIMIT 1";

// Database change
$database_update_sql = "
DROP TABLE IF EXISTS
game_arcade,
game_development,
game_falcon_enhan,
game_falcon_only,
game_falcon_rgb,
game_falcon_vga,
game_free,
game_mono,
game_seuck,
game_stac,
game_ste_enhan,
game_ste_only,
game_stos,
game_unfinished,
game_unreleased,
game_wanted;";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
