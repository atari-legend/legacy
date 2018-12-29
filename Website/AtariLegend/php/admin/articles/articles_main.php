<?php
/***************************************************************************
 *                                articles_main.php
 *                            ------------------------------
 *   begin                : Wednesdat, October 5th, 2016
 *   copyright            : (C) 2016 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : Start of creation file
 *
 *   Id: interviews_main.php,v 0.10 05/10/2016 23:06 Gatekeeper
 *             - AL 2.0 / creation of section
 *   Id: interviews_main.php,v 0.11 25/04/2018 17:15 STG
 *             - Update making more user friendly
 *
 ***************************************************************************/

//****************************************************************************************
// The main articles page
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
    ORDER BY article_text.article_date DESC LIMIT  " . $v_counter . ", 5")
    or die("Couldn't query database for articles");

while ($article = $sql_articles->fetch_array(MYSQLI_BOTH)) {
    $article_date = date("F j, Y", $article['article_date']);

    $article_text  = $article['article_intro'];
    $article_text  = nl2br($article_text);
    $article_text  = InsertALCode($article_text);
    //$article_text = InsertSmillies($article_text);
    $article_title = rawurlencode($article['article_title']);

    $smarty->append('article_list', array(
        'userid' => $article['userid'],
        'user_id' => $article['user_id'],
        'user_email' => $article['email'],
        'article_id' => $article['article_id'],
        'article_title' => $article['article_title'],
        'article_date' => $article_date,
        'article_type' => $article['article_type'],
        'article_text' => $article_text
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

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "articles_main.html");

//close the connection
mysqli_close($mysqli);
