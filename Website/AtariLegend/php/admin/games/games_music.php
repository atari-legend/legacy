<?php
/***************************************************************************
*                                games_music.php
*                            --------------------------
*   begin                : Tuesday, November 15, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*						   Created file
*						
*   Id: games_music.php,v 0.10 2005/11/15 ST Graveyard
* 		v 0.2 clean up 2015-12-26 Mattias
*
***************************************************************************/

//load all common functions
include("../../includes/common.php");
include("../../includes/admin.php");

/*
************************************************************************************************
This is the game music main page
************************************************************************************************
*/

	$smarty->assign("user_id",$_SESSION['user_id']);

	//Send all smarty variables to the templates
	$smarty->display('file:../../../templates/html/admin/games_music.html');

	//close the connection
	mysqli_close($mysqli);

?>
