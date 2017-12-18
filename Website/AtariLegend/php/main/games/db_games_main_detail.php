<?php
/***************************************************************************
*                                db_games_main_detail.php
*                            ------------------------------------
*   begin                : Sunday, August 13, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id: db_games_main_detail.php,v 0.1 2017/08/13 21:02 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php code where we update, delete the game's comments
//*********************************************************************************************

include("../../config/common.php");
include("../../config/admin.php");

if (isset($action)) {
    if ($action=='delete_comment') {
        create_log_entry('Games', $comment_id, 'Comment', $comment_id, 'Delete', $_SESSION['user_id']);

        $sql = $mysqli->query("DELETE FROM game_user_comments WHERE comment_id = '$comment_id'") or die("couldn't delete game_comment quote");
        $sql = $mysqli->query("DELETE FROM comments WHERE comments_id = '$comment_id'") or die("couldn't delete comment quote");
    } elseif ($action=="save_comment") {
        //$data = $_POST['data'];
        $data = $mysqli->real_escape_string($data);

        $mysqli->query("UPDATE comments SET comment='$data' WHERE comments_id='$comment_id'") or die("couldn't update comments table");

        create_log_entry('Games', $comment_id, 'Comment', $comment_id, 'Update', $_SESSION['user_id']);
    } elseif ($action=="submit_info") {
        if (isset($subtype) and $subtype == 'medium') {
            if ($textfield_medium == '' or  $textfield_medium == 'Game info') {
                $_SESSION['edit_message'] = "Please add some info in the game info field";
                header("Location: ../games/games_detail.php?game_id=$game_id");
                die();
            } else {
                $timestamp = time();
                $maxsize    = 10000000; //10mb
                $mysqli->query("INSERT INTO game_submitinfo (game_id, user_id, timestamp, submit_text ) VALUES ('$game_id', '$_SESSION[user_id]', '$timestamp', '$textfield_medium')") or die("Inserting the game submission failed");

                $new_game_submit_id = $mysqli->insert_id;
                create_log_entry('Games', $new_game_submit_id, 'Submission', $game_id, 'Insert', $_SESSION['user_id']);

                //Here we'll be looping on each of the inputs on the page that are filled in with an image!
                $image = $_FILES['image_medium'];

                foreach ($image['tmp_name'] as $key => $tmp_name) {
                    if ($tmp_name !== 'none') {
                        // Check what extention the file has and if it is allowed.

                        $ext        = "";
                        $type_image = $image['type'][$key];
                        $size_image = $image['size'][$key];

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
                        if ($size_image < $maxsize) {
                            if ($ext !== "") {
                                // First we insert the directory path of where the file will be stored... this also creates an autoinc number for us.
                                $sdbquery = $mysqli->query("INSERT INTO screenshot_main (screenshot_id,imgext) VALUES ('','$ext')") or die("Database error - inserting screenshots");

                                //select the newly entered screenshot_id from the main table
                                $SCREENSHOT = $mysqli->query("SELECT screenshot_id FROM screenshot_main
                                                       ORDER BY screenshot_id desc") or die("Database error - selecting screenshots");

                                $screenshotrow = $SCREENSHOT->fetch_row();
                                $screenshot_id = $screenshotrow[0];

                                $sdbquery = $mysqli->query("INSERT INTO screenshot_game_submitinfo (game_submitinfo_id, screenshot_id) VALUES ($new_game_submit_id, $screenshot_id)") or die("Database error - inserting screenshots2");

                                // Rename the uploaded file to its autoincrement number and move it to its proper place.
                                $file_data = rename($image['tmp_name'][$key], "$game_submit_screenshot_save_path$screenshotrow[0].$ext");

                                chmod("$game_submit_screenshot_save_path$screenshotrow[0].$ext", 0777);
                            }
                        } else {
                            $_SESSION['edit_message'] = "File is bigger than limit of 10MB";
                            header("Location: ../games/games_detail.php?game_id=$game_id");
                            die();
                        }
                    }
                }
                $_SESSION['edit_message'] = "Game submission has been sent - waiting for approval";
                header("Location: ../games/games_detail.php?game_id=$game_id");
                die();
            }
        } else {
            if ($textfield == '' or  $textfield == 'Game info') {
                $_SESSION['edit_message'] = "Please add some info in the game info field";
                header("Location: ../games/games_detail.php?game_id=$game_id");
                die();
            } else {
                $timestamp = time();
                $maxsize    = 10000000; //10mb
                $mysqli->query("INSERT INTO game_submitinfo (game_id, user_id, timestamp, submit_text ) VALUES ('$game_id', '$_SESSION[user_id]', '$timestamp', '$textfield')") or die("Inserting the game submission failed");

                $new_game_submit_id = $mysqli->insert_id;
                create_log_entry('Games', $new_game_submit_id, 'Submission', $game_id, 'Insert', $_SESSION['user_id']);

                //Here we'll be looping on each of the inputs on the page that are filled in with an image!
                $image = $_FILES['image'];

                foreach ($image['tmp_name'] as $key => $tmp_name) {
                    if ($tmp_name !== 'none') {
                        // Check what extention the file has and if it is allowed.

                        $ext        = "";
                        $type_image = $image['type'][$key];
                        $size_image  = $image['size'][$key];

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

                        if ($size_image < $maxsize) {
                            if ($ext !== "") {
                                // First we insert the directory path of where the file will be stored... this also creates an autoinc number for us.
                                $sdbquery = $mysqli->query("INSERT INTO screenshot_main (screenshot_id,imgext) VALUES ('','$ext')") or die("Database error - inserting screenshots");

                                //select the newly entered screenshot_id from the main table
                                $SCREENSHOT = $mysqli->query("SELECT screenshot_id FROM screenshot_main
                                                       ORDER BY screenshot_id desc") or die("Database error - selecting screenshots");

                                $screenshotrow = $SCREENSHOT->fetch_row();
                                $screenshot_id = $screenshotrow[0];

                                $sdbquery = $mysqli->query("INSERT INTO screenshot_game_submitinfo (game_submitinfo_id, screenshot_id) VALUES ($new_game_submit_id, $screenshot_id)") or die("Database error - inserting screenshots2");

                                // Rename the uploaded file to its autoincrement number and move it to its proper place.
                                $file_data = rename($image['tmp_name'][$key], "$game_submit_screenshot_save_path$screenshotrow[0].$ext");

                                chmod("$game_submit_screenshot_save_path$screenshotrow[0].$ext", 0777);
                            }
                        } else {
                            $_SESSION['edit_message'] = "File is bigger than limit of 10MB";
                            header("Location: ../games/games_detail.php?game_id=$game_id");
                            die();
                        }
                    }
                }
                $_SESSION['edit_message'] = "Game submission has been sent - waiting for approval";
                header("Location: ../games/games_detail.php?game_id=$game_id");
                die();
            }
        }
    } else {
        $data = $mysqli->real_escape_string($data);
        $timestamp = time();

        $mysqli->query("INSERT INTO comments (comment, user_id, timestamp ) VALUES ('$data', '$_SESSION[user_id]', '$timestamp')") or die("Inserting the comment failed");
        $new_comment_id = $mysqli->insert_id;
        $mysqli->query("INSERT INTO game_user_comments (game_id, comment_id) VALUES ('$game_id', '$new_comment_id')") or die("Inserting the comment failed");

        create_log_entry('Games', $new_comment_id, 'Comment', $new_comment_id, 'Insert', $_SESSION['user_id']);
    }

    //Select the comments from the DB
    $sql_comment = $mysqli->query("SELECT *
                                FROM game_user_comments
                                LEFT JOIN comments ON ( game_user_comments.comment_id = comments.comments_id )
                                LEFT JOIN users ON ( comments.user_id = users.user_id )
                                LEFT JOIN game ON ( game_user_comments.game_id = game.game_id )
                                WHERE game_user_comments.game_id = '$game_id'
                                ORDER BY comments.timestamp desc") or die("Syntax Error! Couldn't not get the comments!");

    // lets put the comments in a smarty array
    while ($query_comment = $sql_comment->fetch_array(MYSQLI_BOTH)) {
        $oldcomment = $query_comment['comment'];
        $oldcomment = nl2br($oldcomment);
        $oldcomment = InsertALCode($oldcomment);
        $oldcomment = trim($oldcomment);
        $oldcomment = RemoveSmillies($oldcomment);
        $oldcomment = stripslashes($oldcomment);

        $comment = stripslashes($query_comment['comment']);
        $comment = trim($comment);
        $comment = RemoveSmillies($comment);

        //this is needed, because users can change their own comments on the website, however this is done with JS (instead of a post with pure HTML)
        //The translation of the 'enter' breaks is different in JS, so in JS I do a conversion to a <br>. However, when we edit a comment, this <br> should not be
        //visible to the user, hence again, now this conversion in php
        $breaks = array("<br />","<br>","<br/>");
        $comment = str_ireplace($breaks, "\r\n", $comment);

        $date = date("F j, Y", $query_comment['timestamp']);

        $smarty->append('comments', array(
            'comment' => $oldcomment,
            'comment_edit' => $comment,
            'comment_id' => $query_comment['comment_id'],
            'date' => $date,
            'game' => $query_comment['game_name'],
            'game_id' => $query_comment['game_id'],
            'user_name' => $query_comment['userid'],
            'user_id' => $query_comment['user_id'],
            'user_fb' => $query_comment['user_fb'],
            'user_website' => $query_comment['user_website'],
            'user_twitter' => $query_comment['user_twitter'],
            'user_af' => $query_comment['user_af'],
            'email' => $query_comment['email']));
    }

    $smarty->assign('smarty_action', 'delete_comment');
    $smarty->assign('game_id', $game_id);

    //Send all smarty variables to the templates
    $smarty->display("file:" . $mainsite_template_folder . "ajax_games_main_detail_comments.html");
}
