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

$GameSubmissionDAO = new AL\Common\DAO\GameSubmissionDAO($mysqli);

$smarty->assign("nr_submission", $GameSubmissionDAO->getGameSubmissionCount());

    //check if there are screenshot added to the submission
    /*$query_screenshots_submission = $mysqli->query("SELECT * FROM screenshot_main
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
    }*/


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
