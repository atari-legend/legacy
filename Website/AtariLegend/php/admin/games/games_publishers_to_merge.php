<?php

include("../../config/common.php");
include("../../config/admin.php");
require_once __DIR__."/../../lib/Db.php" ;

$stmt = \AL\Db\execute_query(
    "games_publishers_to_merge",
    $mysqli,
    "SELECT * FROM
    (
        SELECT
            game.game_id,
            game.game_name,
            pub_dev.pub_dev_id,
            pub_dev.pub_dev_name,
            continent.continent_name,
            developer_role.role,
            ''
        FROM
            game
        LEFT JOIN game_publisher ON game_publisher.game_id = game.game_id
        LEFT JOIN pub_dev ON game_publisher.pub_dev_id = pub_dev.pub_dev_id
        LEFT JOIN continent ON game_publisher.continent_id = continent.continent_id
        -- `developer_role` is used here, even if it's a publisher, because
        -- it was the table that held the publisher `game_extra_info` previously
        -- This will disappear once all publishers linked to games have been merged
        LEFT JOIN developer_role ON game_publisher.game_extra_info_id = developer_role.id

        UNION

        SELECT
            game.game_id,
            game.game_name,
            '',
            '',
            '',
            '',
            YEAR(game_release.date)
        FROM
            game
        LEFT JOIN game_release ON game_release.game_id = game.game_id
    ) AS T
    WHERE game_id IN
    (
        SELECT
            game_id
        FROM
            game_publisher
    )
    ORDER BY
        game_name ASC",
    null, null
);

\AL\Db\bind_result(
    "games_publishers_to_merge",
    $stmt,
    $game_id, $game_name, $pub_dev_id, $pub_dev_name, $continent_name, $developer_role, $release_date
);

$previous_game_id = -1;
while ($stmt->fetch()) {
    if ($previous_game_id != $game_id) {
        $smarty->append('rows', 'separator');
        $previous_game_id = $game_id;
    }

    $smarty->append('rows', array(
        'game_id' => $game_id,
        'game_name' => $game_name,
        'pub_dev_id' => $pub_dev_id,
        'pub_dev_name' => $pub_dev_name,
        'continent_name' => $continent_name,
        'developer_role' => $developer_role,
        'release_date' => $release_date
    ));
}

$stmt->close();

$smarty->display("file:" . $cpanel_template_folder . "games_publishers_to_merge.html");

mysqli_close($mysqli);
