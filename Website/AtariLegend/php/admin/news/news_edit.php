<?php
/***************************************************************************
 *                                news_edit.php
 *                            ---------------------------
 *   begin                : Thursday, May 5, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : File creation
 *
 *   Id: news_edit.php,v 0.10 2004/05/05 ST Graveyard
 *   Id: news_edit.php,v 0.20 2016/07/29 ST Graveyard
 *           - AL 2.0
 *   Id: news_edit.php,v 0.25 2018/03/29 ST Graveyard
 *           - Conversion to DAO
 *
 ***************************************************************************/
//****************************************************************************************
// This is where we can edit all the news sections
//****************************************************************************************

include("../../config/common.php");
include("../../config/admin.php");
require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../../common/DAO/NewsDAO.php";

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

$NewsDAO = new AL\Common\DAO\NewsDAO($mysqli);

//********************************************************************************************
// Get all the needed data to load the news page!
//********************************************************************************************

//if (isset($user_id)){
//    $smarty->assign(
//        'news',
//        $NewsDAO->getAllNewsForUser(isset($user_id) ? $user_id : null, isset($last_timestamp) ? $last_timestamp : null, isset($action) ? $action : null, isset($view) ? $view : null)
//    );
//}else{   
    $smarty->assign(
        'news',
        $NewsDAO->getLatestNews(isset($user_id) ? $user_id : null, isset($last_timestamp) ? $last_timestamp : null, isset($action) ? $action : null, isset($view) ? $view : null)
    ); 
//}

$smarty->assign("nr_news", $NewsDAO->getNewsCount());

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "news_edit.html");

//close the connection
mysqli_close($mysqli);
