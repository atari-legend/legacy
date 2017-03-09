<?php
/***************************************************************************
*                                2017-03-09_change_game_download.php
*                            ----------------------------------------------
*   begin                : 2017-03-09
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        :
*
*   Id: 2017-03-09_change_game_download.php,v 0.10 2017-03-02 STG
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 91;

// Description of what the change will do.
$update_description = "Change the game download table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.columns
WHERE table_schema = '$db_databasename' AND table_name = 'game_download' LIMIT 1";

// Database change
$database_update_sql = "ALTER TABLE `game_download` CHANGE COLUMN `set_nr` `download_id` INT(11) NOT NULL, DROP COLUMN `game_ext`, DROP COLUMN `date`, DROP COLUMN `md5`, DROP COLUMN `cracker`, DROP COLUMN `supplier`, DROP COLUMN `screen`, DROP COLUMN `language`, DROP COLUMN `trainer`,DROP COLUMN `disks`, DROP COLUMN `legend`, DROP COLUMN `harddrive`, DROP COLUMN `intro`, DROP COLUMN `disable`, DROP COLUMN `version`, DROP COLUMN `tos`;";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
