<?php
/***************************************************************************
*                                interviews_help.php
*                            --------------------------
*   begin                : Sunday, July 31 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : created this page
*
*   Id: interviews_help.php,v 0.10 2005/07/31 18:01 Gatekeeper
*   Id: interviews_help.php,v 0.20 2016/08/03 23:03 Gatekeeper
*			- AL 2.0
*
***************************************************************************/

//****************************************************************************************
// This is the interview help page. 
//**************************************************************************************** 

include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php"); 

$smarty->assign("user_id",$_SESSION['user_id']);

$smarty->assign('quick_search_games', 'quick_search_games_interviews_help');
$smarty->assign('left_nav', 'leftnav_position_interviews_help');	

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."interviews_help.html");

//close the connection
mysqli_close($mysqli);
