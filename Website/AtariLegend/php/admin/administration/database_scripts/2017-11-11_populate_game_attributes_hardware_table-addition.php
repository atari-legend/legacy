<?php
/***************************************************************************
*                    2017-11-11_populate_game_attributes_hardware_table-addition.php
*                            ----------------------------------------------
*   begin                : 2017-11-11
*   copyright            : (C) 2017 Atari Legend
*   email                : nicolas+github@guillaumin.me
*
*   Extra update script to fill the game_attributes table
*
***************************************************************************/

// game_faclon_enhan tables
$result = $mysqli->query("
INSERT INTO game_attributes_hardware (attribute_hardware_type_id,game_id) SELECT 1,game_id FROM game_falcon_enhan")
    or die("Error selecting game_faclon_enhan tables: ".$mysqli->error);

// game_faclon_only tables
$result = $mysqli->query("
DELETE FROM game_falcon_only WHERE game_id = 27")
    or die("Error selecting game_faclon_only tables: ".$mysqli->error);
$result = $mysqli->query("
INSERT INTO game_attributes_hardware (attribute_hardware_type_id,game_id) SELECT 2,game_id FROM game_falcon_only")
    or die("Error selecting game_faclon_only tables: ".$mysqli->error);

// game_faclon_rgb tables
$result = $mysqli->query("
INSERT INTO game_attributes_hardware (attribute_hardware_type_id,game_id) SELECT 3,game_id FROM game_falcon_rgb")
    or die("Error selecting game_faclon_rgb tables: ".$mysqli->error);

// game_faclon_vga tables
$result = $mysqli->query("
INSERT INTO game_attributes_hardware (attribute_hardware_type_id,game_id) SELECT 4,game_id FROM game_falcon_vga")
    or die("Error selecting game_faclon_vga tables: ".$mysqli->error);

// game_mono tables
$result = $mysqli->query("
DELETE FROM game_mono WHERE game_id = 4072")
    or die("Error selecting game_faclon_only tables: ".$mysqli->error);
$result = $mysqli->query("
DELETE FROM game_mono WHERE game_id = 5313")
    or die("Error selecting game_faclon_only tables: ".$mysqli->error);
$result = $mysqli->query("
DELETE FROM game_mono WHERE game_id = 5386")
    or die("Error selecting game_faclon_only tables: ".$mysqli->error);
$result = $mysqli->query("
DELETE FROM game_mono WHERE game_id = 5741")
    or die("Error selecting game_faclon_only tables: ".$mysqli->error);
$result = $mysqli->query("
INSERT INTO game_attributes_hardware (attribute_hardware_type_id,game_id) SELECT 5,game_id FROM game_mono")
    or die("Error selecting game_mono tables: ".$mysqli->error);

// game_ste_enhan tables
$result = $mysqli->query("
INSERT INTO game_attributes_hardware (attribute_hardware_type_id,game_id) SELECT 6,game_id FROM game_ste_enhan")
    or die("Error selecting game_ste_enhan tables: ".$mysqli->error);

// game_ste_only tables
$result = $mysqli->query("
INSERT INTO game_attributes_hardware (attribute_hardware_type_id,game_id) SELECT 7,game_id FROM game_ste_only")
    or die("Error selecting game_ste_only tables: ".$mysqli->error);

?>
