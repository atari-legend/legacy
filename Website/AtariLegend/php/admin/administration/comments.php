<?php
/***************************************************************************
 *                                comments.php
 *                            -----------------------
 *   begin                : 2018-02-10
 *   copyright            : (C) 2018 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *
 ***************************************************************************/

include("../../config/common.php");
include("../../config/admin.php");
require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../../common/DAO/CommentsDAO.php";

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

$commentsDao = new AL\Common\DAO\CommentsDAO($mysqli);
//*********************************************************************************************
// User comments
//*********************************************************************************************

if (isset($view) and $view == "users_comments") {
    $view = "users_comments";
} elseif (isset($view) and $view == "comments_game_comments") {
    $view = "comments_game_comments";
} elseif (isset($view) and $view == "comments_all") {
    $view = "comments_all";
} elseif (isset($view) and $view == "comments_game_review_comments") {
    $view = "comments_game_review_comments";
} elseif (isset($view) and $view == "comments_interview_comments") {
    $view = "comments_interview_comments";
} else {
    $view = "latest_comments";
}

$smarty->assign(
    'comments',
    $commentsDao->getCommentsBuild(
        isset($view) ? $view : null,
        isset($user_id) ? $user_id : null,
        isset($action) ? $action : null,
        isset($last_timestamp) ? $last_timestamp : null
    )
);

$smarty->assign('links', array(
    'view' => $view,
    'getCommentCount' => $commentsDao->getCommentCount(),
));

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "comments.html");
