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

$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);
$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);

$stmt = $mysqli->prepare("SELECT game_name FROM game WHERE game_id = ?") or die($mysqli->error);
$stmt->bind_param("s", $game_id) or die($mysqli->error);
$stmt->execute() or die($mysqli->error);
$stmt->bind_result($edited_game_name) or die($mysqli->error);
$stmt->fetch() or die($mysqli->error);
$stmt->close();

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
    header("Location: ../games/games_detail.php?game_id=$game_id");
}

//***********************************************************************************
//If add aka button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'game_aka') {
    //$sql_aka = $mysqli->query("INSERT INTO game_aka (game_id, aka_name) VALUES ('$game_id','$game_aka')") or die("Couldn't insert aka games");
    $stmt = $mysqli->prepare("INSERT INTO game_aka (game_id, aka_name) VALUES (?,?)") or die($mysqli->error);
    $stmt->bind_param("is", $game_id, $game_aka) or die($mysqli->error);
    $stmt->execute() or die($mysqli->error);
    $stmt->close();

    $new_aka_id = $mysqli->insert_id;
    create_log_entry('Games', $game_id, 'AKA', $new_aka_id, 'Insert', $_SESSION['user_id']);

    $_SESSION['edit_message'] = "AKA link has been added";
    header("Location: ../games/games_detail.php?game_id=$game_id");
}

//***********************************************************************************
//If delete Creator button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'delete_creator') {
    if (isset($game_author_id)) {
        foreach ($game_author_id as $author) {
            create_log_entry('Games', $game_id, 'Creator', $author, 'Delete', $_SESSION['user_id']);

            $mysqli->query("DELETE FROM game_author WHERE game_author_id = '$author' AND game_id = '$game_id'");
            $_SESSION['edit_message'] = "Creator has been deleted";
        }
    } else {
        $_SESSION['edit_message'] = "Please choose a creator";
    }
    header("Location: ../games/games_detail.php?game_id=$game_id");
}

//***********************************************************************************
//If add publisher button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'add_creator') {
    if ($ind_id != '-') {
        $sql = $mysqli->query("INSERT INTO game_author (game_id , ind_id, author_type_id) VALUES ('$game_id','$ind_id', '$author_type_id')") or die("creator insertion failed");

        create_log_entry('Games', $game_id, 'Creator', $ind_id, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Creator has been added";
    } else {
        $_SESSION['edit_message'] = "Please choose a creator";
    }
    header("Location: ../games/games_detail.php?game_id=$game_id");
}

//***********************************************************************************
//If delete publisher button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'delete_publisher') {
    if (isset($game_publisher_id)) {
        foreach ($game_publisher_id as $publisher) {
            create_log_entry('Games', $game_id, 'Publisher', $publisher, 'Delete', $_SESSION['user_id']);

            $mysqli->query("DELETE FROM game_publisher WHERE pub_dev_id = '$publisher' AND game_id = '$game_id'");
            $_SESSION['edit_message'] = "Publisher has been deleted";
        }
    } else {
        $_SESSION['edit_message'] = "Please choose a publisher";
    }
    header("Location: ../games/games_detail.php?game_id=$game_id");
}

//***********************************************************************************
//If add publisher button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'add_publisher') {
    if ($company_id_pub != '-') {
        $sql = $mysqli->query("INSERT INTO game_publisher (pub_dev_id ,game_id, continent_id, game_extra_info_id) VALUES ('$company_id_pub','$game_id','$continent_pub', '$game_extra_info_pub')") or die("Publisher insertion failed");

        create_log_entry('Games', $game_id, 'Publisher', $company_id_pub, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Publisher has been added";
    } else {
        $_SESSION['edit_message'] = "Please choose a publisher";
    }
    header("Location: ../games/games_detail.php?game_id=$game_id");
}

