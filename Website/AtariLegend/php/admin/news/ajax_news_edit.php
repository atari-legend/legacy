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

//if (isset($view) and $view == "users_news") {
//    if (isset($user_id)) {
//        $smarty->assign(
//            'news',
//            $NewsDAO->getAllNewsForUser(isset($user_id) ? $user_id : null, isset($last_timestamp) ? $last_timestamp : null, isset($action) ? $action : null, isset($view) ? $view : null)
//        );
//    }else{   
//    $smarty->assign(
//        'news',
//        $NewsDAO->getLatestNews(isset($user_id) ? $user_id : null, isset($last_timestamp) ? $last_timestamp : null, isset($action) ? $action : null, isset($view) ? $view : null)
//    ); 
//   }
//}else{   
    $smarty->assign(
        'news',
        $NewsDAO->getLatestNews(isset($user_id) ? $user_id : null, isset($last_timestamp) ? $last_timestamp : null, isset($action) ? $action : null, isset($view) ? $view : null)
    ); 
//}

$smarty->assign("nr_news", $NewsDAO->getNewsCount());

if (isset($view) and $view == "users_news") {
    $smarty->assign("view", 'users_news');
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_news_edit.html");

//close the connection
mysqli_close($mysqli);
