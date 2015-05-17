<?php
/***************************************************************************
*                                games_review_add.php
*                            --------------------------
*   begin                : Sunday, November 27, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : created this page
*
*   Id: games_review_add.php,v 0.10 2005/11/27 Gatekeeper
*
***************************************************************************/

/*
***********************************************************************************
This is the game review page where you add a review to the db
***********************************************************************************
*/

//load all common functions
include("../includes/common.php"); 

if (isset($action) and $action  == 'add_review' )
{
	// first we have to convert the date vars into a time stamp to be inserted to review_date
	
	$date = date_to_timestamp($Date_Year,$Date_Month,$Date_Day);

	$sdbquery = $mysqli->query("INSERT INTO review_main (member_id, review_text, review_date) VALUES ($members, '$textfield', '$date')")
				or die("Couldn't insert into review_main");
	
	//get the id of the inserted review
	$REVIEW = $mysqli->query("SELECT review_id FROM review_main
	   					   ORDER BY review_id desc")
			  or die ("Database error - selecting reviews");
		
	$reviewrow = mysql_fetch_row($REVIEW);

	$reviewid = $reviewrow[0];
    
	//Then, we'll be filling up the game review table
	$sdbquery = $mysqli->query("INSERT INTO review_game (review_id, game_id) VALUES ($reviewid, $game_id)") 
				or die("Couldn't insert into review_game");
				
	//Fill the score table
	$sdbquery = $mysqli->query("INSERT INTO review_score (review_id, review_graphics, review_sound, review_gameplay, review_overall) VALUES ($reviewid, $graphics, $sound, $gameplay, $conclusion)")
				or die("Couldn't insert into review_score");
				
	//we're gonna add the screenhots into the screenshot_review table and fill up the review_comment table.
	//We need to loop on the screenshot table to check the shots used. If a comment field is filled,
	//the screenshot was used!
	$SCREEN = $mysqli->query("SELECT * FROM screenshot_game where game_id = '$game_id' ORDER BY screenshot_id ASC")
	    	  or die ("Database error - getting screenshots");
				
    	$i=0;
		
		while ( $screenrow=mysql_fetch_row($SCREEN) )
		{
			
			if($inputfield[$i] != "")
			{
				//fill the review_screenshot table 
				
				$screenid = $screenrow[2];
				$comment = $inputfield[$i];
								
				$sdbquery = $mysqli->query("INSERT INTO screenshot_review (review_id, screenshot_id) VALUES ('$reviewid', '$screenid')")
							or die("Couldn't insert into screenshot_review");
				
				$REVIEWSHOT = $mysqli->query("SELECT * FROM screenshot_review
	   				   		 			   ORDER BY screenshot_review_id desc")
		  					  or die ("Database error - selecting screenshots review");
			
				$reviewshotrow = mysql_fetch_row($REVIEWSHOT);
				
			 	$reviewshotid = $reviewshotrow[0];
			
				//fill the screenshot comment table
				$sdbquery = $mysqli->query("INSERT INTO review_comments (screenshot_review_id, comment_text) VALUES ('$reviewshotid', '$comment')")
							or die("Couldn't insert into review_comments");
			}
			$i++;
		}
		header("Location: ../games/games_review_add.php?game_id=$game_id");
}



?>
