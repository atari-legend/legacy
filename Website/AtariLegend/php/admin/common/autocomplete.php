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
        $stmt = $mysqli->prepare("
            SELECT user_id, userid
            FROM users
            WHERE permission = 1
            AND LOWER(userid) LIKE CONCAT('%',LOWER(?),'%')")
        or die("Error querying users: ".$mysqli->error);

        $stmt->bind_param("s", $term);
        $stmt->execute();
        $stmt->bind_result($user_id, $userid);

        while ($stmt->fetch()) {
            array_push($json, array(
                "value" => $user_id,
                "label" => $userid)
            );
        }
        
        $stmt->close();

        break;
}

header("Content-Type: application/json");
echo json_encode($json);
?>
