<?php
/***************************************************************************
 *   Initial creation of the game release resolution table
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 134;

// Description of what the change will do.
$update_description = "Create release resolution table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM information_schema.tables
WHERE table_schema = '$db_databasename'
AND table_name = 'game_release_resolution' LIMIT 1";

// Database change
$database_update_sql = "CREATE TABLE game_release_resolution (
  `game_release_resolution_id` INT NOT NULL AUTO_INCREMENT,
  `resolution_id` INT NOT NULL,
  `game_release_id` INT NOT NULL,
  PRIMARY KEY (`game_release_resolution_id`),
  FOREIGN KEY (resolution_id) REFERENCES resolution(resolution_id),
  FOREIGN KEY (game_release_id) REFERENCES game_release(id)
)
ENGINE = InnoDB
CHARSET = utf8
COMMENT = 'List screen resolutions supported by a release'";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