//***********************************************************************************
//If delete developer button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'delete_developer') {
    if (isset($game_developer_id)) {
        foreach ($game_developer_id as $developer) {
            create_log_entry('Games', $game_id, 'Developer', $developer, 'Delete', $_SESSION['user_id']);

            $mysqli->query("DELETE FROM game_developer WHERE dev_pub_id = '$developer' AND game_id = '$game_id'");
            $_SESSION['edit_message'] = "Developer has been deleted";
        }
    } else {
        $_SESSION['edit_message'] = "Please choose a developer";
    }
    header("Location: ../games/games_detail.php?game_id=$game_id");
}

//***********************************************************************************
//If add developer button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'add_developer') {
    if ($company_id_dev != '-') {
        $sql = $mysqli->query("INSERT INTO game_developer (dev_pub_id, game_id, continent_id, game_extra_info_id) VALUES ('$company_id_dev','$game_id','$continent_dev','$game_extra_info_dev')") or die("Developer insertion failed");

        create_log_entry('Games', $game_id, 'Developer', $company_id_dev, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Developer has been added";
    } else {
        $_SESSION['edit_message'] = "Please choose a developer";
    }
    header("Location: ../games/games_detail.php?game_id=$game_id");
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
//If add release button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'add_release') {
    if ($edited_game_name == $release_name) {
        // Prevent creating a relase with the exact same name as the game
        $_SESSION['edit_message'] = "Alternative title for the release must be different than the game one."
            ." If no alternative title, leave it empty";
        header("Location: ../games/games_detail.php?game_id=$game_id");
        exit();
    }
    $release_id = $gameReleaseDao->addReleaseForGame($game_id, $release_name, $Date_Year."-01-01");

    $changeLogDao->insertChangeLog(
        new \AL\Common\Model\Database\ChangeLog(
            -1,
            "Games",
            $game_id,
            $edited_game_name,
            "Release",
            $release_id,
            empty($release_name) ? $edited_game_name : $release_name,
            $_SESSION["user_id"],
            \AL\Common\Model\Database\ChangeLog::ACTION_INSERT
        )
    );

    $_SESSION['edit_message'] = "Release has been added";
    header("Location: ../games/games_detail.php?game_id=$game_id");
}

