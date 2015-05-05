<?
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

		$sql_trivia =  mysql_query("SELECT * FROM trivia_quotes ORDER BY trivia_quote_id");
		
		while (list($trivia_quote_id,$trivia_quote) = mysql_fetch_row($sql_trivia))
		
		{
		
					$smarty->append('trivia',
	    			array('trivia_quote_id' => $trivia_quote_id,
						  'trivia_quote' => $trivia_quote));
		} 
		
 
$smarty->assign('manage_trivia_quotes_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
?>