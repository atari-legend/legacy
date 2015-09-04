<?php
/***************************************************************************
*                                manage_trivia_quotes.php
*                            --------------------------------
*   begin                : Saturday, May 01, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: manage_trivia_quotes.php,v 1.10 2005/08/12 Silver Surfer
*   Id: manage_trivia_quotes.php,v 1.20 2015/09/04 ST Graveyard
*
***************************************************************************/

/*
***********************************************************************************
Manage our trivia quotes!
***********************************************************************************
*/

include("../../includes/common.php");

		$sql_trivia = $mysqli->query("SELECT * FROM trivia_quotes ORDER BY trivia_quote_id");

		while ($query_trivia = $sql_trivia->fetch_array(MYSQLI_BOTH))  		
		{
		
					$smarty->append('trivia',
	    			array('trivia_quote_id' => $query_trivia['trivia_quote_id'],
						  'trivia_quote' => $query_trivia['trivia_quote']));
		} 

$smarty->assign('left_nav', 'leftnav_position_triviaquotes');	
		
//Send all smarty variables to the templates
$smarty->display('extends:../../../templates/html/admin/main.html|../../../templates/html/admin/frontpage.html|../../../templates/html/admin/manage_trivia_quotes.html|../../../templates/html/admin/left_nav.html');

?>
