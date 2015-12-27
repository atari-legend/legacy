<?php
/***************************************************************************
*                                games_similar.php
*                            --------------------------
*   begin                : 2006 April
*   copyright            : (C) 2006 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: games_similar.php,v 0.10 2006-04-05 Silver
*
***************************************************************************/


//load all common functions
include("../../includes/common.php");
include("../../includes/admin.php");


//***********************************************************************************
//Let's get the general game info first. 
//***********************************************************************************

	$sql_game = $mysqli->query("SELECT * FROM game 
					       WHERE game_id='$game_id' ORDER BY game_name")
				    or die ("Error getting game info");

					
		$game_info=$sql_game->fetch_array(MYSQLI_BOTH);
		
			$smarty->assign('game_info',
	    		 array('game_name' => $game_info['game_name'],
				 	   'game_id' => $game_info['game_id']));
		

//***********************************************************************************
//Similar Games
//***********************************************************************************
		
		
	$sql_similar = $mysqli->query("SELECT * FROM game_similar 
							    LEFT JOIN game ON (game_similar.game_similar_cross = game.game_id)
								WHERE game_similar.game_id='$game_id'")
					or die ("Couldn't query similar games");
	$nr_similar = 0;
	while  ($similar=$sql_similar->fetch_array(MYSQLI_BOTH)) 
	{ 
		$smarty->append('similar',
	   		 	 array('game_similar_id' => $similar['game_similar_id'],
				 	   'game_name' => $similar['game_name'],
					   'game_id' => $similar['game_similar_cross']));
		$nr_similar++;
	}
	
	$smarty->assign("nr_similar",$nr_similar); 
	
	//get all the games for the similar dropdown
	$sql_game_similar = $mysqli->query("SELECT * FROM game order by game_name") or die ("Couldn't query all games"); 
	
	while  ($game_similar=$sql_game_similar->fetch_array(MYSQLI_BOTH)) 
	{ 
		$smarty->append('similar_games',
	   		 	 array('game_id' => $game_similar['game_id'],
				 	   'game_name' => $game_similar['game_name']));
	}



		$smarty->assign("user_id",$_SESSION['user_id']);

		//Send all smarty variables to the templates
		$smarty->display('file:../../../templates/html/admin/games_similar.html');

//close the connection
mysqli_close($mysqli);
?>
