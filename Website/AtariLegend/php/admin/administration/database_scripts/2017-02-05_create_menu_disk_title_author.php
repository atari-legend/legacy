<?php
/***************************************************************************
*                                2017-02-05_create_menu_disk_title_author.php
*                            ---------------------------------------------
*   begin                : 2017-02-05
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : creation of file
*
*   Id: 2017-02-05_create_menu_disk_title_author.php,v 0.10 2017-02-05 ST Graveyard
*
***************************************************************************/

// Unique identifier set by developer.
$database_update_id = 32;

// Description of what the change will do.
$update_description = "Create the menu_disk_title_author table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_fail";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT * FROM information_schema.tables
WHERE table_schema = '$db_databasename' AND table_name = 'menu_disk_title_author' LIMIT 1";

// Database change
$database_update_sql = "CREATE TABLE IF NOT EXISTS `menu_disk_title_author` (
						  `menu_disk_title_author_id` int(11) NOT NULL AUTO_INCREMENT,
						  `menu_disk_title_id` int(11) NOT NULL,
						  `ind_id` int(11) NOT NULL,
                          `author_type_id` int(11) NOT NULL,
						  PRIMARY KEY (`menu_disk_title_author_id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
