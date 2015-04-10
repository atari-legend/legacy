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
	$v_image  = '../data/images/news_images/';
	$v_image .= $sql_news['news_image_id'];
	$v_image .= '.';
	$v_image .= $sql_news['news_image_ext'];

	//fixxx the enters 
	$news_text = nl2br($sql_news['news_text']);
	$news_text = InsertALCode($news_text);
	
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

$smarty->assign('news_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.html');

//close the connection
mysql_close();
?>
