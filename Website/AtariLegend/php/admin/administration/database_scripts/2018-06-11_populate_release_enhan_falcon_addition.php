<?php
// 2018-06-11_populate_release_enhan_falcon_addition.php
// Script to populate the release enhancement table with the FALCON entries

//Let's first loop over the falcon enhancement table
$result1 = $mysqli->query("SELECT * FROM game_falcon_enhan")
                            or die("Unable to retrieve the list of falcon enhanced titles: ".$mysqli->error);

while ($falcon_enhan = $result1->fetch_array(MYSQLI_BOTH)) {
    
//  Now let's see if we have a game release for this entry. This is not always the case so it seems.
    $result2 = $mysqli->query("SELECT * FROM game_release WHERE game_id = $falcon_enhan[game_id]")
                            or die("Unable to retrieve the game_id from the game release table: ".$mysqli->error);
    
    while ($game_release = $result2->fetch_array(MYSQLI_BOTH)) {
        $mysqli->query("INSERT INTO game_release_system_enhanced(system_id, game_release_id)
                 VALUES ('1', $game_release[id])") or die("Error error inserting Falcon Enhancement: ".$mysqli->error);
    }
}
