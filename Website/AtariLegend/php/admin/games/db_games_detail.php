<?php
/***************************************************************************
 *                                db_games_detail.php
 *                            ------------------------
 *   begin                : Tuesday, September 6, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *   actual update        : Creation of file
 *
 *   Id: db_games_detail.php,v 0.10 2005/10/06 17:41 Zombieman
 *   Id: db_games_detail.php,v 0.20 2015/11/06 22:16 Zombieman
 *   Id: db_games_detail.php,v 0.30 2015/12/27 22:16 Zombieman - added messages
 *   Id: db_games_detail.php,v 0.40 2016/08/19 STG - added change log
 *   Id: db_games_detail.php,v 0.41 2017/01/06 STG - added falcon vga and rgb option
 *
 ***************************************************************************/

//****************************************************************************************
// This is the detail page of a game. Change all the specifics over here!
//****************************************************************************************

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

require_once __DIR__."/../../common/DAO/GameReleaseDAO.php";
require_once __DIR__."/../../common/DAO/ChangeLogDAO.php";
require_once __DIR__."/../../common/DAO/ProgrammingLanguageDAO.php";
require_once __DIR__."/../../common/DAO/GameGenreDAO.php";
require_once __DIR__."/../../common/DAO/PortDAO.php";
require_once __DIR__."/../../common/DAO/EngineDAO.php";
require_once __DIR__."/../../common/DAO/ControlDAO.php";
require_once __DIR__."/../../common/DAO/SoundHardwareDAO.php";

$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);
$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);
$programmingLanguageDao = new \AL\Common\DAO\ProgrammingLanguageDAO($mysqli);
$gameGenreDao = new \AL\Common\DAO\GameGenreDAO($mysqli);
$portDao = new \AL\Common\DAO\PortDAO($mysqli);
$engineDao = new \AL\Common\DAO\engineDAO($mysqli);
$controlDao = new \AL\Common\DAO\controlDAO($mysqli);
$soundHardwareDao = new \AL\Common\DAO\SoundHardwareDAO($mysqli);

if (isset($game_id)){
    $stmt = $mysqli->prepare("SELECT game_name FROM game WHERE game_id = ?") or die($mysqli->error);
    $stmt->bind_param("s", $game_id) or die($mysqli->error);
    $stmt->execute() or die($mysqli->error);
    $stmt->bind_result($edited_game_name) or die($mysqli->error);
    $stmt->fetch() or die($mysqli->error);
    $stmt->close();
}

//***********************************************************************************
//Insert new game
//***********************************************************************************
if (isset($action) and $action == "insert_game") {
    //Insert the game in the game table
    $stmt = $mysqli->prepare("INSERT INTO game (game_name) VALUES (?)") or die($mysqli->error);
    $stmt->bind_param("s", $newgame) or die($mysqli->error);
    $stmt->execute() or die($mysqli->error);
    $stmt->close();

    $_SESSION['edit_message'] = "The game $newgame has been inserted into the database";

    $new_game_id = $mysqli->insert_id;

    create_log_entry('Games', $new_game_id, 'Game', $new_game_id, 'Insert', $_SESSION['user_id']);

    // Insert a new release by default
    $new_release_id = $gameReleaseDao->addReleaseForGame($new_game_id);

    $changeLogDao->insertChangeLog(
        new \AL\Common\Model\Database\ChangeLog(
            -1,
            "Games",
            $new_game_id,
            $newgame,
            "Release",
            $new_release_id,
            $newgame,
            $_SESSION["user_id"],
            \AL\Common\Model\Database\ChangeLog::ACTION_INSERT
        )
    );

    header("Location: ../games/games_detail.php?game_id=$new_game_id");
}

//***********************************************************************************
//If delete aka link has been pressed
//***********************************************************************************
if (isset($action) and $action == 'delete_aka') {
    create_log_entry('Games', $game_id, 'AKA', $game_aka_id, 'Delete', $_SESSION['user_id']);

    $sql_aka = $mysqli->query("DELETE FROM game_aka WHERE game_aka_id = '$game_aka_id' AND game_id = '$game_id'") or die("Couldn't delete aka");

    $_SESSION['edit_message'] = "AKA link has been deleted";
    header("Location: ../games/games_detail.php?game_id=$game_id#gd_game_aka");
}

