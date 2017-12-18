<?php
/***************************************************************************
 *                                interviews_comment_edit.php
 *                            -------------------------------
 *   begin                : Monday, August 21, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : re-creation of code from scratch into new file.
 *
 *   Id: interviews_comment_edit.php,v 0.1 2017/08/21 STG
 ***************************************************************************/

/*
 ***********************************************************************************
 This will compile the games comment edit page
 ***********************************************************************************
 */

include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

if (empty($view)) {
    $view = "comment";
}
if (empty($c_counter)) {
    $c_counter = "";
}

$sql_build = "SELECT *  FROM interview_user_comments
                            LEFT JOIN comments ON ( interview_user_comments.comment_id = comments.comments_id )
                            LEFT JOIN users ON ( comments.user_id = users.user_id )
                            LEFT JOIN interview_main ON ( interview_user_comments.interview_id = interview_main.interview_id )
                            LEFT JOIN individuals on ( interview_main.ind_id = individuals.ind_id )
                            LEFT JOIN individual_text ON (individual_text.ind_id = individuals.ind_id)
                            WHERE interview_user_comments_id = '$interview_user_comments_id'";

$sql_comment = $mysqli->query($sql_build) or die("couldn't build query");
$query_comment = $sql_comment->fetch_array(MYSQLI_BOTH) or die("couldn't build query");

$date = date("F j, Y", $query_comment['timestamp']);

$comment = stripslashes($query_comment['comment']);
$comment = trim($comment);

//this is needed, because users can change their own comments on the website, however this is done with JS (instead of a post with pure HTML)
//The translation of the 'enter' breaks is different in JS, so in JS I do a conversion to a <br>. However, when we edit a comment, this <br> should not be 
//visible to the user, hence again, now this conversion in php
$breaks = array("<br />","<br>","<br/>");
$comment = str_ireplace($breaks, "\r\n", $comment);

$smarty->assign('comments', array(
    'comment' => $comment,
    'date' => $date,
    'ind_name' => $query_comment['ind_name'],
    'interview_id' => $query_comment['interview_id'],
    'view' => $view,
    'user_name' => $query_comment['userid'],
    'users_id' => $query_comment['user_id'],
    'interview_user_comments_id' => $interview_user_comments_id,
    'c_counter' => $c_counter,
    'comment_id' => $query_comment['comment_id'],
    'v_counter' => $v_counter
));

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "interviews_comment_edit.html");
