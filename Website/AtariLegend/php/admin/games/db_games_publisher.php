<?php
/*
 * Manage publisher relationships to games
 */

require_once __DIR__.'/../../config/common.php';
require_once __DIR__.'/../../config/admin.php';

require_once __DIR__."/../../common/DAO/GameDAO.php";
require_once __DIR__."/../../common/DAO/GameReleaseDAO.php";
require_once __DIR__."/../../common/DAO/PubDevDAO.php";
require_once __DIR__."/../../common/DAO/LocationDAO.php";
require_once __DIR__."/../../common/DAO/ChangeLogDAO.php";

$gameDao = new \AL\Common\DAO\GameDAO($mysqli);
$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);
$pubDevDao = new \AL\Common\DAO\PubDevDao($mysqli);
$locationDao = new \AL\Common\DAO\LocationDao($mysqli);
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
            $new_game_extra_info_id
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
                \AL\Common\Model\Database\ChangeLog::ACTION_UPDATE
            )
        );

        $_SESSION['edit_message'] = "Updated ".$pubdev->getName()." role on ".$game->getName();
        break;

    case "associate_to_release":
        $release = $gameReleaseDao->getRelease($game_release_id);

        $gameReleaseDao->updateRelease(
            $release->getId(),
            $release->getName(),
            $release->getDate(),
            $release->getLicense(),
            ($game_extra_info_id != null && $game_extra_info_id == 1) ? \AL\Common\DAO\GameReleaseDAO::TYPE_BUDGET : $release->getType(),
            $pub_dev_id
        );

        if ($continent_id != null) {
            // The publisher had a continent_id associated to it. We need to
            // convert this into a new entry in game_release_location, using the
            // new location IDs
            $location_id = -1;
            switch ($continent_id) {
                case 1: // Europe
                    $location_id = 120;
                    break;
                case 2: // North America
                    $location_id = 172;
                    break;
                case 3: // South America
                    $location_id = 239;
                    break;
                case 4: // Asia
                    $location_id = 65;
                    break;
                case 5: // Australia
                    $location_id = 212;
                    break;
                case 6: // Rest of the world
                    $location_id = 254;
                    break;
            }

            $locationDao->setLocationsForRelease($release->getId(), array($location_id));
        }

        $changeLogDao->insertChangeLog(
            new \AL\Common\Model\Database\ChangeLog(
                -1,
                "Games",
                $game_id,
                $game->getName(),
                "Release",
                $release->getId(),
                ($release->getName() != null) ? $release->getName() : $game->getName(),
                $_SESSION["user_id"],
                \AL\Common\Model\Database\ChangeLog::ACTION_DELETE
            )
        );

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
        break;
}

header("Location: games_detail.php?game_id=$game_id#gd_publisher_info");
