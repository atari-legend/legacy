<?php
/***************************************************************************
*                                did_you_know_tile.php
*                            ----------------------------
*   begin                : Tuesday, April 14, 2015
*   copyright            : (C) 2015 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id:   did_you_know_tile.php,v 0.1 2015/04/14 23:02 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php code for the 'did you know' tile
//*********************************************************************************************

//Lets get some did you know texts
$query_trivia_text = mysql_query("SELECT trivia_text FROM trivia ORDER BY RAND() LIMIT 1"); 
$sql_trivia_text = mysql_fetch_array($query_trivia_text);

$smarty->assign('trivia_text', $sql_trivia_text['trivia_text']);
?>