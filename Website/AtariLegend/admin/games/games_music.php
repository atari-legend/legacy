<?php
/***************************************************************************
*                                games_music.php
*                            --------------------------
*   begin                : Tuesday, November 15, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*						   Created file
*						
*   Id: games_music.php,v 0.10 2005/11/15 ST Graveyard
*
***************************************************************************/

//load all common functions
include("../includes/common.php"); 

/*
************************************************************************************************
This is the game music main page
************************************************************************************************
*/
$start1=gettimeofday();
list($start2, $start3) = explode(":", exec('date +%N:%S'));
				
if (isset($action) and $action == 'search')
{
	//check the $gamebrowse select
	if ($gamebrowse == "")
	{
		$gamebrowse_select = "";
	}
	elseif ($gamebrowse == '-')
	{
		$gamebrowse_select = "";
	}
	elseif ($gamebrowse == 'num')
	{
		$gamebrowse_select = "game.game_name REGEXP '^[0-9].*' AND ";
	}
	else
	{
		$gamebrowse_select = "game.game_name LIKE '$gamebrowse%' AND ";
	}
	
	//Before we start the build the query, we check if there is at least
	//one search field filled in or used! 
	
	if ( $gamebrowse_select == ""  and $gamesearch == "" )
	{
		$smarty->assign("message","Please fill in one of the search fields");
		
		$smarty->assign("user_id",$_SESSION['user_id']);
		$smarty->assign('games_music_tpl', '1');

		//Send all smarty variables to the templates
		$smarty->display('file:../templates/0/index.tpl');

		//close the connection
		mysql_close();
	}
	else
	{
		//In all cases we search we start searching through the game table
		//first
		$RESULTGAME = "SELECT 
							game.game_id, 
							game.game_name, 
							pub_dev.pub_dev_name, 
							pub_dev.pub_dev_id, 
							game_year.game_year
					   FROM game
					   LEFT JOIN game_publisher ON ( game.game_id = game_publisher.game_id ) 
					   LEFT JOIN pub_dev ON ( game_publisher.pub_dev_id = pub_dev.pub_dev_id ) 
					   LEFT JOIN game_year ON ( game_year.game_id = game.game_id ) WHERE ";
		
		$RESULTGAME .= $gamebrowse_select;
		$RESULTGAME .= "game.game_name LIKE '%$gamesearch%'"; 
		$RESULTGAME .= ' ORDER BY game.game_name ASC';
		
		$games = $mysqli->query($RESULTGAME);
		
		if (!$games)
		{
			echo "Couldn't query games database for games starting with a certain number";
		}
		else
		{
			$rows = $games->num_rows();
			if ( $rows > 0 )
			{ $i = 0;
				while ( $row=mysql_fetch_assoc($games) ) 
				{  
					$i++;
				
					//check how many muzaks there are for the game
					$numberzaks = $mysqli->query("SELECT count(*) as count FROM game_music WHERE game_id='$row[game_id]'")
				    			  or die ("couldn't get number of zaks");
				
					$array = $numberzaks->fetch_array(MYSQLI_BOTH);
				
					$smarty->append('music',
	   			 	 array('game_id' => $row['game_id'],
						   'game_name' => $row['game_name'],
						   'game_publisher' => $row['pub_dev_name'],
						   'game_year' => $row['game_year'],
						   'number_zaks' => $array['count']));	
				}	
				
				$end1=gettimeofday();
				$totaltime1 = (float)($end1['sec'] - $start1['sec']) + ((float)($end1['usec'] - $start1['usec'])/1000000);

				$smarty->assign('querytime', $totaltime1);
				$smarty->assign('nr_of_entries', $i);
				
				$smarty->assign("user_id",$_SESSION['user_id']);
				$smarty->assign('games_music_list_tpl', '1');
				
				//Send all smarty variables to the templates
				$smarty->display('file:../templates/0/index.tpl');

				//close the connection
				mysql_close();	
			}	
			else
			{
				$smarty->assign("message","No entries for your query!");
		
				$smarty->assign("user_id",$_SESSION['user_id']);
				$smarty->assign('games_music_tpl', '1');

				//Send all smarty variables to the templates
				$smarty->display('file:../templates/0/index.tpl');

				//close the connection
				mysql_close();
			}
		}
	}
}
else
{
	$smarty->assign("user_id",$_SESSION['user_id']);
	$smarty->assign('games_music_tpl', '1');

	//Send all smarty variables to the templates
	$smarty->display('file:../templates/0/index.tpl');

	//close the connection
	mysql_close();
}
?>
