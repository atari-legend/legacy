<?php
/***************************************************************************
 * Remove newlines in the pub_dev table
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 149;

// Description of what the change will do.
$update_description = "Remove new lines in pub_dev";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT
    *
FROM
    `pub_dev`
WHERE
    pub_dev_name LIKE '%\n%'
OR
    pub_dev_name LIKE '%\r%'
LIMIT 1";

// Database change
$database_update_sql = "UPDATE pub_dev SET pub_dev_name = REPLACE(REPLACE(pub_dev_name, '\n', ''), '\r', '');";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
