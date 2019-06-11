<?php
/***************************************************************************
 *                                news_approve.php
 *                            ---------------------------
 *   begin                : Thursday, May 5, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : File creation
 *
 *
 * Id: news_approve.php,v 0.10 2004/05/05 ST Graveyard
 * Id: news_approve.php,v 0.20 2016/07/28 ST Graveyard
 *     - AL 2.0
 * Id: news_approve.php,v 0.25 2018/03/14 ST Graveyard
 *     - Conversion to DOA
 *
 ***************************************************************************/
/*
 ***********************************************************************************
 In this section we can approve a news update.
 ***********************************************************************************
 */

include("../../config/common.php");
include("../../config/admin.php");
require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../../common/DAO/NewsSubmissionDAO.php";

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

$NewsSubmissionDAO = new AL\Common\DAO\NewsSubmissionDAO($mysqli);

//********************************************************************************************
// Get all the needed data to load the submission page!
//********************************************************************************************
if (isset($user_id)) {
    $smarty->assign(
        'news_submissions',
        $NewsSubmissionDAO->getAllSubmissionsForUser(isset($user_id) ? $user_id : null)
    );
} else {
    $smarty->assign(
        'news_submissions',
        $NewsSubmissionDAO->getAllSubmissions(isset($user_id) ? $user_id : null)
    );
}

$smarty->assign("nr_submissions", $NewsSubmissionDAO->getSubmissionCount());

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "news/news_approve.html");

//close the connection
mysqli_close($mysqli);
