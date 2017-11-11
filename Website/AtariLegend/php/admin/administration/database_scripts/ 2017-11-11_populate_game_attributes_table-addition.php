<?php
/***************************************************************************
*                    2017-11-11_populate_game_attributes_table-addition.php
*                            ----------------------------------------------
*   begin                : 2017-11-11
*   copyright            : (C) 2017 Atari Legend
*   email                : nicolas+github@guillaumin.me
*
*   Extra update script to fill the game_attributes table
*
***************************************************************************/

// game_arcade tables
$result = $mysqli->query("
INSERT INTO game_attributes (attribute_type_id,game_id) SELECT 1,game_id FROM game_arcade")
    or die("Error selecting game_arcade: ".$mysqli->error);

// game_faclon_enhan tables
$result = $mysqli->query("
INSERT INTO game_attributes (attribute_type_id,game_id) SELECT 2,game_id FROM game_falcon_enhan")
    or die("Error selecting game_faclon_enhan tables: ".$mysqli->error);

// game_faclon_only tables
$result = $mysqli->query("
INSERT INTO game_attributes (attribute_type_id,game_id) SELECT 3,game_id FROM game_falcon_only")
    or die("Error selecting game_faclon_only tables: ".$mysqli->error);

// game_faclon_rgb tables
$result = $mysqli->query("
INSERT INTO game_attributes (attribute_type_id,game_id) SELECT 4,game_id FROM game_falcon_rgb")
    or die("Error selecting game_faclon_rgb tables: ".$mysqli->error);

// game_faclon_vga tables
$result = $mysqli->query("
INSERT INTO game_attributes (attribute_type_id,game_id) SELECT 5,game_id FROM game_falcon_vga")
    or die("Error selecting game_faclon_vga tables: ".$mysqli->error);

// game_free tables
$result = $mysqli->query("
INSERT INTO game_attributes (attribute_type_id,game_id) SELECT 6,game_id FROM game_free")
    or die("Error selecting game_free tables: ".$mysqli->error);

// game_mono tables
$result = $mysqli->query("
INSERT INTO game_attributes (attribute_type_id,game_id) SELECT 7,game_id FROM game_mono")
    or die("Error selecting game_mono tables: ".$mysqli->error);

// game_seuck tables
$result = $mysqli->query("
INSERT INTO game_attributes (attribute_type_id,game_id) SELECT 8,game_id FROM game_seuck")
    or die("Error selecting game_seuck tables: ".$mysqli->error);

// game_stac tables
$result = $mysqli->query("
INSERT INTO game_attributes (attribute_type_id,game_id) SELECT 9,game_id FROM game_stac")
    or die("Error selecting game_stac tables: ".$mysqli->error);

// game_ste_enhan tables
$result = $mysqli->query("
INSERT INTO game_attributes (attribute_type_id,game_id) SELECT 10,game_id FROM game_ste_enhan")
    or die("Error selecting game_ste_enhan tables: ".$mysqli->error);

// game_ste_only tables
$result = $mysqli->query("
INSERT INTO game_attributes (attribute_type_id,game_id) SELECT 11,game_id FROM game_ste_only")
    or die("Error selecting game_ste_only tables: ".$mysqli->error);

// game_unfinished tables
$result = $mysqli->query("
INSERT INTO game_attributes (attribute_type_id,game_id) SELECT 12,game_id FROM game_unfinished")
    or die("Error selecting game_unfinished tables: ".$mysqli->error);

// game_unreleased tables
$result = $mysqli->query("
INSERT INTO game_attributes (attribute_type_id,game_id) SELECT 13,game_id FROM game_unreleased")
    or die("Error selecting game_unreleased tables: ".$mysqli->error);

// game_wanted tables
$result = $mysqli->query("
INSERT INTO game_attributes (attribute_type_id,game_id) SELECT 14,game_id FROM game_wanted")
    or die("Error selecting game_wanted tables: ".$mysqli->error);

// game_stos tables
$result = $mysqli->query("
INSERT INTO game_attributes (attribute_type_id,game_id) SELECT 15,game_id FROM game_stos")
    or die("Error selecting game_stos tables: ".$mysqli->error);

// game_development tables
$result = $mysqli->query("
INSERT INTO game_attributes (attribute_type_id,game_id) SELECT 16,game_id FROM game_development")
    or die("Error selecting game_development tables: ".$mysqli->error);
?>