//***********************************************************************************
//If add aka button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'game_aka') {

    if ($language_id == ""){
        $language_id = null;
    }

    $stmt = $mysqli->prepare("INSERT INTO game_aka (game_id, aka_name, language_id) VALUES (?,?,?)") or die($mysqli->error);
    $stmt->bind_param("iss", $game_id, $game_aka, $language_id) or die($mysqli->error);
    $stmt->execute() or die($mysqli->error);
    $stmt->close();

    $new_aka_id = $mysqli->insert_id;

    create_log_entry('Games', $game_id, 'AKA', $new_aka_id, 'Insert', $_SESSION['user_id']);

    $_SESSION['edit_message'] = "AKA link has been added";
    header("Location: ../games/games_detail.php?game_id=$game_id#gd_game_aka");
}

//***********************************************************************************
//If update aka link has been pressed
//***********************************************************************************
if (isset($action) and $action == 'update_aka') {
    create_log_entry('Games', $game_id, 'AKA', $game_aka_id, 'Update', $_SESSION['user_id']);

    if ($new_language_id == ""){
        $new_language_id = null;
    }

    $stmt = $mysqli->prepare("UPDATE game_aka SET language_id = ? WHERE game_aka_id = ?") or die($mysqli->error);
    $stmt->bind_param("si", $new_language_id, $game_aka_id) or die($mysqli->error);
    $stmt->execute() or die($mysqli->error);
    $stmt->close();

    $_SESSION['edit_message'] = "AKA link has been updated";
    header("Location: ../games/games_detail.php?game_id=$game_id#gd_game_aka");
}

//***********************************************************************************
//If add soundhardware button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'add_sound_hardware') {

    $soundHardwareDao->addSoundHardwareToGame($game_id, $sound_hardware_id);

    create_log_entry('Games', $game_id, 'Sound hardware', $sound_hardware_id, 'Insert', $_SESSION['user_id']);

    $_SESSION['edit_message'] = "Sound hardware has been deleted";
    header("Location: ../games/games_detail.php?game_id=$game_id#gd_game_aka");
}

//***********************************************************************************
//If delete soundhardware button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'delete_sound_hardware') {

    $soundHardwareDao->deleteSoundHardwareFromGame($game_id, $sound_hardware_id);

    create_log_entry('Games', $game_id, 'Sound hardware', $sound_hardware_id, 'Delete', $_SESSION['user_id']);

    $_SESSION['edit_message'] = "Sound hardware has been added";
    header("Location: ../games/games_detail.php?game_id=$game_id#gd_game_aka");
}

//***********************************************************************************
//If delete release button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'delete_release') {
    if (isset($game_release_id)) {
        foreach ($game_release_id as $release_id) {

            // create_log_entry('Games', $game_id, 'Year', $year, 'Delete', $_SESSION['user_id']);
            $release = $gameReleaseDao->getRelease($release_id);

            $gameReleaseDao->deleteRelease($release_id);

            $changeLogDao->insertChangeLog(
                new \AL\Common\Model\Database\ChangeLog(
                    -1,
                    "Games",
                    $game_id,
                    $edited_game_name,
                    "Release",
                    $release_id,
                    empty($release->getName()) ? $edited_game_name : $release->getName(),
                    $_SESSION["user_id"],
                    \AL\Common\Model\Database\ChangeLog::ACTION_DELETE
                )
            );

            $_SESSION['edit_message'] = "Release has been deleted";
        }
    } else {
        $_SESSION['edit_message'] = "Please choose a release";
    }
    header("Location: ../games/games_detail.php?game_id=$game_id");
}

