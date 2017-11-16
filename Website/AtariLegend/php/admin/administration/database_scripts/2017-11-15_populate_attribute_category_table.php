<?php
/***************************************************************************
*                                2017-11-15_populate_attribute_category_table.php
*                            -----------------------
*   begin                : 2017-11-11
*   copyright            : (C) 2017 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        :
*
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 113;

// Description of what the change will do.
$update_description = "Populate attribute_category table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables
WHERE table_schema = '$db_databasename' AND table_name = 'attribute_category' LIMIT 1";

// Database change
$database_update_sql = "INSERT INTO attribute_category
  (attribute_category_name)
VALUES
  ('General'),
  ('Hardware')";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
