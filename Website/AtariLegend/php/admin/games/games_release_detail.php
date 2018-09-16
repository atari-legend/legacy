<?php

include("../../config/common.php");
include("../../config/admin.php");
include("../../admin/tiles/tile_shortlog.php");

require_once __DIR__."/../../common/DAO/GameDAO.php";
require_once __DIR__."/../../common/DAO/GameReleaseDAO.php";
require_once __DIR__."/../../common/DAO/ResolutionDAO.php";
require_once __DIR__."/../../common/DAO/SystemDAO.php";
require_once __DIR__."/../../common/DAO/PubDevDAO.php";
require_once __DIR__."/../../common/DAO/LocationDAO.php";
require_once __DIR__."/../../common/DAO/ChangeLogDAO.php";
require_once __DIR__."/../../common/DAO/GameReleaseAkaDAO.php";
require_once __DIR__."/../../common/DAO/LanguageDAO.php";

$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);
$gameDao = new \AL\Common\DAO\GameDao($mysqli);
$resolutionDao = new \AL\Common\DAO\ResolutionDao($mysqli);
$systemDao = new \AL\Common\DAO\SystemDao($mysqli);
$pubDevDao = new \AL\Common\DAO\PubDevDAO($mysqli);
$locationDao = new \AL\Common\DAO\LocationDAO($mysqli);
$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);
$gameReleaseAkaDao = new \AL\Common\DAO\GameReleaseAkaDAO($mysqli);
$languageDao = new \AL\Common\DAO\LanguageDAO($mysqli);

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $smarty->assign('license_types', $gameReleaseDao->getLicenseTypes());
    $smarty->assign('release_types', $gameReleaseDao->getTypes());
    $smarty->assign('locations', $locationDao->getAllLocations());
    $smarty->assign('resolutions', $resolutionDao->getAllResolutions());
    $smarty->assign('systems', $systemDao->getAllSystems());
    $smarty->assign('publishers', $pubDevDao->getAllPubDevs());
    $smarty->assign('languages', $languageDao->getAllLanguages());

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
        $smarty->assign('release_locations', $locationDao->getLocationsForRelease($release->getId()));
        $smarty->assign('release_akas', $gameReleaseAkaDao->getAllGameReleaseAkas($release->getId()));
    } else {
        // Creating a new release
        $game = $gameDao->getGame($game_id);
        $smarty->assign('game', $game);
        $smarty->assign('game_releases', $gameReleaseDao->getReleasesForGame($game->getId()));

        $smarty->assign('release', new AL\Common\Model\Game\GameRelease(-1, $game->getId(), '', '', '', '', null, null));

        $smarty->assign('system_incompatible', []);
        $smarty->assign('system_enhanced', []);
        $smarty->assign('release_resolutions', []);
        $smarty->assign('release_locations', []);

        // Pass through a pub_dev_id, location_id and release type that may be in URL parameters
        $smarty->assign('pub_dev_id', isset($pub_dev_id) ? $pub_dev_id : null);
        $smarty->assign('location_id', isset($location_id) ? $location_id : null);
        $smarty->assign('type', isset($type) ? $type : null);
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once __DIR__.'/../../config/admin_rights.php';
    
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
        if (isset($action) && ($action == 'general')) 
        {     
            $gameReleaseDao->updateRelease(
                $release_id,
                $name,
                $date,
                $license,
                ($type != '') ? $type : null,
                ($pub_dev_id != '') ? $pub_dev_id : null
            );
            
            $locationDao->setLocationsForRelease($release_id, isset($location) ? $location : []);

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
        }
    } else {
        $release_id = $gameReleaseDao->addReleaseForGame(
            $game_id,
            $name,
            $Date_Year."-01-01",
            $license,
            ($type != '') ? $type : null,
            ($pub_dev_id != '') ? $pub_dev_id : null
        );

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
    
    if (isset($action) && ($action == 'features')) 
    {  
        $systemDao->setIncompatibleSystemsForRelease($release_id, isset($system_incompatible) ? $system_incompatible : []);
        $systemDao->setEnhancedSystemsForRelease($release_id, isset($system_enhanced) ? $system_enhanced : []);
        $resolutionDao->setResolutionsForRelease($release_id, isset($resolution) ? $resolution : []);
        
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
    }

    if ($submit_type == "save_and_back") {
        header("Location: games_detail.php?game_id=".$game_id);
    } else {
        header("Location: ?release_id=".$release_id);
    }
}

$smarty->display("file:" . $cpanel_template_folder . "games_release_detail.html");

mysqli_close($mysqli);
