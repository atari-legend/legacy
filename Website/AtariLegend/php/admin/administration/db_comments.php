<?php
/***************************************************************************
*                              db_comments.php
*                            --------------------------
*   begin                : 2018-02-13
*   copyright            : (C) 2018 Atari Legend
*   email                : admin@atarilegend.com
*
*
***************************************************************************/

// Manage db comments edits and deletes

include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

//****************************************************************************************
// Delete comment
//****************************************************************************************
if (isset($action) and $action == "delete") {
    if (isset($comments_id)) {
        //Set up queries
        $sql_games = "SELECT * FROM game_user_comments WHERE comment_id = '$comments_id'";
        $sql_interviews = "SELECT * FROM interview_user_comments WHERE comment_id = '$comments_id'";
        $sql_gamereviews = "SELECT * FROM review_user_comments WHERE comment_id = '$comments_id'";

        $result = $mysqli->query($sql_games);
        if ($result->num_rows > 0) {
            create_log_entry('Games', $comments_id, 'Comment', $comments_id, 'Delete', $_SESSION['user_id']);
            $message = "Game comment deleted!";
        }
        $result = $mysqli->query($sql_interviews);
        if ($result->num_rows > 0) {
            create_log_entry('Interviews', $comments_id, 'Comment', $comments_id, 'Delete', $_SESSION['user_id']);
            $message = "Interview comment deleted!";
        }
        $result = $mysqli->query($sql_gamereviews);
        if ($result->num_rows > 0) {
            create_log_entry('Reviews', $comments_id, 'Comment', $comments_id, 'Delete', $_SESSION['user_id']);
            $message = "Game review comment deleted!";
        }

        //Set up delete queries
        $sql_games = "DELETE FROM game_user_comments WHERE comment_id = '$comments_id'";
        $sql_interviews = "DELETE FROM interview_user_comments WHERE comment_id = '$comments_id'";
        $sql_gamereviews = "DELETE FROM review_user_comments WHERE comment_id = '$comments_id'";
        $sql_comments = "DELETE FROM comments WHERE comments_id = '$comments_id'";

        $mysqli->query($sql_games);
        if ($mysqli->affected_rows > 0) {
            $mysqli->query($sql_comments);
        }
        $mysqli->query($sql_interviews);
        if ($mysqli->affected_rows > 0) {
            $mysqli->query($sql_comments);
        }
        $mysqli->query($sql_gamereviews);
        if ($mysqli->affected_rows > 0) {
            $mysqli->query($sql_comments);
        }

        echo $message;
    }
    mysqli_close($mysqli);
}
