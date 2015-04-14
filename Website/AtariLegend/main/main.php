<?php
/***************************************************************************
*                                main.php
*                            -----------------------
*   begin                : Tuesday, April 14, 2015
*   copyright            : (C) 2015 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id: news.php,v 0.1 2015/04/14 22:54 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php for the front page of AtariLegend
//********************************************************************************************* 

//load all common functions
include("../includes/common.php"); 
include("../news/latest_news_tile.php"); 
include("../trivia/trivia_tile.php"); 
include("../trivia/did_you_know_tile.php"); 
include("../reviews/latest_reviews_tile.php"); 

//Send all smarty variables to the templates
$smarty->display('extends:../templates/0/main.html|../templates/0/top.html|../templates/0/latest_news_tile.html|../templates/0/latest_reviews_tile.html|../templates/0/who_is_it_tile.html|../templates/0/screenstar_tile.html|../templates/0/hotlinks_tile.html|../templates/0/date_quote_tile.html|../templates/0/did_you_know_tile.html|../templates/0/statistics_tile.html|../templates/0/footer.html'); 

//close the connection
mysql_close();
?>
