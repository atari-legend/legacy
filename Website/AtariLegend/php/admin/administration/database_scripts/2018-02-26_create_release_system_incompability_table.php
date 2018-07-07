<?php
/***************************************************************************
 *   Initial creation of the game release system compability table
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 132;

// Description of what the change will do.
$update_description = "Create system incompatible table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM information_schema.tables
WHERE table_schema = '$db_databasename'
AND table_name = 'game_release_system_incompatible' LIMIT 1";

// Database change
$database_update_sql = "CREATE TABLE game_release_system_incompatible (
  `id` INT NOT NULL AUTO_INCREMENT,
  `system_id` INT NOT NULL COMMENT 'ID of the system the release is incompatible with',
  `game_release_id` INT NOT NULL COMMENT 'ID of the release',
  PRIMARY KEY (`id`),
  FOREIGN KEY (system_id) REFERENCES system(id),
  FOREIGN KEY (game_release_id) REFERENCES game_release(id)
)
ENGINE = InnoDB
CHARSET = utf8
COMMENT = 'List systems a release is not compatible with'";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
