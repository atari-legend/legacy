<?php
// Script to populate the game_programming_language table from the old game_stos,
// game_stac, game_seuck

//
// Lets do STOS First
//

//Let's first loop over the game_stos table
$result1 = $mysqli->query("SELECT * FROM game_stos")
                            or die("Unable to retrieve the list of game_stos titles: ".$mysqli->error);

while ($game_stos = $result1->fetch_array(MYSQLI_BOTH)) {
    //  Now let's see if we have a game for this entry. This is not always the case so it seems.
    $result5 = $mysqli->query("SELECT * FROM game WHERE game_id = $game_stos[game_id]")
                            or die("Unable to retrieve the game_id from the game table: ".$mysqli->error);

    while ($game = $result5->fetch_array(MYSQLI_BOTH)) {
        $game_id = $game['game_id'];

        // Insert STOS
        $mysqli->query("
        INSERT INTO game_programming_language
            (game_id, programming_language_id)
        VALUES
            ($game_id, 1)")
        or die("Error error inserting STOS: ".$mysqli->error);
    }
}

//
// Next do STAC
//

/* $result2 = $mysqli->query("SELECT * FROM game_stac")
                            or die("Unable to retrieve the list of game_stac titles: ".$mysqli->error);

while ($game_stac = $result2->fetch_array(MYSQLI_BOTH)) {
    $game_id = $game_stac['game_id'];

    // Insert STAC
    $mysqli->query("
     INSERT INTO game_programming_language
            (game_id, programming_language_id)
        VALUES
            ($game_id, 3)")
        or die("Error error inserting STAC: ".$mysqli->error);
}

//
// and finally SEUCK
//

$result4 = $mysqli->query("SELECT * FROM game_seuck")
                            or die("Unable to retrieve the list of game_seuck titles: ".$mysqli->error);

while ($game_seauck = $result4->fetch_array(MYSQLI_BOTH)) {
    $game_id = $game_seauck['game_id'];

    // Insert SEUCK
   $mysqli->query("
     INSERT INTO game_programming_language
            (game_id, programming_language_id)
        VALUES
            ($game_id, 2)")
        or die("Error error inserting STAC: ".$mysqli->error);
} */
