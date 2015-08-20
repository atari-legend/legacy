<?php
/***************************************************************************
*                                trivia_tile.php
*                            ----------------------------
*   begin                : Tuesday, April 14, 2015
*   copyright            : (C) 2015 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id:  trivia_tile.php,v 0.1 2015/04/14 23:00 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php code for the trivia tile with boxart
//********************************************************************************************* 

//Lets get some trivia quotes
$query_trivia_quote = $mysqli->query("SELECT trivia_quote FROM trivia_quotes ORDER BY RAND() LIMIT 1"); 
$sql_trivia_quote = $query_trivia_quote->fetch_array(MYSQLI_BOTH);

$smarty->assign('trivia_quote', $sql_trivia_quote['trivia_quote']);
?>
