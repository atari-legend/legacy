<?php

include("../../config/common.php");
require_once __DIR__."/../../common/DAO/GameDAO.php";
require_once __DIR__."/../../common/DAO/GameReleaseDAO.php";
require_once __DIR__."/../../common/DAO/ResolutionDAO.php";
require_once __DIR__."/../../common/DAO/SystemDAO.php";
require_once __DIR__."/../../common/DAO/ChangeLogDAO.php";

$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);
$gameDao = new \AL\Common\DAO\GameDao($mysqli);
$resolutionDao = new \AL\Common\DAO\ResolutionDao($mysqli);
$systemDao = new \AL\Common\DAO\SystemDao($mysqli);
$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $smarty->assign('license_types', array(
        \AL\Common\DAO\GameReleaseDAO::LICENSE_COMMERCIAL,
        \AL\Common\DAO\GameReleaseDAO::LICENSE_NON_COMMERCIAL
    ));

    $smarty->assign('resolutions', $resolutionDao->getAllResolutions());
    $smarty->assign('systems', $systemDao->getAllSystems());

    // Edit existing release
    if (isset($release_id)) {
        $release = $gameReleaseDao->getRelease($release_id);
        $game = $gameDao->getGame($release->getGameId());
        $smarty->assign('game_screenshot', $gameDao->getRandomScreenshot($game->getId()));

        $smarty->assign('release', $release);
        $smarty->assign('release_id', $release->getId());
        $smarty->assign('game', $game);
        $smarty->assign('game_releases', $gameReleaseDao->getReleasesForGame($game->getId()));

        $smarty->assign('system_incompatible', $systemDao->getIncompatibleSystemsForRelease($release->getId()));
        $smarty->assign('system_enhanced', $systemDao->getEnhancedSystemsForRelease($release->getId()));
        $smarty->assign('release_resolutions', $resolutionDao->getResolutionsForRelease($release->getId()));
    } else {
        // Creating a new release
        $game = $gameDao->getGame($game_id);
        $smarty->assign('game', $game);
        $smarty->assign('game_releases', $gameReleaseDao->getReleasesForGame($game->getId()));

        $smarty->assign('release', new AL\Common\Model\Game\GameRelease(-1, $game->getId(), '', '', ''));

        $smarty->assign('system_incompatible', []);
        $smarty->assign('system_enhanced', []);
        $smarty->assign('release_resolutions', []);

    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Update existing release or create a new one

    $game = $gameDao->getGame($game_id);

    // Do not store an alternative title if it's identical to the game
    if (strtolower($name) == strtolower($game->getName())) {
        $name = null;
    }

    $date = $Date_Year."-01-01";
    if ($Date_Year == "") {
        $date = null;
    }

    if ($release_id > -1) {
        $gameReleaseDao->updateRelease(
            $release_id,
            $name,
            $date,
            $license);

        $changeLogDao->insertChangeLog(
            new \AL\Common\Model\Database\ChangeLog(
                -1,
                "Games",
                $game_id,
                $game->getName(),
                "Release",
                $release_id,
                ($name == '') ? $game->getName() : $name,
                $_SESSION["user_id"],
                \AL\Common\Model\Database\ChangeLog::ACTION_UPDATE
            )
        );
    } else {
        $release_id = $gameReleaseDao->addReleaseForGame($game_id, $name, $Date_Year."-01-01");

        $changeLogDao->insertChangeLog(
            new \AL\Common\Model\Database\ChangeLog(
                -1,
                "Games",
                $game_id,
                $game->getName(),
                "Release",
                $release_id,
                ($name == '') ? $game->getName() : $name,
                $_SESSION["user_id"],
                \AL\Common\Model\Database\ChangeLog::ACTION_INSERT
            )
        );
}

    $systemDao->setIncompatibleSystemsForRelease($release_id, isset($system_incompatible) ? $system_incompatible : []);
    $systemDao->setEnhancedSystemsForRelease($release_id, isset($system_enhanced) ? $system_enhanced : []);
    $resolutionDao->setResolutionsForRelease($release_id, isset($resolution) ? $resolution : []);

    if ($submit_type == "save_and_back") {
        header("Location: games_detail.php?game_id=".$game_id);
    } else {
        header("Location: ?release_id=".$release_id);
    }
}

$smarty->display("file:" . $cpanel_template_folder . "games_release_detail.html");

mysqli_close($mysqli);
