<?php
require_once __DIR__."/../../config/common.php";
require_once __DIR__."/../../config/admin.php";
require_once __DIR__."/../../config/admin_rights.php";
require_once __DIR__."/../../lib/Db.php";

$stmt = \AL\Db\execute_query(
    "games_boxscans_to_merge.php: Get games with boxscans",
    $mysqli,
    "SELECT
        game.game_id,
        game.game_name,
        game_boxscan_id,
        imgext
    FROM
        game_boxscan
    LEFT JOIN game ON game.game_id = game_boxscan.game_id",
    null, null
);

\AL\Db\bind_result(
    "games_boxscans_to_merge.php: Get games with boxscans",
    $stmt,
    $game_id, $game_name, $game_boxscan_id, $game_boxscan_imgext
);

$smarty->assign('boxscans', []);
while ($stmt->fetch()) {
    $smarty->append('boxscans', array(
        "game_id" => $game_id,
        "game_name" => $game_name,
        "game_boxscan_id" => $game_boxscan_id,
        "game_boxscan_imgext" => $game_boxscan_imgext
    ));
}
$stmt->close();

$smarty->display("file:" . $cpanel_template_folder . "games_boxscans_to_merge.html");

