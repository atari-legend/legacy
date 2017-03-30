<?php
/********************************************************************************
 *                                games_screenshots_add.php
 *                            ---------------------------------
 *   begin                : Tuesday, november 9, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *   actual update        : Creation of file
 *
 *   Id: games_screenshots_add.php,v 0.10 2005/11/09 23:02 ST Gravedigger
 *   Id: games_screenshots_add.php,v 0.20 2016/07/16 23:21 ST Gravedigger
 *                                  - AL 2.0
 *   Id: games_screenshots_add.php,v 0.30 2016/08/19 9:31 ST Gravedigger
 *                                  - Change log
 *   id: games_screenshots_add.php,v 0.31 2017/02/26 22:19 STG
 *                          - fix sql warnings stonish server
 *********************************************************************************/

//****************************************************************************************
// This is the image selection/upload screen for the games
//****************************************************************************************

include("../../config/common.php");
include("../../config/admin.php");
include("../../admin/games/quick_search_games.php");

//If we are uploading new screenshots
if (isset($action) and $action == 'add_screens') {
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

                $sdbquery = $mysqli->query("INSERT INTO screenshot_game (game_id, screenshot_id) VALUES ($game_id, $screenshot_id)") or die("Database error - inserting screenshots2");

                // Rename the uploaded file to its autoincrement number and move it to its proper place.
                $file_data = rename($image['tmp_name'][$key], "$game_screenshot_save_path$screenshotrow[0].$ext");

                chmod("$game_screenshot_save_path$screenshotrow[0].$ext", 0777);

                create_log_entry('Games', $game_id, 'Screenshot', $game_id, 'Insert', $_SESSION['user_id']);

                $_SESSION['edit_message'] = "screenshot uploaded";

                header("Location: ../games/games_screenshot_add.php?game_id=$game_id");
            }
        }
    }
}

//If we pressed the delete screenshot link
if (isset($action) and $action == 'delete_screen') {
    $sql_gameshot = $mysqli->query("SELECT * FROM screenshot_game
                                      WHERE game_id = $game_id
                                      AND screenshot_id = $screenshot_id") or die("Database error - selecting screenshots game");

    $gameshot   = $sql_gameshot->fetch_row();
    $gameshotid = $gameshot[0];

    //get the extension
    $SCREENSHOT = $mysqli->query("SELECT * FROM screenshot_main
                              WHERE screenshot_id = '$screenshot_id'") or die("Database error - selecting screenshots");

    $screenshotrow  = $SCREENSHOT->fetch_array(MYSQLI_BOTH);
    $screenshot_ext = $screenshotrow['imgext'];

    $sql = $mysqli->query("DELETE FROM screenshot_main WHERE screenshot_id = '$screenshot_id' ");
    $sql = $mysqli->query("DELETE FROM screenshot_game WHERE screenshot_id = '$screenshot_id' ");

    $new_path = $game_screenshot_save_path;
    ;
    $new_path .= $screenshot_id;
    $new_path .= ".";
    $new_path .= $screenshot_ext;

    unlink("$new_path");

    create_log_entry('Games', $game_id, 'Screenshot', $game_id, 'Delete', $_SESSION['user_id']);

    $_SESSION['edit_message'] = "Screenshot deleted succesfully";

    header("Location: ../games/games_screenshot_add.php?game_id=$game_id");
}

//close the connection
mysqli_close($mysqli);
