<?php
require_once __DIR__."/../../config/common.php";
require_once __DIR__."/../../config/admin.php";
require_once __DIR__."/../../config/admin_rights.php";
require_once __DIR__."/../../lib/functions.php";
require_once __DIR__."/../../common/DAO/GameDAO.php";
require_once __DIR__."/../../common/DAO/GameReleaseScanDAO.php";
require_once __DIR__."/../../common/DAO/ChangeLogDAO.php";

$gameDao = new AL\Common\DAO\GameDAO($mysqli);
$gameReleaseScanDao = new AL\Common\DAO\GameReleaseScanDAO($mysqli);
$changeLogDao = new AL\Common\DAO\ChangeLogDAO($mysqli);

$game = $gameDao->getGame($game_id);

switch ($action) {
    case "upload":
        if ($_FILES["scan"] != null) {

            $file = $_FILES["scan"];

            if ($file["error"] == 0) {
                if (in_array($file["type"], array_keys(MIME_TYPES_TO_EXT))) {
                    $imgext = MIME_TYPES_TO_EXT[$file["type"]];

                    $id = $gameReleaseScanDao->addScanToRelease($game_release_id, $type, $imgext, (isset($notes) && !empty($notes)) ? $notes : null);

                    @mkdir($game_release_scan_save_path);
                    move_uploaded_file($file["tmp_name"], $game_release_scan_save_path.$id.".".$imgext);

                    $changeLogDao->insertChangeLog(
                        new \AL\Common\Model\Database\ChangeLog(
                            -1,
                            "Game Release",
                            $game_id,
                            $game->getName(),
                            "Scan",
                            $game_release_id,
                            $type,
                            $_SESSION["user_id"],
                            \AL\Common\Model\Database\ChangeLog::ACTION_INSERT
                        )
                    );
                } else {
                    //FIXME: Unknown type
                }
            } else {
                switch ($file["error"]) {
                    case UPLOAD_ERR_INI_SIZE:
                        $_SESSION['edit_message'] = "File larger than what is configured in PHP.INI (".ini_get("upload_max_filesize").")";
                        break;
                    default:
                        $_SESSION['edit_message'] = "Unknown upload error (code ".$file["error"].")";
                }
            }
        }
    break;

    case "delete":
        $scan = $gameReleaseScanDao->getScan($scan_id);
        $gameReleaseScanDao->deleteScan($scan_id);
        unlink($scan->getFile());

        $changeLogDao->insertChangeLog(
            new \AL\Common\Model\Database\ChangeLog(
                -1,
                "Game Release",
                $game_id,
                $game->getName(),
                "Scan",
                $game_release_id,
                $scan->getType(),
                $_SESSION["user_id"],
                \AL\Common\Model\Database\ChangeLog::ACTION_DELETE
            )
        );
    break;

    // ================ TEMPORARY START
    // Merge Game box scan into a release
    case "merge_game_boxscan":
        // Add box scan to the release
        $id = $gameReleaseScanDao->addScanToRelease($game_release_id, $side == 0 ? 'Box front' : 'Box back', $imgext, null);

        // Move boxscan to the release scans folder
        @mkdir($game_release_scan_save_path);
        rename($game_boxscan_save_path.$game_boxscan_id.".".$imgext, $game_release_scan_save_path.$id.".".$imgext);

        // Delete boxscan from DB
        $stmt = \AL\Db\execute_query(
            "db_games_release_scans.php: Delete Game Box scan",
            $mysqli,
            "DELETE FROM game_boxscan WHERE game_boxscan_id = ?",
            "i", $game_boxscan_id
        );

    break;
    // ================ TEMPORARY END
}

header("Location: games_release_detail.php?game_id=$game_id&release_id=$game_release_id&tab=scans");
