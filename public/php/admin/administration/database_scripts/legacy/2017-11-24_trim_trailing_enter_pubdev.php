<?php
/***************************************************************************
*                                2017-11-24_trim_trailing_enter_pubdev.php
*                            ----------------------------------------------
*   begin                : 2017-11-24
*   copyright            : (C) 2017 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        :
*
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 121;

// Description of what the change will do.
$update_description = "Trim trailing enter in publisher";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT
    *,
    HEX(pub_dev_name)
FROM
    `pub_dev`
WHERE
    pub_dev_name LIKE '%\n'
LIMIT 1";

// Database change
$database_update_sql = "UPDATE pub_dev SET pub_dev_name = TRIM(TRAILING '\n' FROM pub_dev_name);";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
