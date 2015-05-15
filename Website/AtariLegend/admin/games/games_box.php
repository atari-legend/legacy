<?php
/***************************************************************************
*                                games_box.php
*                            --------------------------
*   begin                : Tuesday, November 15, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*						   Created file
*						
*   Id: games_box.php,v 0.10 2005/11/19 Silver
*
***************************************************************************/

//load all common functions
include("../includes/common.php"); 
/*
************************************************************************************************
This is the game box main page
************************************************************************************************
*/

		$sql_game = mysql_query("SELECT * FROM game WHERE game_id='$game_id'")
				   or die ("Database error - getting game name");
       	$game_name=mysql_fetch_array($sql_game);
		
		$smarty->assign('game_info',
	    array('game_id' => $game_name['game_id'],
			  'game_name' => $game_name['game_name']));
		
		if ($mode == "back") 
		{
		$smarty->assign('mode',
	    array('mode' => $mode,
			  'frontscan_id' => $frontscan_id));
		}
		else
		{
		$mode = "front";
		$frontscan_id = "";
		
		$smarty->assign('mode',
		array('mode' => $mode,
			  'frontscan_id' => $frontscan_id));
		}

		
	 	$IMAGE = mysql_query("SELECT * FROM game_boxscan WHERE game_id='$game_id' ORDER BY game_boxscan_side, game_boxscan_id")
				 or die ("Database error - selecting gamebox scan");
		
		$imagenum_rows = mysql_num_rows($IMAGE);
		
		// if no boxscans are attached
		$smarty->assign('numberscans', $imagenum_rows);
		
	   	if ($imagenum_rows>0) 
	   	{
			$front = 0;
			$back = 0;
			
			while ($rowimage=mysql_fetch_array ($IMAGE)) 
			{	// First check if front cover
				if ($rowimage['game_boxscan_side'] == 0)
				{
					$front++;
					
					// Get the image dimensions for the pop up window
					$imginfo = getimagesize("$game_boxscan_path$rowimage[game_boxscan_id].jpg");
					$width = $imginfo[0]+20;
					$height = $imginfo[1]+25;		
					
					$smarty->append('frontscan',
	    						array('game_boxscan_id' => $rowimage['game_boxscan_id'],
			  						  'height' => $height,
									  'width' => $width));
				} 
				// Else back covers
				else
				{
					$back++;
					
					$couple = mysql_query("SELECT game_boxscan_id FROM game_box_couples WHERE game_boxscan_cross=$rowimage[game_boxscan_id]")
				 			  or die ("Database error - selecting gamebox scan");
					$couplerow = mysql_fetch_row($couple);
					$boxscan_cross_id = $couplerow[0];
					
							
					// Get the image dimensions for the pop up window
					$imginfo = getimagesize("$game_boxscan_path$rowimage[game_boxscan_id].jpg");
					$width = $imginfo[0]+20;
					$height = $imginfo[1]+25;
							
			       	
					$smarty->append('backscan',
	    						array('game_boxscan_id' => $rowimage['game_boxscan_id'],
			  						  'height' => $height,
									  'width' => $width,
									  'boxscan_cross_id' => $boxscan_cross_id));
				}
		 	}
		} 

		
	$smarty->assign('nr_front', $front);
	$smarty->assign('nr_back', $back);
	
	$smarty->assign('games_box_tpl', '1');

	//Send all smarty variables to the templates
	$smarty->display('file:../templates/0/index.tpl');

	//close the connection
	mysql_close();
?>
