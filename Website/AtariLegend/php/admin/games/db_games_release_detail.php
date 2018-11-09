<?php
/***************************************************************************
 *                                db_games_release_detail.php
 ***************************************************************************/

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

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
require_once __DIR__."/../../common/DAO/MediaDAO.php";
require_once __DIR__."/../../common/DAO/DumpDAO.php";
require_once __DIR__."/../../common/DAO/MediaScanDAO.php";


$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);
$gameDao = new \AL\Common\DAO\GameDao($mysqli);
$resolutionDao = new \AL\Common\DAO\ResolutionDao($mysqli);
$systemDao = new \AL\Common\DAO\SystemDao($mysqli);
$pubDevDao = new \AL\Common\DAO\PubDevDAO($mysqli);
$locationDao = new \AL\Common\DAO\LocationDAO($mysqli);
$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);
$gameReleaseAkaDao = new \AL\Common\DAO\GameReleaseAkaDAO($mysqli);
$languageDao = new \AL\Common\DAO\LanguageDAO($mysqli);
$languageDao = new \AL\Common\DAO\LanguageDAO($mysqli);
$emulatorDao = new \AL\Common\DAO\EmulatorDAO($mysqli);
$trainerOptionDao = new \AL\Common\DAO\TrainerOptionDAO($mysqli);
$memoryDao = new \AL\Common\DAO\MemoryDAO($mysqli);
$tosDao = new \AL\Common\DAO\TosDAO($mysqli);
$copyProtectionDao = new \AL\Common\DAO\CopyProtectionDAO($mysqli);
$diskProtectionDao = new \AL\Common\DAO\DiskProtectionDAO($mysqli);
$mediaDao = new \AL\Common\DAO\MediaDAO($mysqli);
$dumpDao = new \AL\Common\DAO\DumpDAO($mysqli);
$mediaScanDao = new \AL\Common\DAO\MediaScanDAO($mysqli);

//***********************************************************************************
// Add a new release
//***********************************************************************************
if (isset($action) && ($action == 'add_release')) 
{
    $game = $gameDao->getGame($game_id);
    
    // Do not store an alternative title if it's identical to the game
    if (isset($name)) {
        if (strtolower($name) == strtolower($game->getName())) {
            $name = null;
        }
    } else {
       $name = null; 
    }
    
    if (isset($Date_Year)) {
        $date = $Date_Year."-01-01";
        if ($Date_Year == "") {
            $date = null;
        }
    } else {
        $date = null;
    }
    
    if (isset ($license)) {} else {$license = null;}
    if (isset ($$type)) {} else {$type = null;}
    if (isset ($pub_dev_id)) {} else {$pub_dev_id = null;}
    
    $release_id = $gameReleaseDao->addReleaseForGame(
        $game_id,
        $name,
        $date,
        $license,
        ($type != '') ? $type : null,
        ($pub_dev_id != '') ? $pub_dev_id : null
    );

    create_log_entry('Game Release', $game_id, 'Game Release', $release_id, 'Insert', $_SESSION['user_id']);
    
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");

}

//***********************************************************************************
// Update general release data
//***********************************************************************************
if (isset($action) && ($action == 'general')) 
{ 
    $game = $gameDao->getGame($game_id);
    
// Do not store an alternative title if it's identical to the game
    if (strtolower($name) == strtolower($game->getName())) {
        $name = null;
    }

    $date = $Date_Year."-01-01";
    if ($Date_Year == "") {
        $date = null;
    }

    $gameReleaseDao->updateRelease(
        $release_id,
        $name,
        $date,
        $license,
        ($type != '') ? $type : null,
        ($pub_dev_id != '') ? $pub_dev_id : null,
        ($status != '') ? $status : null,
        ($notes != '') ? $notes : null
    );
    
    $locationDao->setLocationsForRelease($release_id, isset($location) ? $location : []);

    create_log_entry('Game Release', $game_id, 'Release Info', $release_id, 'Update', $_SESSION['user_id']);
    
    if ($submit_type == "save_and_back") {
        header("Location: games_detail.php?game_id=".$game_id);
    } else {
        header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
    }
}

//***********************************************************************************
//If add aka button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'game_release_aka') {
    
    create_log_entry('Game Release', $game_id, 'Release AKA', $game_release_id, 'Insert', $_SESSION['user_id']);

    if ($language_id == ""){
        $language_id = null;
    }

    $gameReleaseAkaDao->AddAkaForRelease($game_release_id, $game_release_aka, $language_id);

    $_SESSION['edit_message'] = "AKA link has been added";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$game_release_id");
}

