<?php
/***************************************************************************
 *                                news_edit_all.php
 *                            ---------------------------
 *   begin                : Thursday, May 5, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : File creation
 *
 *   Id: news_edit_all.php,v 0.10 2004/05/05 ST Graveyard
 *   Id: news_edit_all.php,v 0.20 2016/07/29 ST Graveyard
 *           - AL 2.0
 *
 ***************************************************************************/
//****************************************************************************************
// This is where we can edit all the news sections
//****************************************************************************************

include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

if (empty($v_linkback)) {
    $v_linkback = '';
}

//get the number of news threads in the archive
$query_number = $mysqli->query("SELECT * FROM news") or die("Couldn't get the number of news threads");
$v_news = $query_number->num_rows;

$smarty->assign('news_nr', $v_news);

$v_counter = (isset($_GET["v_counter"]) ? $_GET["v_counter"] : 0);

$sql_news = $mysqli->query("SELECT
                         news.news_id,
                         news.news_headline,
                         news.user_id,
                         news_image.news_image_ext,
                         news.news_image_id,
                         news.news_text,
                         users.email,
                         news.news_date
                         FROM news
                         LEFT JOIN news_image ON (news.news_image_id = news_image.news_image_id)
                         LEFT JOIN users on ( news.user_id = users.user_id )
                         ORDER BY news_date DESC LIMIT  " . $v_counter . ", 10");

while ($news = $sql_news->fetch_array(MYSQLI_BOTH)) {
    $user_name      = get_username_from_id($news['user_id']);
    $news_date      = date("d-m-Y", $news['news_date']);
    $news_text      = InsertALCode($news['news_text']);
    //$news_text = InsertSmillies($news_text);
    $news_text      = nl2br($news_text);
    $email_headline = rawurlencode($news['news_headline']);

    $v_image = $news_images_path;
    $v_image .= $news['news_image_id'];
    $v_image .= '.';
    $v_image .= $news['news_image_ext'];

    $smarty->append('edit_submissions', array(
        'edit_userid' => $user_name,
        'edit_id' => $news['news_id'],
        'edit_headline' => $news['news_headline'],
        'email_headline' => $email_headline,
        'edit_date' => $news_date,
        'edit_text' => $news_text,
        'edit_image_id' => $news['news_image_id'],
        'edit_email' => $news['email'],
        'edit_icon' => $v_image
    ));
}

//Check if back arrow is needed
if ($v_counter > 0) {
    // Build the link
    $v_linkback = ("news_edit_all.php" . '?v_counter=' . ($v_counter - 10));
}

//Check if we need to place a next arrow
if ($v_news > ($v_counter + 10)) {
    //Build the link
    $v_linknext = ("news_edit_all.php" . '?v_counter=' . ($v_counter + 10));
}

$smarty->assign('links', array(
    'linkback' => $v_linkback,
    'linknext' => $v_linknext
));

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "news_edit_all.html");

//close the connection
mysqli_close($mysqli);
