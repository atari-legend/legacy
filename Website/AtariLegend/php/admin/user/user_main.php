<?php
/***************************************************************************
*                                user_main.php
*                            -----------------------
*   begin                : Saturday, May 01, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: user_main.php,v 0.10 2005/05/01 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
User main
***********************************************************************************
*/
// Include common variables and functions
include("../includes/common.php");

//get all the user accounts
$query__number = $mysqli->query("SELECT count(*) FROM users") or die ("Couldn't get the total number of users");
$v_rows = $query__number->num_rows;
$smarty->assign('nr_users', $v_rows);

				// Create dropdown values a-z
				$az_value = az_dropdown_value(0);
				$az_output = az_dropdown_output(0);
						   
				$smarty->assign('az_value', $az_value);
				$smarty->assign('az_output', $az_output);	

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/user_main.html');
?>
