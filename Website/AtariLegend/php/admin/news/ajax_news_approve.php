<?php
/***************************************************************************
 *                                ajax_news_approve.php
 *                            -----------------------
 *   begin                : 2018-03-20
 *   copyright            : (C) 2018 Atari Legend
 *   actual update        : file creation
 *
 *
 ***************************************************************************/

include("../../config/common.php");
include("../../config/admin.php");
require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../../common/DAO/NewsDAO.php";

$commentsDao = new AL\Common\DAO\NewsDAO($mysqli);

//********************************************************************************************
// Get all the needed data to load the submission page!
//********************************************************************************************
if (isset($user_id)){
    $smarty->assign(
        'news_submissions',
        $NewsSubmissionDAO->getAllSubmissionsForUser(isset($user_id) ? $user_id : null)
    );
}else{   
    $smarty->assign(
        'news_submissions',
        $NewsSubmissionDAO->getAllSubmissions(isset($user_id) ? $user_id : null)
    ); 
}

$smarty->assign("nr_submissions", $NewsSubmissionDAO->getSubmissionCount());

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_news.html");
