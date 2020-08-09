<?php
// Script to populate the port_id field in the game table from the old game_arcade table

//Let's first loop over the game_stos table
$result1 = $mysqli->query("SELECT * FROM game_arcade")
                    or die("Unable to retrieve the list of game_arcade titles: ".$mysqli->error);

while ($game_arcade = $result1->fetch_array(MYSQLI_BOTH)) {
    //  Now let's see if we have a game for this entry. This is not always the case so it seems.
    $result5 = $mysqli->query("SELECT * FROM game WHERE game_id = $game_arcade[game_id]")
                            or die("Unable to retrieve the game_id from the game table: ".$mysqli->error);
    while ($game = $result5->fetch_array(MYSQLI_BOTH)) {
        $sdbquery = $mysqli->query("UPDATE game SET port_id='1' WHERE game_id='$game_arcade[game_id]'")
            or die("trouble updating game");
    }
}
