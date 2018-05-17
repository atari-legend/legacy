<?php
/***************************************************************************
 *                                ajax_comments_search.php
 *                            ----------------------------
 *   begin                : Monday, April 23, 2018
 *   copyright            : (C) 2018 Atari Legend
 *   email                : admin@atarilegend.com
 *
 *   Id: ajax_comments_search.php 23/04/2018 ST Graveyard - creation of file
 *
 ***************************************************************************/
 
 //load all common functions
include("../../config/common.php");
include("../../config/admin.php");

require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../../common/DAO/CommentsDAO.php";

$commentsDao = new AL\Common\DAO\CommentsDAO($mysqli);

//********************************************************************************************
// Get all the needed data to load the news page!
//********************************************************************************************
$date = date_to_timestamp($comments_searchYear, $comments_searchMonth, $comments_searchDay);

if ( $author_search == '-' )
{ 
    $view = "comments_all";
} else {
    $view = "users_comments";
}

$smarty->assign(
    'comments',
    $commentsDao->getCommentsBuild(
        isset($view) ? $view : null,
        isset($author_search) ? $author_search : null,
        isset($action) ? $action : null,
        isset($date) ? $date : null
    )
);

$smarty->assign('links', array(
    'view' => $view,
    'getCommentCount' => $commentsDao->getCommentCount(),
));

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_comments_search.html");
