<?php
/***************************************************************************
 *                             games_submission.php
 *                            -----------------------
 *   begin                : Saturday, Jan 08, 2005
 *   copyright            : (C) 2003 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : Fixed counting bug
 *                          Fixed switch bug
 *
 *   Id: games_submission.php,v 0.12 2005/04/28 Silver Surfer
 *   Id: games_submission.php,v 0.13 2016/07/27 STG
 *               - AL 2.0
 *   Id: games_submission.php,v 1.14 2017/09/08 STG
 *               - Enhanced for submissions with screenshots
 ***************************************************************************/

/*
 ***********************************************************************************
 Display submissions
 ***********************************************************************************
 */

include("../../config/common.php");
include("../../config/admin.php");
require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../../common/DAO/GameSubmissionDAO.php";

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

// get the total nr of submissions in the DB
//$query_total_number = $mysqli->query("SELECT * FROM game_submitinfo") or die("Couldn't get the total number of submissions");
//$v_rows_total = $query_total_number->num_rows;
//$smarty->assign('total_nr_submissions', $v_rows_total);

$GameSubmissionDAO = new AL\Common\DAO\GameSubmissionDAO($mysqli);

$smarty->assign("nr_submission", $GameSubmissionDAO->getGameSubmissionCount());

//$v_counter = (isset($_GET['v_counter']) ? $_GET['v_counter'] : 0);

//if (isset($user_id)) {
//    $where_condition = " AND users.user_id = $user_id";
//} else {
//    $where_condition = "";
//}

//if (isset($action) and $action == 'autoload'){
//    " AND game_submitinfo.timestamp >= $last_timestamp";
//}
    

//if (empty($v_counter)) {
//    $v_counter = 0;
//}
//if (!isset($list)) {
//    $list = "current";
//}
//if ($list == "done") {
//    $sql_submission = $mysqli->query("SELECT * FROM game_submitinfo
//                                        LEFT JOIN game ON (game_submitinfo.game_id = game.game_id)
//                                        LEFT JOIN users ON (game_submitinfo.user_id = users.user_id)
//                                        WHERE game_done = '1'" . $where_condition . "
//                                        ORDER BY game_submitinfo.game_submitinfo_id
//                                        DESC LIMIT 10") or die("Couldn't get the game submissions");

    //check the number of comments
//    $query_number = $mysqli->query("SELECT * FROM game_submitinfo
//                                             WHERE game_done = '1'
//                                             ORDER BY game_submitinfo_id DESC") or die("Couldn't get the number of game submissions");

//    $v_rows = $query_number->num_rows;
//} else {
//    $sql_submission = $mysqli->query("SELECT * FROM game_submitinfo
//                                        LEFT JOIN game ON (game_submitinfo.game_id = game.game_id)
//                                        LEFT JOIN users ON (game_submitinfo.user_id = users.user_id)
//                                        WHERE game_done <> '1' OR game_done IS NULL" . $where_condition . "
//                                        ORDER BY game_submitinfo.game_submitinfo_id
//                                        DESC LIMIT 10") or die("Couldn't get the game submissions");

    //check the number of comments
//    $query_number = $mysqli->query("SELECT * FROM game_submitinfo
//                                             WHERE game_done <> '1' OR game_done IS NULL
//                                             ORDER BY game_submitinfo_id DESC") or die("Couldn't get the number of game submissions");

//    $v_rows = $query_number->num_rows;
//}

//$number_sub = $sql_submission->num_rows;

