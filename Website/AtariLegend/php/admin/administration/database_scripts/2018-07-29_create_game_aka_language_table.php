<?php
/***************************************************************************
 *   Initial creation of the game_aka_language cross table
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 163;

// Description of what the change will do.
$update_description = "Create game_aka_language table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM information_schema.tables
WHERE table_schema = '$db_databasename'
AND table_name = 'game_aka_language' LIMIT 1";

// Database change
$database_update_sql = "CREATE TABLE game_aka_language (
    `id` INT NOT NULL AUTO_INCREMENT,
    `language_id` INT(11) NOT NULL COMMENT 'ID of language table',
    `game_aka_id` INT(11) NOT NULL COMMENT 'ID of game_aka table',
    PRIMARY KEY (`id`)
)
ENGINE = InnoDB
CHARSET = utf8
COMMENT = 'Cross table between game_aka and language table'";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
