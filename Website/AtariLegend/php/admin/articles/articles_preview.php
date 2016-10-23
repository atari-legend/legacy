<?php
/***************************************************************************
*                               articles_preview.php
*                            --------------------------
*   begin                : friday, October 8, 2016
*   copyright            : (C) 2016 Atari Legend
*   email                : martens_maarten@hotmail.com
*
*   Id: articles_preview.php,v 0.10 2016/10/08 20:14 ST Graveyard
*                   - AL 2.0
*
***************************************************************************/

//*********************************************************************************************
// Load a preview of the article!
//*********************************************************************************************

//load all common functions
include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php");

$sql_article = $mysqli->query("SELECT
                                   article_main.article_id,
                                   article_main.user_id,
                                   article_text.article_title,
                                   article_text.article_text,
                                   article_text.article_date,
                                   users.userid,
                                   article_type.article_type
                            FROM article_main
                            LEFT JOIN article_text on (article_main.article_id = article_text.article_id)
                            LEFT JOIN users on (article_main.user_id = users.user_id)
                            LEFT JOIN article_type on (article_main.article_type_id = article_type.article_type_id)
                            WHERE article_main.article_id = $article_id") or die("Error - Couldn't query article data");

$query_article = $sql_article->fetch_array(MYSQLI_BOTH);

    $v_article_date = date("F j, Y",$query_article  ['article_date']);

    $article_text = $query_article['article_text'];
    $article_text = nl2br($article_text);
    $article_text = InsertALCode($article_text);

    //get the author of the article
    $query_author = $mysqli->query("SELECT userid, email FROM users WHERE user_id = $query_article[user_id]")
                    or die ("couldn't get author of article");
    $sql_author = $query_author->fetch_array(MYSQLI_BOTH);

    $smarty->assign('article',
         array('article_title' => $query_article['article_title'],
               'article_type' => $query_article['article_type'],
               'article_author' => $sql_author['userid'],
               'article_email' => $sql_author['email'],
               'article_id' => $article_id,
               'article_date' => $v_article_date,
               'article_text' => $article_text));

//Get the screenshots and the comments of this article
$query_screenshots = $mysqli->query("SELECT * FROM article_main
                                LEFT JOIN screenshot_article ON (article_main.article_id = screenshot_article.article_id)
                                LEFT JOIN screenshot_main ON (screenshot_article.screenshot_id = screenshot_main.screenshot_id)
                                LEFT JOIN article_comments ON (screenshot_article.screenshot_article_id = article_comments.screenshot_article_id)
                                WHERE article_main.article_id = '$article_id'
                                ORDER BY screenshot_main.screenshot_id");

$count = 1;

while ($sql_screenshots = $query_screenshots->fetch_array(MYSQLI_BOTH))
{
    $new_path = $article_screenshot_path;
    $new_path .= $sql_screenshots['screenshot_id'];
    $new_path .= ".";
    $new_path .= $sql_screenshots['imgext'];

    $smarty->append('screenshots',
                  array('screenshot' => $new_path,
                        'count' => $count,
                        'comment' => $sql_screenshots['comment_text']));

    $count++;
}

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."articles_preview.html");

//close the connection
mysqli_close($mysqli);
?>
