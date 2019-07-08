<?php
require "../../config/common.php";

require_once __DIR__."/../../common/DAO/GameDAO.php";
require_once __DIR__."/../../common/DAO/GameReleaseDAO.php";
require_once __DIR__."/../../common/DAO/LocationDAO.php";
require_once __DIR__."/../../common/DAO/GameReleaseAkaDAO.php";
require_once __DIR__."/../../common/DAO/PubDevDAO.php";
require_once __DIR__."/../../common/DAO/LanguageDAO.php";
require_once __DIR__."/../../common/DAO/SystemDAO.php";
require_once __DIR__."/../../common/DAO/EmulatorDAO.php";
require_once __DIR__."/../../common/DAO/TosDAO.php";
require_once __DIR__."/../../common/DAO/EnhancementDAO.php";
require_once __DIR__."/../../common/DAO/MemoryDAO.php";
require_once __DIR__."/../../common/DAO/CopyProtectionDAO.php";
require_once __DIR__."/../../common/DAO/DiskProtectionDAO.php";
require_once __DIR__."/../../common/DAO/MediaDAO.php";
require_once __DIR__."/../../common/DAO/DumpDAO.php";
require_once __DIR__."/../../common/DAO/MediaScanDAO.php";
require_once __DIR__."/../../common/DAO/GameReleaseScanDAO.php";

$gameDao = new \AL\Common\DAO\GameDAO($mysqli);
$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);
$locationDao = new \AL\Common\DAO\LocationDAO($mysqli);
$gameReleaseAkaDao = new \AL\Common\DAO\GameReleaseAkaDAO($mysqli);
$pubDevDao = new \AL\Common\DAO\PubDevDAO($mysqli);
$languageDao = new \AL\Common\DAO\LanguageDAO($mysqli);
$systemDao = new \AL\Common\DAO\SystemDao($mysqli);
$emulatorDao = new \AL\Common\DAO\EmulatorDAO($mysqli);
$tosDao = new \AL\Common\DAO\TosDAO($mysqli);
$enhancementDao = new \AL\Common\DAO\EnhancementDAO($mysqli);
$memoryDao = new \AL\Common\DAO\MemoryDAO($mysqli);
$copyProtectionDao = new \AL\Common\DAO\CopyProtectionDAO($mysqli);
$diskProtectionDao = new \AL\Common\DAO\DiskProtectionDAO($mysqli);
$mediaDao = new \AL\Common\DAO\MediaDAO($mysqli);
$dumpDao = new \AL\Common\DAO\DumpDAO($mysqli);
$mediaScanDao = new \AL\Common\DAO\MediaScanDAO($mysqli);
$gameReleaseScanDao = new AL\Common\DAO\GameReleaseScanDAO($mysqli);

function generate_release_description(
    $release,
    $game,
    $release_locations,
    $media,
    $dumps
) {
    $year = $release->getDate()
        ? date("Y", strtotime($release->getDate()))
        : "[no date]";

    $desc[] = "$year release of ".$game->getName();

    if ($release->getName()) {
        $desc[] = "(".$release->getName().")";
    }

    if (count($release_locations) > 0) {
        $desc[] = "in ".join(
            ", ",
            array_map(
                function ($location) {
                    return $location->getName();
                },
                $release_locations
            )
        );
    }

    if ($release->getPublisher()) {
        $desc[] = "published by ".$release->getPublisher()->getName();
    }

    $items = [];
    if (count($media) > 0) {
        $items[] = count($media)." media";
    }

    if (count($dumps) > 0) {
        $items[] = count($dumps). " downloads";
    }

    $description = join(" ", $desc);
    if (count($items) > 0) {
        $description .= " (".join(", ", $items).")";
    }

    return $description;
}

$release = $gameReleaseDao->getRelease($release_id);
$game = $gameDao->getGame($release->getGameId());

$smarty->assign('game', $game);
$smarty->assign('release', $release);

$release_locations = $locationDao->getLocationsForRelease($release->getId());
$smarty->assign('release_locations', $release_locations);
$smarty->assign('release_akas', $gameReleaseAkaDao->getAllGameReleaseAkas($release->getId()));
$smarty->assign('release_distributors', $pubDevDao->getDistributorsForRelease($release->getId()));
$smarty->assign('release_languages', $languageDao->getReleaseLanguages($release->getId()));

$smarty->assign('systems_incompatible', $systemDao->getIncompatibleSystemsForRelease($release->getId()));
$smarty->assign('emulators_incompatible', $emulatorDao->getIncompatibleEmulatorForRelease($release->getId()));
$smarty->assign('tos_incompatible', $tosDao->getIncompatibleTosForRelease($release->getId()));

$smarty->assign('systems_enhanced', $systemDao->getEnhancedSystemsForRelease($release->getId()));
$smarty->assign('memory_enhancements', $memoryDao->getMemoryForRelease($release->getId()));
$smarty->assign('minimum_memory', $memoryDao->getMinimumMemoryForRelease($release->getId()));
$smarty->assign('memory_incompatible', $memoryDao->getMemoryIncompatibleForRelease($release->getId()));
$smarty->assign('copy_protections', $copyProtectionDao->getCopyProtectionsForRelease($release->getId()));
$smarty->assign('disk_protections', $diskProtectionDao->getDiskProtectionsForRelease($release->getId()));
$smarty->assign('release_scans', $gameReleaseScanDao->getScansForRelease($release->getId()));

$media = $mediaDao->getAllMediaFromRelease($release->getId());
$smarty->assign('medias', $media);

$dumps = [];
$mediaScans = [];
foreach ($media as $medium) {
    $dumps[$medium->getId()] = $dumpDao->getAllDumpsFromMedia($medium->getId());
    $mediaScans[$medium->getId()] = $mediaScanDao->getAllMediaScansFromMedia($medium->getId());
}
$smarty->assign('dumps', $dumps);
$smarty->assign('media_scans', $mediaScans);
$smarty->assign('media_scans_path', $media_scan_path);

$smarty->assign('release_description', generate_release_description(
    $release,
    $game,
    $release_locations,
    $media,
    $dumps
));

$smarty->display("file:" . $mainsite_template_folder. "games/games_release_main.html");
