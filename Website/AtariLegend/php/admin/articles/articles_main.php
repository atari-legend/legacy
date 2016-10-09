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
*   - AL 2.0 / creation of section
*
***************************************************************************/

//****************************************************************************************
// The main articles page
//****************************************************************************************

include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php");

//Get list of all articles
$sql_articles = $mysqli->query("SELECT * FROM article_main
                LEFT JOIN article_text ON (article_main.article_id = article_text.article_id)
                ORDER BY article_text.article_date ASC")
             or die ("Couldn't query articles database");

while ($articles = $sql_articles->fetch_array(MYSQLI_BOTH))
{
  $smarty->append('articles',
         array('article_id' => $articles['article_id'],
           'article_title' => $articles['article_title']));
}

if ( isset($action) and $action == 'search' )
{
    if ( $article_search == " " or $article_search == '-' )
    {
      //show all
      $sql_articles = $mysqli->query("SELECT * FROM article_main
                      LEFT JOIN article_text on (article_main.article_id = article_text.article_id)
                      LEFT JOIN article_type on (article_main.article_type_id = article_type.article_type_id)
                      LEFT JOIN users on ( article_main.user_id = users.user_id )
                      ORDER BY article_text.article_date DESC")
                 or die ("Couldn't query database for articles");
    }
    else
    {
      $sql_articles = $mysqli->query("SELECT * FROM article_main
                      LEFT JOIN article_text on (article_main.article_id = article_text.article_id)
                      LEFT JOIN article_type on (article_main.article_type_id = article_type.article_type_id)
                      LEFT JOIN users on ( article_main.user_id = users.user_id )
                      WHERE article_main.article_id = '$article_search'
                      ORDER BY article_text.article_date DESC")
                 or die ("Couldn't query database for articles");
    }

    //get the number of articles in the archive
    $v_articles = $sql_articles->num_rows;
    $message = 'Your search query resulted in ';
    $message .= $v_articles;
    $message .= ' hits';
    $smarty->assign("message",$message);

    while ($article = $sql_articles->fetch_array(MYSQLI_BOTH))
    {

      $article_date = convert_timestamp($article['article_date']);

      $article_text = $article['article_intro'];
      $article_text = nl2br($article_text);
      $article_text = InsertALCode($article_text);
      //$article_text = InsertSmillies($article_text);
      $article_title = rawurlencode($article['article_title']);

      $smarty->append('article_selected',
           array('user_id' => $article['userid'],
               'user_email' => $article['email'],
               'article_id' => $article['article_id'],
               'article_title' => $article['article_title'],
               'article_date' => $article_date,
               'article_type' => $article['article_type'],
               'article_text' => $article_text));
  }
}

$smarty->assign("user_id",$_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."articles_main.html");

//close the connection
mysqli_close($mysqli);