//***********************************************************************************
//If the modify button has been pressed, update the necesarry tables
//***********************************************************************************
if (isset($action) and $action == 'modify_game') {
    // game_table

    $game_name = $mysqli->real_escape_string($game_name);

    $sdbquery = $mysqli->query("UPDATE game SET game_name='$game_name' WHERE game_id=$game_id") or die("trouble updating game");

    //Update the game genre
    $gameGenreDao->setGameGenreForGame($game_id, isset($game_genre) ? $game_genre : []);
    
    //Update the game engine
    $engineDao->setGameEngineForGame($game_id, isset($game_engine) ? $game_engine : []);
    
    //Update the programming language
    $programmingLanguageDao->setProgrammingLanguageForGame($game_id, isset($programming_language) ? $programming_language : []);
    
    //Update the port
    if ($port_id == ''){$port_id = null;}
    $portDao->setPortForGame($game_id, isset($port_id) ? $port_id : null);
    
    //Update the game controls
    $controlDao->setGameControlForGame($game_id, isset($game_control) ? $game_control : []);

    // Update the Unreleased tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_unreleased WHERE game_id='$game_id'");

    // then insert the new value if it has been passed.
    if (isset($unreleased)) {
        $sdbquery = $mysqli->query("INSERT INTO game_unreleased (game_id,unreleased) VALUES ('$game_id','$unreleased')");
    }

    // Update the In Development tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_development WHERE game_id='$game_id'");

    // then insert the new value if it has been passed.
    if (isset($development)) {
        $sdbquery = $mysqli->query("INSERT INTO game_development (game_id,development) VALUES ('$game_id','$development')");
    }

    // Update the GAME UNFINISHED tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_unfinished WHERE game_id='$game_id'");

    // then insert the new value if it has been passed.
    if (isset($unfinished)) {
        $sdbquery = $mysqli->query("INSERT INTO game_unfinished (game_id,unfinished) VALUES ('$game_id','$unfinished')");
    }

    // Update the game wanted tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_wanted WHERE game_id='$game_id'");

    // then insert the new value if it has been passed.
    if (isset($wanted)) {
        $sdbquery = $mysqli->query("INSERT INTO game_wanted (game_id) VALUES ('$game_id')");
    }

    // UPDATE THE ARCADE TICK BOX INFO
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_arcade WHERE game_id='$game_id'");

    // then insert the new value if it has been passed.
    if (isset($arcade)) {
        $sdbquery = $mysqli->query("INSERT INTO game_arcade (game_id,arcade) VALUES ('$game_id','$arcade')") or die("Couldn't insert arcade tick box info");
    }

    $_SESSION['edit_message'] = "Game has been modified";

    create_log_entry('Games', $game_id, 'Game', $game_id, 'Update', $_SESSION['user_id']);

    header("Location: ../games/games_detail.php?game_id=$game_id#games_detail");
}

//***********************************************************************************
//If the delete button has been pressed, delete the necesarry records from the tables
//***********************************************************************************

