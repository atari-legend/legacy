<?php
/***************************************************************************
 *   Populate the game_release table from the game table
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 127;

// Description of what the change will do.
$update_description = "Populate game_release table from game";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM information_schema.tables
WHERE table_schema = '$db_databasename'
AND table_name = 'game_release' LIMIT 1";

// Database change
$database_update_sql = "INSERT INTO game_release(`game_id`, `date`)
SELECT
    game.game_id,
    CONCAT(game_year.game_year, '-01-01')
FROM
    game
LEFT JOIN game_year ON game_year.game_id = game.game_id";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
