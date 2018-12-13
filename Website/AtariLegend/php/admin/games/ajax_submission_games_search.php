<?php
/***************************************************************************
 *                                ajax_submission_games_search.php
 *                            ----------------------------------------
 *   begin                : Thursday, 31st May, 2018
 *   copyright            : (C) 2018 Atari Legend
 *   email                : admin@atarilegend.com
 *
 *   Id: ajax_submission_games_search.php 31/05/2018 ST Graveyard - creation of file
 ***************************************************************************/

include("../../config/common.php");
include("../../config/admin.php");
require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../../common/DAO/GameSubmissionDAO.php";

$GameSubmissionDAO = new AL\Common\DAO\GameSubmissionDAO($mysqli);

//********************************************************************************************
// Get all the needed data to load the comments page!
//********************************************************************************************
$smarty->assign("nr_submission", $GameSubmissionDAO->getGameSubmissionCount());

$date = date_to_timestamp($submsission_searchYear, $submsission_searchMonth, $submsission_searchDay);

if ($author_search == '-') {
} else {
    $user_id = $author_search;
}

if (isset($done) and $done == '1') {
    if (isset($open) and $open == '2') {
        $done = '3'; //open and closed are flagged
    } else {
        $done = '1'; //only closed is flagged
    }
} elseif (isset($open) and $open == '2') {
    $done = '2'; //only open is flagged
}

$submissions = $GameSubmissionDAO->getLatestSubmissions(
    isset($user_id) ? $user_id : null,
    isset($date) ? $date : null,
    isset($action) ? $action : null,
    isset($done) ? $done : null
);
$smarty->assign('submission', $submissions);

//check if there are screenshot added to the submission
foreach ($submissions as $submissionId) {
    $submitinfo_id = $submissionId->getSubmissionId();
    $query_screenshots_submission = $mysqli->query("SELECT * FROM screenshot_main
        LEFT JOIN screenshot_game_submitinfo
        ON (screenshot_main.screenshot_id = screenshot_game_submitinfo.screenshot_id)
        WHERE screenshot_game_submitinfo.game_submitinfo_id = '$submitinfo_id'")
        or die("Error - Couldn't query submitinfo screenshots");

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

if (isset($done)) {
    $smarty->assign("done", $done);
}

$smarty->assign("action", $action);
$smarty->assign("last_timestamp", $date);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_submission_games_search.html");

//close the connection
mysqli_close($mysqli);