//***********************************************************************************
//If update release_aka link has been pressed
//***********************************************************************************
if (isset($action) and $action == 'update_release_aka') {
       
    create_log_entry('Game Release', $game_id, 'Release AKA', $game_release_id, 'Update', $_SESSION['user_id']);

    if ($new_language_id == ""){
        $new_language_id = null;
    }
    
    $gameReleaseAkaDao->UpdateLanguageForReleaseAka($new_language_id, $game_release_aka_id);

    $_SESSION['edit_message'] = "AKA link has been updated";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$game_release_id");
}

//***********************************************************************************
//If delete aka link has been pressed
//***********************************************************************************
if (isset($action) and $action == 'delete_release_aka') {
        
    create_log_entry('Game Release', $game_id, 'Release AKA', $game_release_id, 'Delete', $_SESSION['user_id']);

    $gameReleaseAkaDao->DeleteAkaForRelease($game_release_aka_id, $game_release_id);

    $_SESSION['edit_message'] = "AKA link has been deleted";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$game_release_id");
}

//***********************************************************************************
//update the release options at the features tab
//***********************************************************************************
if (isset($action) && ($action == 'features')) {  
    $game = $gameDao->getGame($game_id);
    
    if (isset($hd_installable)) {
        $hd_installable = 1;
    }else{
        $hd_installable = 0;
    } 
    
    $systemDao->setIncompatibleSystemsForRelease($release_id, isset($system_incompatible) ? $system_incompatible : []);
    //$systemDao->setEnhancedSystemsForRelease($release_id, isset($system_enhanced) ? $system_enhanced : []);
    $resolutionDao->setResolutionsForRelease($release_id, isset($resolution) ? $resolution : []);
    $emulatorDao->setIncompatibleEmulatorsForRelease($release_id, isset($emulator_incompatible) ? $emulator_incompatible : []);
    $gameReleaseDao->updateHdRelease($release_id, $hd_installable);
    
    create_log_entry('Game Release', $game_id, 'Compatibility', $release_id, 'Update', $_SESSION['user_id']);
    $_SESSION['edit_message'] = "Compatibility options updated";
    
    if ($submit_type == "save_and_back") {
        header("Location: games_detail.php?game_id=".$game_id);
    } else {
        header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
    }
}


