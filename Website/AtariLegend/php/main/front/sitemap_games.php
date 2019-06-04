<?php
/**
 * Generate a sitemap for games starting with a given letter
 *
 * This generates a sitemap providing links to each individual games starting
 * with a specific letter or number
 *
 * In addition, the special value '-' generates a list of all game that start
 * with anything else than a letter or number (e.g. 'EE's Lost His Marbles)
 */

require "../../config/common.php";

// Letter parameter is mandatory, and must only have one character
// which is a letter, number or '-'
if (! isset($letter) || !preg_match("/^[a-z0-9-]$/i", $letter)) {
    http_response_code(400);
    exit();
}

if ($letter == "-") {
    // Special case: Select all games that don't start with a letter or number
    $stmt = $mysqli->prepare(
        "SELECT game_id FROM game WHERE LOWER(game_name) "
        ."NOT REGEXP('^[a-zA-Z0-9]') ORDER BY game_id"
    )
        or die($mysqli->error);
} else {
    // Select all games stating with the given letter or number
    $stmt = $mysqli->prepare(
        "SELECT game_id FROM game WHERE LOWER(game_name) "
        ."LIKE CONCAT(LOWER(?), '%') ORDER BY game_id"
    )
        or die($mysqli->error);
    $stmt->bind_param("s", $letter)
        or die($mysqli->error);
}

$stmt->execute() or die($mysqli->error);
$stmt->bind_result($game_id) or die($mysqli->error);

// Fetch all game ids for the letter
$game_ids = [];
while ($stmt->fetch()) {
    $game_ids[] = $game_id;
}

$stmt->close();

header("Content-Type: application/xml");

$smarty->assign("game_ids", $game_ids);
$smarty->display("file:${mainsite_template_folder}front/sitemap_games.xml");
