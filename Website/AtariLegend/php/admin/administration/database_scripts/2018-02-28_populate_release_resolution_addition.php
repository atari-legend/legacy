<?php
// 2018-02-28_populate_release_resolution_addition.php
// Script to populate the resolution table from the old game_falcon_rgb,
// game_falcon_vga and game_mono tables.

//
// Lets do mono First
//

// first fix bug
$mysqli->query("
DELETE FROM game_mono WHERE game_id = 4072")
    or die("Error selecting game_mono tables: ".$mysqli->error);
$mysqli->query("
DELETE FROM game_mono WHERE game_id = 5313")
    or die("Error selecting game_mono tables: ".$mysqli->error);
$mysqli->query("
DELETE FROM game_mono WHERE game_id = 5386")
    or die("Error selecting game_mono tables: ".$mysqli->error);
$mysqli->query("
DELETE FROM game_mono WHERE game_id = 5741")
    or die("Error selecting game_mono tables: ".$mysqli->error);

$result3 = $mysqli->query("
SELECT
    game_release.id AS game_release_id
FROM
    game_mono
LEFT JOIN game_release ON (game_release.game_id = game_mono.game_id )")
or die("Unable to retrieve the list of falcon only titles: ".$mysqli->error);

while ($game_mono = $result3->fetch_array(MYSQLI_BOTH)) {
    $game_release_id = $game_mono['game_release_id'];

    // Insert mono/ST Highrez
    $mysqli->query("
    INSERT INTO game_release_resolution
        (resolution_id,game_release_id)
    VALUES
        (3, $game_release_id)")
    or die("Error error inserting ST high rez: ".$mysqli->error);
}

//
// Next do Falcon RGB
//

$result2 = $mysqli->query("
SELECT
    game_release.id AS game_release_id
FROM
    game_falcon_rgb
LEFT JOIN game_release ON (game_release.game_id = game_falcon_rgb.game_id )")
or die("Unable to retrieve the list of falcon rgb titles: ".$mysqli->error);

while ($falcon_rgb = $result2->fetch_array(MYSQLI_BOTH)) {
    $game_release_id = $falcon_rgb['game_release_id'];

    // Insert falcon rgb
    $mysqli->query("
    INSERT INTO game_release_resolution
        (resolution_id,game_release_id)
    VALUES
        (4, $game_release_id)")
    or die("Error error inserting falcon rgb: ".$mysqli->error);
}

//
// and finally falcon vga
//

$result4 = $mysqli->query("
SELECT
    game_release.id AS game_release_id
FROM
    game_falcon_vga
LEFT JOIN game_release ON (game_release.game_id = game_falcon_vga.game_id )")
or die("Unable to retrieve the list of falcon vga titles: ".$mysqli->error);

while ($falcon_vga = $result4->fetch_array(MYSQLI_BOTH)) {
    $game_release_id = $falcon_vga['game_release_id'];

    // Insert falcon rgb
    $mysqli->query("
    INSERT INTO game_release_resolution
        (resolution_id,game_release_id)
    VALUES
        (5, $game_release_id)")
    or die("Error error inserting falcon vga: ".$mysqli->error);
}
