<?php
/***************************************************************************
 *                                news_add.php
 *                            -----------------------
 *   begin                : Sunday, may 1 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : creation of file
 *
 *
 *   Id:  news_add.php,v 0.12 2016/07/27 ST Graveyard
 *          -AL 2.0
 *
 ***************************************************************************/

/************************************************************************************
 In this section we can add a news update to the DB
************************************************************************************/

include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

$sql_newsimage = $mysqli->query("SELECT news_image_id,news_image_name FROM news_image ORDER BY news_image_name");

while ($newsimages = $sql_newsimage->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('news_images', array(
        'image_id' => $newsimages['news_image_id'],
        'image_name' => $newsimages['news_image_name']
    ));
}

//Get the authors for the news post
$sql_author = $mysqli->query("SELECT user_id,userid FROM users ORDER BY userid ASC")
    or die("Database error - getting members name");

while ($authors = $sql_author->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('authors', array(
        'user_id' => $authors['user_id'],
        'user_name' => $authors['userid']
    ));
}

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "news/news_add.html");

//close the connection
mysqli_close($mysqli);
