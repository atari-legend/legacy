<?php
// Script to populate the status field of the game release table

//
// let's do game_unfinished
//

$result1 = $mysqli->query("SELECT * FROM game_unfinished")
                            or die("Unable to retrieve the list of game_unfinished titles: ".$mysqli->error);

while ($game_unfinished = $result1->fetch_array(MYSQLI_BOTH)) {
    $game_id = $game_unfinished['game_id'];

    // Insert unfinished
    $mysqli->query("UPDATE game_release SET status = 'Unfinished' WHERE game_id = $game_id")
        or die("Error inserting unfinished releases: ".$mysqli->error);
}

//
// let's do game_development
//

$result2 = $mysqli->query("SELECT * FROM game_development")
                            or die("Unable to retrieve the list of game_development titles: ".$mysqli->error);

while ($game_development = $result2->fetch_array(MYSQLI_BOTH)) {
    $game_id = $game_development['game_id'];

    // Insert unfinished
    $mysqli->query("UPDATE game_release SET status = 'Development' WHERE game_id = $game_id")
        or die("Error inserting unfinished releases: ".$mysqli->error);
}


//
// let's do game_unreleased
//

$result3 = $mysqli->query("SELECT * FROM game_unreleased")
                            or die("Unable to retrieve the list of game_unreleased titles: ".$mysqli->error);

while ($game_unreleased = $result3->fetch_array(MYSQLI_BOTH)) {
    $game_id = $game_unreleased['game_id'];

    // Insert game_unreleased
    $mysqli->query("UPDATE game_release SET status = 'Unreleased' WHERE game_id = $game_id")
        or die("Error inserting unfinished releases: ".$mysqli->error);
}

