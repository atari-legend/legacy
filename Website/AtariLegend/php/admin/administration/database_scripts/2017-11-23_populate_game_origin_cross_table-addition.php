<?php
/***************************************************************************
*                    2017-11-23_populate_game_origin_cross_table-addition.php
*                            ----------------------------------------------
*   begin                : 2017-11-23
*   copyright            : (C) 2017 Atari Legend
*   email                :
*
*   Extra update script to fill the game_origin_cross table
*
***************************************************************************/

// game_arcade tables
$result = $mysqli->query("
INSERT INTO game_origin_cross (software_origin_id,game_id) SELECT 1,game_id FROM game_arcade")
    or die("Error selecting game_arcade: ".$mysqli->error);

// game_unfinished tables
$result = $mysqli->query("
DELETE FROM game_unfinished WHERE game_id = 4067")
    or die("Error selecting game_unfinished tables: ".$mysqli->error);
$result = $mysqli->query("
INSERT INTO game_origin_cross (software_origin_id,game_id) SELECT 2,game_id FROM game_unfinished")
    or die("Error selecting game_unfinished tables: ".$mysqli->error);

// game_unreleased tables
$result = $mysqli->query("
INSERT INTO game_origin_cross (software_origin_id,game_id) SELECT 3,game_id FROM game_unreleased")
    or die("Error selecting game_unreleased tables: ".$mysqli->error);

// game_development tables
$result = $mysqli->query("
INSERT INTO game_origin_cross (software_origin_id,game_id) SELECT 4,game_id FROM game_development")
    or die("Error selecting game_development tables: ".$mysqli->error);

// game_wanted tables
$result = $mysqli->query("
DELETE FROM game_wanted WHERE game_id = 4405")
    or die("Error selecting game_wanted tables: ".$mysqli->error);
$result = $mysqli->query("
INSERT INTO game_origin_cross (software_origin_id,game_id) SELECT 5,game_id FROM game_wanted")
    or die("Error selecting game_wanted tables: ".$mysqli->error);
