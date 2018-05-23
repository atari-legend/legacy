<?php
/***************************************************************************
 *                                db_games_submissions.php
 *                            -----------------------
 *   begin                : Sunday, Sept 18, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : re-creation of code from scratch into new file.
 *
 *   Id: db_games_submissions.php,v 1.10 2005/09/19 Silver Surfer
 *   Id: db_games_submissions.php,v 1.10 2016/07/27 STG
 *      - AL 2.0 : added messages
 *   Id: db_games_submissions.php,v 1.11 2016/08/19 STG
 *      - added change log
 *   Id: db_games_submissions.php,v 1.12 2017/09/08 STG
 *      - Enhanced for submissions with screenshots
 *
 ***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

if ($action == "update_submission") {
    if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {
        //****************************************************************************************
        // This is where the submissions get "sent" to "done"
        //****************************************************************************************
        if (isset($submit_id)) {
            $commentquery = $mysqli->query("UPDATE game_submitinfo SET game_done = '1' WHERE game_submitinfo_id='$submit_id'");

            $sql_user = $mysqli->query("SELECT user_id FROM game_submitinfo WHERE game_submitinfo_id='$submit_id'");

            list($user_id) = $sql_user->fetch_array(MYSQLI_BOTH);
            $karma_action = "game_submission";

            UserKarma($user_id, $karma_action);
        }

        $osd_message = "Submission set to done status - transferred to done list";

        create_log_entry('Games', $submit_id, 'Submission', $submit_id, 'Update', $_SESSION['user_id']);
    }else{
        $osd_message = "You don't have permission to perform this task";
    }
    
    $smarty->assign('action', 'approve_submission');
    $smarty->assign('osd_message', $osd_message);
    
//  Get the submissions    
    if (empty($v_counter)) {
        $v_counter = 0;
    }
    if (!isset($list)) {
        $list = "current";
    }

    $sql_submission = $mysqli->query("SELECT * FROM game_submitinfo
                                        LEFT JOIN game ON (game_submitinfo.game_id = game.game_id)
                                        LEFT JOIN users ON (game_submitinfo.user_id = users.user_id)
                                        WHERE game_done <> '1' OR game_done IS NULL
                                        ORDER BY game_submitinfo.game_submitinfo_id
                                        DESC LIMIT  " . $v_counter . ", 25");

    //check the number of comments
    $query_number = $mysqli->query("SELECT * FROM game_submitinfo
                                             WHERE game_done <> '1' OR game_done IS NULL
                                             ORDER BY game_submitinfo_id DESC") or die("Couldn't get the number of game submissions");

    $v_rows = $query_number->num_rows;
    $number_sub = $sql_submission->num_rows;

    while ($query_submission = $sql_submission->fetch_array(MYSQLI_BOTH)) {
        //check if there are screenshot added to the submission
        $query_screenshots_submission = $mysqli->query("SELECT * FROM screenshot_main
                                            LEFT JOIN screenshot_game_submitinfo ON (screenshot_main.screenshot_id = screenshot_game_submitinfo.screenshot_id)
                                            WHERE screenshot_game_submitinfo.game_submitinfo_id = '$query_submission[game_submitinfo_id]'") or die("Error - Couldn't query submitinfo screenshots");

        while ($sql_screenshots_submission = $query_screenshots_submission->fetch_array(MYSQLI_BOTH)) {
            $new_path = $game_submit_screenshot_path;
            $new_path .= $sql_screenshots_submission['screenshot_id'];
            $new_path .= ".";
            $new_path .= $sql_screenshots_submission['imgext'];

            $smarty->append(

                'submission_screenshots',
                array('game_submitinfo_id' => $sql_screenshots_submission['game_submitinfo_id'],
                'game_submitinfo_screenshot' => $new_path)
            );
        }

        // Retrive userstats from database
        $query_user         = $mysqli->query("SELECT *
                                   FROM game_user_comments
                                   LEFT JOIN comments ON ( game_user_comments.comment_id = comments.comments_id )
                                   WHERE user_id = " . $query_submission['user_id'] . "");
        $usercomment_number = $query_user->num_rows;

        $query_submitinfo = $mysqli->query("SELECT * FROM game_submitinfo WHERE user_id = " . $query_submission['user_id'] . "") or die("Could not count user submissions");
        $usersubmit_number = $query_submitinfo->num_rows;

        $converted_date = date("F j, Y", $query_submission['timestamp']);
        if ($query_submission['join_date'] !== '') {
            $user_joindate  = date("d-m-y", $query_submission['join_date']);
        } else {
            $user_joindate = "Unknown";
        }
        $comment        = InsertALCode($query_submission['submit_text']);
        $comment        = InsertSmillies($comment);
        $comment        = nl2br($comment);
        $comment        = stripslashes($comment);

        $email_game = rawurlencode($query_submission['game_name']);

        if ($query_submission['avatar_ext'] !== "") {
            $avatar_image = $user_avatar_path;
            $avatar_image .= $query_submission['user_id'];
            $avatar_image .= '.';
            $avatar_image .= $query_submission['avatar_ext'];
        } else {
            $avatar_image = $GLOBALS['style_folder']."/images/default_avatar_image.png";
        }
        $smarty->append('submission', array(
            'game_id' => $query_submission['game_id'],
            'game_name' => $query_submission['game_name'],
            'date' => $converted_date,
            'comment' => $comment,
            'submit_id' => $query_submission['game_submitinfo_id'],
            'user_name' => $query_submission['userid'],
            'user_id' => $query_submission['user_id'],
            'avatar_ext' => $query_submission['avatar_ext'],
            'avatar_image' => $avatar_image,
            'karma' => $query_submission['karma'],
            'user_joindate' => $user_joindate,
            'user_comment_nr' => $usercomment_number,
            'usersubmit_number' => $usersubmit_number,
            'email_game' => $email_game,
            'email' => $query_submission['email']
        ));
    }
    
    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_submission_game.html");
}

if ($action == "delete_submission") {
    //****************************************************************************************
    // This is the delete submission
    //****************************************************************************************

    if (isset($submit_id)) {
        //Let's first check if this submission has screenshots.
        $query_submit_screenshot = $mysqli->query("SELECT * FROM screenshot_game_submitinfo WHERE game_submitinfo_id = " . $submit_id . "") or die("something is wrong with mysqli of submissions screenshots");

        while ($sql_submit_screenshot = $query_submit_screenshot->fetch_array(MYSQLI_BOTH)) {
            $screenshot_id = $sql_submit_screenshot['screenshot_id'];

            //get the extension
            $SCREENSHOT = $mysqli->query("SELECT * FROM screenshot_main
                                      WHERE screenshot_id = '$screenshot_id'") or die("Database error - selecting screenshots");

            $screenshotrow  = $SCREENSHOT->fetch_array(MYSQLI_BOTH);
            $screenshot_ext = $screenshotrow['imgext'];

            $sql = $mysqli->query("DELETE FROM screenshot_main WHERE screenshot_id = '$screenshot_id' ");
            $sql = $mysqli->query("DELETE FROM screenshot_game_submitinfo WHERE screenshot_id = '$screenshot_id' ");

            $new_path = $game_submit_screenshot_save_path;
            $new_path .= $screenshot_id;
            $new_path .= ".";
            $new_path .= $screenshot_ext;

            unlink("$new_path");
        }

        create_log_entry('Games', $submit_id, 'Submission', $submit_id, 'Delete', $_SESSION['user_id']);

        $sql = $mysqli->query("DELETE FROM game_submitinfo WHERE game_submitinfo_id = '$submit_id'") or die("couldn't delete game_submissions quote");
    }

    $_SESSION['edit_message'] = "Submission deleted";

    if ($list == "done") {
        header("Location: ../games/submission_games.php?v_counter=$v_counter&list=$list");
    } else {
        header("Location: ../games/submission_games.php?v_counter=$v_counter");
    }
}

// Move
if ($action == "move_submission_tocomment") {
    //****************************************************************************************
    // This is the move to comments place
    //****************************************************************************************

    if (isset($submit_id)) {
        //Let's first check if this submission has screenshots. If so, it is not suited for movement to comment section!
        $query_submit_screenshot = $mysqli->query("SELECT * FROM screenshot_game_submitinfo WHERE game_submitinfo_id = " . $submit_id . "") or die("something is wrong with mysqli of submissions screenshots");
        $v_rows = $query_submit_screenshot->num_rows;

        if ($v_rows > 0) {
            $_SESSION['edit_message'] = "Submission has screenshots and is not suited for the comment section";
        } else {
            $query_submit = $mysqli->query("SELECT * FROM game_submitinfo WHERE game_submitinfo_id = " . $submit_id . "") or die("something is wrong with mysqli");
            $sql_submit = $query_submit->fetch_array(MYSQLI_BOTH) or die("something is wrong with mysqli2");

            $submit_text   = $sql_submit['submit_text'];
            $submit_text   = $mysqli->real_escape_string($submit_text);
            $sub_timestamp = $sql_submit['timestamp'];
            $sub_user_id   = $sql_submit['user_id'];
            $sub_game_id   = $sql_submit['game_id'];

            $sql = $mysqli->query("INSERT INTO comments (comment,timestamp,user_id) VALUES ('$submit_text','$sub_timestamp','$sub_user_id')") or die("something is wrong with INSERT mysql3");

            $new_comment_id = $mysqli->insert_id;

            $sql = $mysqli->query("INSERT INTO game_user_comments (game_id,comment_id) VALUES ('$sub_game_id',LAST_INSERT_ID())") or die("something is wrong with INSERT mysql4");

            $sql = $mysqli->query("DELETE FROM game_submitinfo WHERE game_submitinfo_id = " . $submit_id . "") or die("couldn't delete game_submissions quote");

            $_SESSION['edit_message'] = "Submission converted to game comment";

            create_log_entry('Games', $new_comment_id, 'Comment', $new_comment_id, 'Insert', $_SESSION['user_id']);
        }
    }

    if ($list == "done") {
        header("Location: ../games/submission_games.php?v_counter=$v_counter&list=$list");
    } else {
        header("Location: ../games/submission_games.php?v_counter=$v_counter");
    }
}
