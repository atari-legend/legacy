<?php
// Script to populate the game_engine table from the old game_stac and game_seuck

//
// let's do STAC first
//

$result2 = $mysqli->query("SELECT * FROM game_stac")
                            or die("Unable to retrieve the list of game_stac titles: ".$mysqli->error);

while ($game_stac = $result2->fetch_array(MYSQLI_BOTH)) {
    $game_id = $game_stac['game_id'];

    // Insert STAC
    $mysqli->query("
     INSERT INTO game_engine
            (game_id, engine_id)
        VALUES
            ($game_id, 2)")
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
     INSERT INTO game_engine
            (game_id, engine_id)
        VALUES
            ($game_id, 1)")
        or die("Error error inserting STAC: ".$mysqli->error);
}
