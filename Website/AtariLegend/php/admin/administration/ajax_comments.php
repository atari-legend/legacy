<?php
/***************************************************************************
 *                                ajax_comments.php
 *                            -----------------------
 *   begin                : 2018-02-12
 *   copyright            : (C) 2018 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : file creation
 *
 *
 ***************************************************************************/

include("../../config/common.php");
include("../../config/admin.php");

//*********************************************************************************************
// User comments
//*********************************************************************************************

if (isset($view) and $view == "users_comments") {
    $where_clause = "WHERE users.user_id = $user_id";
    $where_clause_temp_table = "";
} elseif ($view == "comments_game_comments") {
    $where_clause_temp_table = "WHERE temp.comment_type = 'game_comment'";
    $view = "comments_game_comments";
    if (empty($where_clause)) {
        $where_clause = "";
    }
} elseif ($view == "comments_all") {
    $where_clause_temp_table = "";
    $view = "comments_all";
    if (empty($where_clause)) {
        $where_clause = "";
    }
} elseif ($view == "comments_game_review_comments") {
    $where_clause_temp_table = "WHERE temp.comment_type = 'game_review_comment'";
    $view = "comments_game_review_comments";
    if (empty($where_clause)) {
        $where_clause = "";
    }
} elseif ($view == "comments_interview_comments") {
    $where_clause_temp_table = "WHERE temp.comment_type = 'interview_comment'";
    $view = "comments_interview_comments";
    if (empty($where_clause)) {
        $where_clause = "";
    }
} else {
    $where_clause = "";
    $view         = "latest_comments";
    $where_clause_temp_table = "";
}

$sql_build_game = "SELECT
comments.comments_id,
comments.timestamp,
users.user_id,
users.userid,
users.email,
users.join_date,
users.karma,
users.avatar_ext,
game.game_id,
game.game_name,
'game_comment' AS comment_type
FROM game_user_comments
LEFT JOIN comments ON ( game_user_comments.comment_id = comments.comments_id )
LEFT JOIN users ON ( comments.user_id = users.user_id )
LEFT JOIN game ON ( game_user_comments.game_id = game.game_id )
" . $where_clause ."";

$sql_build_gamereview = "SELECT
comments.comments_id,
comments.timestamp,
users.user_id,
users.userid,
users.email,
users.join_date,
users.karma,
users.avatar_ext,
game.game_id AS game_id,
game.game_name AS game_name,
'game_review_comment' AS comment_type
FROM review_user_comments
LEFT JOIN comments ON ( review_user_comments.comment_id = comments.comments_id )
LEFT JOIN review_game ON (review_user_comments.review_id = review_game.review_id )
LEFT JOIN game ON ( review_game.game_id = game.game_id )
LEFT JOIN users ON ( comments.user_id = users.user_id )
" . $where_clause ."";

$sql_build_interview = "SELECT
comments.comments_id,
comments.timestamp,
users.user_id,
users.userid,
users.email,
users.join_date,
users.karma,
users.avatar_ext,
interview_main.interview_id AS game_id,
individuals.ind_name AS game_name,
'interview_comment' AS comment_type
FROM interview_user_comments
LEFT JOIN comments ON ( interview_user_comments.comment_id = comments.comments_id )
LEFT JOIN interview_main ON (interview_user_comments.interview_id = interview_main.interview_id )
LEFT JOIN individuals ON (interview_main.ind_id = individuals.ind_id )
LEFT JOIN users ON ( comments.user_id = users.user_id )
" . $where_clause ."";

$temp_query = $mysqli->query("DROP TABLE IF EXISTS temp") or die('Error: ' . mysqli_error($mysqli));

$temp_query = $mysqli->query("CREATE TEMPORARY TABLE temp (
    comments_id int(11),
    timestamp varchar(32),
    user_id int(11),
    userid varchar(255),
    email varchar(255),
    join_date varchar(32),
    karma int(11),
    avatar_ext varchar(255),
    game_id int(11),
    game_name varchar(255),
    comment_type varchar(255)
)") or die('Error: ' . mysqli_error($mysqli));

$temp_query = $mysqli->query("INSERT INTO temp $sql_build_game") or die('Error: ' . mysqli_error($mysqli));
$temp_query = $mysqli->query("INSERT INTO temp $sql_build_gamereview") or die('Error: ' . mysqli_error($mysqli));
$temp_query = $mysqli->query("INSERT INTO temp $sql_build_interview") or die('Error: ' . mysqli_error($mysqli));

$sql_build = "SELECT
temp.comments_id,
temp.timestamp,
temp.user_id,
temp.userid,
temp.email,
temp.join_date,
temp.karma,
temp.avatar_ext,
temp.game_id,
temp.game_name,
temp.comment_type,
comments.comment
FROM temp
LEFT JOIN comments ON (temp.comments_id = comments.comments_id)
". $where_clause_temp_table ."
ORDER BY temp.timestamp DESC LIMIT 15";

$sql_comment = $mysqli->query($sql_build) or die('Error: ' . mysqli_error($mysqli));;

// lets put the comments in a smarty array
while ($query_comment = $sql_comment->fetch_array(MYSQLI_BOTH)) {
    $query_game_id = $query_comment['game_id'];

    //  Retrive userstats from database
    $query_user = $mysqli->query("SELECT *
                               FROM comments
                               WHERE user_id = $query_comment[user_id]")
                               or die("Could not count user comments");
    $usercomment_number = $query_user->num_rows;

    $query_submitinfo = $mysqli->query("SELECT * FROM game_submitinfo WHERE user_id = $query_comment[user_id]")
    or die("Could not count user submissions");
    $usersubmit_number = $query_submitinfo->num_rows;

    //  Get the dataElements we want to place on screen

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
        'user_name' => $query_comment['userid'],
        'user_id' => $query_comment['user_id'],
        'avatar_image' => $avatar_image,
        'karma' => $query_comment['karma'],
        'timestamp' => $query_comment['timestamp'],
        'comments_id' => $query_comment['comments_id'],
        'user_comment_nr' => $usercomment_number,
        'user_joindate' => $user_joindate,
        'usersubmit_number' => $usersubmit_number,
        'comments_id' => $query_comment['comments_id'],
        'email' => $query_comment['email']
    ));
}

$smarty->assign('links', array(
    'view' => $view,
));

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_comments.html");
