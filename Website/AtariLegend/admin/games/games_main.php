<?php
/***************************************************************************
*                                games_main.php
*                            --------------------------
*   begin                : Sunday, August 28, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: games_main.php,v 0.10 2005/08/28 17:30 Gatekeeper
*
***************************************************************************/

/*
***********************************************************************************
This is the game browse page where you can navigate your way through the games db
***********************************************************************************
*/

//load all common functions
include("../includes/common.php"); 

date_default_timezone_set('UTC');
$start = microtime(true);

		//Get publisher values to fill the searchfield
		$sql_publisher = $mysqli->query("SELECT pub_dev.pub_dev_id,
											 pub_dev.pub_dev_name
											 FROM game_publisher
											 LEFT JOIN pub_dev ON (game_publisher.pub_dev_id = pub_dev.pub_dev_id)
											 GROUP BY pub_dev.pub_dev_id HAVING COUNT(DISTINCT pub_dev.pub_dev_id) = 1
											 ORDER BY pub_dev.pub_dev_name ASC") 
										or die("Problems retriving values from publishers.");
		
		while ($company_publisher = $sql_publisher->fetch_array(MYSQLI_BOTH))
		{
		
			$smarty->append('company_publisher',
	    		 array('comp_id' => $company_publisher['pub_dev_id'],
				 	   'comp_name' => $company_publisher['pub_dev_name']));
		
		}
		
		//Get Developer values to fill the searchfield
		$sql_developer = $mysqli->query("SELECT pub_dev.pub_dev_id,
											 pub_dev.pub_dev_name
											 FROM game_developer
											 LEFT JOIN pub_dev ON (game_developer.dev_pub_id = pub_dev.pub_dev_id)
											 GROUP BY pub_dev.pub_dev_id HAVING COUNT(DISTINCT pub_dev.pub_dev_id) = 1
											 ORDER BY pub_dev.pub_dev_name ASC") 
										or die("Problems retriving values from developers.");
		
		while ($company_developer = $sql_developer->fetch_array(MYSQLI_BOTH))
		{
		
			$smarty->append('company_developer',
	    		 array('comp_id' => $company_developer['pub_dev_id'],
				 	   'comp_name' => $company_developer['pub_dev_name']));
		
		}
		
		//get the number of games in the archive
		$query_number = $mysqli->query("SELECT * FROM game") or die("Couldn't get the number of games");
		$v_rows = get_rows($query_number) or die("Couldn't get the number of games");

		$smarty->assign('games_nr', $v_rows); 
		
				// Create dropdown values a-z
				$az_value = az_dropdown_value(0);
				$az_output = az_dropdown_output(0);
						   
				$smarty->assign('az_value', $az_value);
				$smarty->assign('az_output', $az_output);	

		$smarty->assign("user_id",$_SESSION['user_id']);

		//Send all smarty variables to the templates
		$smarty->display('file:../templates/0/games_main.html');

//close the connection
mysqli_close($mysqli);
?>
