<?php
/***************************************************************************
*                            magazine_review_score.php
*                            -----------------------
*   begin                : Saturday, May 01, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: magazine_review_score.php,v 1.10 2005/09/11 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
In this section of the site we can add game review score from magazines!
***********************************************************************************
*/

include("../includes/common.php");
		
		// Get all the issues
		$sql = $mysqli->query("SELECT * FROM magazine_issue
							LEFT JOIN magazine ON (magazine.magazine_id = magazine_issue.magazine_id)
							ORDER BY magazine_name, magazine_issue_nr ASC") or die ("Error retriving magazines issues");
		
		while ($fetch = $sql->fetch_array(MYSQLI_BOTH)) 
		{
		// put in smarty array
		$smarty->append('issues',
	   			  array('magazine_name' => $fetch['magazine_name'],
					    'magazine_issue_id' => $fetch['magazine_issue_id'],
						'magazine_issue_nr' => $fetch['magazine_issue_nr']));
		}
		
		// get reviews for game
		$sql_game = $mysqli->query("SELECT * FROM magazine_game
						 LEFT JOIN game ON (magazine_game.game_id = game.game_id)
						 LEFT JOIN magazine_issue ON (magazine_game.magazine_issue_id = magazine_issue.magazine_issue_id)
						 LEFT JOIN magazine ON (magazine_issue.magazine_id = magazine.magazine_id)
						 WHERE magazine_game.game_id='$game_id'");
			 // put the reviewscores in an array
			 while ($fetch_game = $sql_game->fetch_array(MYSQLI_BOTH)) 
			 	{
							
					// Create smarty array
					$smarty->append('game_score',
	   			  array('game_name' => $fetch_game['game_name'],
					    'magazine_name' => $fetch_game['magazine_name'],
						'magazine_issue_nr' => $fetch_game['magazine_issue_nr'],
						'score' => $fetch_game['score'],
						'magazine_game_id' => $fetch_game['magazine_game_id']));
					
					
				}

				// Create smarty array with game id
					$smarty->assign('game',
	   			 			  array('game_id' => $game_id));

	
						
$smarty->assign('magazine_review_score_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
?>
