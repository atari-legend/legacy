<?php
/***************************************************************************
 *                                ajax_news_approve_edit.php
 *                            ----------------------------------
 *   begin                : 2018-03-20
 *   copyright            : (C) 2018 Atari Legend
 *   actual update        : file creation
 *
 *
 ***************************************************************************/

include("../../config/common.php");
include("../../config/admin.php");
require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../../common/DAO/NewsSubmissionDAO.php";

$newsSubmissionDAO = new AL\Common\DAO\NewsSubmissionDAO($mysqli);

//*********************************************************************************************
// User comments
//*********************************************************************************************

if (isset($action) and $action == "get_newsapprove_text") {
    if (isset($news_id)) {
        $smarty->assign('news_text', $newsSubmissionDAO->getNewsText($news_id));
        $smarty->assign('action', $action);
        $smarty->assign('news_id', $news_id);
    }
}

if (isset($action) and $action == "save_news_text") {
    if ($_SESSION['permission']==1 or $_SESSION['permission']=='1') {
        if (isset($news_id)) {
            if (!$newsSubmissionDAO->saveNewsText($news_id, $news_text)) {
                $osd = "News Updated!";
            } else {
                $osd = "Update Failed!";
            }

            $smarty->assign('news_text', $newsSubmissionDAO->getNewsText($news_id));
            $smarty->assign('action', $action);
            $smarty->assign('osd_message', $osd);
            $smarty->assign('news_id', $news_id);
        }
    }else{
        $osd = "You don't have permission to perform this task";
        $smarty->assign('news_text', $newsSubmissionDAO->getNewsText($news_id));
        $smarty->assign('action', $action);
        $smarty->assign('osd_message', $osd);
        $smarty->assign('news_id', $news_id);
    }
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_news_approve_edit.html");
