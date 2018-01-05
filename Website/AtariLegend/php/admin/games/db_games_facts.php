<?php
/***************************************************************************
 *                                db_games_facts.php
 *                            -----------------------
 *   begin                : Saturday, September 09, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *
 *   Id: gdb_games_facts.php,v 1.0  2017/09/09 ST Graveyard
 ***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

if ($action == "game_fact_insert") {
    if ($fact_text == '') {
        $_SESSION['edit_message'] = "Please add an actual fact in the textfield";
        header("Location: ../games/games_facts.php?game_id=$game_id&game_name=$game_name");
    } else {
        $fact_text = $mysqli->real_escape_string($fact_text);

        $mysqli->query("INSERT INTO game_fact (game_id, game_fact ) VALUES ('$game_id', '$fact_text')") or die("Inserting the game fact failed");

        $new_game_fact_id = $mysqli->insert_id;
        create_log_entry('Games', $game_id, 'Fact', $game_id, 'Insert', $_SESSION['user_id']);

        //Here we'll be looping on each of the inputs on the page that are filled in with an image!
        $image = $_FILES['image'];

        foreach ($image['tmp_name'] as $key => $tmp_name) {
            if ($tmp_name !== 'none') {
                // Check what extention the file has and if it is allowed.

                $ext        = "";
                $type_image = $image['type'][$key];

                // set extension
                if ($type_image == 'image/png') {
                    $ext = 'png';
                }

                if ($type_image == 'image/x-png') {
                    $ext = 'png';
                } elseif ($type_image == 'image/gif') {
                    $ext = 'gif';
                } elseif ($type_image == 'image/jpeg') {
                    $ext = 'jpg';
                }

                if ($ext !== "") {
                    // First we insert the directory path of where the file will be stored... this also creates an autoinc number for us.
                    $sdbquery = $mysqli->query("INSERT INTO screenshot_main (screenshot_id,imgext) VALUES ('','$ext')") or die("Database error - inserting screenshots");

                    //select the newly entered screenshot_id from the main table
                    $SCREENSHOT = $mysqli->query("SELECT screenshot_id FROM screenshot_main
                                           ORDER BY screenshot_id desc") or die("Database error - selecting screenshots");

                    $screenshotrow = $SCREENSHOT->fetch_row();
                    $screenshot_id = $screenshotrow[0];

                    $sdbquery = $mysqli->query("INSERT INTO screenshot_game_fact (game_fact_id, screenshot_id) VALUES ($new_game_fact_id, $screenshot_id)") or die("Database error - inserting screenshots2");

                    // Rename the uploaded file to its autoincrement number and move it to its proper place.
                    $file_data = rename($image['tmp_name'][$key], "$game_fact_screenshot_save_path$screenshotrow[0].$ext");

                    chmod("$game_fact_screenshot_save_path$screenshotrow[0].$ext", 0777);
                }
            }
        }
        header("Location: ../games/games_facts.php?game_id=$game_id&game_name=$game_name");
    }
}

if ($action == "fact_delete") {
    //****************************************************************************************
    // This is the delete submission
    //****************************************************************************************

    if (isset($fact_id)) {
        //Let's first check if this submission has screenshots.
        $query_fact_screenshot = $mysqli->query("SELECT * FROM screenshot_game_fact WHERE game_fact_id = " . $fact_id . "") or die("something is wrong with mysqli of fact screenshots");

        while ($sql_fact_screenshot = $query_fact_screenshot->fetch_array(MYSQLI_BOTH)) {
            $screenshot_id = $sql_fact_screenshot['screenshot_id'];

            //get the extension
            $SCREENSHOT = $mysqli->query("SELECT * FROM screenshot_main
                                      WHERE screenshot_id = '$screenshot_id'") or die("Database error - selecting screenshots");

            $screenshotrow  = $SCREENSHOT->fetch_array(MYSQLI_BOTH);
            $screenshot_ext = $screenshotrow['imgext'];

            $sql = $mysqli->query("DELETE FROM screenshot_main WHERE screenshot_id = '$screenshot_id' ");
            $sql = $mysqli->query("DELETE FROM screenshot_game_fact WHERE screenshot_id = '$screenshot_id' ");

            $new_path = $game_fact_screenshot_save_path;
            $new_path .= $screenshot_id;
            $new_path .= ".";
            $new_path .= $screenshot_ext;

            unlink("$new_path");
        }

        create_log_entry('Games', $game_id, 'Fact', $game_id, 'Delete', $_SESSION['user_id']);

        $sql = $mysqli->query("DELETE FROM game_fact WHERE game_fact_id = '$fact_id'") or die("couldn't delete game_fact quote");

        $_SESSION['edit_message'] = "Fact deleted";
        header("Location: ../games/games_facts.php?game_id=$game_id&game_name=$game_name");
    }
}

if ($action == "delete_screenshot") {
    //****************************************************************************************
    // Delete the screenshot of a fact
    //****************************************************************************************
    //get the extension
    $SCREENSHOT = $mysqli->query("SELECT * FROM screenshot_main
                              WHERE screenshot_id = '$screenshot_id'") or die("Database error - selecting screenshots");

    $screenshotrow  = $SCREENSHOT->fetch_array(MYSQLI_BOTH);
    $screenshot_ext = $screenshotrow['imgext'];

    $sql = $mysqli->query("DELETE FROM screenshot_main WHERE screenshot_id = '$screenshot_id' ") or die("Database error - deleting from screenshot_main");
    $sql = $mysqli->query("DELETE FROM screenshot_game_fact WHERE screenshot_id = '$screenshot_id' ") or die("Database error - deleting from screenshot_game_fact");

    $new_path = $game_fact_screenshot_save_path;
    $new_path .= $screenshot_id;
    $new_path .= ".";
    $new_path .= $screenshot_ext;

    unlink("$new_path");

    create_log_entry('Games', $game_id, 'Fact', $game_id, 'Delete shot', $_SESSION['user_id']);

    $_SESSION['edit_message'] = "Screenshot deleted";
    header("Location: ../games/games_facts.php?game_id=$game_id");
}

if ($action == "fact_update") {
    //****************************************************************************************
    // Update the fact
    //****************************************************************************************
    $fact_text = $mysqli->real_escape_string($fact);
    $mysqli->query("UPDATE game_fact SET game_fact='$fact_text' WHERE game_fact_id='$fact_id'") or die("couldn't update game_facts table");

    create_log_entry('Games', $game_id, 'Fact', $game_id, 'Update', $_SESSION['user_id']);
    header("Location: ../games/games_facts.php?game_id=$game_id");
}
