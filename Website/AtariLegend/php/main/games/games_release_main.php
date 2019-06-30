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

$release = $gameReleaseDao->getRelease($release_id);
$game = $gameDao->getGame($release->getGameId());

$smarty->assign('game', $game);
$smarty->assign('release', $release);

$smarty->assign('release_locations', $locationDao->getLocationsForRelease($release->getId()));
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

$smarty->display("file:" . $mainsite_template_folder. "games/games_release_main.html");
