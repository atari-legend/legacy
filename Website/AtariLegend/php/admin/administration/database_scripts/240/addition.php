<?php
// Script to populate the game_release_memory_minimum table

$result1 = $mysqli->query("SELECT * FROM game_release")
                            or die("Unable to retrieve the list of game_release titles: ".$mysqli->error);

while ($game_release = $result1->fetch_array(MYSQLI_BOTH)) {
    
    if ($game_release['memory_id'] == null){    
    } else {
        $mysqli->query("INSERT INTO game_release_memory_minimum (release_id, memory_id) VALUES ($game_release[id], $game_release[memory_id])")
        or die("Error inserting minmum_memory: ".$mysqli->error);
    }
}
