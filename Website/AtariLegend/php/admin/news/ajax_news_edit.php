<?php
/***************************************************************************
 *                                ajax_news_edit.php
 *                            ----------------------------------
 *   begin                : 2018-04-03
 *   copyright            : (C) 2018 Atari Legend
 *   actual update        : file creation
 *
 *
 ***************************************************************************/

include("../../config/common.php");
include("../../config/admin.php");
require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../../common/DAO/NewsDAO.php";

$NewsDAO = new AL\Common\DAO\NewsDAO($mysqli);

//********************************************************************************************
// Get all the needed data to load the news page!
//********************************************************************************************
$smarty->assign(
    'news',
    $NewsDAO->getLatestNews(
        5,
        isset($user_id) ? $user_id : null,
        isset($last_timestamp) ? $last_timestamp : null,
        isset($action) ? $action : null,
        isset($news_text) ? $news_text : null
    )
);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_news_edit.html");

//close the connection
mysqli_close($mysqli);
