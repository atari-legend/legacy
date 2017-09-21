<?php
/***************************************************************************
*                                2016-09-02_ind_menu_prod_int11
*                            -------------------------------------------------
*   begin                : 2016-09-02
*   copyright            : (C) 2016 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : creation of file
*
*   Id: 2016-09-02_ind_menu_prod_int11,v 0.10 2016-09-02 ST Graveyard
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 10;

// Description of what the change will do.
$update_description = "Change field type to int(11) for table ind_menu_prod";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables
WHERE table_schema = '$db_databasename' AND table_name = 'ind_menu_prod' LIMIT 1";

// Database change
$database_update_sql = "ALTER TABLE `ind_menu_prod` CHANGE `ind_menu_prod_id` `ind_menu_prod_id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `ind_id` `ind_id` INT(11) NULL DEFAULT NULL, CHANGE `menu_sets_id` `menu_sets_id` INT(11) NULL DEFAULT NULL; ";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
