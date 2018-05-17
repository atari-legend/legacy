<?php
/***************************************************************************
 *                                ajax_news_post_edit.php
 *                            -------------------------------
 *   begin                : Thursday, April 4, 2018
 *   copyright            : (C) 2018 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : File creation
 *
 ***************************************************************************/
//****************************************************************************************
// This is where we can edit all the news sections
//****************************************************************************************

include("../../config/common.php");
include("../../config/admin.php");
require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../../common/DAO/NewsDAO.php";

$newsDAO = new AL\Common\DAO\NewsDAO($mysqli);

if (isset($action) and $action == "get_newspost_text") {
    if (isset($news_id)) {
        $smarty->assign('news_item', $newsDAO->getSpecificNews($news_id));
        $smarty->assign('action', $action);
        $smarty->assign('news_id', $news_id);
    }
}
//Get the authors for the news post
$sql_author = $mysqli->query("SELECT user_id,userid FROM users ORDER BY userid ASC") or die("Database error - getting members name");

while ($authors = $sql_author->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('authors', array(
        'user_id' => $authors['user_id'],
        'user_name' => $authors['userid']
    ));
}

//Get the news images
$sql_newsimage = $mysqli->query("SELECT news_image_id,news_image_name FROM news_image ORDER BY news_image_name");

while ($newsimages = $sql_newsimage->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('news_images', array(
        'image_id' => $newsimages['news_image_id'],
        'image_name' => $newsimages['news_image_name']
    ));
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_news_post_edit.html");

//close the connection
mysqli_close($mysqli);
