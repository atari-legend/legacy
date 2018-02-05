<?php
/***************************************************************************
 *                                db_news.php
 *                            ------------------------------------
 *   begin                : Sunday, August 28, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : Creation of file
 *
 *   Id: db_news.php,v 0.1 2017/08/28 09:58 ST Graveyard
 *
 ***************************************************************************/

//*************************************************************************
// This is the php code where we add a news submission
//*************************************************************************

include("../../config/common.php");
include("../../config/admin.php");

if (isset($news_headline) and $news_headline != 'Headline' and $news_headline != ''
    and isset($textfield) and $textfield != 'News item' and $textfield != '') {
    $timestamp = time();
    $textfield = $mysqli->real_escape_string($textfield);
    $mysqli->query("INSERT INTO news_submission (news_headline, news_text, user_id, news_date )
    VALUES ('$news_headline', '$textfield', '$_SESSION[user_id]', '$timestamp')")
    or die("Inserting the news submission failed");

    $new_news_id = $mysqli->insert_id;
    create_log_entry('News', $new_news_id, 'News submit', $new_news_id, 'Insert', $_SESSION['user_id']);

    $_SESSION['edit_message'] = "News submitted correctly - Waiting for approval by admin";
} else {
    $_SESSION['edit_message'] = "Please fill in all required fields";
}

header("Location: ../news/news.php");
