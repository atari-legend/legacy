<?php
/***************************************************************************
*                                index.php
*                            -----------------------
*   begin                : Sunday, Aug 31, 2003
*   copyright            : (C) 2003 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : added delete screenshot comment case, 
*						   review preview case
*
*   Id: index.php,v 0.20 2003/08/29 14:56 Gatekeeper
*
***************************************************************************/

//****************************************************************************************
// This index file is called throughout the whole of the application. It's a dynamic screen
// build up file, which prevents us from using the same template file, with little tweaks, 
// over and over!
//**************************************************************************************** 

//The only thing that changes when we load a page is the middle part of the screen.
//The header, navigation bar and disclaimer always stays the same. So we are always going 
//to call this action file, which receives a var, to check for which action is asked!
//setcookie("last_visit_time",time(),time()+7776000);

//Includes
include("../includes/common.php"); 

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/updates.html');
?>
