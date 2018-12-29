<?php
/***************************************************************************
 *                                games_config.php
 *                            ------------------------
 *   begin                : Wednesday, September 12, 2018
 *   copyright            : (C) 2018 Atari Legend
 *   actual update        : Creation of file
 *
 ***************************************************************************/

//****************************************************************************************
// This is the main configuration page for the game section
//****************************************************************************************

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");
include("../../admin/games/quick_search_games.php");

require_once __DIR__."/../../common/DAO/EngineDAO.php";
require_once __DIR__."/../../common/DAO/ProgrammingLanguageDAO.php";
require_once __DIR__."/../../common/DAO/GameGenreDAO.php";
require_once __DIR__."/../../common/DAO/PortDAO.php";
require_once __DIR__."/../../common/DAO/IndividualRoleDAO.php";
require_once __DIR__."/../../common/DAO/DeveloperRoleDAO.php";
require_once __DIR__."/../../common/DAO/ControlDAO.php";
require_once __DIR__."/../../common/DAO/ResolutionDAO.php";
require_once __DIR__."/../../common/DAO/SystemDAO.php";
require_once __DIR__."/../../common/DAO/EmulatorDAO.php";
require_once __DIR__."/../../common/DAO/TrainerOptionDAO.php";
require_once __DIR__."/../../common/DAO/MemoryDAO.php";
require_once __DIR__."/../../common/DAO/TosDAO.php";
require_once __DIR__."/../../common/DAO/CopyProtectionDAO.php";
require_once __DIR__."/../../common/DAO/DiskProtectionDAO.php";
require_once __DIR__."/../../common/DAO/EnhancementDAO.php";
require_once __DIR__."/../../common/DAO/MediaTypeDAO.php";
require_once __DIR__."/../../common/DAO/MediaScanTypeDAO.php";
require_once __DIR__."/../../common/DAO/SoundHardwareDAO.php";
require_once __DIR__."/../../common/DAO/GameProgressSystemDAO.php";

$engineDao = new \AL\Common\DAO\EngineDAO($mysqli);
$programmingLanguageDao = new \AL\Common\DAO\ProgrammingLanguageDAO($mysqli);
$gameGenreDao = new \AL\Common\DAO\GameGenreDAO($mysqli);
$portDao = new \AL\Common\DAO\PortDAO($mysqli);
$individualRoleDao = new \Al\Common\DAO\IndividualRoleDAO($mysqli);
$developerRoleDao = new \Al\Common\DAO\DeveloperRoleDAO($mysqli);
$controlDao = new \AL\Common\DAO\ControlDAO($mysqli);
$resolutionDao = new \AL\Common\DAO\ResolutionDAO($mysqli);
$systemDao = new \AL\Common\DAO\SystemDAO($mysqli);
$emulatorDao = new \AL\Common\DAO\EmulatorDAO($mysqli);
$trainerOptionDao = new \AL\Common\DAO\TrainerOptionDAO($mysqli);
$memoryDao = new \AL\Common\DAO\MemoryDAO($mysqli);
$tosDao = new \AL\Common\DAO\TosDAO($mysqli);
$copyProtectionDao = new \AL\Common\DAO\CopyProtectionDAO($mysqli);
$diskProtectionDao = new \AL\Common\DAO\DiskProtectionDAO($mysqli);
$enhancementDao = new \AL\Common\DAO\enhancementDAO($mysqli);
$mediaTypeDao = new \AL\Common\DAO\MediaTypeDAO($mysqli);
$mediaScanTypeDao = new \AL\Common\DAO\MediaScanTypeDAO($mysqli);
$soundHardwareDao = new \AL\Common\DAO\SoundHardwareDAO($mysqli);
$gameProgressSystemDao = new \AL\Common\DAO\GameProgressSystemDAO($mysqli);

//***********************************************************************************
//get the engines
//***********************************************************************************
$smarty->assign('engines', $engineDao->getAllEngines());

//*******************************************************************************************
//get the programming languages
//*******************************************************************************************
$smarty->assign('programming_languages', $programmingLanguageDao->getAllProgrammingLanguages());

//***********************************************************************************
//get the game categories
//***********************************************************************************
$smarty->assign('game_genres', $gameGenreDao->getAllGameGenres());

//***********************************************************************************
//get the game ports
//***********************************************************************************
$smarty->assign('ports', $portDao->getAllPorts());

//***********************************************************************************
//get the game controls
//***********************************************************************************
$smarty->assign('controls', $controlDao->getAllControls());

// Get the indivual roles
$smarty->assign('individual_roles', $individualRoleDao->getAllIndividualRoles());

// Get the developer roles
$smarty->assign('developer_roles', $developerRoleDao->getAllDeveloperRoles());

//***********************************************************************************
//get the game release resolutions
//***********************************************************************************
$smarty->assign('resolutions', $resolutionDao->getAllresolutions());

//***********************************************************************************
//get the game release systems
//***********************************************************************************
$smarty->assign('systems', $systemDao->getAllsystems());

//***********************************************************************************
//get the game release emulators
//***********************************************************************************
$smarty->assign('emulators', $emulatorDao->getAllemulators());

//***********************************************************************************
//get the trainer options
//***********************************************************************************
$smarty->assign('trainer_options', $trainerOptionDao->getAllTrainerOptions());

//***********************************************************************************
//get the memory amounts
//***********************************************************************************
$smarty->assign('memory', $memoryDao->getAllMemory());

//***********************************************************************************
//get the copy protection type
//***********************************************************************************
$smarty->assign('copy_protections', $copyProtectionDao->getAllCopyProtections());

//***********************************************************************************
//get the disk protection type
//***********************************************************************************
$smarty->assign('disk_protections', $diskProtectionDao->getAllDiskProtections());

//***********************************************************************************
//get the game release tos versions
//***********************************************************************************
$smarty->assign('tos', $tosDao->getAllTos());

//***********************************************************************************
//get the enhancenments
//***********************************************************************************
$smarty->assign('enhancement', $enhancementDao->getAllEnhancements());

//***********************************************************************************
//get the media types
//***********************************************************************************
$smarty->assign('media_type', $mediaTypeDao->getAllMediaTypes());

//***********************************************************************************
//get the media scan types
//***********************************************************************************
$smarty->assign('media_scan_type', $mediaScanTypeDao->getAllMediaScanTypes());

//***********************************************************************************
//get the sound hardware
//***********************************************************************************
$smarty->assign('soundhardware', $soundHardwareDao->getAllSoundHardware());

//***********************************************************************************
//get the game progress systems
//***********************************************************************************
$smarty->assign('progress_system', $gameProgressSystemDao->getAllProgressSystems());

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games_config.html");

//close the connection
mysqli_close($mysqli);
