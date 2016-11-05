<?php
/***************************************************************************
 *                               articles_screenshots_Add.php
 *                            ----------------------------------
 *   begin                : friday, October 8, 2016
 *   copyright            : (C) 2016 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *
 *   Id: articles_screenshots_Add.php,v 0.10 2016/10/08 22:26 ST Graveyard
 *                         - AL 2.0
 *
 ***************************************************************************/

//****************************************************************************************
// This is the image selection/upload screen for the articles
//****************************************************************************************

include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php");

//Get the screenshots for this article, if they exist
$sql_screenshots = $mysqli->query("SELECT * FROM screenshot_article
                                  LEFT JOIN screenshot_main ON (screenshot_article.screenshot_id = screenshot_main.screenshot_id)
                                  WHERE screenshot_article.article_id = '$article_id' ORDER BY screenshot_article.screenshot_id") or die("Database error - selecting screenshots");

//get the number of screenshots in the archive
$v_screenshots = $sql_screenshots->num_rows;
$smarty->assign("screenshots_nr", $v_screenshots);

$count = 1;

while ($screenshots = $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
    // Get the image dimensions for the pop up window
    $imginfo    = getimagesize("$article_screenshot_save_path$screenshots[screenshot_id].$screenshots[imgext]");
    $width      = $imginfo[0] + 20;
    $height     = $imginfo[1] + 25;
    $image_path = "$article_screenshot_path$screenshots[screenshot_id].$screenshots[imgext]";

    $smarty->append('screenshots', array(
        'count' => $count,
        'width' => $width,
        'height' => $height,
        'image_path' => $image_path,
        'id' => $screenshots['screenshot_id']
    ));
    $count++;
}

//we need to get the data of the loaded article
$sql_article = $mysqli->query("SELECT * FROM article_main
                              LEFT JOIN article_text ON ( article_main.article_id = article_text.article_id )
                              LEFT JOIN article_type on ( article_main.article_type_id = article_type.article_type_id )
                              WHERE article_main.article_id = '$article_id'") or die("Database error - selecting article data");

while ($article = $sql_article->fetch_array(MYSQLI_BOTH)) {
    $smarty->assign('article', array(
        'article_id' => $article_id,
        'article_title' => $article['article_title'],
        'article_type' => $article['article_type'],
        'article_author' => $article['user_id']
    ));
}

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "articles_screenshots_add.html");

//close the connection
mysqli_close($mysqli);
