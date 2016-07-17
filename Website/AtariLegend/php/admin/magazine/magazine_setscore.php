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

include("../../includes/common.php");
include("../../includes/admin.php");
include("../../includes/quick_search_games.php");
		
// Get issue info
$sql = $mysqli->query("SELECT * FROM magazine_issue
					LEFT JOIN magazine ON (magazine.magazine_id = magazine_issue.magazine_id)
					WHERE magazine_issue.magazine_issue_id='$magazine_issue_id' 
					ORDER BY magazine_name, magazine_issue_nr ASC") or die ("Error retriving magazines issues");

$fetch = $sql->fetch_array(MYSQLI_BOTH);


// get game info
$fetchgame =  $mysqli->query("SELECT * FROM game WHERE game_id='$game_id'")->fetch_array(MYSQLI_BOTH);

		// Create smarty array
			$smarty->assign('game',
					  array('game_id' => $game_id,
							'game_name' => $fetchgame['game_name'],
							'magazine_name' => $fetch['magazine_name'],
							'magazine_issue_nr' => $fetch['magazine_issue_nr'],
							'magazine_issue_id' => $magazine_issue_id));

$smarty->assign('quick_search_games', 'quick_search_magazine_set_score');
$smarty->assign('left_nav', 'leftnav_position_magazine_set_score');

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."magazine_setscore.html");
?>