//***********************************************************************************
//If the modify button has been pressed, update the necesarry tables
//***********************************************************************************
if (isset($action) and $action == 'modify_game') {
    // game_table

    $game_name = $mysqli->real_escape_string($game_name);

    $sdbquery = $mysqli->query("UPDATE game SET game_name='$game_name' WHERE game_id=$game_id") or die("trouble updating game");

    // Delete the category crosses currently in the database for this game
    $sdbquery = $mysqli->query("DELETE FROM game_cat_cross WHERE game_id=$game_id");

    // Insert the values from the passed category array
    if (isset($category)) {
        foreach ($category as $cat) {
            $sdbquery = $mysqli->query("INSERT INTO game_cat_cross (game_id,game_cat_id) VALUES ($game_id,$cat)");
        }
    }

    // Update the public domain tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_free WHERE game_id='$game_id'");

    // then insert the new value if it has been passed.
    if (isset($free)) {
        $sdbquery = $mysqli->query("INSERT INTO game_free (game_id,free) VALUES ('$game_id','$free')");
    }

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

    // Update the STE ONLY tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_ste_only WHERE game_id='$game_id'");

    // then insert the new value if it has been passed.
    if (isset($ste_only)) {
        $sdbquery = $mysqli->query("INSERT INTO game_ste_only (game_id,ste_only) VALUES ('$game_id','$ste_only')");
    }

    // Update the STE ENHANCED tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_ste_enhan WHERE game_id='$game_id'");

    // then insert the new value if it has been passed.
    if (isset($ste_enhanced)) {
        $sdbquery = $mysqli->query("INSERT INTO game_ste_enhan (game_id,ste_enhanced) VALUES ('$game_id','$ste_enhanced')");
    }

    // Update the FALCON ONLY tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_falcon_only WHERE game_id='$game_id'");

    // then insert the new value if it has been passed.
    if (isset($falcon_only)) {
        $sdbquery = $mysqli->query("INSERT INTO game_falcon_only (game_id,falcon_only) VALUES ('$game_id','$falcon_only')");
    }

    // Update the FALCON ENHANCED tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_falcon_enhan WHERE game_id='$game_id'");

    // then insert the new value if it has been passed.
    if (isset($falcon_enhanced)) {
        $sdbquery = $mysqli->query("INSERT INTO game_falcon_enhan (game_id,falcon_enhanced) VALUES ('$game_id','$falcon_enhanced')");
    }

    // Update the FALCON RGB tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_falcon_rgb WHERE game_id='$game_id'");

    // then insert the new value if it has been passed.
    if (isset($falcon_rgb)) {
        $sdbquery = $mysqli->query("INSERT INTO game_falcon_rgb (game_id,falcon_rgb) VALUES ('$game_id','$falcon_rgb')");
    }

    // Update the FALCON VGA tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_falcon_vga WHERE game_id='$game_id'");

    // then insert the new value if it has been passed.
    if (isset($falcon_vga)) {
        $sdbquery = $mysqli->query("INSERT INTO game_falcon_vga (game_id,falcon_vga) VALUES ('$game_id','$falcon_vga')");
    }

    // Update the GAME UNFINISHED tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_unfinished WHERE game_id='$game_id'");

    // then insert the new value if it has been passed.
    if (isset($unfinished)) {
        $sdbquery = $mysqli->query("INSERT INTO game_unfinished (game_id,unfinished) VALUES ('$game_id','$unfinished')");
    }

    // Update the MONOCHROME GAME tick box info
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_mono WHERE game_id='$game_id'");

    // then insert the new value if it has been passed.
    if (isset($monochrome)) {
        $sdbquery = $mysqli->query("INSERT INTO game_mono (game_id,monochrome) VALUES ('$game_id','$monochrome')");
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

    // UPDATE THE SEUCK TICK BOX INFO
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_seuck WHERE game_id='$game_id'");

    // then insert the new value if it has been passed.
    if (isset($seuck)) {
        $sdbquery = $mysqli->query("INSERT INTO game_seuck (game_id,seuck) VALUES ('$game_id','$seuck')") or die("Couldn't insert seuck tick box info");
    }

    // UPDATE THE STOS TICK BOX INFO
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_stos WHERE game_id='$game_id'") or die("STOS Deletion failed");
    ;

    // then insert the new value if it has been passed.
    if (isset($stos)) {
        $sdbquery = $mysqli->query("INSERT INTO game_stos (game_id,stos) VALUES ('$game_id','$stos')");
    }

    // UPDATE THE STAC TICK BOX INFO
    // Start off by deleting previos value
    $sdbquery = $mysqli->query("DELETE FROM game_stac WHERE game_id='$game_id'");

    // then insert the new value if it has been passed.
    if (isset($stac)) {
        $sdbquery = $mysqli->query("INSERT INTO game_stac (game_id,stac) VALUES ('$game_id','$stac')") or die("Couldn't insert stac tick box info");
    }

    $_SESSION['edit_message'] = "Game has been modified";

    create_log_entry('Games', $game_id, 'Game', $game_id, 'Update', $_SESSION['user_id']);

    header("Location: ../games/games_detail.php?game_id=$game_id");
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
                                        $sdbquery = $mysqli->query("DELETE FROM game_publisher WHERE game_id = '$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_developer WHERE game_id = '$game_id' ");
                                        $sdbquery = $mysqli->query("DELETE FROM game_cat_cross WHERE game_id = '$game_id' ");
                                        $sdbquery = $mysqli->query("DELETE FROM game_development WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_unreleased WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_free WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_arcade WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_seuck WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_stos WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_wanted WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_mono WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_unfinished WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_falcon_enhan WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_falcon_only WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_falcon_rgb WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_falcon_vga WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_ste_enhan WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_ste_only WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_aka WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM lingo_game WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_similar WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_series_cross WHERE game_id='$game_id'");
                                        $sdbquery = $mysqli->query("DELETE FROM game_author WHERE game_id='$game_id'");

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

//close the connection
mysqli_close($mysqli);
