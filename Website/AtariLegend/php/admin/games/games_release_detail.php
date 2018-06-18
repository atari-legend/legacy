<?php

include("../../config/common.php");
require_once __DIR__."/../../common/DAO/GameDAO.php";
require_once __DIR__."/../../common/DAO/GameReleaseDAO.php";
require_once __DIR__."/../../common/DAO/ResolutionDAO.php";
require_once __DIR__."/../../common/DAO/SystemDAO.php";

$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);
$gameDao = new \AL\Common\DAO\GameDao($mysqli);
$resolutionDao = new \AL\Common\DAO\ResolutionDao($mysqli);
$systemDao = new \AL\Common\DAO\SystemDao($mysqli);

$release = $gameReleaseDao->getRelease($release_id);

if (isset($release)) {

    // Display release details
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $game = $gameDao->getGame($release->getGameId());

        $smarty->assign('release', $release);
        $smarty->assign('game', $game);

        $smarty->assign('system_incompatible', $systemDao->getIncompatibleSystemsForRelease($release->getId()));
        $smarty->assign('system_enhanced', $systemDao->getEnhancedSystemsForRelease($release->getId()));
        $smarty->assign('release_resolutions', $resolutionDao->getResolutionsForRelease($release->getId()));

        $smarty->assign('license_types', array(
            \AL\Common\DAO\GameReleaseDAO::LICENSE_COMMERCIAL,
            \AL\Common\DAO\GameReleaseDAO::LICENSE_NON_COMMERCIAL
        ));

        $smarty->assign('resolutions', $resolutionDao->getAllResolutions());
        $smarty->assign('systems', $systemDao->getAllSystems());

    // Update release
    } else if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $game = $gameDao->getGame($release->getGameId());

        // Do not store an alternative title if it's identical to the game
        if (strtolower($name) == strtolower($game->getName())) {
            $name = null;
        }

        $gameReleaseDao->updateRelease(
            $release->getId(),
            $name,
            $Date_Year."-01-01",
            $license);

        $systemDao->setIncompatibleSystemsForRelease($release->getId(), isset($system_incompatible) ? $system_incompatible : []);
        $systemDao->setEnhancedSystemsForRelease($release->getId(), isset($system_enhanced) ? $system_enhanced : []);
        $resolutionDao->setResolutionsForRelease($release->getId(), isset($resolution) ? $resolution : []);

        if ($submit_type == "save_and_back") {
            header("Location: games_detail.php?game_id=".$release->getGameId());
        } else {
            header("Location: ?release_id=".$release->getId());
        }
    }

    $smarty->display("file:" . $cpanel_template_folder . "games_release_detail.html");
} else {
    // Release not found
    http_response_code(404);
}

mysqli_close($mysqli);
