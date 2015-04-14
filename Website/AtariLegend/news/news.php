<?php
/***************************************************************************
*                                news.php
*                            -----------------------
*   begin                : Friday, March 20, 2015
*   copyright            : (C) 2015 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id: news.php,v 0.1 2015/03/20 21:06 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This file will insert the AtariLegend news into the MIDDLE section of an AL template  file
//********************************************************************************************* 

//load all common functions
include("../includes/common.php"); 

$v_counter = (isset($_GET["v_counter"]) ? $_GET["v_counter"] : 0);

//Select the news from the DB
$query_news = mysql_query("SELECT * FROM news 
						   LEFT JOIN news_image ON (news.news_image_id = news_image.news_image_id) 
						   LEFT JOIN users ON (news.user_id = users.user_id) 
						   ORDER BY news.news_date DESC LIMIT  " . $v_counter . ", 6"); 
						 

//check the number of news updates
$query_number = mysql_query("SELECT count(*) FROM news ORDER BY news_date DESC") or die("Couldn't get the number of news stories");
$v_rows = mysql_result($query_number,0,0) or die("Couldn't get the number of news stories");


//Lets put all the acquired news data into a smarty array and send them to the template.
while ($sql_news = mysql_fetch_array($query_news))  
{	
	$v_image  = $news_images_path;
	$v_image .= $sql_news['news_image_id'];
	$v_image .= '.';
	$v_image .= $sql_news['news_image_ext'];

	//fixxx the enters 
	$news_text = nl2br($sql_news['news_text']);
	//$news_text = InsertALCode($news_text); // disabled this as it wrecked the design.
	//Only 41 characters
	$news_text = substr($news_text, 0,44);
	$news_text = trim($news_text);
	$news_text .= "...";
	
	//convert the date to readible format
	$news_date = convert_timestamp($sql_news['news_date']);
	
	$smarty->append('news',
	    array('news_date' => $news_date,
			  'news_headline' => $sql_news['news_headline'],
        	  'news_text' => $news_text,
		      'image' => $v_image));
}

//Lets get some trivia quotes
$query_trivia_quote = mysql_query("SELECT trivia_quote FROM trivia_quotes ORDER BY RAND() LIMIT 1"); 
$sql_trivia_quote = mysql_fetch_array($query_trivia_quote);

$smarty->assign('trivia_quote', $sql_trivia_quote['trivia_quote']);

//Lets get some did you know texts
$query_trivia_text = mysql_query("SELECT trivia_text FROM trivia ORDER BY RAND() LIMIT 1"); 
$sql_trivia_text = mysql_fetch_array($query_trivia_text);

$smarty->assign('trivia_text', $sql_trivia_text['trivia_text']);

//Get the latest reviews
$query_recent_reviews = mysql_query("SELECT 
								   review_game.review_id,
								   review_game.game_id,
								   review_main.review_edit,
								   review_main.review_text,	
								   game.game_name,
								   screenshot_review.screenshot_id,
								   screenshot_main.imgext
								   FROM review_game
								   LEFT JOIN review_main on (review_game.review_id = review_main.review_id)
								   LEFT JOIN game on (review_game.game_id = game.game_id)
								   LEFT JOIN screenshot_review on (review_game.review_id = screenshot_review.review_id)
								   LEFT JOIN screenshot_main on (screenshot_review.screenshot_id = screenshot_main.screenshot_id)
								   WHERE review_main.review_edit = '0'
								   GROUP BY game_id
								   ORDER BY review_main.review_date DESC LIMIT 3") or die ("couldn't get 3 latest reviews");

while ($sql_recent_reviews = mysql_fetch_array($query_recent_reviews))
{	
	
	//convert the date to readible format
	$v_review_date = convert_timestamp($sql_recent_reviews[review_date]);
	
	$game_name = $sql_recent_reviews[game_name];
	$review_text = $sql_recent_reviews[review_text];
	$review_text = str_replace("[i][b]Comments[/b][/i]", "",$review_text);
	$review_text = substr($review_text, 0,75);
	$review_text = trim($review_text);
	$review_text .= "...";

	$v_review_image  = $game_screenshot_path;
	$v_review_image .= $sql_recent_reviews['screenshot_id'];
	$v_review_image .= '.';
	$v_review_image .= $sql_recent_reviews['imgext'];

			
	$smarty->append('recent_reviews',
	     array('review_name' => $game_name,
		 	   'review_id' => $sql_recent_reviews[review_id],
		 	   'game_id' => $sql_recent_reviews[game_id],
			   'review_text' => $review_text,
			   'review_img' => $v_review_image,
			   'review_user' => $sql_recent_reviews[userid],
			   'email' => $sql_recent_reviews[email]));
}

$smarty->assign('news_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.html');

//close the connection
mysql_close();
?>
