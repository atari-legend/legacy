<?php
/***************************************************************************
 * Create game_programming language table
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 177;

// Description of what the change will do.
$update_description = "Create game_programming_language table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM information_schema.tables
WHERE table_schema = '$db_databasename'
AND table_name = 'game_programming_language'
LIMIT 1";

// Database change
$database_update_sql = "CREATE TABLE `game_programming_language` (
    `game_id` INT NOT NULL COMMENT 'Foreign key to game table',
    `programming_language_id`INT NOT NULL COMMENT 'Foreign key to programming_language table',
    FOREIGN KEY (game_id) REFERENCES game(game_id),
    FOREIGN KEY (programming_language_id) REFERENCES programming_language(id)
  )
  ENGINE=InnoDB
  CHARSET=utf8
  COMMENT 'Cross table between a game and the programming language'";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
