<?php
/***************************************************************************
 *                                Games_reviews_detail.php
 *                            ---------------------------------
 *   begin                : Wednesday, August 23, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *
 *   Id: Games_reviews_detail.php,v 0.1 2017/08/23 13:02 STG
 ****************************************************************************/

//****************************************************************************************
// This is the detail page of a review.
//****************************************************************************************

//load all common functions
require "../../config/common.php";

//load the tiles
require "../../common/tiles/latest_reviews_tile.php";
require "../../common/tiles/tile_bug_report.php";

//***********************************************************************************
//Let's get all the review and author data
//***********************************************************************************
$count= 0;

$sql_review = $mysqli->query(
    "SELECT * FROM game
                           LEFT JOIN review_game ON (game.game_id = review_game.game_id)
                           LEFT JOIN review_main ON (review_game.review_id = review_main.review_id)
                           LEFT JOIN review_score ON (review_main.review_id = review_score.review_id)
                           LEFT JOIN users ON (review_main.user_id = users.user_id)
                           WHERE review_game.review_id = '$review_id'
                           AND review_main.review_edit = '0'"
) or die("Error - Couldn't query review data");

$query_review = $sql_review->fetch_array(MYSQLI_BOTH);

$review_date = date("F j, Y", $query_review['review_date']);
$review_text = $query_review['review_text'];
$review_text = nl2br($review_text);
$review_text = InsertALCode($review_text);

$smarty->assign(
    'review', array(
    'user_name' => $query_review['userid'],
    'user_id' => $query_review['user_id'],
    'userid' => $query_review['userid'],
    'email' => $query_review['email'],
    'game_id' => $query_review['game_id'],
    'date' => $review_date,
    'game_name' => $query_review['game_name'],
    'game_id' => $query_review['game_id'],
    'review_id' => $review_id,
    'text' => $review_text
    )
);

$smarty->assign(
    'score', array(
    'graphics' => $query_review['review_graphics'],
    'sound' => $query_review['review_sound'],
    'gameplay' => $query_review['review_gameplay'],
    'overall' => $query_review['review_overall']
    )
);

//Get the screenshots and the comments of this review
$query_screenshots = $mysqli->query(
    "SELECT * FROM review_main
    LEFT JOIN screenshot_review ON (review_main.review_id = screenshot_review.review_id)
    LEFT JOIN screenshot_main ON (screenshot_review.screenshot_id = screenshot_main.screenshot_id)
    LEFT JOIN review_comments ON (screenshot_review.screenshot_review_id = review_comments.screenshot_review_id)
    WHERE review_main.review_id = '$review_id' AND review_main.review_edit = '0'"
);

while ($sql_screenshots = $query_screenshots->fetch_array(MYSQLI_BOTH)) {
    $new_path = $game_screenshot_path;
    $new_path .= $sql_screenshots['screenshot_id'];
    $new_path .= ".";
    $new_path .= $sql_screenshots['imgext'];

    $smarty->append(
        'screenshots_review', array(
        'screenshot' => $new_path,
        'comment' => $sql_screenshots['comment_text']
        )
    );
    $count++;
}

//Lets get all the reviews by this author
$sql_reviews_author = $mysqli->query(
    "SELECT * FROM review_main
                           LEFT JOIN review_game ON (review_main.review_id = review_game.review_id)
                           LEFT JOIN game ON (game.game_id = review_game.game_id)
                           LEFT JOIN users ON (review_main.user_id = users.user_id)
                           WHERE review_main.user_id = '$query_review[user_id]'
                           AND review_main.review_id != '$review_id'
                           AND review_main.review_edit = '0' ORDER BY game.game_name"
) or die("problem with query");

$count = 0;

while ($query_reviews_author = $sql_reviews_author->fetch_array(MYSQLI_BOTH)) {
    $count++;

    $smarty->append(
        'reviews_author', array(
            'review_id' => $query_reviews_author['review_id'],
            'game_name' => $query_reviews_author['game_name'],
            'game_id' => $query_reviews_author['game_id'],
            'user_name' => $query_reviews_author['userid'],
            'user_id' => $query_reviews_author['user_id']
        )
    );
}

$smarty->assign('nr_reviews_author', $count);

//***********************************************************************************
//Get the comments
//***********************************************************************************
//Select the comments from the DB
$sql_comment = $mysqli->query(
    "SELECT *
                                FROM review_user_comments
                                LEFT JOIN comments ON ( review_user_comments.comment_id = comments.comments_id )
                                LEFT JOIN users ON ( comments.user_id = users.user_id )
                                WHERE review_user_comments.review_id = '$review_id'
                                ORDER BY comments.timestamp desc"
) or die("Syntax Error! Couldn't not get the comments!");

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

//Send all smarty variables to the templates
$smarty->display("file:" . $mainsite_template_folder . "games_reviews_detail.html");

//close the connection
mysqli_close($mysqli);
