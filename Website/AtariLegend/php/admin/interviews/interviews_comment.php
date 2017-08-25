<?php
/***************************************************************************
 *                                interviews_comment.php
 *                            -------------------------------
 *   begin                : Monday, August 21, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : re-creation of code from scratch into new file.
 *
 *   Id: interviews_comment.php.php,v 0.1 2017/08/21 STG
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
} elseif ($view == "interview_comments") {
    $where_clause = "WHERE interview_main.interview_id = $interview_id";
    $view         = "interview_comments";
} else {
    $where_clause = "";
    $view         = "latest_comments";
}

$sql_build = "SELECT *
                FROM interview_user_comments
                LEFT JOIN comments ON ( interview_user_comments.comment_id = comments.comments_id )
                LEFT JOIN users ON ( comments.user_id = users.user_id )
                 " . $where_clause . "
                ORDER BY comments.timestamp DESC LIMIT  " . $v_counter . ", 5";

$sql_comment = $mysqli->query($sql_build);

// get the total nr of comments in the DB
$query_total_number = $mysqli->query("SELECT * FROM interview_user_comments") or die("Couldn't get the total number of comments");
$v_rows_total = $query_total_number->num_rows;
$smarty->assign('total_nr_comments', $v_rows_total);

// count number of comments
$query_number = $mysqli->query("SELECT * FROM interview_user_comments
                             LEFT JOIN comments ON ( interview_user_comments.comment_id = comments.comments_id )
                             LEFT JOIN interview_main ON ( interview_user_comments.interview_id = interview_main.interview_id )
                             LEFT JOIN users ON ( comments.user_id = users.user_id ) " . $where_clause) or die("Couldn't get the number of comments - count");

$v_rows = $query_number->num_rows;

$smarty->assign('nr_comments', $v_rows);

// lets put the comments in a smarty array
while ($query_comment = $sql_comment->fetch_array(MYSQLI_BOTH)) {

    //  Retrive userstats from database
    $query_user = $mysqli->query("SELECT *
                               FROM interview_user_comments
                               LEFT JOIN comments ON ( interview_user_comments.comment_id = comments.comments_id )
                               WHERE user_id = '$query_comment[user_id]'") or die("Could not count user comments");
    $usercomment_number = $query_user->num_rows;
    
    $query_ind_pic = $mysqli->query("SELECT * FROM interview_main
                                LEFT JOIN individuals on ( interview_main.ind_id = individuals.ind_id )
                                LEFT JOIN individual_text ON (individual_text.ind_id = individuals.ind_id)
                                WHERE interview_id = $query_comment[interview_id]") or die("Could not get individual picture");
    
    while ($sql_pic = $query_ind_pic->fetch_array(MYSQLI_BOTH)) {
        //  Get the dataElements we want to place on screen
        $ind_name = $sql_pic['ind_name'];
        if ($sql_pic['ind_imgext'] == 'png' or $sql_pic['ind_imgext'] == 'jpg' or $sql_pic['ind_imgext']) {
            $v_ind_image  = $individual_screenshot_path;
            $v_ind_image .= $sql_pic['ind_id'];
            $v_ind_image .= '.';
            $v_ind_image .= $sql_pic['ind_imgext'];
        } else {
            $v_ind_image = "none";
        }
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
        $avatar_image = 'none';
    }

    $smarty->append('comments', array(
        'comment' => $oldcomment,
        'date' => $date,
        'ind_name' => $ind_name,
        'interview_id' => $query_comment['interview_id'],
        'image' => $v_ind_image,
        'user_name' => $query_comment['userid'],
        'users_id' => $query_comment['user_id'],
        'avatar_image' => $avatar_image,
        'karma' => $query_comment['karma'],
        'interview_user_comments_id' => $query_comment['interview_user_comments_id'],
        'user_comment_nr' => $usercomment_number,
        'user_joindate' => $user_joindate,
        'comment_id' => $query_comment['comment_id'],
        'email' => $query_comment['email']
    ));
}

//Check if back arrow is needed
if ($v_counter > 0) {
    // Build the link
    $v_linkback = ('?v_counter=' . ($v_counter - 5 . $users_comments));
}

//Check if we need to place a next arrow
if ($v_rows > ($v_counter + 5)) {
    //Build the link
    $v_linknext = ('?v_counter=' . ($v_counter + 5 . $users_comments));
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
$smarty->display("file:" . $cpanel_template_folder . "interviews_comment.html");
