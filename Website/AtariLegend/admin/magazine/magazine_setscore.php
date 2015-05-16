<?php
/***************************************************************************
*                            magazine_setscore.php
*                            -----------------------
*   begin                : Saturday, May 01, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: magazine_setscore.php,v 1.10 2005/09/11 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
In this section of the site we can add game review score from magazines!
***********************************************************************************
*/

include("../includes/common.php");
		
		// Get issue info
		$sql = mysql_query("SELECT * FROM magazine_issue
							LEFT JOIN magazine ON (magazine.magazine_id = magazine_issue.magazine_id)
							WHERE magazine_issue.magazine_issue_id='$magazine_issue_id' 
							ORDER BY magazine_name, magazine_issue_nr ASC") or die ("Error retriving magazines issues");
	
		$fetch = mysql_fetch_array($sql);
	
	
		// get game info
		$fetchgame = mysql_fetch_array( mysql_query("SELECT * FROM game WHERE game_id='$game_id'"));
		
				// Create smarty array
					$smarty->assign('game',
	   			 			  array('game_id' => $game_id,
							        'game_name' => $fetchgame['game_name'],
									'magazine_name' => $fetch['magazine_name'],
									'magazine_issue_nr' => $fetch['magazine_issue_nr'],
									'magazine_issue_id' => $magazine_issue_id));


						
$smarty->assign('magazine_setscore_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
?>
