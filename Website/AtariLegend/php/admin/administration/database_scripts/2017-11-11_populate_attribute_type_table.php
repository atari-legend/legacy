<?php
/***************************************************************************
*                                2017-11-11_populate_attribut_type_table.php
*                            -----------------------
*   begin                : 2017-11-11
*   copyright            : (C) 2016 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        :
*
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 114;

// Description of what the change will do.
$update_description = "Populate attribute_type table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables
WHERE table_schema = '$db_databasename' AND table_name = 'attribute_type' LIMIT 1";

// Database change
$database_update_sql = "
INSERT INTO attribute_type
  (attribute_type_name,attribute_category_id)
VALUES
  ('Arcade','1'),
  ('Non Commercial','1'),
  ('SEUCK','1'),
  ('STAC','1'),
  ('Unfinished','1'),
  ('Unreleased','1'),
  ('Wanted','1'),
  ('Stos','1'),
  ('In Development','1'),
  ('Falcon Enhanced','2'),
  ('Falcon Only','2'),
  ('Falcon RGB','2'),
  ('Falcon VGA','2'),
  ('Monochrome Only','2'),
  ('STE Enhanced','2'),
  ('STE Only','2');";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
