<?php
/***************************************************************************
 *                                db_games_comment.php
 *                            -----------------------
 *   begin                : Sunday, Sept 18, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : re-creation of code from scratch into new file.
 *
 *   Id: db_games_comment.php,v 1.10 2005/09/19 Silver Surfer
 *   Id: db_games_comment.php,v 1.15 2016/07/21 STG
 *              - AL 2.0 : added messages
 *   Id: db_games_comment.php,v 1.16 2016/08/19 STG
 *              - Change log added
 *   Id: db_games_comment.php,v 1.17 2017/04/27 STG
 *              - added real_escape_string
 *
 ***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

if ($action == "edit_games_comment") {
    //****************************************************************************************
    // This is the game comment edit place
    //****************************************************************************************

    if (isset($comment_text) and isset($comment_id)) {
        $comment_text = $mysqli->real_escape_string($comment_text);
        
        $mysqli->query("UPDATE comments SET comment='$comment_text' WHERE comments_id='$comment_id'") or die("couldn't update comments table");

        create_log_entry('Games', $comment_id, 'Comment', $comment_id, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Comment edited";
    }

    if ($view == "users_comments") {
        header("Location: ../games/games_comment.php?v_counter=$v_counter&c_counter=$c_counter&users_id=$users_id&view=$view");
    } else {
        header("Location: ../games/games_comment.php?v_counter=$v_counter");
    }
}


// Delete
if ($action == "delete_comment") {
    //****************************************************************************************
    // This is the game comment edit place
    //****************************************************************************************

    if (isset($comment_id)) {
        create_log_entry('Games', $comment_id, 'Comment', $comment_id, 'Delete', $_SESSION['user_id']);

        $sql = $mysqli->query("DELETE FROM game_user_comments WHERE comment_id = '$comment_id'") or die("couldn't delete game_comment quote");
        $sql = $mysqli->query("DELETE FROM comments WHERE comments_id = '$comment_id'") or die("couldn't delete comment quote");
        $_SESSION['edit_message'] = "Comment deleted";
    }

    if ($view == "users_comments") {
        header("Location: ../games/games_comment.php?v_counter=$v_counter&c_counter=$c_counter&users_id=$users_id&view=$view");
    } else {
        header("Location: ../games/games_comment.php?v_counter=$v_counter");
    }
}
