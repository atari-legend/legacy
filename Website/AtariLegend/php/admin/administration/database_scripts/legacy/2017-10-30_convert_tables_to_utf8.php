<?php

// Unique identifier set by developer.
$database_update_id = 109;

// Description of what the change will do.
$update_description = "Convert all tables to utf8";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "
SELECT
    CCSA.character_set_name,
    SUBSTRING(tables.table_name FROM 1)
FROM
    information_schema.tables,
    information_schema.collation_character_set_applicability CCSA
WHERE
    CCSA.collation_name = tables.table_collation
AND tables.table_schema = '$db_databasename'
AND CCSA.character_set_name != 'utf8'
LIMIT 1";

// Database change
$database_update_sql = '../../admin/administration/database_scripts/legacy/2017-10-30_convert_tables_to_utf8-addition.php';

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
