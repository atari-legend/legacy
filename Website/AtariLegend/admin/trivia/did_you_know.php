<?
/***************************************************************************
*                                did_you_know.php
*                            -----------------------
*   begin                : Saturday, May 01, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: did_you_know.php,v 0.10 2005/05/01 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
Manage our Did you know? quotes!
***********************************************************************************
*/

include("../includes/common.php");

		$sql_trivia =  mysql_query("SELECT * FROM trivia ORDER BY trivia_id");
		
		while (list($trivia_id,$trivia_text) = mysql_fetch_row($sql_trivia))
		
		{
				$trivia_text = nl2br($trivia_text);
				$trivia_text = stripslashes($trivia_text);
		
					$smarty->append('trivia',
	    			array('trivia_id' => $trivia_id,
						  'trivia_text' => $trivia_text));
		} 
		
 
$smarty->assign('did_you_know_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
?>