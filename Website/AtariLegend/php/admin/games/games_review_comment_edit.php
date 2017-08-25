<?php
/***************************************************************************
 *                                games_review_comment_edit.php
 *                            ------------------------------------
 *   begin                : wednesday, August 23, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : Creation of file
 *
 *
 *   Id: games_review_comment_edit.php,v 0.10 2017/08/23 17:47 ST Graveyard
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 This will compile the games review comment edit page
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

$sql_comment = $mysqli->query("SELECT * FROM review_user_comments
                                        LEFT JOIN comments ON ( review_user_comments.comment_id = comments.comments_id )
                                        LEFT JOIN users ON ( comments.user_id = users.user_id )
                                        LEFT JOIN review_game ON ( review_user_comments.review_id = review_game.review_id )
                                        LEFT JOIN game ON ( review_game.game_id = game.game_id )
                                        WHERE review_user_comments_id = '$review_user_comments_id'") or die("couldn't build query");
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
    'game' => $query_comment['game_name'],
    'game_id' => $query_comment['game_id'],
    'view' => $view,
    'user_name' => $query_comment['userid'],
    'users_id' => $query_comment['user_id'],
    'review_user_comments_id' => $review_user_comments_id,
    'c_counter' => $c_counter,
    'comment_id' => $query_comment['comment_id'],
    'v_counter' => $v_counter
));

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games_review_comment_edit.html");
