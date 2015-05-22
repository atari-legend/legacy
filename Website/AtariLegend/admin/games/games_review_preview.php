<?php
/***************************************************************************
*                               games_review_preview.php
*                            -------------------------------
*   begin                : Saturday, December 03, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: games_review_preview.php,v 0.10 2005/12/03 17:40 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// Load a review of a certain game!
//********************************************************************************************* 

//load all common functions
include("../includes/common.php"); 
include("../includes/config.php"); 

$sql_review = $mysqli->query("SELECT * FROM game
						   LEFT JOIN review_game ON (game.game_id = review_game.game_id)
						   LEFT JOIN review_main ON (review_game.review_id = review_main.review_id)
						   LEFT JOIN review_score ON (review_main.review_id = review_score.review_id)
						   LEFT JOIN users ON (review_main.member_id = users.user_id)
						   WHERE game.game_id = '$game_id' AND review_game.review_id = '$review_id' 
						   AND review_main.review_edit = '0'") 
			  or die("Error - Couldn't query review data");
						   
$query_review = $sql_review->fetch_array(MYSQLI_BOTH);

	$review_date = convert_timestamp($query_review['review_date']);
	
	$review_text = $query_review['review_text'];
	$review_text = nl2br($review_text);
	$review_text = review_screenshot($review_text);
	$review_text = InsertALCode($review_text);
	$review_text = InsertSmillies($review_text);
	
	$smarty->assign('review',
	 array('user_name' => $query_review['userid'],
	 	   'email' => $query_review['email'],
	 	   'game_id' => $query_review['game_id'],
		   'date' => $review_date,
		   'game_name' => $query_review['game_name'],
		   'text' => $review_text));

	$smarty->assign('score',
	 array('graphics' => $query_review['review_graphics'],
		   'sound' => $query_review['review_sound'],
		   'gameplay' => $query_review['review_gameplay'],
		   'overall' => $query_review['review_overall']));

//Get the screenshots and the comments of this review
$query_screenshots = $mysqli->query("SELECT * FROM review_main 
								LEFT JOIN screenshot_review ON (review_main.review_id = screenshot_review.review_id)
								LEFT JOIN screenshot_main ON (screenshot_review.screenshot_id = screenshot_main.screenshot_id)
								LEFT JOIN review_comments ON (screenshot_review.screenshot_review_id = review_comments.screenshot_review_id)
								WHERE review_main.review_id = '$review_id' AND review_main.review_edit = '0'");

while ($sql_screenshots = $query_screenshots->fetch_array(MYSQLI_BOTH))
{
	$new_path = $game_screenshot_path;
	$new_path .= $sql_screenshots['screenshot_id'];
	$new_path .= ".";
	$new_path .= $sql_screenshots['imgext'];
		
	
	$smarty->append('screenshots',
	    		  array('screenshot' => $new_path,
			 		    'comment' => $sql_screenshots['comment_text'])); 
}

$smarty->assign('game_id', $game_id);

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/games_review_preview.html');

//close the connection
mysqli_close($mysqli);
?>
