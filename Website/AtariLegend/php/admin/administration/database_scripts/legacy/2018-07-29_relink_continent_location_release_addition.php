<?php

// Europe
$mysqli->query("INSERT INTO game_release_location (game_release_id, location_id)
    SELECT id, 120 FROM game_release WHERE continent_id = 1")
    or die($mysqli->error);


// North America
$mysqli->query("INSERT INTO game_release_location (game_release_id, location_id)
    SELECT id, 172 FROM game_release WHERE continent_id = 2")
    or die($mysqli->error);

// South America
$mysqli->query("INSERT INTO game_release_location (game_release_id, location_id)
    SELECT id, 239 FROM game_release WHERE continent_id = 3")
    or die($mysqli->error);

// Asia
$mysqli->query("INSERT INTO game_release_location (game_release_id, location_id)
    SELECT id, 65 FROM game_release WHERE continent_id = 4")
    or die($mysqli->error);

// Australia
$mysqli->query("INSERT INTO game_release_location (game_release_id, location_id)
    SELECT id, 212 FROM game_release WHERE continent_id = 5")
    or die($mysqli->error);

// Rest of the world
$mysqli->query("INSERT INTO game_release_location (game_release_id, location_id)
    SELECT id, 254 FROM game_release WHERE continent_id = 6")
    or die($mysqli->error);
