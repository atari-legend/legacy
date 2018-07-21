<?php
/***************************************************************************
 *                             ajax_submission_games.php
 *                            ----------------------------
 *   begin                : Thursday, May 24, 2018
 *   copyright            : (C) 2018 Atari Legend
 *   actual update        : Creation of file
 *
 *   Id: ajax_submission_games.php,v 0.1 2018/05/24 STG
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

$GameSubmissionDAO = new AL\Common\DAO\GameSubmissionDAO($mysqli);

$smarty->assign("nr_submission", $GameSubmissionDAO->getGameSubmissionCount());

if (isset($done) and $done == '1') {
    if (isset($open) and $open == '2') {
        $done = '3'; //open and closed are flagged
    } else {
        $done = '1'; //only closed is flagged
    }
} elseif (isset($open) and $open == '2') {
    $done = '2'; //only open is flagged
}

if ($last_timestamp == '') {
    $last_timestamp = null;
}

$submissions = $GameSubmissionDAO->getLatestSubmissions(isset($user_id) ? $user_id : null, isset($last_timestamp) ? $last_timestamp : null, isset($action) ? $action : null, isset($done) ? $done : null);
$smarty->assign('submission', $submissions);

//check if there are screenshot added to the submission
foreach ($submissions as $submissionId) {
    $submitinfo_id = $submissionId->getSubmissionId();
    $query_screenshots_submission = $mysqli->query("SELECT * FROM screenshot_main
                                        LEFT JOIN screenshot_game_submitinfo ON (screenshot_main.screenshot_id = screenshot_game_submitinfo.screenshot_id)
                                        WHERE screenshot_game_submitinfo.game_submitinfo_id = '$submitinfo_id'") or die("Error - Couldn't query submitinfo screenshots");

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
}

//Get the authors for submission search
$sql_author = $mysqli->query("SELECT game_submitinfo.user_id, users.userid FROM game_submitinfo
                              LEFT JOIN users ON ( game_submitinfo.user_id = users.user_id ) 
                              GROUP BY game_submitinfo.user_id 
                              ORDER BY users.userid ASC") or die("Database error - getting members name");

while ($authors = $sql_author->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('authors_search', array(
        'user_id' => $authors['user_id'],
        'user_name' => $authors['userid']
    ));
}

if (isset($user_id)) {
    $smarty->assign("user_id", $user_id);
}

$smarty->assign("action", $action);
$smarty->assign("last_timestamp", $last_timestamp);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_submission_games.html");

//close the connection
mysqli_close($mysqli);