if (isset($action) and $action == 'delete_game') {
    //First we need to do a hell of a lot checks before we can delete an actual game.
    $sdbquery = $mysqli->query("SELECT * FROM game_download WHERE game_id='$game_id'") or die("Error getting download info");

    if ($sdbquery->num_rows > 0) {
        $_SESSION['edit_message'] = "Deletion failed - This game has downloads - Delete it in the appropriate section";
        header("Location: ../games/games_detail.php?game_id=$game_id");
    } else {
        $sdbquery = $mysqli->query("SELECT * FROM game_diskscan WHERE game_id='$game_id'") or die("Error getting diskscan info");
        if ($sdbquery->num_rows > 0) {
            $_SESSION['edit_message'] = "Deletion failed - This game has a diskscan - Delete it in the appropriate section";
            header("Location: ../games/games_detail.php?game_id=$game_id");
        } else {
            $sdbquery = $mysqli->query("SELECT * FROM game_gallery WHERE game_id='$game_id'") or die("Error getting gallery info");

            if ($sdbquery->num_rows > 0) {
                $_SESSION['edit_message'] = "Deletion failed - This game has a images in the gallery table - Delete it in the appropriate section";
                header("Location: ../games/games_detail.php?game_id=$game_id");
            } else {
                $sdbquery = $mysqli->query("SELECT * FROM game_boxscan WHERE game_id='$game_id'") or die("Error getting boxscan info");

                if ($sdbquery->num_rows > 0) {
                    $_SESSION['edit_message'] = "Deletion failed - This game has (a) boxscan(s) - Delete it in the appropriate section";
                    header("Location: ../games/games_detail.php?game_id=$game_id");
                } else {
                    $sdbquery = $mysqli->query("SELECT * FROM game_user_comments WHERE game_id='$game_id'") or die("Error getting user comments");

                    if ($sdbquery->num_rows > 0) {
                        $_SESSION['edit_message'] = "Deletion failed - This game has user comments - Delete it in the appropriate section";
                        header("Location: ../games/games_detail.php?game_id=$game_id");
                    } else {
                        $sdbquery = $mysqli->query("SELECT * FROM game_submitinfo WHERE game_id='$game_id'") or die("Error getting submit info");

                        if ($sdbquery->num_rows > 0) {
                            $_SESSION['edit_message'] = "Deletion failed - This game has info submitted from visitors - Delete it in the appropriate section";
                            header("Location: ../games/games_detail.php?game_id=$game_id");
                        } else {
                            $sdbquery = $mysqli->query("SELECT * FROM screenshot_game WHERE game_id='$game_id'") or die("Error getting screenshot info");

                            if ($sdbquery->num_rows > 0) {
                                $_SESSION['edit_message'] = "Deletion failed - This game has screenshots - Delete it in the appropriate section";
                                header("Location: ../games/games_detail.php?game_id=$game_id");
                            } else {
                                $sdbquery = $mysqli->query("SELECT * FROM review_game WHERE game_id='$game_id'") or die("Error getting review info");

                                if ($sdbquery->num_rows > 0) {
                                    $_SESSION['edit_message'] = "Deletion failed - This game has reviews - Delete it in the appropriate section";
                                    header("Location: ../games/games_detail.php?game_id=$game_id");
                                } else {
                                    $sdbquery = $mysqli->query("SELECT * FROM game_music WHERE game_id='$game_id'") or die("Error getting music info");

                                    if ($sdbquery->num_rows > 0) {
                                        $_SESSION['edit_message'] = "Deletion failed - This game has music files attached - Delete it in the appropriate section";
                                        header("Location: ../games/games_detail.php?game_id=$game_id");
                                    } else {
                                        $sdbquery = $mysqli->query("SELECT * FROM game_fact WHERE game_id='$game_id'") or die("Error getting fact info");

                                        if ($sdbquery->num_rows > 0) {
                                            $_SESSION['edit_message'] = "Deletion failed - This game has a fact linked to it - Delete it in the appropriate section";
                                            header("Location: ../games/games_detail.php?game_id=$game_id");
                                        } else {
                                            $sdbquery = $mysqli->query("SELECT * FROM game_release WHERE game_id='$game_id'") or die("Error getting release info");

                                            if ($sdbquery->num_rows > 0) {
                                                $_SESSION['edit_message'] = "Deletion failed - This game has releases linked to it - Delete it in the appropriate section";
                                                header("Location: ../games/games_detail.php?game_id=$game_id");
                                            } else {
                                                $sdbquery = $mysqli->query("SELECT * FROM game_sound_hardware WHERE game_id='$game_id'") or die("Error getting sound_hardware info");
                                                if ($sdbquery->num_rows > 0) {
                                                    $_SESSION['edit_message'] = "Deletion failed - This game has sound hardware linked - Delete it in the appropriate section";
                                                    header("Location: ../games/games_detail.php?game_id=$game_id");
                                                } else {   
                                                    create_log_entry('Games', $game_id, 'Game', $game_id, 'Delete', $_SESSION['user_id']);

                                                    $releases = $gameReleaseDao->getReleasesForGame($game_id);
                                                    foreach ($releases as $release) {
                                                        $gameReleaseDao->deleteRelease($release->getId());

                                                        $changeLogDao->insertChangeLog(
                                                            new \AL\Common\Model\Database\ChangeLog(
                                                                -1,
                                                                "Games",
                                                                $game_id,
                                                                $edited_game_name,
                                                                "Release",
                                                                $release->getId(),
                                                                $edited_game_name,
                                                                $_SESSION["user_id"],
                                                                \AL\Common\Model\Database\ChangeLog::ACTION_DELETE
                                                            )
                                                        );
                                                    }

                                                    $sdbquery = $mysqli->query("DELETE FROM game WHERE game_id = '$game_id' ");
<<<<<<< HEAD
=======
                                                    //$sdbquery = $mysqli->query("DELETE FROM game_publisher WHERE game_id = '$game_id'");
>>>>>>> CleanUpTables
                                                    $sdbquery = $mysqli->query("DELETE FROM game_developer WHERE game_id = '$game_id' ");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_genre_cross WHERE game_id = '$game_id' ");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_development WHERE game_id='$game_id'");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_unreleased WHERE game_id='$game_id'");
<<<<<<< HEAD
                                                    $sdbquery = $mysqli->query("DELETE FROM game_programming_language WHERE game_id='$game_id'");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_engine WHERE game_id='$game_id'");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_control WHERE game_id='$game_id'");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_wanted WHERE game_id='$game_id'");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_unfinished WHERE game_id='$game_id'");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_aka WHERE game_id='$game_id'");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_similar WHERE game_id='$game_id'");
=======
                                                    //$sdbquery = $mysqli->query("DELETE FROM game_free WHERE game_id='$game_id'");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_programming_language WHERE game_id='$game_id'");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_engine WHERE game_id='$game_id'");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_control WHERE game_id='$game_id'");
                                                    //$sdbquery = $mysqli->query("DELETE FROM game_arcade WHERE game_id='$game_id'");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_wanted WHERE game_id='$game_id'");
                                                    //$sdbquery = $mysqli->query("DELETE FROM game_mono WHERE game_id='$game_id'");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_unfinished WHERE game_id='$game_id'");
                                                    //$sdbquery = $mysqli->query("DELETE FROM game_falcon_enhan WHERE game_id='$game_id'");
                                                    //$sdbquery = $mysqli->query("DELETE FROM game_falcon_only WHERE game_id='$game_id'");
                                                    //$sdbquery = $mysqli->query("DELETE FROM game_falcon_rgb WHERE game_id='$game_id'");
                                                    //$sdbquery = $mysqli->query("DELETE FROM game_falcon_vga WHERE game_id='$game_id'");
                                                    //$sdbquery = $mysqli->query("DELETE FROM game_ste_enhan WHERE game_id='$game_id'");
                                                    //$sdbquery = $mysqli->query("DELETE FROM game_ste_only WHERE game_id='$game_id'");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_aka WHERE game_id='$game_id'");
                                                    //$sdbquery = $mysqli->query("DELETE FROM lingo_game WHERE game_id='$game_id'");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_similar WHERE game_id='$game_id'");
                                                    //$sdbquery = $mysqli->query("DELETE FROM game_series_cross WHERE game_id='$game_id'");
                                                    //$sdbquery = $mysqli->query("DELETE FROM game_author WHERE game_id='$game_id'");
>>>>>>> CleanUpTables
                                                    $sdbquery = $mysqli->query("DELETE FROM game_individual WHERE game_id='$game_id'");
                                                    $sdbquery = $mysqli->query("DELETE FROM game_sound_hardware WHERE game_id='$game_id'");

                                                    $_SESSION['edit_message'] = "Game has been deleted";

                                                    header("Location: ../games/games_main.php");
                                                    $smarty->assign("user_id", $_SESSION['user_id']);

                                                    //close the connection
                                                    mysqli_free_result();
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

//close the connection
mysqli_close($mysqli);
