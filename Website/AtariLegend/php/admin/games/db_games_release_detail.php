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
require_once __DIR__."/../../common/DAO/ChangeLogDAO.php";
require_once __DIR__."/../../common/DAO/GameReleaseAkaDAO.php";

$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);
$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);
$gameDao = new \AL\Common\DAO\GameDao($mysqli);
$gameReleaseAkaDAO = new \AL\Common\DAO\GameReleaseAkaDAO($mysqli);

$game = $gameDao->getGame($game_id);

//***********************************************************************************
//If add aka button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'game_release_aka') {
    $changeLogDao->insertChangeLog(
        new \AL\Common\Model\Database\ChangeLog(
            -1,
            "Games",
            $game_id,
            $game->getName(),
            "Release",
            $game_release_id,
            ($name == '') ? $game->getName() : $name,
            $_SESSION["user_id"],
            \AL\Common\Model\Database\ChangeLog::ACTION_UPDATE
        )
    );

    if ($language_id == ""){
        $language_id = null;
    }

    $gameReleaseAkaDAO->AddAkaForRelease($game_release_id, $game_release_aka, $language_id);

    $_SESSION['edit_message'] = "AKA link has been added";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$game_release_id");
}

//***********************************************************************************
//If update release_aka link has been pressed
//***********************************************************************************
if (isset($action) and $action == 'update_release_aka') {
    $changeLogDao->insertChangeLog(
        new \AL\Common\Model\Database\ChangeLog(
            -1,
            "Games",
            $game_id,
            $game->getName(),
            "Release",
            $game_release_id,
            ($name == '') ? $game->getName() : $name,
            $_SESSION["user_id"],
            \AL\Common\Model\Database\ChangeLog::ACTION_UPDATE
        )
    );

    if ($new_language_id == ""){
        $new_language_id = null;
    }
    
    $gameReleaseAkaDAO->UpdateLanguageForReleaseAka($new_language_id, $game_release_aka_id);

    $_SESSION['edit_message'] = "AKA link has been updated";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$game_release_id");
}

//***********************************************************************************
//If delete aka link has been pressed
//***********************************************************************************
if (isset($action) and $action == 'delete_release_aka') {
    $changeLogDao->insertChangeLog(
        new \AL\Common\Model\Database\ChangeLog(
            -1,
            "Games",
            $game_id,
            $game->getName(),
            "Release",
            $game_release_id,
            ($name == '') ? $game->getName() : $name,
            $_SESSION["user_id"],
            \AL\Common\Model\Database\ChangeLog::ACTION_UPDATE
        )
    );

    $gameReleaseAkaDAO->DeleteAkaForRelease($game_release_aka_id, $game_release_id);

    $_SESSION['edit_message'] = "AKA link has been deleted";
    header("Location: ../games/games_release_detail.php?game_id=$game_id&release_id=$game_release_id");
}


//close the connection
mysqli_close($mysqli);
