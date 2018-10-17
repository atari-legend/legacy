<?php
/*
 * Manage all the game config features
 */
 
require_once __DIR__.'/../../config/common.php';
require_once __DIR__.'/../../config/admin.php';
require_once __DIR__.'/../../config/admin_rights.php';

require_once __DIR__."/../../common/DAO/EngineDAO.php";
require_once __DIR__."/../../common/DAO/ChangeLogDAO.php";
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

$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);
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
$enhancementDao = new \AL\Common\DAO\EnhancementDAO($mysqli);
$mediaTypeDao = new \AL\Common\DAO\MediaTypeDAO($mysqli);
$mediaScanTypeDao = new \AL\Common\DAO\MediaScanTypeDAO($mysqli);

switch ($_POST['action']) {
	case "Add engine":
        $engineDao->addGameEngine($engine_new);
        
        $new_engine_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_engine_id, 'Games Engine', $new_engine_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$engine_new has been added" ;
        break;
        
    case "Delete engine":
        create_log_entry('Games Config', $engine_id_edit, 'Games Engine', $engine_id_edit, 'Delete', $_SESSION['user_id']);
        
        $engineDao->deleteGameEngine($engine_id_edit);       

        $_SESSION['edit_message'] = "Engine has been deleted" ;
        break;
        
    case "Modify engine":
        $engineDao->updateGameEngine($engine_id_edit, $engine_edit);

        create_log_entry('Games Config', $engine_id_edit, 'Games Engine', $engine_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Engine has been updated" ;
        break;
        
    case "Add language":
        $programmingLanguageDao->addProgrammingLanguage($programming_language_new);
        
        $new_programming_language_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_programming_language_id, 'Programming Language',$new_programming_language_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$programming_language_new has been added" ;
        break;
        
    case "Delete language":
        create_log_entry('Games Config', $programming_language_id_edit, 'Programming Language', $programming_language_id_edit, 'Delete', $_SESSION['user_id']);
        
        $programmingLanguageDao->deleteProgrammingLanguage($programming_language_id_edit);       

        $_SESSION['edit_message'] = "Programming language has been deleted" ;
        break;
        
    case "Modify language":
        $programmingLanguageDao->updateProgrammingLanguage($programming_language_id_edit, $programming_language_edit); 

        create_log_entry('Games Config', $programming_language_id_edit, 'Programming Language', $programming_language_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Programming language has been updated" ;
        break;
    
    case "Add genre":
        $gameGenreDao->addGenre($genre_new);
        
        $new_genre_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_genre_id, 'Genre',$new_genre_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$genre_new has been added" ;
        break;
        
    case "Delete genre":
        create_log_entry('Games Config', $genre_id_edit, 'Genre', $genre_id_edit, 'Delete', $_SESSION['user_id']);
        
        $gameGenreDao->deleteGenre($genre_id_edit);       

        $_SESSION['edit_message'] = "Genre has been deleted" ;
        break;
        
    case "Modify genre":
        $gameGenreDao->updateGenre($genre_id_edit, $genre_edit);

        create_log_entry('Games Config', $genre_id_edit, 'Genre', $genre_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Genre has been updated" ;
        break;
        
    case "Add port":
        $portDao->addPort($port_new);
        
        $new_port_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_port_id, 'Port',$new_port_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$port_new has been added" ;
        break;
        
    case "Delete port":
        create_log_entry('Games Config', $port_id_edit, 'Port', $port_id_edit, 'Delete', $_SESSION['user_id']);
        
        $portDao->deletePort($port_id_edit);       

        $_SESSION['edit_message'] = "Port has been deleted" ;
        break;
        
    case "Modify port":        
        $portDao->updatePort($port_id_edit, $port_edit);      

        create_log_entry('Games Config', $port_id_edit, 'Port', $port_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Port has been updated" ;
        break;
        
    case "Add ind role":
        $individualRoleDao->addIndividualRole($individual_role_new);
        
        $new_individual_role_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_individual_role_id, 'Individual Role',$new_individual_role_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$individual_role_new has been added" ;
        break;
        
    case "Delete ind role":
        create_log_entry('Games Config', $individual_role_id_edit, 'Individual Role', $individual_role_id_edit, 'Delete', $_SESSION['user_id']);
        
        $individualRoleDao->deleteIndividualRole($individual_role_id_edit);       

        $_SESSION['edit_message'] = "Individual role has been deleted" ;
        break;
        
    case "Modify ind role":       
        $individualRoleDao->updateIndividualRole($individual_role_id_edit, $individual_role_edit);       
        
        create_log_entry('Games Config', $individual_role_id_edit, 'Individual Role', $individual_role_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Individual role has been updated" ;
        break;
        
    case "Add dev role":
        $developerRoleDao->addDeveloperRole($developer_role_new);
        
        $new_developer_role_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_developer_role_id, 'Developer Role',$new_developer_role_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$developer_role_new has been added" ;
        break;
        
    case "Delete dev role":
        create_log_entry('Games Config', $developer_role_id_edit, 'Developer Role', $developer_role_id_edit, 'Delete', $_SESSION['user_id']);
        
        $developerRoleDao->deleteDeveloperRole($developer_role_id_edit);       

        $_SESSION['edit_message'] = "Developer role has been deleted" ;
        break;
        
    case "Modify dev role":       
        $developerRoleDao->updateDeveloperRole($developer_role_id_edit, $developer_role_edit);       
        
        create_log_entry('Games Config', $developer_role_id_edit, 'Developer Role', $developer_role_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Developer role has been updated" ;
        break;
    
    case "Add control":
        $controlDao->addControl($control_new);
        
        $new_control_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_control_id, 'Control',$new_control_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$control_new has been added" ;
        break;
        
    case "Delete control":
        create_log_entry('Games Config', $control_id_edit, 'Control', $control_id_edit, 'Delete', $_SESSION['user_id']);
        
        $controlDao->deleteControl($control_id_edit);       

        $_SESSION['edit_message'] = "Control has been deleted" ;
        break;
        
    case "Modify control":        
        $controlDao->updateControl($control_id_edit, $control_edit);      

        create_log_entry('Games Config', $control_id_edit, 'Control', $control_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Control has been updated" ;
        break;
        
    case "Add resolution":
        $resolutionDao->addResolution($resolution_new);
        
        $new_resolution_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_resolution_id, 'Resolution', $new_resolution_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$resolution_new has been added" ;
        break;
        
    case "Delete resolution":
        create_log_entry('Games Config', $resolution_id_edit, 'Resolution', $resolution_id_edit, 'Delete', $_SESSION['user_id']);
        
        $resolutionDao->deleteResolution($resolution_id_edit);       

        $_SESSION['edit_message'] = "Resolution has been deleted" ;
        break;
        
    case "Modify resolution":
        $resolutionDao->updateResolution($resolution_id_edit, $resolution_edit);

        create_log_entry('Games Config', $resolution_id_edit, 'Resolution', $resolution_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Resolution has been updated" ;
        break;
        
    case "Add system":
        $systemDao->addSystem($system_new);
        
        $new_system_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_system_id, 'System', $new_system_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$system_new has been added" ;
        break;
        
    case "Delete system":
        create_log_entry('Games Config', $system_id_edit, 'System', $system_id_edit, 'Delete', $_SESSION['user_id']);
        
        $systemDao->deleteSystem($system_id_edit);       

        $_SESSION['edit_message'] = "System has been deleted" ;
        break;
        
    case "Modify system":
        $systemDao->updateSystem($system_id_edit, $system_edit);

        create_log_entry('Games Config', $system_id_edit, 'System', $system_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "System has been updated" ;
        break;
        
    case "Add emulator":
        $emulatorDao->addEmulator($emulator_new);
        
        $new_emulator_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_emulator_id, 'Emulator', $new_emulator_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$emulator_new has been added" ;
        break;
        
    case "Delete emulator":
        create_log_entry('Games Config', $emulator_id_edit, 'Emulator', $emulator_id_edit, 'Delete', $_SESSION['user_id']);
        
        $emulatorDao->deleteEmulator($emulator_id_edit);       

        $_SESSION['edit_message'] = "Emulator has been deleted" ;
        break;
        
    case "Modify emulator":
        $emulatorDao->updateEmulator($emulator_id_edit, $emulator_edit);

        create_log_entry('Games Config', $emulator_id_edit, 'Emulator', $emulator_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Emulator has been updated" ;
        break;

    case "Add trainer":
        $trainerOptionDao->addTrainerOption($trainer_option_new);
        
        $new_trainer_option_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_trainer_option_id, 'Trainer', $new_trainer_option_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$trainer_option_new has been added" ;
        break;
        
    case "Delete trainer":
        create_log_entry('Games Config', $trainer_option_id_edit, 'Trainer', $trainer_option_id_edit, 'Delete', $_SESSION['user_id']);
        
        $trainerOptionDao->deleteTrainerOption($trainer_option_id_edit);       

        $_SESSION['edit_message'] = "Trainer has been deleted" ;
        break;
        
    case "Modify trainer":
        $trainerOptionDao->updateTrainerOption($trainer_option_id_edit, $trainer_option_edit);

        create_log_entry('Games Config', $trainer_option_id_edit, 'Trainer', $trainer_option_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Trainer has been updated" ;
        break;
    
    case "Add memory":
        $memoryDao->addMemory($memory_new);
        
        $new_memory_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_memory_id, 'Memory', $new_memory_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$memory_new has been added" ;
        break;
        
    case "Delete memory":
        create_log_entry('Games Config', $memory_id_edit, 'Memory', $memory_id_edit, 'Delete', $_SESSION['user_id']);
        
        $memoryDao->deleteMemory($memory_id_edit);       

        $_SESSION['edit_message'] = "Memory has been deleted" ;
        break;
        
    case "Modify memory":
        $memoryDao->updateMemory($memory_id_edit, $memory_edit);

        create_log_entry('Games Config', $memory_id_edit, 'Memory', $memory_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Memory has been updated" ;
        break;  

    case "Add TOS":
        $tosDao->addTos($tos_new);
        
        $new_tos_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_tos_id, 'Tos', $new_tos_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$tos_new has been added" ;
        break;
        
    case "Delete TOS":
        create_log_entry('Games Config', $tos_id_edit, 'Tos', $tos_id_edit, 'Delete', $_SESSION['user_id']);
        
        $tosDao->deleteTos($tos_id_edit);       

        $_SESSION['edit_message'] = "TOS has been deleted" ;
        break;
        
    case "Modify TOS":
        $tosDao->updateTos($tos_id_edit, $tos_edit);

        create_log_entry('Games Config', $tos_id_edit, 'Tos', $tos_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Tos has been updated" ;
        break;  
        
    case "Add protection":
        $copyProtectionDao->addCopyProtection($copy_protection_new);
        
        $new_copy_protection_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_copy_protection_id, 'Protection', $new_copy_protection_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$copy_protection_new has been added" ;
        break;
        
    case "Delete protection":
        create_log_entry('Games Config', $copy_protection_id_edit, 'Protection', $copy_protection_id_edit, 'Delete', $_SESSION['user_id']);
        
        $copyProtectionDao->deleteCopyProtection($copy_protection_id_edit);       

        $_SESSION['edit_message'] = "Protection has been deleted" ;
        break;
        
    case "Modify protection":
        $copyProtectionDao->updateCopyProtection($copy_protection_id_edit, $copy_protection_edit);

        create_log_entry('Games Config', $copy_protection_id_edit, 'Protection', $copy_protection_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Protection has been updated" ;
        break;
        
    case "Add disk protection":
        $diskProtectionDao->addDiskProtection($disk_protection_new);
        
        $new_disk_protection_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_disk_protection_id, 'Disk Protection', $new_disk_protection_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$disk_protection_new has been added" ;
        break;
        
    case "Delete disk protection":
        create_log_entry('Games Config', $disk_protection_id_edit, 'Disk Protection', $disk_protection_id_edit, 'Delete', $_SESSION['user_id']);
        
        $diskProtectionDao->deleteDiskProtection($disk_protection_id_edit);       

        $_SESSION['edit_message'] = "Protection has been deleted" ;
        break;
        
    case "Modify disk protection":
        $diskProtectionDao->updateDiskProtection($disk_protection_id_edit, $disk_protection_edit);

        create_log_entry('Games Config', $disk_protection_id_edit, 'Disk Protection', $disk_protection_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Protection has been updated" ;
        break;
        
    case "Add enhancement":
        $enhancementDao->addEnhancement($enhancement_new);
        
        $new_enhancement_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_enhancement_id, 'Enhancement', $new_enhancement_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$enhancement_new has been added" ;
        break;
        
    case "Delete enhancement":
        create_log_entry('Games Config', $enhancement_id_edit, 'Enhancement', $enhancement_id_edit, 'Delete', $_SESSION['user_id']);
        
        $enhancementDao->deleteEnhancement($enhancement_id_edit);       

        $_SESSION['edit_message'] = "Enhancement has been deleted" ;
        break;
        
    case "Modify enhancement":
        $enhancementDao->updateEnhancement($enhancement_id_edit, $enhancement_edit);

        create_log_entry('Games Config', $enhancement_id_edit, 'Enhancement', $enhancement_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Enhancement has been updated" ;
        break;

    case "Add type":
        $mediaTypeDao->addMediaType($media_type_new);
        
        $media_type_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $media_type_id, 'Media Type', $media_type_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$media_type_new has been added" ;
        break;
        
    case "Delete type":
        create_log_entry('Games Config', $media_type_id_edit, 'Media Type', $media_type_id_edit, 'Delete', $_SESSION['user_id']);
        
        $mediaTypeDao->deleteMediaType($media_type_id_edit);       

        $_SESSION['edit_message'] = "Media type has been deleted" ;
        break;
        
    case "Modify type":
        $mediaTypeDao->updateMediaType($media_type_id_edit, $media_type_edit);

        create_log_entry('Games Config', $media_type_id_edit, 'Media Type', $media_type_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Media Type has been updated" ;
        break;
        
    case "Add scan type":
        $mediaScanTypeDao->addMediaScanType($media_scan_type_new);
        
        $media_scan_type_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $media_scan_type_id, 'Media Scan Type', $media_scan_type_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$media_scan_type_new has been added" ;
        break;
        
    case "Delete scan type":
        create_log_entry('Games Config', $media_scan_type_id_edit, 'Media Scan Type', $media_scan_type_id_edit, 'Delete', $_SESSION['user_id']);
        
        $mediaScanTypeDao->deleteMediaScanType($media_scan_type_id_edit);       

        $_SESSION['edit_message'] = "Media scan type has been deleted" ;
        break;
        
    case "Modify scan type":
        $mediaScanTypeDao->updateMediaScanType($media_scan_type_id_edit, $media_scan_type_edit);

        create_log_entry('Games Config', $media_scan_type_id_edit, 'Media Scan Type', $media_Scan_type_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Media Scan Type has been updated" ;
        break;
}

header("Location: games_config.php");
