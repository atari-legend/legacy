<?php
/***************************************************************************
*                                news.php
*                            ------------------------------
*   begin                : Friday, August 25, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*
*   Id: news.php,v 0.1 2017/08/25 19:50 STG
****************************************************************************/

//*********************************************************************************************
// This is the main news page
//*********************************************************************************************

//load all common functions
include("../../config/common.php");

//load the tiles
include("../../common/tiles/screenstar.php");
include("../../common/tiles/did_you_know_tile.php");
include("../../common/tiles/latest_comments_tile.php");

$v_counter= (isset($_GET["v_counter"]) ? $_GET["v_counter"] : 0);


//Select the news from the DB
$query_news = $mysqli->query("SELECT * FROM news
                               LEFT JOIN news_image ON (news.news_image_id = news_image.news_image_id)
                               LEFT JOIN users ON (news.user_id = users.user_id)
                               ORDER BY news.news_date DESC LIMIT  " . $v_counter . ", 6");


//check the number of news updates
$query_number = $mysqli->query("SELECT * FROM news ORDER BY news_date DESC") or die("Couldn't get the number of news stories");
$v_rows = $query_number->num_rows;


//Lets put all the acquired news data into a smarty array and send them to the template.
while ($sql_news = $query_news->fetch_array(MYSQLI_BOTH)) {
    $v_image  = $news_images_path;
    $v_image .= $sql_news['news_image_id'];
    $v_image .= '.';
    $v_image .= $sql_news['news_image_ext'];

    //fixxx the enters
    $news_text = nl2br($sql_news['news_text']);
    $news_text = InsertALCode($news_text);
    $news_text = trim($news_text);
    $news_text = RemoveSmillies($news_text);

    //convert the date to readible format
    $news_date = date("F j, Y",$sql_news['news_date']);

    $smarty->append('news', array(
                'news_date' => $news_date,
                'news_headline' => $sql_news['news_headline'],
                'news_text' => $news_text,
                'image' => $v_image,
                'image_id' => $sql_news['news_image_id'],
                'user_id' => $sql_news['user_id'],
                'user_name' => $sql_news['userid'],
                'email' => $sql_news['email']));
}

//Check if back arrow is needed
if ($v_counter > 0) {
// Build the link
    $v_linkback =('?v_counter=' . ($v_counter - 6));
}

//Check if we need to place a next arrow
if ($v_rows > ($v_counter + 6)) {
//Build the link
    $v_linknext =('?v_counter=' . ($v_counter + 6));
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
        'linknext' => $v_linknext)
);

//Send all smarty variables to the templates
$smarty->display("file:" . $mainsite_template_folder . "news.html");

//close the connection
mysqli_close($mysqli);
