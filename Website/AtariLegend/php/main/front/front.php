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
include("../../config/common.php");

//Load all tiles
include("../../common/tiles/latest_news_tile.php");
include("../../common/tiles/trivia_tile.php");
include("../../common/tiles/did_you_know_tile.php");
include("../../common/tiles/latest_reviews_tile.php");
include("../../common/tiles/who_is_it_tile.php");
include("../../common/tiles/screenstar.php");
include("../tiles/statistics_tile.php");
include("../../common/tiles/hotlinks_tile.php");


//Create the id's for dynamic positioning of the tiles
$smarty->assign('date_quote_tile', 'datequote_position_front');
$smarty->assign('did_you_know_tile', 'didyouknow_position_front');
$smarty->assign('hotlinks_tile', 'hotlinks_position_front');
$smarty->assign('screenstar_tile', 'screenstar_position_front');
$smarty->assign('statistics_tile', 'statistics_position_front');
$smarty->assign('who_is_it_tile', 'whoisit_position_front');

//Send all smarty variables to the templates
$smarty->display("file:".$mainsite_template_folder."frontpage.html");

//close the connection
mysqli_close($mysqli)
?>

