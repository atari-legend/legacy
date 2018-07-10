<?php
/*
 * Manage publisher relationships to games
 */

require_once __DIR__.'/../../config/common.php';
require_once __DIR__.'/../../config/admin.php';

require_once __DIR__."/../../common/DAO/GameDAO.php";
require_once __DIR__."/../../common/DAO/PubDevDAO.php";
require_once __DIR__."/../../common/DAO/ChangeLogDAO.php";

$gameDao = new \AL\Common\DAO\GameDAO($mysqli);
$pubDevDao = new \AL\Common\DAO\PubDevDao($mysqli);
$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);

$game = $gameDao->getGame($game_id);
$pubdev = $pubDevDao->getPubDev($pub_dev_id);

switch ($action) {
    case "remove":
        $gameDao->removePublisher(
            $game_id,
            $pub_dev_id,
            $continent_id,
            $game_extra_info_id
        );

        $changeLogDao->insertChangeLog(
            new \AL\Common\Model\Database\ChangeLog(
                -1,
                "Games",
                $game_id,
                $game->getName(),
                "Publisher",
                $pub_dev_id,
                $pubdev->getName(),
                $_SESSION["user_id"],
                \AL\Common\Model\Database\ChangeLog::ACTION_DELETE
            )
        );

        $_SESSION['edit_message'] = "Removed ".$pubdev->getName()." from ".$game->getName();
        break;

    case "add":
        $gameDao->addPublisher(
            $game_id,
            $pub_dev_id,
            $continent_id,
            $game_extra_info_id
        );

        $changeLogDao->insertChangeLog(
            new \AL\Common\Model\Database\ChangeLog(
                -1,
                "Games",
                $game_id,
                $game->getName(),
                "Publisher",
                $pub_dev_id,
                $pubdev->getName(),
                $_SESSION["user_id"],
                \AL\Common\Model\Database\ChangeLog::ACTION_INSERT
            )
        );

        $_SESSION['edit_message'] = "Added ".$pubdev->getName()." to ".$game->getName();
        break;

    case "update":
        $gameDao->updatePublisher(
            $game_id,
            $pub_dev_id,
            $continent_id,
            $game_extra_info_id,
            $new_continent_id,
            $new_game_extra_info_id);

        $changeLogDao->insertChangeLog(
            new \AL\Common\Model\Database\ChangeLog(
                -1,
                "Games",
                $game_id,
                $game->getName(),
                "Publisher",
                $pub_dev_id,
                $pubdev->getName(),
                $_SESSION["user_id"],
                \AL\Common\Model\Database\ChangeLog::ACTION_UPDATE
            )
        );

        $_SESSION['edit_message'] = "Updated ".$pubdev->getName()." role on ".$game->getName();
        break;
}

header("Location: games_detail.php?game_id=$game_id#gd_publisher_info");
?>
