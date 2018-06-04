<?php
// 2018-02-26_populate_release_incompatability_addition.php
// Script to populate the incompatibility table with data from the falcon_only
// and STE_only tables.
// What we are doing here is basically taking adding all other systems as
// incompatible with the release that has been tagged as for instance falcon only

$st = 4;
$ste = 2;
$tt = 3;
$falcon = 1;

//
// Lets do falcon First
//

// first fix bug
$mysqli->query("
DELETE FROM game_falcon_only WHERE game_id = 27")
    or die("Error selecting game_faclon_only tables: ".$mysqli->error);

$result3 = $mysqli->query("
SELECT
    game_release.id AS game_release_id
FROM
    game_falcon_only
LEFT JOIN game_release ON (game_release.game_id = game_falcon_only.game_id )")
or die("Unable to retrieve the list of falcon only titles: ".$mysqli->error);

while ($falcon_only = $result3->fetch_array(MYSQLI_BOTH)) {
    $game_release_id = $falcon_only['game_release_id'];

    // Insert incompatible systems into the incompatibility table
    // ST
    $mysqli->query("
    INSERT INTO game_release_system_incompatible
        (system_id,game_release_id)
    VALUES
        ($st, $game_release_id)")
    or die("Error error inserting ST incompabilities: ".$mysqli->error);

    // STE
    $mysqli->query("
    INSERT INTO game_release_system_incompatible
        (system_id,game_release_id)
    VALUES
        ($ste, $game_release_id)")
    or die("Error error inserting STE incompabilities: ".$mysqli->error);

    // TT
    $mysqli->query("
    INSERT INTO game_release_system_incompatible
        (system_id,game_release_id)
    VALUES
        ($tt, $game_release_id)")
    or die("Error error inserting STE incompabilities: ".$mysqli->error);
}

//
// Next do STE Only
//

$result2 = $mysqli->query("
SELECT
    game_release.id AS game_release_id
FROM
    game_ste_only
LEFT JOIN game_release ON (game_release.game_id = game_ste_only.game_id )")
or die("Unable to retrieve the list of ste only titles: ".$mysqli->error);

while ($ste_only = $result2->fetch_array(MYSQLI_BOTH)) {
    $game_release_id = $ste_only['game_release_id'];

    // Insert incompatible systems into the incompatibility table
    // ST
    $mysqli->query("
    INSERT INTO game_release_system_incompatible
        (system_id,game_release_id)
    VALUES
        ($st, $game_release_id)")
    or die("Error error inserting ST incompabilities: ".$mysqli->error);

    // Falcon
    $mysqli->query("
    INSERT INTO game_release_system_incompatible
        (system_id,game_release_id)
    VALUES
        ($falcon, $game_release_id)")
    or die("Error error inserting Falcon incompabilities: ".$mysqli->error);

    // TT
    $mysqli->query("
    INSERT INTO game_release_system_incompatible
        (system_id,game_release_id)
    VALUES
        ($tt, $game_release_id)")
    or die("Error error inserting TT incompabilities: ".$mysqli->error);
}
