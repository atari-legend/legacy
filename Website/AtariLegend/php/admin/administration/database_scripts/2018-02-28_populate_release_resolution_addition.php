<?php
// 2018-02-28_populate_release_resolution_addition.php
// Script to populate the resolution table from the old game_falcon_rgb,
// game_falcon_vga and game_mono tables.

//
// Lets do mono First
//

//Let's first loop over the game_mono table
$result1 = $mysqli->query("SELECT * FROM game_mono")
                            or die("Unable to retrieve the list of game_mono titles: ".$mysqli->error);

while ($game_mono = $result1->fetch_array(MYSQLI_BOTH)) {
    //  Now let's see if we have a game release for this entry. This is not always the case so it seems.
    $result5 = $mysqli->query("SELECT * FROM game_release WHERE game_id = $game_mono[game_id]")
                            or die("Unable to retrieve the game_id from the game release table: ".$mysqli->error);

    while ($game_release = $result5->fetch_array(MYSQLI_BOTH)) {

        $game_release_id = $game_release['id'];

        // Insert mono/ST Highrez
        $mysqli->query("
        INSERT INTO game_release_resolution
            (resolution_id,game_release_id)
        VALUES
            (3, $game_release_id)")
        or die("Error error inserting ST high rez: ".$mysqli->error);
    }
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
