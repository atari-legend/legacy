<?php
/***************************************************************************
 *                                autocomplete.php
 *                            --------------------------
 *   begin                : Saturday, October 14 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : nicolas+github@guillaumin.me
 *
 ***************************************************************************

 ***************************************************************************
 * Auto-complete backend for the cpanel side, requiring authentication
 **************************************************************************/

include("../../config/common.php");
include("../../config/connect.php");
include("../../config/admin.php");

$term = $_GET["term"];
$extraParams = $_GET["extraParams"];
$json = array();

switch ($extraParams) {
    case "admin-user":
        $stmt = $mysqli->prepare(
            "SELECT user_id, userid
            FROM users
            WHERE LOWER(userid) LIKE CONCAT('%',LOWER(?),'%')"
        )
        or
        die("Error querying users: ".$mysqli->error);

        $stmt->bind_param("s", $term);
        $stmt->execute();
        $stmt->bind_result($user_id, $userid);

        // phpcs:disable Generic.WhiteSpace.ScopeIndent
        while ($stmt->fetch()) {
            array_push(
                $json,
                array(
                    "value" => $user_id,
                    "label" => $userid
                )
            );
        }
        // phpcs:enable
        $stmt->close();
        break;

    case "individual":
        $stmt = $mysqli->prepare(
            "SELECT ind_id, ind_name
            FROM individuals
            WHERE LOWER(ind_name) LIKE CONCAT('%',LOWER(?),'%')"
        )
        or
        die("Error querying individuals: ".$mysqli->error);

        $stmt->bind_param("s", $term);
        $stmt->execute();
        $stmt->bind_result($ind_id, $ind_name);

        // phpcs:disable Generic.WhiteSpace.ScopeIndent
        while ($stmt->fetch()) {
            array_push(
                $json,
                array(
                    "value" => $ind_id,
                    "label" => $ind_name
                )
            );
        }
        // phpcs:enable
        $stmt->close();
        break;

    case "game":
        $stmt = $mysqli->prepare(
            "SELECT game_id, game_name
            FROM game
            WHERE LOWER(game_name) LIKE CONCAT('%',LOWER(?),'%')"
        )
        or
        die("Error querying games: ".$mysqli->error);

        $stmt->bind_param("s", $term);
        $stmt->execute();
        $stmt->bind_result($game_id, $game_name);

        // phpcs:disable Generic.WhiteSpace.ScopeIndent
        while ($stmt->fetch()) {
            array_push(
                $json,
                array(
                    "value" => $game_id,
                    "label" => $game_name
                )
            );
        }
        // phpcs:enable
        $stmt->close();
        break;

    case "game_not_in_series":
        $stmt = $mysqli->prepare(
            "
            SELECT game_id, game_name
            FROM game
            WHERE game_series_id IS NULL
            AND LOWER(game_name) LIKE CONCAT('%',LOWER(?),'%')"
        )
        or
        die("Error querying games: ".$mysqli->error);

        $stmt->bind_param("s", $term);
        $stmt->execute();
        $stmt->bind_result($game_id, $game_name);

        // phpcs:disable Generic.WhiteSpace.ScopeIndent
        while ($stmt->fetch()) {
            array_push(
                $json,
                array(
                    "value" => $game_id,
                    "label" => $game_name
                )
            );
        }
        // phpcs:enable
        $stmt->close();
        break;

    case "pub_dev":
        $stmt = $mysqli->prepare(
            "SELECT pub_dev_id, pub_dev_name
            FROM pub_dev
            WHERE LOWER(pub_dev_name) LIKE CONCAT('%',LOWER(?),'%')"
        )
        or
        die("Error querying pub_dev: ".$mysqli->error);

        $stmt->bind_param("s", $term);
        $stmt->execute();
        $stmt->bind_result($pub_dev_id, $pub_dev_name);

        // phpcs:disable Generic.WhiteSpace.ScopeIndent
        while ($stmt->fetch()) {
            array_push(
                $json,
                array(
                    "value" => $pub_dev_id,
                    "label" => $pub_dev_name
                )
            );
        }
        // phpcs:enable
        $stmt->close();
        break;
}

header("Content-Type: application/json");
echo json_encode($json);
