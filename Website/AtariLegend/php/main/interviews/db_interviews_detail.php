<?php
/***************************************************************************
 *                                db_interviews_detail.php
 *                            ------------------------------------
 *   begin                : Sunday, August 20, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : Creation of file
 *
 *   Id: db_interviews_detail.php,v 0.1 2017/08/20 23:32 ST Graveyard
 ***************************************************************************/

//*********************************************************************************************
// This is the php code where we update, delete the interviews comments
//*********************************************************************************************

require "../../config/common.php";
require "../../config/admin.php";

if (isset($action)) {
    if ($action=='delete_comment') {
        create_log_entry('Interviews', $comment_id, 'Comment', $comment_id, 'Delete', $_SESSION['user_id']);

        $sql = $mysqli->query("DELETE FROM interview_user_comments WHERE comment_id = '$comment_id'")
            or die("couldn't delete game_comment quote");
        $sql = $mysqli->query("DELETE FROM comments WHERE comments_id = '$comment_id'")
            or die("couldn't delete comment quote");
    } elseif ($action=="save_comment") {
        //$data = $_POST['data'];
        $data = $mysqli->real_escape_string($data);

        $mysqli->query("UPDATE comments SET comment='$data' WHERE comments_id='$comment_id'")
            or die("couldn't update comments table");

        create_log_entry('Interviews', $comment_id, 'Comment', $comment_id, 'Update', $_SESSION['user_id']);
    } else {
        $data = $mysqli->real_escape_string($data);
        $timestamp = time();

        $mysqli->query(
            "INSERT INTO comments (comment, user_id, timestamp ) "
            ."VALUES ('$data', '$_SESSION[user_id]', '$timestamp')"
        )
            or die("Inserting the comment failed");
        $new_comment_id = $mysqli->insert_id;
        $mysqli->query(
            "INSERT INTO interview_user_comments (interview_id, comment_id) "
            ."VALUES ('$interview_id', '$new_comment_id')"
        )
            or die("Inserting the comment failed");

        create_log_entry('Interviews', $interview_id, 'Comment', $new_comment_id, 'Insert', $_SESSION['user_id']);
    }

    //Select the comments from the DB
    $sql_comment = $mysqli->query(
        "SELECT *
                                FROM interview_user_comments
                                LEFT JOIN comments ON ( interview_user_comments.comment_id = comments.comments_id )
                                LEFT JOIN users ON ( comments.user_id = users.user_id )
                                WHERE interview_user_comments.interview_id = '$interview_id'
                                ORDER BY comments.timestamp desc"
    )
                                or die("Syntax Error! Couldn't not get the comments!");

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

        //this is needed, because users can change their own comments on the website, however this is done with JS
        //(instead of a post with pure HTML) The translation of the 'enter' breaks is different in JS, so in JS I do
        //a conversion to a <br>. However, when we edit a comment, this <br> should not be
        //visible to the user, hence again, now this conversion in php
        $breaks = array("<br />","<br>","<br/>");
        $comment = str_ireplace($breaks, "\r\n", $comment);

        $date = date("d/m/y", $query_comment['timestamp']);

        $smarty->append(
            'comments', array(
            'comment' => $oldcomment,
            'comment_edit' => $comment,
            'comment_id' => $query_comment['comment_id'],
            'date' => $date,
            'user_name' => $query_comment['userid'],
            'user_id' => $query_comment['user_id'],
            'user_fb' => $query_comment['user_fb'],
            'user_website' => $query_comment['user_website'],
            'user_twitter' => $query_comment['user_twitter'],
            'user_af' => $query_comment['user_af'],
            'show_email' => $query_comment['show_email'],
            'email' => $query_comment['email']
            )
        );
    }

    $smarty->assign('smarty_action', 'delete_comment');
    $smarty->assign('selected_interview_id', $interview_id);

    //Send all smarty variables to the templates
    $smarty->display("file:" . $mainsite_template_folder . "ajax_interviews_detail_comments.html");
}
