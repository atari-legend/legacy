<?
/***************************************************************************
*                                games_review.php
*                            --------------------------
*   begin                : Sunday, November 27, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*						   Created file
*						
*   Id: games_review.php,v 0.10 2005/11/27 ST Graveyard
*
***************************************************************************/

//load all common functions
include("../includes/common.php"); 

/*
************************************************************************************************
This is the game review main page
************************************************************************************************
*/
$start1=gettimeofday();
list($start2, $start3) = explode(":", exec('date +%N:%S'));

	//get the number of reviews in the archive
	$query_number = mysql_query("SELECT count(*) FROM review_main WHERE review_edit = '0'") or die("Couldn't get the number of reviews");
	$v_reviews = mysql_result($query_number,0,0) or die("Couldn't get the number of reviews");


		$RESULTGAME = "SELECT 
					game.game_id, 
					game.game_name, 
					pub_dev.pub_dev_name, 
					pub_dev.pub_dev_id, 
					game_year.game_year
					FROM game
					LEFT JOIN game_publisher ON ( game.game_id = game_publisher.game_id ) 
					LEFT JOIN pub_dev ON ( game_publisher.pub_dev_id = pub_dev.pub_dev_id ) 
					LEFT JOIN game_year ON ( game_year.game_id = game.game_id ) 
					LEFT JOIN review_game ON ( review_game.game_id = game.game_id )
					LEFT JOIN review_main ON ( review_main.review_id = review_game.review_id)
					WHERE review_game.game_id IS NOT NULL ORDER BY review_main.review_date DESC";

		
		$games = mysql_query($RESULTGAME);
		

			$rows = mysql_num_rows($games);
			if ( $rows > 0 )
			{	if (empty($i)) {$i = 0;}
				while ( $row=mysql_fetch_assoc($games) ) 
				{  
					$i++;
				
					//check how many reviews there are for the game
					$number_revs = mysql_query("SELECT count(*) as count FROM review_game WHERE game_id='$row[game_id]'")
				    			  or die ("couldn't get number of reviews");
				
					$array = mysql_fetch_array($number_revs);
				
					$smarty->append('review',
	   			 	 array('game_id' => $row['game_id'],
						   'game_name' => $row['game_name'],
						   'game_publisher' => $row['pub_dev_name'],
						   'game_year' => $row['game_year'],
						   'number_reviews' => $array['count']));	
				}
			}


	$smarty->assign('review_nr', $v_reviews);
								  
	$smarty->assign("user_id",$_SESSION['user_id']);
	$smarty->assign('games_review_html', '1');

	//Send all smarty variables to the templates
	$smarty->display('file:../templates/0/index.tpl');

	//close the connection
	mysql_close();
?>
