<?php
//***************************************************************************
//*                                articles_detail.html
//*                            -----------------------------
//*   begin                : Wednesday May 2, 2018
//*   copyright            : (C) 2018 Atari Legend
//*   email                : martens_maarten@hotmail.com
//*
//*   Id: articles_detail.html,v 0.1 2018/05/02 16:58 STG
//****************************************************************************

//****************************************************************************
// This is the detail page of an article.
//****************************************************************************

//load all common functions
include("../../config/common.php");

//load the tiles
include("../../common/tiles/latest_interviews_tile.php");

//***********************************************************************************
//Let's get all the article data
//***********************************************************************************
$sql_article = $mysqli->query("SELECT * FROM article_main
                    LEFT JOIN article_text ON ( article_main.article_id = article_text.article_id )
                    LEFT JOIN article_type ON ( article_main.article_type_id = article_type.article_type_id )
                    LEFT JOIN users ON ( article_main.user_id = users.user_id )
                    WHERE article_main.article_id = '$selected_article_id'") or die("Database error - selecting article data");


$article = $sql_article->fetch_array(MYSQLI_BOTH);
    
$v_article_date = date("F j, Y", $article['article_date']); 

$article_intro = $article['article_intro'];
$article_intro = nl2br($article_intro);
$article_intro = InsertALCode($article_intro);    

$article_text = $article['article_text'];
$article_text = nl2br($article_text);
$article_text = InsertALCode($article_text);               

$smarty->assign('article', array(
    'article_date' => $v_article_date,
    'article_title' => $article['article_title'],
    'article_type' => $article['article_type'],
    'article_id' => $selected_article_id,
    'article_intro' => $article_intro,
    'article_type_id' => $article['article_type_id'],
    'article_text' => $article_text,
    'article_userid' => $article['user_id'],
    'article_author' => $article['userid']
));


//Let's get the screenshots for the article
$sql_screenshots = $mysqli->query("SELECT * FROM screenshot_article
                                  LEFT JOIN screenshot_main on ( screenshot_article.screenshot_id = screenshot_main.screenshot_id )
                                  WHERE screenshot_article.article_id = '$selected_article_id' ORDER BY screenshot_article.screenshot_id ASC") or die("Database error - getting screenshots & comments");

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

//***********************************************************************************
//Get the comments
//***********************************************************************************
//Select the comments from the DB
$sql_comment = $mysqli->query("SELECT *
    FROM article_user_comments
    LEFT JOIN comments ON ( article_user_comments.comments_id = comments.comments_id )
    LEFT JOIN users ON ( comments.user_id = users.user_id )
    WHERE article_user_comments.article_id = '$selected_article_id'
    ORDER BY comments.timestamp desc") or die("Syntax Error! Couldn't not get the comments!");

while ($query_comment = $sql_comment->fetch_array(MYSQLI_BOTH)) {
    $oldcomment = $query_comment['comment'];
    $oldcomment = nl2br($oldcomment);
    $oldcomment = InsertALCode($oldcomment);
    $oldcomment = trim($oldcomment);
    $oldcomment = RemoveSmillies($oldcomment);
    $oldcomment = stripslashes($oldcomment);

    $comment = stripslashes($query_comment['comment']);
    $comment = trim($comment);
    $comment = RemoveSmillies($comment);

    // this is needed, because users can change their own comments on the website, however this is done with JS
    // (instead of a post with pure HTML)
    //The translation of the 'enter' breaks is different in JS, so in JS I do a conversion to a <br>.
    //However, when we edit a comment, this <br> should not be visible to the user, hence again,
    //now this conversion in php

    $breaks  = array(
        "<br />",
        "<br>",
        "<br/>"
    );
    $comment = str_ireplace($breaks, "\r\n", $comment);

    $date = date("d/m/y", $query_comment['timestamp']);

    $smarty->append('comments', array(
        'comment' => $oldcomment,
        'comment_edit' => $comment,
        'comment_id' => $query_comment['comments_id'],
        'date' => $date,
        'user_name' => $query_comment['userid'],
        'user_id' => $query_comment['user_id'],
        'user_fb' => $query_comment['user_fb'],
        'user_website' => $query_comment['user_website'],
        'user_twitter' => $query_comment['user_twitter'],
        'user_af' => $query_comment['user_af'],
        'email' => $query_comment['email']
    ));
}

//*************************************************************
//Lets get all the articles by this author
//*************************************************************
$sql_articles_author = $mysqli->query("SELECT * FROM article_main
                           LEFT JOIN article_text ON (article_main.article_id = article_text.article_id)
                           LEFT JOIN users ON (article_main.user_id = users.user_id)
                           WHERE article_main.user_id = '$article[user_id]'") or die("problem with query");

$count = 0;

while ($query_articles_author = $sql_articles_author->fetch_array(MYSQLI_BOTH)) {
    $count++;

    $smarty->append('articles_author', array(
            'article_id' => $query_articles_author['article_id'],
            'article_title' => $query_articles_author['article_title']
        ));
}

$smarty->assign('nr_articles_author', $count);

//Send all smarty variables to the templates
$smarty->display("file:" . $mainsite_template_folder . "articles_detail.html");

//close the connection
mysqli_close($mysqli);
