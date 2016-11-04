<?php
/***************************************************************************
 *                                news_edit_images.php
 *                            ---------------------------
 *   begin                : Sunday, May 1, 2005
 *   copyright            : (C) 2003 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : File creation
 *
 *   Id: news_edit_images.php,v 0.10 2004/05/01 ST Graveyard
 *   Id: news_edit_images.php,v 0.20 2016/07/29 ST Graveyard
 *           - AL 2.0
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 In this section we can delete/edit a newsimage
 ***********************************************************************************
 */

include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php");

$sql_images = $mysqli->query("SELECT * FROM news_image ORDER BY news_image_name ASC");

while ($news_images = $sql_images->fetch_array(MYSQLI_BOTH)) {
    $v_image = $news_images_path;
    $v_image .= $news_images['news_image_id'];
    $v_image .= '.';
    $v_image .= $news_images['news_image_ext'];

    // Count how many times the image is used.
    $query      = $mysqli->query("SELECT COUNT(*) AS count FROM news WHERE news_image_id = $news_images[news_image_id]");
    $imagecount = $query->fetch_array(MYSQLI_BOTH);

    $smarty->append('news_images', array(
        'image_id' => $news_images['news_image_id'],
        'image_name' => $news_images['news_image_name'],
        'image_count' => $imagecount['count'],
        'image_link' => $v_image
    ));
}

$sql_news = $mysqli->query("SELECT
                news_id,
                news_headline,
                news_image_id
                FROM news ORDER BY news_image_id") or die("Error retriving news posts");

while ($news = $sql_news->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('news_headlines', array(
        'news_id' => $news['news_id'],
        'news_headline' => $news['news_headline'],
        'news_image_id' => $news['news_image_id']
    ));
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "news_edit_images.html");

//close the connection
mysqli_close($mysqli);
