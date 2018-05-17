<?php
/***************************************************************************
 *                                articles_edit.php
 *                            --------------------------
 *   begin                : Thursday, 06/10/2016
 *   copyright            : (C) 2016 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : created this page
 *
 *   Id: articles_edit.php,v 0.10 2016/10/06 13:40 Gatekeeper
 *                   - AL 2.0 / creation of file
 *
 ***************************************************************************/

//****************************************************************************************
// This is the articles edit page. Overhere you can edit an existing article
//****************************************************************************************

include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

//Get list of all articles
$sql_articles = $mysqli->query("SELECT * FROM article_main
                                LEFT JOIN article_text ON (article_main.article_id = article_text.article_id)
                                ORDER BY article_text.article_date ASC") or die("Couldn't query articles database");

while ($articles = $sql_articles->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('articles', array(
        'article_id' => $articles['article_id'],
        'article_title' => $articles['article_title']
    ));
}

//Get the authors for the article
$sql_author = $mysqli->query("SELECT user_id,userid FROM users") or die("Database error - getting members name");

while ($authors = $sql_author->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('authors', array(
        'user_id' => $authors['user_id'],
        'user_name' => $authors['userid']
    ));
}

//get the types
$sql_types = $mysqli->query("SELECT article_type_id,article_type FROM article_type") or die("Database error - getting the article types");

while ($article_types = $sql_types->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('article_types', array(
        'article_type_id' => $article_types['article_type_id'],
        'article_type' => $article_types['article_type']
    ));
}

//we need to get the data of the loaded article
$sql_article = $mysqli->query("SELECT * FROM article_main
                  LEFT JOIN article_text ON ( article_main.article_id = article_text.article_id )
                  LEFT JOIN article_type on ( article_main.article_type_id = article_type.article_type_id )
                WHERE article_main.article_id = '$article_id'") or die("Database error - selecting article data");

while ($article = $sql_article->fetch_array(MYSQLI_BOTH)) {
    $smarty->assign('article', array(
        'article_date' => $article['article_date'],
        'article_title' => $article['article_title'],
        'article_id' => $article_id,
        'article_intro' => $article['article_intro'],
        'article_type_id' => $article['article_type_id'],
        'article_text' => $article['article_text'],
        'article_author' => $article['user_id']
    ));
}

//Let's get the screenshots for the article
$sql_screenshots = $mysqli->query("SELECT * FROM screenshot_article
                                  LEFT JOIN screenshot_main on ( screenshot_article.screenshot_id = screenshot_main.screenshot_id )
                                  WHERE screenshot_article.article_id = '$article_id' ORDER BY screenshot_article.screenshot_id ASC") or die("Database error - getting screenshots & comments");

//get the number of screenshots in the archive
$v_screeshots = $sql_screenshots->num_rows;
$smarty->assign("screenshots_nr", $v_screeshots);

$count = 1;

while ($screenshots = $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
    $v_int_image = $article_screenshot_path;
    $v_int_image .= $screenshots['screenshot_id'];
    $v_int_image .= '.';
    $v_int_image .= $screenshots['imgext'];

    //We need to get the comments with each screenshot
    $sql_comments = $mysqli->query("SELECT * FROM article_comments
                                    WHERE screenshot_article_id  = $screenshots[screenshot_article_id]") or die("Database error - getting screenshots comments");

    $comments = $sql_comments->fetch_array(MYSQLI_BOTH);

    $smarty->append('screenshots', array(
        'article_screenshot' => $v_int_image,
        'article_screenshot_id' => $screenshots['screenshot_id'],
        'article_screenshot_count' => $count,
        'article_screenshot_comment' => $comments['comment_text']
    ));

    $count = $count + 1;
}

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "articles_edit.html");

//close the connection
mysqli_close($mysqli);
