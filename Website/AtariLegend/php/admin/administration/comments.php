<?php
/***************************************************************************
 *                                games_comment.php
 *                            -----------------------
 *   begin                : Saturday, sept 17, 2005
 *   copyright            : (C) 2003 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : file creation
 *
 *
 *   Id: games_comment.php,v 0.10 2005/09/17 Silver Surfer
 *   Id: games_comment.php,v 0.20 2015/12/27 STG - added left/right side
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
} elseif ($view == "game_comments") {
    $where_clause = "WHERE game.game_id = $game_id";
    $view         = "game_comments";
} else {
    $where_clause = "";
    $view         = "latest_comments";
}

$sql_build = "SELECT *
                FROM game_user_comments
                LEFT JOIN comments ON ( game_user_comments.comment_id = comments.comments_id )
                LEFT JOIN users ON ( comments.user_id = users.user_id )
                LEFT JOIN game ON ( game_user_comments.game_id = game.game_id )
                 " . $where_clause . "
                ORDER BY comments.timestamp DESC LIMIT  " . $v_counter . ", 15";

$sql_comment = $mysqli->query($sql_build);

// get the total nr of comments in the DB
$query_total_number = $mysqli->query("SELECT * FROM game_user_comments") or die("Couldn't get the total number of comments");
$v_rows_total = $query_total_number->num_rows;
$smarty->assign('total_nr_comments', $v_rows_total);

// count number of comments
$query_number = $mysqli->query("SELECT * FROM game_user_comments
                             LEFT JOIN comments ON ( game_user_comments.comment_id = comments.comments_id )
                             LEFT JOIN game ON ( game_user_comments.game_id = game.game_id )
                             LEFT JOIN users ON ( comments.user_id = users.user_id ) " . $where_clause) or die("Couldn't get the number of comments - count");

$v_rows = $query_number->num_rows;

$smarty->assign('nr_comments', $v_rows);

// lets put the comments in a smarty array
while ($query_comment = $sql_comment->fetch_array(MYSQLI_BOTH)) {
    $query_game_id = $query_comment['game_id'];
    //  Select a random screenshot record
    $query_game    = $mysqli->query("SELECT
                               screenshot_game.game_id,
                               screenshot_game.screenshot_id,
                               screenshot_main.imgext
                               FROM screenshot_game
                               LEFT JOIN screenshot_main ON (screenshot_game.screenshot_id = screenshot_main.screenshot_id)
                               WHERE screenshot_game.game_id = $query_game_id
                               ORDER BY RAND() LIMIT 1");

    $sql_game = $query_game->fetch_array(MYSQLI_BOTH);

    //  Retrive userstats from database
    $query_user = $mysqli->query("SELECT *
                               FROM game_user_comments
                               LEFT JOIN comments ON ( game_user_comments.comment_id = comments.comments_id )
                               WHERE user_id = $query_comment[user_id]") or die("Could not count user comments");
    $usercomment_number = $query_user->num_rows;

    $query_submitinfo = $mysqli->query("SELECT * FROM game_submitinfo WHERE user_id = $query_comment[user_id]") or die("Could not count user submissions");
    $usersubmit_number = $query_submitinfo->num_rows;

    //  Get the dataElements we want to place on screen
    if (isset($sql_game['imgext'])) {
        $v_game_image = $game_screenshot_path;
        $v_game_image .= $sql_game['screenshot_id'];
        $v_game_image .= '.';
        $v_game_image .= $sql_game['imgext'];
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

    $smarty->append('comments', array(
        'comment' => $oldcomment,
        'date' => $date,
        'game' => $query_comment['game_name'],
        'game_id' => $query_comment['game_id'],
        'image' => $v_game_image,
        'user_name' => $query_comment['userid'],
        'users_id' => $query_comment['user_id'],
        'avatar_image' => $avatar_image,
        'karma' => $query_comment['karma'],
        'game_user_comments_id' => $query_comment['game_user_comments_id'],
        'user_comment_nr' => $usercomment_number,
        'user_joindate' => $user_joindate,
        'usersubmit_number' => $usersubmit_number,
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
$smarty->display("file:" . $cpanel_template_folder . "comments.html");
