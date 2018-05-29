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

$smarty->assign("action", $action);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_submission_games.html");

//close the connection
mysqli_close($mysqli);
