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

//Let's first loop over the Falcon only table
$result3 = $mysqli->query("SELECT * FROM game_falcon_only")
                            or die("Unable to retrieve the list of Falcon only titles: ".$mysqli->error);

while ($falcon_only = $result3->fetch_array(MYSQLI_BOTH)) {

    //  Now let's see if we have a game release for this entry. This is not always the case so it seems.
    $result4 = $mysqli->query("SELECT * FROM game_release WHERE game_id = $falcon_only[game_id]")
                            or die("Unable to retrieve the game_id from the game release table: ".$mysqli->error);

    while ($game_release = $result4->fetch_array(MYSQLI_BOTH)) {
        $game_release_id = $game_release['id'];

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
}

//
// Next do STE Only
//

//Let's first loop over the STe only table
$result1 = $mysqli->query("SELECT * FROM game_ste_only")
                            or die("Unable to retrieve the list of STe only titles: ".$mysqli->error);

while ($ste_only = $result1->fetch_array(MYSQLI_BOTH)) {

//  Now let's see if we have a game release for this entry. This is not always the case so it seems.
    $result2 = $mysqli->query("SELECT * FROM game_release WHERE game_id = $ste_only[game_id]")
                            or die("Unable to retrieve the game_id from the game release table: ".$mysqli->error);

    while ($game_release = $result2->fetch_array(MYSQLI_BOTH)) {
        $game_release_id = $game_release['id'];

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
}
