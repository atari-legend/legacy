<?php
/***************************************************************************
 *                                db_games_review_comment.php
 *                            ---------------------------------
 *   begin                : Wednesday, August 23, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : 
 *   actual update        : re-creation of code from scratch into new file.
 *
 *   Id: db_games_review_comment.php,v 0.1 2017/08/23 STG
 ***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../../config/common.php");
include("../../config/admin.php");

if ($action == "edit_reviews_comment") {
    //****************************************************************************************
    // This is the review comment edit place
    //****************************************************************************************

    if (isset($comment_text) and isset($comment_id)) {
        
        $comment_text = $mysqli->real_escape_string($comment_text);
        
        $mysqli->query("UPDATE comments SET comment='$comment_text' WHERE comments_id='$comment_id'") or die("couldn't update comments table");

        create_log_entry('Reviews', $comment_id, 'Comment', $comment_id, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Comment edited";
    }

    if ($view == "users_comments") {
        header("Location: ../games/games_review_comment.php?v_counter=$v_counter&c_counter=$c_counter&users_id=$users_id&view=$view");
    } else {
        header("Location: ../games/games_review_comment.php?v_counter=$v_counter");
    }
}


// Delete
if ($action == "delete_comment") {
    //****************************************************************************************
    // This is the review comment edit place
    //****************************************************************************************

    if (isset($comment_id)) {
        create_log_entry('Reviews', $comment_id, 'Comment', $comment_id, 'Delete', $_SESSION['user_id']);

        $sql = $mysqli->query("DELETE FROM review_user_comments WHERE comment_id = '$comment_id'") or die("couldn't delete review_comment quote");
        $sql = $mysqli->query("DELETE FROM comments WHERE comments_id = '$comment_id'") or die("couldn't delete comment quote");
        $_SESSION['edit_message'] = "Comment deleted";
    }

    if ($view == "users_comments") {
        header("Location: ../games/games_review_comment.php?v_counter=$v_counter&c_counter=$c_counter&users_id=$users_id&view=$view");
    } else {
        header("Location: ../games/games_review_comment.php?v_counter=$v_counter");
    }
}