//***********************************************************************************
//add a distributor to a release
//***********************************************************************************
if (isset($action) && ($action == 'add_distributor')) {  
    
    $pubDevDao->addDistributorToRelease($release_id, $distributor_id);
    
    $new_distributor_id = $mysqli->insert_id;
    
    create_log_entry('Game Release', $game_id, 'Distributor', $distributor_id, 'Insert', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "Distributor has been added";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//remove a distributor to a release
//***********************************************************************************
if (isset($action) && ($action == 'remove_distributor')) {  
    
    create_log_entry('Game Release', $game_id, 'Distributor', $pub_dev_id, 'Delete', $_SESSION['user_id']);
    
    $pubDevDao->deleteDistributorFromRelease($release_id, $pub_dev_id);
    
    $_SESSION['edit_message'] = "Distributor has been removed";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");

}

//***********************************************************************************
//update the release options at the scene tab
//***********************************************************************************
if (isset($action) && ($action == 'scene')) {  
    
    //Update the game engine
    $trainerOptionDao->setTrainerOptionsForRelease($release_id, isset($trainer_option) ? $trainer_option : []);
    
    create_log_entry('Game Release', $game_id, 'Scene', $release_id, 'Update', $_SESSION['user_id']);
    $_SESSION['edit_message'] = "Scene info updated";
    
    if ($submit_type == "save_and_back") {
        header("Location: games_detail.php?game_id=".$game_id);
    } else {
        header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
    }
}

//***********************************************************************************
//add a memory enhancement to a release
//***********************************************************************************
if (isset($action) && ($action == 'add_memory_enhancement')) {  

    if ( $memory_enhancement == '') {$memory_enhancement=null;}
    
    $memoryDao->setMemoryForRelease($release_id, $memory_id, $memory_enhancement);
    
    create_log_entry('Game Release', $game_id, 'Memory Enhancement', $release_id, 'Insert', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "Memory enhancement has been added";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}


//***********************************************************************************
//Update a memory enhancement to a release
//***********************************************************************************
if (isset($action) && ($action == 'update_memory_enhancement')) {  
    
    $memoryDao->UpdateMemoryForRelease($release_id, $memory_id, $new_enhancement);
    
    create_log_entry('Game Release', $game_id, 'Memory Enhancement', $release_id, 'Update', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "Memory enhancement has been updated";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}


//***********************************************************************************
//Delete a memory enhancement to a release
//***********************************************************************************
if (isset($action) && ($action == 'remove_memory_enhancement')) {  
    
    $memoryDao->DeleteMemoryForRelease($release_id, $memory_id);
    
    create_log_entry('Game Release', $game_id, 'Memory Enhancement', $release_id, 'Delete', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "Memory enhancement has been deleted";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//add a memory minimum to a release
//***********************************************************************************
if (isset($action) && ($action == 'add_minimum_memory')) {  
    
    $memoryDao->setMinimumMemoryForRelease($release_id, $memory_id);
    
    create_log_entry('Game Release', $game_id, 'Minimum Memory', $release_id, 'Insert', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "Minimum memory has been added";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//Delete a memory minimum to a release
//***********************************************************************************
if (isset($action) && ($action == 'remove_minimum_memory')) {  
    
    $memoryDao->DeleteMinimumMemoryForRelease($release_id, $memory_id);
    
    create_log_entry('Game Release', $game_id, 'Minimum Memory', $release_id, 'Delete', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "Minimum memory has been deleted";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//Delete a memory incompatible to a release
//***********************************************************************************
if (isset($action) && ($action == 'remove_incompatible_memory')) {  
    
    $memoryDao->deleteMemoryIncompatibleForRelease($release_id, $memory_id);
    
    create_log_entry('Game Release', $game_id, 'Incompatible Memory', $release_id, 'Delete', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "Incompatible memory has been deleted";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//add a memory incompatible to a release
//***********************************************************************************
if (isset($action) && ($action == 'add_incompatible_memory')) {  
    
    $memoryDao->setMemoryIncompatibleForRelease($release_id, $memory_id);
    
    create_log_entry('Game Release', $game_id, 'Incompatible Memory', $release_id, 'Insert', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "Incompatible memory has been added";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//add a incompatible TOS to a release
//***********************************************************************************
if (isset($action) && ($action == 'add_tos_incompatible')) {  

    if ($language_id == ''){
        $language_id = null;
    }
    
    $tosDao->setIncompatibleTosForRelease($release_id, $tos_id, $language_id);
    
    create_log_entry('Game Release', $game_id, 'Incompatible TOS', $release_id, 'Insert', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "Incompatible TOS has been added";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//Update incompatible TOS language for a release
//***********************************************************************************
if (isset($action) && ($action == 'update_tos_incompatible')) {  
    
    $tosDao->updateTosLanguageForRelease($release_id, $tos_id, $new_language_id);
    
    create_log_entry('Game Release', $game_id, 'Incompatible TOS', $release_id, 'Update', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "Incompatible TOS was updated";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//Delete incompatible TOS language for a release
//***********************************************************************************
if (isset($action) && ($action == 'remove_tos_incompatible')) {  
    
    $tosDao->deleteTosForRelease($release_id, $tos_id);
    
    create_log_entry('Game Release', $game_id, 'Incompatible TOS', $release_id, 'Delete', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "Incompatible TOS was deleted";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//Add the copy protection for a release
//***********************************************************************************
if (isset($action) && ($action == 'add_copy_protection')) {  
    
    $copyProtectionDao->addCopyProtectionForRelease($release_id, isset($protection_id) ? $protection_id : [], $copy_protection_note);
    
    create_log_entry('Game Release', $game_id, 'Copy Protection', $release_id, 'Add', $_SESSION['user_id']);
    $_SESSION['edit_message'] = "Copy Protection added";  
  
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//Delete the copy protection for a release
//***********************************************************************************
if (isset($action) && ($action == 'remove_copy_protection')) {  
    
    $copyProtectionDao->deleteCopyProtectionForRelease($release_id, isset($protection_id) ? $protection_id : []);
    
    create_log_entry('Game Release', $game_id, 'Copy Protection', $release_id, 'Delete', $_SESSION['user_id']);
    $_SESSION['edit_message'] = "Copy Protection deleted";  
  
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//Add the disk protection for a release
//***********************************************************************************
if (isset($action) && ($action == 'add_disk_protection')) {  
    
    $diskProtectionDao->addDiskProtectionForRelease($release_id, isset($protection_id) ? $protection_id : [], $disk_protection_note);
    
    create_log_entry('Game Release', $game_id, 'Disk Protection', $release_id, 'Add', $_SESSION['user_id']);
    $_SESSION['edit_message'] = "Disk Protection added";  
  
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//Delete the disk protection for a release
//***********************************************************************************
if (isset($action) && ($action == 'remove_disk_protection')) {  
    
    $diskProtectionDao->deleteDiskProtectionForRelease($release_id, isset($protection_id) ? $protection_id : []);
    
    create_log_entry('Game Release', $game_id, 'Disk Protection', $release_id, 'Delete', $_SESSION['user_id']);
    $_SESSION['edit_message'] = "Disk Protection deleted";  
  
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//add a language to a release
//***********************************************************************************
if (isset($action) && ($action == 'add_release_language')) {  
    
    $languageDao->addLanguageForRelease($release_id, $language_id);
    
    $new_language_id = $mysqli->insert_id;
    
    create_log_entry('Game Release', $game_id, 'Language', $release_id, 'Insert', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "Language has been added";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//remove a language from a release
//***********************************************************************************
if (isset($action) && ($action == 'remove_release_language')) {  
    
    create_log_entry('Game Release', $game_id, 'Language', $release_id, 'Delete', $_SESSION['user_id']);
    
    $languageDao->deleteLanguageFromRelease($release_id, $language_id);
    
    $_SESSION['edit_message'] = "Language has been removed";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");

}

//***********************************************************************************
//add a system enhancement to a release
//***********************************************************************************
if (isset($action) && ($action == 'add_system_enhanced')) {  

    if ($enhancement_id == ''){
        $enhancement_id = null;
    }
    
    $systemDao->addEnhancedSystemForRelease($release_id, $system_id, $enhancement_id);
    
    create_log_entry('Game Release', $game_id, 'System Enhancement', $release_id, 'Insert', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "System enhancement has been added";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//Update system enhancement for a release
//***********************************************************************************
if (isset($action) && ($action == 'update_system_enhanced')) {  
    
    $systemDao->updateEnhancedSystemForRelease($release_id, $system_id, $new_enhancement_id);
    
    create_log_entry('Game Release', $game_id, 'System Enhancement', $release_id, 'Update', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "System enhancement was updated";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//Update system enhancement for a release
//***********************************************************************************
if (isset($action) && ($action == 'remove_system_enhanced')) {  
    
    $systemDao->deleteEnhancedSystemForRelease($release_id, $system_id);
    
    create_log_entry('Game Release', $game_id, 'System Enhancement', $release_id, 'Delete', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "System enhancement was delete";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//add a media to a release
//***********************************************************************************
if (isset($action) && ($action == 'add_media')) {  
    
    $mediaDao->addMediaToRelease($release_id, $media_type_id);
    
    create_log_entry('Game Release', $game_id, 'Media', $release_id, 'Insert', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "Media was added to a release";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//delete a media from a release
//***********************************************************************************
if (isset($action) && ($action == 'remove_media')) {  
    
    $mediaDao->deleteMediaFromRelease($media_id);
    
    create_log_entry('Game Release', $game_id, 'Media', $release_id, 'Delete', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "Media has been removed from a release";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//delete a media from a release
//***********************************************************************************
if (isset($action) && ($action == 'Add file')) { 

    // adding this vars inhere as the $_FILES['game_download_name'] 
    // is not recognized in the DumpDAO.php file
    $game_download_name = $_FILES['game_download_name'];
    $filename = $_FILES['game_download_name']['name'];
    $tempfilename = $_FILES['game_download_name']['tmp_name'];
    $filesize = $_FILES['game_download_name']["size"];
   
    //Also adding the game_file_paths vars, not recognized in the DumpDAO.php file
    $dumpDao->AddDumpToMedia($media_id, $format, $filename, $tempfilename, $info, $game_file_temp_path, $game_file_path, $filesize);
    
    create_log_entry('Game Release', $game_id, 'Dump', $release_id, 'Insert', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "File has been added to this media";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//delete a file from a media
//***********************************************************************************
if (isset($action) && ($action == 'remove_dump')) {  
    
    $dumpDao->deleteDumpFromMedia($dump_id, $game_file_path);
    
    create_log_entry('Game Release', $game_id, 'Dump', $release_id, 'Delete', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "File has been removed from this media";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//add a media scan
//***********************************************************************************
if (isset($action) && ($action == 'Add scan')) {  
    
    $image = $_FILES['image'];
    
    //first we need to check if this scan type already exists for this medium
    $scan_check = $mediaScanDao->checkForScanType($media_id, $type);
    if ($scan_check == null){
        $mediaScanDao->addMediaScanToMedia($media_id, $type, $media_scan_save_path, $image);  
      
        create_log_entry('Game Release', $game_id, 'Media Scan', $release_id, 'Insert', $_SESSION['user_id']);        
        $_SESSION['edit_message'] = "Scan has been added to the media";    
    } else {
        $_SESSION['edit_message'] = "This scan type is already used for this media"; 
    }
    
    
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}

//***********************************************************************************
//remove scan from media
//***********************************************************************************
if (isset($action) && ($action == 'remove_scan')) {  
    
    $mediaScanDao->deleteScanFromMedia($media_scan_id, $media_scan_save_path, $ext);
    
    create_log_entry('Game Release', $game_id, 'Media Scan', $release_id, 'Delete', $_SESSION['user_id']);
    
    $_SESSION['edit_message'] = "Scan has been removed from this media";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
}
    
//close the connection
mysqli_close($mysqli);
