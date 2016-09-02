<?php
/***************************************************************************
*                                2016-09-02_crew_menu_prod_auto_increment
*                            -------------------------------------------------
*   begin                : 2016-09-02
*   copyright            : (C) 2016 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : creation of file	
*							 
*   Id: 2016-09-02_crew_menu_prod_auto_increment,v 0.10 2016-09-02 ST Graveyard
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 8; 

// Description of what the change will do.
$update_description = "auto increment to id field of crew_menu_prod"; 

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success"; 

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables 
WHERE table_schema = '$db_databasename' AND table_name = 'crew_menu_prod' LIMIT 1";

// Database change 
$database_update_sql = "ALTER TABLE `crew_menu_prod` CHANGE `crew_menu_prod_id` `crew_menu_prod_id` INT(11) NOT NULL AUTO_INCREMENT;";

// If the update should auto execute without user interaction set to "yes".    
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
?>
