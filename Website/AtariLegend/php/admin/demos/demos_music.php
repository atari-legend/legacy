<?php
/***************************************************************************
*                                demos_music.php
*                            --------------------------
*   begin                : saturday, November 19, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*						   Created file
*						
*   Id: demos_music.php,v 0.10 2005/11/19 ST Graveyard
*
***************************************************************************/

//load all common functions
include("../../includes/common.php"); 
include("../../includes/admin.php"); 

/*
************************************************************************************************
This is the demo music main page
************************************************************************************************
*/
//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."demos_music.html");

//close the connection
mysqli_close($mysqli);
?>
