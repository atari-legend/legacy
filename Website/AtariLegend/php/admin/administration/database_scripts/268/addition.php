<?php
require_once __DIR__."/../../../../lib/Db.php";
require_once __DIR__."/../../../../config/config.php";
require_once __DIR__."/../../../../common/DAO/GameReleaseScanDAO.php";

// Addition script to migrate boxscans of games that only have one
// release into the release itself

$gameReleaseScanDao = new AL\Common\DAO\GameReleaseScanDAO($mysqli);

@mkdir($game_release_scan_save_path);

// Find games with a single release
$stmt = \AL\Db\execute_query(
    "migrate_boxscans_to_single_release: Get single release games",
    $mysqli,
    "SELECT
        game_release.game_id,
        game_release.id,
        COUNT(id) AS C
    FROM
        game_release
    LEFT JOIN game ON game_release.game_id = game.game_id
    GROUP BY
        game_release.game_id
    HAVING
        C = 1",
    null,
    null
);

$stmt->store_result();

\AL\Db\bind_result(
    "migrate_boxscans_to_single_release: Get single release games",
    $stmt,
    $game_id,
    $game_release_id,
    $count
);

while ($stmt->fetch()) {
    // Find boxscans of that game
    $stmt2 = \AL\Db\execute_query(
        "migrate_boxscans_to_single_release: Find box scans for a game",
        $mysqli,
        "SELECT game_boxscan_id, imgext, game_boxscan_side FROM game_boxscan
        WHERE game_id = ?",
        "i",
        $game_id
    );

    $stmt2->store_result();

    \AL\Db\bind_result(
        "migrate_boxscans_to_single_release: Get single release games",
        $stmt2,
        $game_boxscan_id,
        $imgext,
        $side
    );

    while ($stmt2->fetch()) {
        // For each boxscan, create a new game_release_scan
        $id = $gameReleaseScanDao->addScanToRelease($game_release_id, $side == 0 ? 'Box front' : 'Box back', $imgext, null);
        // Move the image in the new location
        rename($game_boxscan_save_path.$game_boxscan_id.".".$imgext, $game_release_scan_save_path.$id.".".$imgext);
        // Delete our game_boxscan row
        $mysqli->query("DELETE FROM game_boxscan WHERE game_boxscan_id = $game_boxscan_id");
    }

    $stmt2->close();
}

$stmt->close();
