<?php

// Select all data from game_series_cross
$resultset = $mysqli->query("SELECT game_id, game_series_id FROM game_series_cross")
    or die($mysqli->error);

// Update all games
while ($game_series = $resultset->fetch_array(MYSQLI_BOTH)) {
    $game_id = $game_series["game_id"];
    $game_series_id = $game_series["game_series_id"];

    $stmt = $mysqli->prepare("UPDATE game SET game_series_id = ? WHERE game_id = ?")
        or die($mysqli->error);
    $stmt->bind_param("ii", $game_series_id, $game_id)
        or die($mysqli->error);

    $stmt->execute() or die($mysqli->error);

    $stmt->close();
}

// Finally delete the game_series_cross table
$mysqli->query("DROP TABLE game_series_cross") or die($mysqli->error);
