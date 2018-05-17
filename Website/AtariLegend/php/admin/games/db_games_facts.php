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
//include("../../config/admin_rights.php");

if ($action == "game_fact_insert") {
    include("../../config/admin_rights.php");
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

if ($action == "fact_delete" or $action == "delete_screenshot") {
    //****************************************************************************************
    // This is the delete submission
    //****************************************************************************************
    if (isset($fact_id)) {
        if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {
            if ($action == "fact_delete"){
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
                
                $osd_message = "Fact deleted";   
            }else{
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

                $osd_message = "Screenshot deleted";  
            }
        } else {
            $osd_message = "You don't have permission to perform this task";   
        }
        
        //load the facts for this games
        $query_games_facts = $mysqli->query("SELECT * from game_fact
                                             LEFT JOIN game ON (game.game_id = game_fact.game_id)
                                             WHERE game_fact.game_id = $game_id") or die("error in query game facts");
        
        $i = 0;        

        while ($sql_games_facts  = $query_games_facts->fetch_array(MYSQLI_BOTH)) {
            $i++;

            //check if there are screenshot added to the submission
            $query_screenshots_facts = $mysqli->query("SELECT * FROM screenshot_main
                                                LEFT JOIN screenshot_game_fact ON (screenshot_main.screenshot_id = screenshot_game_fact.screenshot_id)
                                                WHERE screenshot_game_fact.game_fact_id = '$sql_games_facts[game_fact_id]'") or die("Error - Couldn't query fact screenshots");

            while ($sql_screenshots_facts = $query_screenshots_facts->fetch_array(MYSQLI_BOTH)) {
                $new_path = $game_fact_screenshot_path;
                $new_path .= $sql_screenshots_facts['screenshot_id'];
                $new_path .= ".";
                $new_path .= $sql_screenshots_facts['imgext'];

                $smarty->append(
                    'facts_screenshots',
                    array('game_fact_id' => $sql_games_facts['game_fact_id'],
                       'screenshot_id' => $sql_screenshots_facts['screenshot_id'],
                       'game_fact_screenshot' => $new_path)
                );
            }

            $fact_text = nl2br($sql_games_facts['game_fact']);
            $fact_text = InsertALCode($fact_text);

            $smarty->append('facts', array(
                'game_id' => $sql_games_facts['game_id'],
                'game_name' => $sql_games_facts['game_name'],
                'game_fact_id' => $sql_games_facts['game_fact_id'],
                'game_fact_nr' => $i,
                'game_fact' => $fact_text
            ));
            
            $smarty->assign('game_name', $sql_games_facts['game_name']);
        }

        $smarty->assign('game_id', $game_id);
        
        $smarty->assign('smarty_action', 'delete_game_facts');
        
        $smarty->assign('osd_message', $osd_message);
        
        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_game_facts_edit.html");
    }
}

if ($action == "fact_update") {
    include("../../config/admin_rights.php");

    //****************************************************************************************
    // Update the fact
    //****************************************************************************************
    $fact_text = $mysqli->real_escape_string($fact_text);
    $mysqli->query("UPDATE game_fact SET game_fact='$fact_text' WHERE game_fact_id='$fact_id'") or die("couldn't update game_facts table");

    create_log_entry('Games', $game_id, 'Fact', $game_id, 'Update', $_SESSION['user_id']);
    $_SESSION['edit_message'] =  "fact updated";   
    
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

                $sdbquery = $mysqli->query("INSERT INTO screenshot_game_fact (game_fact_id, screenshot_id) VALUES ($fact_id, $screenshot_id)") or die("Database error - inserting screenshots2");

                // Rename the uploaded file to its autoincrement number and move it to its proper place.
                $file_data = rename($image['tmp_name'][$key], "$game_fact_screenshot_save_path$screenshotrow[0].$ext");

                chmod("$game_fact_screenshot_save_path$screenshotrow[0].$ext", 0777);
            }
        }
    }

    //load the facts for this games
    $query_games_facts = $mysqli->query("SELECT * from game_fact
                                         LEFT JOIN game ON (game.game_id = game_fact.game_id)
                                         WHERE game_fact.game_id = $game_id") or die("error in query game facts");
    
    $i = 0;        

    while ($sql_games_facts = $query_games_facts->fetch_array(MYSQLI_BOTH)) {
        $i++;

        //check if there are screenshot added to the submission
        $query_screenshots_facts = $mysqli->query("SELECT * FROM screenshot_main
                                            LEFT JOIN screenshot_game_fact ON (screenshot_main.screenshot_id = screenshot_game_fact.screenshot_id)
                                            WHERE screenshot_game_fact.game_fact_id = '$sql_games_facts[game_fact_id]'") or die("Error - Couldn't query fact screenshots");

        while ($sql_screenshots_facts = $query_screenshots_facts->fetch_array(MYSQLI_BOTH)) {
            $new_path = $game_fact_screenshot_path;
            $new_path .= $sql_screenshots_facts['screenshot_id'];
            $new_path .= ".";
            $new_path .= $sql_screenshots_facts['imgext'];

            $smarty->append(
                'facts_screenshots',
                array('game_fact_id' => $sql_games_facts['game_fact_id'],
                   'screenshot_id' => $sql_screenshots_facts['screenshot_id'],
                   'game_fact_screenshot' => $new_path)
            );
        }

        $fact_text = nl2br($sql_games_facts['game_fact']);
        $fact_text = InsertALCode($fact_text);

        $smarty->append('facts', array(
            'game_id' => $sql_games_facts['game_id'],
            'game_name' => $sql_games_facts['game_name'],
            'game_fact_id' => $sql_games_facts['game_fact_id'],
            'game_fact_nr' => $i,
            'game_fact' => $fact_text
        ));
    }

    $smarty->assign('game_id', $game_id);
    $smarty->assign('game_name', $game_name);

    header("Location: ../games/games_facts.php?game_id=$game_id");
}
