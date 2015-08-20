<?php
/***************************************************************************
*                                front.php
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
include("../../includes/common.php"); 
include("../tiles/latest_news_tile.php"); 
include("../tiles/trivia_tile.php"); 
include("../tiles/did_you_know_tile.php"); 
include("../tiles/latest_reviews_tile.php"); 
include("../tiles/who_is_it_tile.php"); 
include("../tiles/screenstar.php");
include("../tiles/statistics_tile.php");
include("../tiles/hotlinks_tile.php");

//Send all smarty variables to the templates
$smarty->display('extends:../../../templates/html/main/main.html|../../../templates/html/main/frontpage.html|../../../templates/html/main/latest_news_tile.html|../../../templates/html/main/latest_reviews_tile.html|../../../templates/html/main/who_is_it_tile.html|../../../templates/html/main/screenstar_tile.html|../../../templates/html/main/hotlinks_tile.html|../../../templates/html/main/date_quote_tile.html|../../../templates/html/main/did_you_know_tile.html|../../../templates/html/main/statistics_tile.html|../../../templates/html/main/user_login_tile.html');

//close the connection
mysqli_close($mysqli)
?>
	