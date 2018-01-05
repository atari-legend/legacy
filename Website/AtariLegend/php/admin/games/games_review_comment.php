<?php
/***************************************************************************
 *                                games_review_comment.php
 *                            -----------------------
 *   begin                : wednesday, August 23, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : Creation of file
 *
 *
 *   Id: games_review_comment.php,v 0.10 2017/08/23 17:10 ST Graveyard
 *
 ***************************************************************************/

include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

$v_counter = (isset($_GET["v_counter"]) ? $_GET["v_counter"] : 0);

//*********************************************************************************************
// User comments
//*********************************************************************************************
if (empty($view)) {
    $view = "";
}
if (empty($users_comments)) {
    $users_comments = "";
}

if ($view == "users_comments") {
    $where_clause = "WHERE users.user_id = $users_id";

    //Build next/back links, part for users_comments only
    $users_comments = "&c_counter=$c_counter&users_id=$users_id&view=users_comments";
} elseif ($view == "review_comments") {
    $where_clause = "WHERE review_user_comments.review_id = $review_id";
    $view         = "review_comments";
} else {
    $where_clause = "";
    $view         = "latest_comments";
}

$sql_build = "SELECT *
                FROM review_user_comments
                LEFT JOIN comments ON ( review_user_comments.comment_id = comments.comments_id )
                LEFT JOIN users ON ( comments.user_id = users.user_id )
                 " . $where_clause . "
                ORDER BY comments.timestamp DESC LIMIT  " . $v_counter . ", 15";

$sql_comment = $mysqli->query($sql_build) or die("problem with the main query");

// get the total nr of comments in the DB
$query_total_number = $mysqli->query("SELECT * FROM review_user_comments") or die("Couldn't get the total number of comments");
$v_rows_total = $query_total_number->num_rows;
$smarty->assign('total_nr_comments', $v_rows_total);

// count number of comments
$query_number = $mysqli->query("SELECT * FROM review_user_comments
                             LEFT JOIN comments ON ( review_user_comments.comment_id = comments.comments_id )
                             LEFT JOIN users ON ( comments.user_id = users.user_id ) " . $where_clause) or die("Couldn't get the number of comments - count");

$v_rows = $query_number->num_rows;

$smarty->assign('nr_comments', $v_rows);

// lets put the comments in a smarty array
while ($query_comment = $sql_comment->fetch_array(MYSQLI_BOTH)) {
    $query_review_id = $query_comment['review_id'];
    //  Select a random screenshot record
    $query_review    = $mysqli->query("SELECT
                               screenshot_review.review_id,
                               screenshot_review.screenshot_id,
                               screenshot_main.imgext
                               FROM screenshot_review
                               LEFT JOIN screenshot_main ON (screenshot_review.screenshot_id = screenshot_main.screenshot_id)
                               WHERE screenshot_review.review_id = '$query_comment[review_id]'
                               ORDER BY RAND() LIMIT 1");

    $sql_review = $query_review->fetch_array(MYSQLI_BOTH);

    //  Retrieve userstats from database
    $query_user = $mysqli->query("SELECT *
                               FROM review_user_comments
                               LEFT JOIN comments ON ( review_user_comments.comment_id = comments.comments_id )
                               WHERE user_id = $query_comment[user_id]") or die("Could not count user comments");
    $usercomment_number = $query_user->num_rows;

    //  Get the dataElements we want to place on screen
    if (isset($sql_review['imgext'])) {
        $v_game_image = $game_screenshot_path;
        $v_game_image .= $sql_review['screenshot_id'];
        $v_game_image .= '.';
        $v_game_image .= $sql_review['imgext'];
    } else {
        $v_game_image = '';
    }

    $oldcomment = $query_comment['comment'];

    $oldcomment = nl2br($oldcomment);
    $oldcomment = InsertALCode($oldcomment);
    $oldcomment = trim($oldcomment);
    $oldcomment = RemoveSmillies($oldcomment);
    $oldcomment = stripslashes($oldcomment);

    if ($query_comment['join_date'] == "") {
        $user_joindate = "unknown";
    } else {
        $user_joindate = date("d-m-y", $query_comment['join_date']);
    }
    $date = date("F j, Y", $query_comment['timestamp']);

    if ($query_comment['avatar_ext'] !== "") {
        $avatar_image = $user_avatar_path;
        $avatar_image .= $query_comment['user_id'];
        $avatar_image .= '.';
        $avatar_image .= $query_comment['avatar_ext'];
    } else {
        $avatar_image = '';
    }

    //get the game name and game id
    $sql_game = $mysqli->query("SELECT *
                               FROM game
                               LEFT JOIN review_game ON ( review_game.game_id = game.game_id )
                               WHERE review_game.review_id = '$query_comment[review_id]' ORDER BY RAND() LIMIT 1") or die("Could not get game detail");

    $query_game = $sql_game->fetch_array(MYSQLI_BOTH);

    $smarty->append('comments', array(
        'comment' => $oldcomment,
        'date' => $date,
        'game' => $query_game['game_name'],
        'game_id' => $query_game['game_id'],
        'image' => $v_game_image,
        'user_name' => $query_comment['userid'],
        'users_id' => $query_comment['user_id'],
        'avatar_image' => $avatar_image,
        'karma' => $query_comment['karma'],
        'review_user_comments_id' => $query_comment['review_user_comments_id'],
        'user_comment_nr' => $usercomment_number,
        'user_joindate' => $user_joindate,
        'comment_id' => $query_comment['comment_id'],
        'email' => $query_comment['email']
    ));
}

//Check if back arrow is needed
if ($v_counter > 0) {
    // Build the link
    $v_linkback = ('?v_counter=' . ($v_counter - 15 . $users_comments));
}

//Check if we need to place a next arrow
if ($v_rows > ($v_counter + 15)) {
    //Build the link
    $v_linknext = ('?v_counter=' . ($v_counter + 15 . $users_comments));
}

if (empty($c_counter)) {
    $c_counter = "";
}
if (empty($v_linkback)) {
    $v_linkback = "";
}
if (empty($v_linknext)) {
    $v_linknext = "";
}

$smarty->assign('links', array(
    'linkback' => $v_linkback,
    'linknext' => $v_linknext,
    'v_counter' => $v_counter,
    'view' => $view,
    'users_comments' => $users_comments,
    'c_counter' => $c_counter
));

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games_review_comment.html");
