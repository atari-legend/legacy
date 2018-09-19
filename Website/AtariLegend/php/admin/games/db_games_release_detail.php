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

$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);
$gameDao = new \AL\Common\DAO\GameDao($mysqli);
$resolutionDao = new \AL\Common\DAO\ResolutionDao($mysqli);
$systemDao = new \AL\Common\DAO\SystemDao($mysqli);
$pubDevDao = new \AL\Common\DAO\PubDevDAO($mysqli);
$locationDao = new \AL\Common\DAO\LocationDAO($mysqli);
$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);
$gameReleaseAkaDao = new \AL\Common\DAO\GameReleaseAkaDAO($mysqli);
$languageDao = new \AL\Common\DAO\LanguageDAO($mysqli);

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
        ($pub_dev_id != '') ? $pub_dev_id : null
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
    
    $systemDao->setIncompatibleSystemsForRelease($release_id, isset($system_incompatible) ? $system_incompatible : []);
    $systemDao->setEnhancedSystemsForRelease($release_id, isset($system_enhanced) ? $system_enhanced : []);
    $resolutionDao->setResolutionsForRelease($release_id, isset($resolution) ? $resolution : []);
    
    create_log_entry('Game Release', $game_id, 'Release Features', $release_id, 'Update', $_SESSION['user_id']);
    
    if ($submit_type == "save_and_back") {
        header("Location: games_detail.php?game_id=".$game_id);
    } else {
        header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$release_id");
    }
}
    
//close the connection
mysqli_close($mysqli);
