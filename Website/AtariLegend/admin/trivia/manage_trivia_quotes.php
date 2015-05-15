<?php
/***************************************************************************
*                                manage_trivia_quotes.php
*                            -----------------------
*   begin                : Saturday, May 01, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: manage_trivia_quotes.php,v 1.10 2005/08/12 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
Manage our trivia quotes!
***********************************************************************************
*/

include("../includes/common.php");

		$sql_trivia = $mysqli->query("SELECT * FROM trivia_quotes ORDER BY trivia_quote_id");

		while ($query_trivia = $sql_trivia->fetch_array(MYSQLI_BOTH))  		
		{
		
					$smarty->append('trivia',
	    			array('trivia_quote_id' => $query_trivia['trivia_quote_id'],
						  'trivia_quote' => $query_trivia['trivia_quote']));
		} 
		
 
$smarty->assign('manage_trivia_quotes_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
?>
