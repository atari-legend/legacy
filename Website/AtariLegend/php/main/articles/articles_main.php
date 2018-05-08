<?php
/***************************************************************************
*                                articles_main.php
*                            ------------------------------
*   begin                : Wednesday May 2, 2018
*   copyright            : (C) 2018 Atari Legend
*   email                : martens_maarten@hotmail.com
*
*   Id: articles_main.php,v 0.1 2018/05/02 16:37 STG
****************************************************************************/

//****************************************************************************************
// This is the main page of the articles section.
//****************************************************************************************

//load all common functions
include("../../config/common.php");

//load the tiles
include("../../common/tiles/hotlinks_tile.php");
include("../../common/tiles/did_you_know_tile.php");
include("../../common/tiles/screenstar.php");
include("../../common/tiles/tile_bug_report.php");

//Get the articles
$v_counter = (isset($_GET["v_counter"]) ? $_GET["v_counter"] : 0);

// count number of articles
$query_number = $mysqli->query("SELECT * FROM article_main") or die("Couldn't get the number of articles - count");
$v_rows = $query_number->num_rows;

//main query
$sql_articles = $mysqli->query("SELECT * FROM article_main
                              LEFT JOIN article_text on (article_main.article_id = article_text.article_id)
                              LEFT JOIN article_type on (article_main.article_type_id = article_type.article_type_id)
                              LEFT JOIN users on ( article_main.user_id = users.user_id )
                              ORDER BY article_text.article_date DESC LIMIT  " . $v_counter . ", 5") or die("Couldn't query database for articles");

while ($article = $sql_articles->fetch_array(MYSQLI_BOTH)) {
    $article_date = date("F j, Y", $article['article_date']);

    $article_text  = $article['article_intro'];
    $article_text  = nl2br($article_text);
    $article_text  = InsertALCode($article_text);
    //$article_text = InsertSmillies($article_text);
    $article_title = rawurlencode($article['article_title']);
    
    //Get a screenshot of this article
    $query_screenshots_article = $mysqli->query("SELECT * FROM article_main
                                    LEFT JOIN screenshot_article ON (article_main.article_id = screenshot_article.article_id)
                                    LEFT JOIN screenshot_main ON (screenshot_article.screenshot_id = screenshot_main.screenshot_id)
                                    WHERE article_main.article_id = '$article[article_id]' ORDER BY RAND() LIMIT 1") or die("Error - Couldn't query article screenshots");

    $sql_screenshots_article = $query_screenshots_article->fetch_array(MYSQLI_BOTH);

    $new_path = $article_screenshot_path;
    $new_path .= $sql_screenshots_article['screenshot_id'];
    $new_path .= ".";
    $new_path .= $sql_screenshots_article['imgext'];


    $smarty->append('article_list', array(
        'userid' => $article['userid'],
        'user_id' => $article['user_id'],
        'user_email' => $article['email'],
        'article_id' => $article['article_id'],
        'article_title' => $article['article_title'],
        'article_date' => $article_date,
        'article_type' => $article['article_type'],
        'article_text' => $article_text,
        'article_img' => $new_path
    ));
}

$smarty->assign('nr_articles', $v_rows);


//Check if back arrow is needed
if ($v_counter > 0) {
    // Build the link
    $v_linkback = ('?v_counter=' . ($v_counter - 5));
}

//Check if we need to place a next arrow
if ($v_rows > ($v_counter + 5)) {
    //Build the link
    $v_linknext = ('?v_counter=' . ($v_counter + 5));
}

if (empty($c_counter)) {
    $c_counter = "";
}
if (empty($v_linkback)) {
    $v_linkback = "";
}
if (empty($v_linknext)) {
    $v_linknext = "";
}

$smarty->assign('links', array(
    'linkback' => $v_linkback,
    'linknext' => $v_linknext,
    'v_counter' => $v_counter,
    'c_counter' => $c_counter
));

//Send all smarty variables to the templates
$smarty->display("file:" . $mainsite_template_folder . "articles_main.html");

//close the connection
mysqli_close($mysqli);
