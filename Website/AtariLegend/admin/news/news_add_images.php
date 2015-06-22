<?php
/***************************************************************************
*                                news_add_images.php
*                            ---------------------------
*   begin                : Sunday, May 1, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : File creation
*							 
*							
*
*   Id: news_add_images.php,v 0.10 2004/05/01 ST Graveyard
*
***************************************************************************/

/*
***********************************************************************************
In this section we can add or delete a newsimage
***********************************************************************************
*/

include("../includes/common.php");

$smarty->assign("user_id",$_SESSION['user_id']);
//Send all smarty variables to the templates
$smarty->display('file:../templates/0/news_add_images.html');

//close the connection
mysqli_close($mysqli);
?>
