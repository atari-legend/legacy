<?php
// 2018-02-28_populate_release_license_addition.php
// Script to populate the license column in game release

//Let's first loop over the game_free table
$result1 = $mysqli->query("SELECT * FROM game_free")
                            or die("Unable to retrieve the list of game_free titles: ".$mysqli->error);

while ($game_free = $result1->fetch_array(MYSQLI_BOTH)) {
    
    //  Now let's see if we have a game release for this entry. This is not always the case so it seems.
    $result2 = $mysqli->query("SELECT * FROM game_release WHERE game_id = $game_free[game_id]")
                            or die("Unable to retrieve the game_id from the game release table: ".$mysqli->error);

    while ($game_release = $result2->fetch_array(MYSQLI_BOTH)) {

        $game_release_id = $game_release['id'];
        
        // Update license
        $mysqli->query("
        UPDATE game_release SET license = 'Non-Commercial'
        WHERE id = $game_release_id")
        or die("Error Updating license: ".$mysqli->error);
    }
}

$mysqli->query("UPDATE game_release SET license = 'Commercial' WHERE license IS NULL") or die("Error Updating license: ".$mysqli->error);
