<?php
/***************************************************************************
*                                2016-10-15_menu_disk_title_games_int11.php
*                            -------------------------------------------------
*   begin                : 2016-10-15
*   copyright            : (C) 2016 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : creation of file
*
*   Id: 2016-10-15_menu_disk_title_games_int11.php,v 0.10 2016-10-15 ST Graveyard
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 48;

// Description of what the change will do.
$update_description = "Change field type to int(11) for table menu_disk_title_game";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables
WHERE table_schema = '$db_databasename' AND table_name = 'menu_disk_title_game' LIMIT 1";

// Database change
$database_update_sql = "ALTER TABLE `menu_disk_title_game` CHANGE `menu_disk_title_game_id` `menu_disk_title_game_id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `menu_disk_title_id` `menu_disk_title_id` INT(11) NULL DEFAULT NULL, CHANGE `game_id` `game_id` INT(11) NULL DEFAULT NULL; ";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
