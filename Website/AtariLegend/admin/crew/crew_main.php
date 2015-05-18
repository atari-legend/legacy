<?php
/***************************************************************************
*                                crew_main.php
*                            --------------------------
*   begin                : Sunday, August 28, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: crew_main.php,v 0.10 2005/10/29 Silver
*
***************************************************************************/

/*
***********************************************************************************
This is the crew page contructor
***********************************************************************************
*/

//load all common functions
include("../includes/common.php"); 


if (isset($new_crew)) 
{
	$smarty->assign('new_crew', $new_crew);
}

if (isset($message)) 
{
	$smarty->assign('message', $message);
}


		$smarty->assign('crew_main_tpl', '1');

		//Send all smarty variables to the templates
		$smarty->display('file:../templates/0/index.html');

//close the connection
mysqli_close($mysqli);
?>
