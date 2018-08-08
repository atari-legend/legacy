<?php
/***************************************************************************
 * Create game_release_location table
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 173;

// Description of what the change will do.
$update_description = "Create game_release_location table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM information_schema.tables
WHERE table_schema = '$db_databasename'
AND table_name = 'game_release_location' LIMIT 1";

// Database change
$database_update_sql = "CREATE TABLE game_release_location (
    `id` INT NOT NULL AUTO_INCREMENT,
    `location_id` INT NOT NULL COMMENT 'ID of a location the relase is from',
    `game_release_id` INT NOT NULL COMMENT 'ID of the release',
    PRIMARY KEY (`id`),
    FOREIGN KEY (location_id) REFERENCES location(id),
    FOREIGN KEY (game_release_id) REFERENCES game_release(id)
  )
  ENGINE = InnoDB
  CHARSET = utf8
  COMMENT = 'List locations of a release'";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
