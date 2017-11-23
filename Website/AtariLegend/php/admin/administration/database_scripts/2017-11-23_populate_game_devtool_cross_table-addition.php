<?php
/***************************************************************************
*                    2017-11-23_populate_game_devtool_cross_table-addition.php
*                            ----------------------------------------------
*   begin                : 2017-11-23
*   copyright            : (C) 2017 Atari Legend
*   email                :
*
*   Extra update script to fill the game_devtool_cross table
*
***************************************************************************/

// game_seuck tables
$result = $mysqli->query("
INSERT INTO game_devtool_cross (software_devtool_id,game_id) SELECT 1,game_id FROM game_seuck")
    or die("Error selecting game_seuck tables: ".$mysqli->error);

// game_stac tables
$result = $mysqli->query("
INSERT INTO game_devtool_cross (software_devtool_id,game_id) SELECT 2,game_id FROM game_stac")
    or die("Error selecting game_stac tables: ".$mysqli->error);

// game_stos tables
$result = $mysqli->query("
INSERT INTO game_devtool_cross (software_devtool_id,game_id) SELECT 3,game_id FROM game_stos")
    or die("Error selecting game_stos tables: ".$mysqli->error);
