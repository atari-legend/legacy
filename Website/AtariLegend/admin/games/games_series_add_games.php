<?php
/***************************************************************************
*                             games_series_main.php
*                            -----------------------
*   begin                : Saturday, Sept 24, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : Creation from scratch for smarty usage
						   
*							
*
*   Id: games_series_main.php,v 0.2 2005/09/24 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
Build game series page
***********************************************************************************
*/

include("../includes/common.php");

	// SERIES LIST DROPDOWN
				
				$sql_series = $mysqli->query("SELECT * FROM game_series ORDER BY game_series_name ASC")
				 		    or die ("Couldn't query Game Series Database1");
		
				while  ($query_series = $sql_series->fetch_array(MYSQLI_BOTH)) 
				{  
				  $smarty->append('game_series',
	    			array('game_series_id' => $query_series['game_series_id'],
						  'game_series_name' => $query_series['game_series_name']));
				}
				

				// Get the information of the selected gameseries	
				$sql_series2 = $mysqli->query("SELECT * FROM game_series WHERE game_series_id='$game_series_id'")
									or die ("Couldn't query Game Series Database4");

								$query_series2 = $sql_series2->fetch_array(MYSQLI_BOTH);
				
				// Do a simple gamesearch... no aka's or the likes of that.
				
				 $sql_build = "SELECT game.game_id,
							   game.game_name,
							   game_publisher.pub_dev_id as 'publisher_id',
							   pd1.pub_dev_name as 'publisher_name',
							   game_developer.dev_pub_id as 'developer_id',
							   pd2.pub_dev_name as 'developer_name',
							   game_year.game_year AS 'year'";
				$sql_build .= "	FROM game ";
				$sql_build .= "	LEFT JOIN game_year on (game_year.game_id = game.game_id) ";
				$sql_build .= " LEFT JOIN game_publisher ON (game_publisher.game_id = game.game_id)"; 
				$sql_build .= " LEFT JOIN pub_dev pd1 ON (pd1.pub_dev_id = game_publisher.pub_dev_id)"; 
				$sql_build .= " LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)";
				$sql_build .= " LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)"; 

				$sql_build .= " WHERE game_name REGEXP '^[0-9].*'";
				$sql_build .= " GROUP BY game.game_name";

				$sql_series_link = $mysqli->query($sql_build)
				 		   		 	or die ("Couldn't query Game Series Database5 ($sql_build)");
				
				$smarty->assign('series_info',
	    			array('game_series_id' => $query_series2['game_series_id'],
						  'game_series_name' => $query_series2['game_series_name'],
						  'series_page' => $series_page));
				
				while  ($query_series_link = $sql_series_link->fetch_array(MYSQLI_BOTH)) 
				{ 		// This smarty is used for creating the list of games contained within a game series
						$smarty->append('series_link',
	    				array('game_id' => $query_series_link['game_id'],
						  	  'game_name' => $query_series_link['game_name'],
							  'publisher_id' => $query_series_link['publisher_id'],
							  'publisher_name' => $query_series_link['publisher_name'],
							  'developer_id' => $query_series_link['developer_id'],
							  'developer_name' => $query_series_link['developer_name'],
							  'year' => $query_series_link['year']));
				}
				
				// Create dropdown values a-z
				$az_value = az_dropdown_value(0);
				$az_output = az_dropdown_output(0);
						   
				$smarty->assign('az_value', $az_value);
				$smarty->assign('az_output', $az_output);
				$smarty->assign('mySelect', 'num');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/games_series_add_games.html');
?>