/* while ($query_submission = $sql_submission->fetch_array(MYSQLI_BOTH)) {
    if (isset($query_submission['game_id'])) {
        //Select a random screenshot record
        $query_game = $mysqli->query("SELECT
                               screenshot_game.game_id,
                               screenshot_game.screenshot_id,
                               screenshot_main.imgext
                               FROM screenshot_game
                               LEFT JOIN screenshot_main ON (screenshot_game.screenshot_id = screenshot_main.screenshot_id)
                               WHERE screenshot_game.game_id = " . $query_submission['game_id'] . "
                               ORDER BY RAND() LIMIT 1");

        $sql_game = $query_game->fetch_array(MYSQLI_BOTH);
    }

    //check if there are screenshot added to the submission
    $query_screenshots_submission = $mysqli->query("SELECT * FROM screenshot_main
                                        LEFT JOIN screenshot_game_submitinfo ON (screenshot_main.screenshot_id = screenshot_game_submitinfo.screenshot_id)
                                        WHERE screenshot_game_submitinfo.game_submitinfo_id = '$query_submission[game_submitinfo_id]'") or die("Error - Couldn't query submitinfo screenshots");

    while ($sql_screenshots_submission = $query_screenshots_submission->fetch_array(MYSQLI_BOTH)) {
        $new_path = $game_submit_screenshot_path;
        $new_path .= $sql_screenshots_submission['screenshot_id'];
        $new_path .= ".";
        $new_path .= $sql_screenshots_submission['imgext'];

        $smarty->append(

            'submission_screenshots',
            array('game_submitinfo_id' => $sql_screenshots_submission['game_submitinfo_id'],
            'game_submitinfo_screenshot' => $new_path)
        );
    }

    // Retrive userstats from database
    $query_user         = $mysqli->query("SELECT *
                               FROM game_user_comments
                               LEFT JOIN comments ON ( game_user_comments.comment_id = comments.comments_id )
                               WHERE user_id = " . $query_submission['user_id'] . "");
    $usercomment_number = $query_user->num_rows;

    $query_submitinfo = $mysqli->query("SELECT * FROM game_submitinfo WHERE user_id = " . $query_submission['user_id'] . "") or die("Could not count user submissions");
    $usersubmit_number = $query_submitinfo->num_rows;

    //Get the dataElements we want to place on screen
    $v_game_image = $game_screenshot_path;
    $v_game_image .= $sql_game['screenshot_id'];
    $v_game_image .= '.';
    $v_game_image .= $sql_game['imgext'];

    $converted_date = date("F j, Y", $query_submission['timestamp']);
    if ($query_submission['join_date'] !== '') {
        $user_joindate  = date("d-m-y", $query_submission['join_date']);
    } else {
        $user_joindate = "Unknown";
    }
    $comment        = InsertALCode($query_submission['submit_text']);
    $comment        = InsertSmillies($comment);
    $comment        = nl2br($comment);
    $comment        = stripslashes($comment);

    $email_game = rawurlencode($query_submission['game_name']);

    if ($query_submission['avatar_ext'] !== "") {
        $avatar_image = $user_avatar_path;
        $avatar_image .= $query_submission['user_id'];
        $avatar_image .= '.';
        $avatar_image .= $query_submission['avatar_ext'];
    } else {
        $avatar_image = $GLOBALS['style_folder']."/images/default_avatar_image.png";
    }
    $smarty->append('submission', array(
        'game_id' => $query_submission['game_id'],
        'game_name' => $query_submission['game_name'],
        'date_load' => $query_submission['timestamp'],
        'date' => $converted_date,
        'image' => $v_game_image,
        'comment' => $comment,
        'submit_id' => $query_submission['game_submitinfo_id'],
        'user_name' => $query_submission['userid'],
        'user_id' => $query_submission['user_id'],
        'avatar_ext' => $query_submission['avatar_ext'],
        'avatar_image' => $avatar_image,
        'karma' => $query_submission['karma'],
        'user_joindate' => $user_joindate,
        'user_comment_nr' => $usercomment_number,
        'usersubmit_number' => $usersubmit_number,
        'email_game' => $email_game,
        'email' => $query_submission['email']
    ));
} */

/* //Check if back arrow is needed
if ($v_counter > 0) {
    $back_arrow = $v_counter - 25;
}

//Check if we need to place a next arrow
if ($v_rows > ($v_counter + 25)) {
    $forward_arrow = ($v_counter + 25);
} else {
    $forward_arrow = '';
}

if (!isset($list)) {
    $list = "current";
}
if (empty($back_arrow)) {
    $back_arrow = '';
}

$smarty->assign('structure', array(
    'list' => $list,
    'v_counter' => $v_counter,
    'back_arrow' => $back_arrow,
    'forward_arrow' => $forward_arrow,
    'num_sub' => $number_sub
));*/

if (isset($done)) {
    $smarty->assign('done', $done );
} else {
    $smarty->assign('done', '' );
}

$smarty->assign(
    'submission',
    $GameSubmissionDAO->getLatestSubmissions(isset($user_id) ? $user_id : null, isset($last_timestamp) ? $last_timestamp : null, isset($action) ? $action : null, isset($done) ? $done : null)
); 

if (isset($user_id)) {
    $smarty->assign("user_id", $user_id);
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "submission_games.html");

//close the connection
mysqli_close($mysqli);
