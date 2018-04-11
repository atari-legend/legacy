<?php
/***************************************************************************
 *                                ajax_news_search.php
 *                            ----------------------------
 *   begin                : Tuesday, April 10, 2018
 *   copyright            : (C) 2018 Atari Legend
 *   email                : admin@atarilegend.com
 *
 *   Id: ajax_news_search.php 10/04/2018 ST Graveyard - creation of file
 *
 ***************************************************************************/
 
 //load all common functions
include("../../config/common.php");
include("../../config/admin.php");

require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../../common/DAO/NewsSearchDAO.php";
require_once __DIR__."/../../common/DAO/NewsDAO.php";

$NewsSearchDAO = new AL\Common\DAO\NewsSearchDAO($mysqli);
$NewsDAO = new AL\Common\DAO\NewsDAO($mysqli);

//********************************************************************************************
// Get all the needed data to load the news page!
//********************************************************************************************
$date = date_to_timestamp($news_searchYear, $news_searchMonth, $news_searchDay);

$smarty->assign(
    'news',
    $NewsSearchDAO->getSearchNews(isset($author_search) ? $author_search : null, isset($date) ? $date : null, isset($newssearch) ? $newssearch : null)
); 

$smarty->assign("nr_news", $NewsDAO->getNewsCount());

$smarty->assign("user_id", $_SESSION['user_id']);

//Search parameters for HTML
$smarty->assign("search_action", 'news_search');
$smarty->assign("search_author_id", '$author_search');
$smarty->assign("search_date", '$date');
$smarty->assign("search_string", '$newssearch');

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_news_search.html");

//close the connection
mysqli_close($mysqli);

