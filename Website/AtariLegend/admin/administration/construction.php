<?
/***************************************************************************
*                               construction.php
*                            --------------------------
*   begin                : friday, July 21, 2005
*   copyright            : (C) 2004 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: construction.php,v 0.10 2005/07/21 17:51 ST Graveyard
*
***************************************************************************/

//load all common functions
include("../includes/common.php"); 
include("../includes/config.php"); 


$message = 'This is page is under construction - Patience is a virtue!';
$section = 'Under construction';

$smarty->assign('error_msg',
	    array('message' => $message,
		      'section' => $section ));

$smarty->assign('error_message_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.html');

//close the connection
mysql_close();
?>
