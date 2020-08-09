<?php

// Select all games that have a single release and a single publisher
$result = $mysqli->query("
    SELECT DISTINCT game_id FROM game
    WHERE game_id IN (
        SELECT
            game_id
        FROM
            game_release
        GROUP BY
            game_id
        HAVING
            COUNT(game_id) = 1
    )
    AND game_id IN (
        SELECT
            game_id
        FROM
            game_publisher
        GROUP BY
            game_id
        HAVING
            COUNT(game_id) = 1
    )
    ") or die($mysqli->error);

while ($games = $result->fetch_array(MYSQLI_BOTH)) {
    $game_id = $games['game_id'];

    // Select the single publisher information for this game
    $publisher_result = $mysqli->query("
        SELECT pub_dev_id, continent_id, game_extra_info_id
        FROM game_publisher
        WHERE game_id = $game_id")
        or die($mysqli->error);
    $publisher = $publisher_result->fetch_array(MYSQLI_BOTH) or die($mysqli->error);

    $continent_id = 'NULL';
    if ($publisher['continent_id'] != null) {
        $continent_id = $publisher['continent_id'];
    }

    $type = 'NULL';
    if ($publisher['game_extra_info_id'] == 1) {
        $type = "'Budget'";
    }

    // Since there's a single release, we can update it directly
    $mysqli->query("
        UPDATE game_release
        SET pub_dev_id = ".$publisher['pub_dev_id'].",
        continent_id = $continent_id,
        type = $type
        WHERE game_id = $game_id")
        or die("Failed to update game $game_id: ".$mysqli->error);

    // Remove the publisher we just merged
    $mysqli->query("DELETE FROM game_publisher WHERE pub_dev_id = ".$publisher['pub_dev_id']." AND game_id = $game_id")
        or die($mysqli->error);
}
