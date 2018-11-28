<?php
/***************************************************************************
 *                               user_statistics.php
 *                            -----------------------
 *   begin                : friday, November 11, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : file creation
 *
 *
 *   Id: user_statistics.php,v 0.10 2005/05/01 ST Graveman
 user_statistics.php,v 0.20 2015/02/09 ST Graveman
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the user statistics page
 ***********************************************************************************
 */
// include common variables and functions
include("../../config/common.php");
include("../../config/admin.php");

// START - NUMBER OF GAME COMMENTS
$sql = $mysqli->query("SELECT * FROM game_user_comments
                    LEFT JOIN comments ON (comments.comments_id = game_user_comments.comment_id)
                    LEFT JOIN game ON ( game_user_comments.game_id = game.game_id )
                    WHERE comments.user_id = $user_id_selected");

$nr_comments = 0;

while ($query = $sql->fetch_array(MYSQLI_BOTH)) {
    $nr_comments++;

    $smarty->append('users_comments', array(
        'game_id' => $query['game_id'],
        'game_name' => $query['game_name']
    ));
}

$smarty->assign('nr_game_comments', $nr_comments);

mysqli_free_result($sql);

// START - NUMBER OF REVIEW COMMENTS
$sql = $mysqli->query("SELECT * FROM review_user_comments
                    LEFT JOIN comments ON (comments.comments_id = review_user_comments.comment_id)
                    LEFT JOIN review_game ON ( review_user_comments.review_id = review_game.review_id )
                    LEFT JOIN game ON ( review_game.game_id = game.game_id )
                    WHERE comments.user_id = $user_id_selected") or die("error in game review stats query");

$nr_comments = 0;

while ($query = $sql->fetch_array(MYSQLI_BOTH)) {
    $nr_comments++;

    $smarty->append('review_users_comments', array(
        'game_id' => $query['game_id'],
        'review_id' => $query['review_id'],
        'game_name' => $query['game_name']
    ));
}

$smarty->assign('nr_review_comments', $nr_comments);

mysqli_free_result($sql);

// START - NUMBER OF INTERVIEW COMMENTS
$sql = $mysqli->query("SELECT * FROM interview_user_comments
                    LEFT JOIN comments ON (comments.comments_id = interview_user_comments.comment_id)
                    LEFT JOIN interview_main ON ( interview_main.interview_id = interview_user_comments.interview_id )
                    LEFT JOIN individuals ON ( individuals.ind_id = interview_main.ind_id )
                    WHERE comments.user_id = $user_id_selected") or die("error in interview stats query");

$nr_comments = 0;

while ($query = $sql->fetch_array(MYSQLI_BOTH)) {
    $nr_comments++;

    $smarty->append('interview_users_comments', array(
        'interview_id' => $query['interview_id'],
        'ind_name' => $query['ind_name']
    ));
}

$smarty->assign('nr_interview_comments', $nr_comments);

mysqli_free_result($sql);

// START - NUMBER OF article COMMENTS
$sql = $mysqli->query("SELECT * FROM article_user_comments
                    LEFT JOIN comments ON (comments.comments_id = article_user_comments.comments_id)
                    LEFT JOIN article_main ON ( article_main.article_id = article_user_comments.article_id )
                    LEFT JOIN article_text ON ( article_main.article_id = article_text.article_id )
                    WHERE comments.user_id = $user_id_selected") or die("error in article stats query");

$nr_comments = 0;

while ($query = $sql->fetch_array(MYSQLI_BOTH)) {
    $nr_comments++;

    $smarty->append('article_users_comments', array(
        'article_id' => $query['article_id'],
        'article_title' => $query['article_title']
    ));
}

$smarty->assign('nr_article_comments', $nr_comments);

mysqli_free_result($sql);

// START - NUMBER OF reviews
$sql        = $mysqli->query("SELECT * FROM review_main
                    LEFT JOIN review_game ON (review_main.review_id = review_game.review_id)
                    LEFT JOIN game ON ( review_game.game_id = game.game_id )
                    WHERE review_main.user_id = $user_id_selected");
$nr_reviews = 0;
while ($query = $sql->fetch_array(MYSQLI_BOTH)) {
    $nr_reviews++;

    $smarty->append('users_reviews', array(
        'game_id' => $query['game_id'],
        'game_name' => $query['game_name'],
        'review_id' => $query['review_id']
    ));
}

$smarty->assign('nr_reviews', $nr_reviews);

mysqli_free_result($sql);

// START - NUMBER OF DOWNLOADS BY USER
<<<<<<< HEAD
//* Add download stats here one day!
=======
/* $query     = $mysqli->query("SELECT COUNT(*) AS count FROM game_download_info WHERE user_id = $user_id_selected");
$gamecount = $query->fetch_array(MYSQLI_BOTH);
$gamecount = $gamecount['count'];

$smarty->assign('nr_downloads', $gamecount);

mysqli_free_result($query); */
>>>>>>> CleanUpTables

// START - NUMBER OF SUBMISSIONS BY USER
$sql = $mysqli->query("SELECT * FROM game_submitinfo
                       LEFT JOIN game ON (game_submitinfo.game_id = game.game_id)
                       WHERE user_id = $user_id_selected");
$nr_submission = 0;
while ($query = $sql->fetch_array(MYSQLI_BOTH)) {
    $nr_submission++;

    $smarty->append('users_submission', array(
        'game_id' => $query['game_id'],
        'game_name' => $query['game_name']
    ));
}

$smarty->assign('nr_submission', $nr_submission);

mysqli_free_result($sql);

// START - NUMBER OF LINKS BY USER
$sql      = $mysqli->query("SELECT * FROM website WHERE user_id = $user_id_selected");
$nr_links = 0;
while ($query = $sql->fetch_array(MYSQLI_BOTH)) {
    $nr_links++;

    $smarty->append('users_website', array(
        'website_id' => $query['website_id'],
        'website_name' => $query['website_name']
    ));
}

$smarty->assign('nr_links', $nr_links);

mysqli_free_result($sql);

// START - NUMBER OF NEWS POSTS BY USER
$sql     = $mysqli->query("SELECT * FROM news WHERE user_id = $user_id_selected");
$nr_news = 0;
while ($query = $sql->fetch_array(MYSQLI_BOTH)) {
    $nr_news++;

    $smarty->append('users_news', array(
        'news_id' => $query['news_id'],
        'news_headline' => $query['news_headline']
    ));
}

//get user info
// START - NUMBER OF NEWS POSTS BY USER
$sql = $mysqli->query("SELECT * FROM users WHERE user_id = $user_id_selected") or die('problem getting user data');

while ($query = $sql->fetch_array(MYSQLI_BOTH)) {
    $smarty->assign('user', array(
        'user_id' => $query['user_id'],
        'username' => $query['userid'],
        'user_email' => $query['email']
    ));
}

$smarty->assign('nr_news', $nr_news);

mysqli_free_result($sql);

$smarty->assign('user_id_selected', $user_id_selected);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "user_statistics.html");

//close the connection
mysqli_close($mysqli);
