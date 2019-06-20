<?php
/***************************************************************************
*                                news_add_images.php
*                            ---------------------------
*   begin                : Sunday, May 1, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : File creation
*
*   Id: news_add_images.php,v 0.10 2004/05/01 ST Graveyard
*   Id: news_add_images.php,v 0.20 2016/07/29 ST Graveyard
*       -AL 2.0
*
***************************************************************************/

/*
***********************************************************************************
In this section we can add or delete a newsimage
***********************************************************************************
*/
include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."news/news_add_images.html");

//close the connection
mysqli_close($mysqli);
