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
require_once __DIR__."/../../common/DAO/EmulatorDAO.php";
require_once __DIR__."/../../common/DAO/TrainerOptionDAO.php";
require_once __DIR__."/../../common/DAO/MemoryDAO.php";
require_once __DIR__."/../../common/DAO/TosDAO.php";
require_once __DIR__."/../../common/DAO/CopyProtectionDAO.php";
require_once __DIR__."/../../common/DAO/DiskProtectionDAO.php";

$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);
$gameDao = new \AL\Common\DAO\GameDao($mysqli);
$resolutionDao = new \AL\Common\DAO\ResolutionDao($mysqli);
$systemDao = new \AL\Common\DAO\SystemDao($mysqli);
$pubDevDao = new \AL\Common\DAO\PubDevDAO($mysqli);
$locationDao = new \AL\Common\DAO\LocationDAO($mysqli);
$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);
$gameReleaseAkaDao = new \AL\Common\DAO\GameReleaseAkaDAO($mysqli);
$languageDao = new \AL\Common\DAO\LanguageDAO($mysqli);
$emulatorDao = new \AL\Common\DAO\EmulatorDAO($mysqli);
$trainerOptionDao = new \AL\Common\DAO\TrainerOptionDAO($mysqli);
$memoryDao = new \AL\Common\DAO\MemoryDAO($mysqli);
$tosDao = new \AL\Common\DAO\TosDAO($mysqli);
$copyProtectionDao = new \AL\Common\DAO\CopyProtectionDAO($mysqli);
$diskProtectionDao = new \AL\Common\DAO\DiskProtectionDAO($mysqli);

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $smarty->assign('license_types', $gameReleaseDao->getLicenseTypes());
    $smarty->assign('release_types', $gameReleaseDao->getTypes());
    $smarty->assign('release_status', $gameReleaseDao->getStatus());
    $smarty->assign('locations', $locationDao->getAllLocations());
    $smarty->assign('resolutions', $resolutionDao->getAllResolutions());
    $smarty->assign('systems', $systemDao->getAllSystems());
    $smarty->assign('publishers', $pubDevDao->getAllPubDevs());
    $smarty->assign('languages', $languageDao->getAllLanguages());
    $smarty->assign('emulators', $emulatorDao->getAllEmulators());
    $smarty->assign('trainer_options', $trainerOptionDao->getAllTrainerOptions());
    $smarty->assign('memory_enhanced', $memoryDao->getAllMemory());
    $smarty->assign('memory_enhancement_types', $memoryDao->getEnhancementTypes());
    $smarty->assign('tos', $tosDao->getAllTos());
    $smarty->assign('copy_protections', $copyProtectionDao->getAllCopyProtections());
    $smarty->assign('disk_protections', $diskProtectionDao->getAllDiskProtections());
    
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
        $smarty->assign('emulator_incompatible', $emulatorDao->getIncompatibleEmulatorsForRelease($release->getId()));
        $smarty->assign('tos_incompatible', $tosDao->getIncompatibleTosWithNameForRelease($release->getId()));
        $smarty->assign('system_enhanced', $systemDao->getEnhancedSystemsForRelease($release->getId()));
        $smarty->assign('release_resolutions', $resolutionDao->getResolutionsForRelease($release->getId()));
        $smarty->assign('release_locations', $locationDao->getLocationsForRelease($release->getId()));
        $smarty->assign('release_akas', $gameReleaseAkaDao->getAllGameReleaseAkas($release->getId()));
        $smarty->assign('release_trainer_options', $trainerOptionDao->getTrainerOptionsForRelease($release->getId()));
        $smarty->assign('distributors', $pubDevDao->getAllPubDevs());
        $smarty->assign('release_distributors', $pubDevDao->getDistributorsForRelease($release->getId()));   
        $smarty->assign('release_memory_enhancements', $memoryDao->getMemoryForRelease($release->getId()));
        $smarty->assign('release_minimum_memory', $memoryDao->getMinimumMemoryForRelease($release->getId()));
        $smarty->assign('release_copy_protections', $copyProtectionDao->getCopyProtectionsForRelease($release->getId()));
        $smarty->assign('release_disk_protections', $diskProtectionDao->getDiskProtectionsForRelease($release->getId()));
        $smarty->assign('release_languages', $languageDao->getAllGameReleaseLanguages($release->getId()));
    } else {
        // Creating a new release
        $game = $gameDao->getGame($game_id);
        $smarty->assign('game', $game);
        $smarty->assign('game_releases', $gameReleaseDao->getReleasesForGame($game->getId()));

        $smarty->assign('release', new AL\Common\Model\Game\GameRelease(-1, $game->getId(), '', '', '', '', null, null));

        $smarty->assign('system_incompatible', []);
        $smarty->assign('emulator_incompatible', []);
        $smarty->assign('tos_incompatible', []);
        $smarty->assign('system_enhanced', []);
        $smarty->assign('release_resolutions', []);
        $smarty->assign('release_locations', []);
        $smarty->assign('release_trainer_options', []);
        $smarty->assign('release_copy_protections', []);
        $smarty->assign('release_memory_enhancements', []);
        $smarty->assign('release_minimum_memory', []);
        $smarty->assign('release_disk_protections', []);

        // Pass through a pub_dev_id, location_id and release type that may be in URL parameters
        $smarty->assign('pub_dev_id', isset($pub_dev_id) ? $pub_dev_id : null);
        $smarty->assign('location_id', isset($location_id) ? $location_id : null);
        $smarty->assign('type', isset($type) ? $type : null);
    }
}

$smarty->display("file:" . $cpanel_template_folder . "games_release_detail.html");

mysqli_close($mysqli);
