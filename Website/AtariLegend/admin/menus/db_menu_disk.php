<?php
/***************************************************************************
*                                db_menu_disk.php
*                            -----------------------
*   begin                : june 06, 2015
*   copyright            : (C) 2005 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : re-creation of code from scratch into new file.
*
***************************************************************************/

// We are using the action var to separate all the queries.

include("../includes/common.php"); 

//****************************************************************************************
// Add new menu set
//**************************************************************************************** 

if($action=="menu_set_new")
{
if(isset($menu_sets_name)) 
{
	$sql = $mysqli->query("INSERT INTO menu_set (menu_sets_name) VALUES ('$menu_sets_name')");  
	mysqli_free_result($sql); 
}

header("Location: ../menus/menus_list.php");

}

//****************************************************************************************
// Add new menu disk
//**************************************************************************************** 

if($action=="add_new_menu_disk")
{
	if ($menu_disk_number!=='' or $menu_disk_letter!=='')
	{	
		//first we start with if this is numbered menu disk
		if($menu_disk_number!=='' and $menu_disk_letter=='')
			{
				$sql = $mysqli->query("INSERT INTO menu_disk (menu_sets_id,menu_disk_number) VALUES ('$menu_sets_id','$menu_disk_number')");
				$last_id = $mysqli->insert_id;
				if($menu_disk_part!=='') 
					{
					$sql = $mysqli->query("UPDATE menu_disk SET menu_disk_part='$menu_disk_part' 
					    WHERE menu_disk_id='$last_id'");
					}
				if($menu_disk_version!=='') 
					{
					$sql = $mysqli->query("UPDATE menu_disk SET menu_disk_version='$menu_disk_version' 
					    WHERE menu_disk_id='$last_id'");
					}
			
			}
		//Ok, but if it is not a numbered disk but instead it is one of those horrible alphabetic disks
		if($menu_disk_number=='' and $menu_disk_letter!=='')
			{
				$sql = $mysqli->query("INSERT INTO menu_disk (menu_sets_id,menu_disk_letter) VALUES ('$menu_sets_id','$menu_disk_letter')");
				$last_id2 = $mysqli->insert_id;
				if($menu_disk_part!=='') 
					{
					$sql = $mysqli->query("UPDATE menu_disk SET menu_disk_part='$menu_disk_part' 
					    WHERE menu_disk_id='$last_id2'");
					}
				if($menu_disk_version!=='') 
					{
					$sql = $mysqli->query("UPDATE menu_disk SET menu_disk_version='$menu_disk_version' 
					    WHERE menu_disk_id='$last_id2'");
					}
			
			}		
	}

header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");

}

//****************************************************************************************
// Edit menu_set name
//**************************************************************************************** 

if($action=="menu_set_name_update")
{
if(isset($menu_sets_id) and $menu_sets_name!=="") 
{
	$sql = $mysqli->query("UPDATE menu_set SET menu_sets_name='$menu_sets_name' 
					    WHERE menu_sets_id='$menu_sets_id'");  
	mysqli_free_result($sql); 
}
header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
}


//****************************************************************************************
// Connect crew to menu set
//**************************************************************************************** 

if($action=="menu_set_crew_set")
{
if(isset($crew_id) and isset($menu_sets_id)) 
{
	$sql = $mysqli->query("INSERT INTO crew_menu_prod (crew_id,menu_sets_id) VALUES ('$crew_id','$menu_sets_id')");  
	mysqli_free_result($sql); 
}

header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");

}

//****************************************************************************************
// Quick add new crew
//**************************************************************************************** 

if($action=="menu_set_crew_add")
{
if(isset($new_crew_name) and isset($menu_sets_id)) 
{
	$sql = $mysqli->query("INSERT INTO crew (crew_name) VALUES ('$new_crew_name')");  
	mysqli_free_result($sql); 
}

header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");

}
//****************************************************************************************
// This is delete crew from menu series
//**************************************************************************************** 
if($action=="delete_crew_from_menu_set")
{
if(isset($crew_id) and isset($menu_sets_id)) 
{
		$mysqli->query("DELETE FROM crew_menu_prod WHERE crew_id='$crew_id' AND menu_sets_id='$menu_sets_id'"); 
}

header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");

}

//****************************************************************************************
// Add game to menu disk AJAX DB job
//**************************************************************************************** 

if(isset($action) and $action=="add_title_to_menu")
{
if(isset($software_id) and isset($menu_disk_id)) 
{		
	if (isset($software_type) and $software_type=="Game")
	{
		//Insert new title in menu_disk_title table
		$mysqli->query("INSERT INTO menu_disk_title (menu_disk_id,menu_types_main_id) VALUES ('$menu_disk_id','1')"); 
		$last_id = $mysqli->insert_id; // Get Last autoinc id
		// Specify title in menu_disk_title_game table
		$mysqli->query("INSERT INTO menu_disk_title_game (menu_disk_title_id,game_id) VALUES ('$last_id','$software_id')"); 
	}
	if (isset($software_type) and $software_type=="Demo")
	{
		$mysqli->query("INSERT INTO menu_disk_title (menu_disk_id,menu_types_main_id) VALUES ('$menu_disk_id','2')"); 	
		$last_id = $mysqli->insert_id; // Get Last autoinc id
		// Specify title in menu_disk_title_game table
		$mysqli->query("INSERT INTO menu_disk_title_demo (menu_disk_title_id,demo_id) VALUES ('$last_id','$software_id')"); 			
	}
	if (isset($software_type) and $software_type=="Tool")
	{
		$mysqli->query("INSERT INTO menu_disk_title (menu_disk_id,menu_types_main_id) VALUES ('$menu_disk_id','3')"); 	
		$last_id = $mysqli->insert_id; // Get Last autoinc id
		// Specify title in menu_disk_title_game table
		$mysqli->query("INSERT INTO menu_disk_title_tools (menu_disk_title_id,tools_id) VALUES ('$last_id','$software_id')"); 			
	}	
	
		
		// ok, insert done. Now this is a ajax job so we need a return value.
		//
			//list of games for the menu disk
				$sql_games = "SELECT game.game_id,
								game.game_name,
								pub_dev.pub_dev_id,
								pub_dev.pub_dev_name,
								game_year.game_year,
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_game ON (menu_disk_title.menu_disk_title_id = menu_disk_title_game.menu_disk_title_id)
								LEFT JOIN game ON (menu_disk_title_game.game_id = game.game_id)
								LEFT JOIN game_developer ON (game.game_id = game_developer.game_id)
								LEFT JOIN pub_dev ON (game_developer.dev_pub_id = pub_dev.pub_dev_id)
								LEFT JOIN game_year ON (game.game_id = game_year.game_id)
								LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
								WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' GROUP BY game.game_name ORDER BY game.game_name ASC";
				
				$result_games = $mysqli->query($sql_games);
				
				while  ($query_game = $result_games->fetch_array(MYSQLI_BOTH)) 
				{ 		// This smarty is used for creating the list of games
						$smarty->append('game',
	    				array('game_id' => $query_game['game_id'],
						  	  'game_name' => $query_game['game_name'],
						  	  'developer_id' => $query_game['pub_dev_id'],
						  	  'developer_name' => $query_game['pub_dev_name'],
						  	  'game_year' => $query_game['game_year'],
						  	  'menu_disk_title_id' => $query_game['menu_disk_title_id'],
						  	  'menu_types_text' => $query_game['menu_types_text']));
				}
				

				
				$smarty->assign('smarty_action', 'add_game_to_menu_return');
				$smarty->assign('menu_disk_id', $menu_disk_id);
	
	//Send to smarty for return value
	$smarty->display('file:../templates/0/ajax_menus_detail.html');
	
}

}

//****************************************************************************************
// DELETE TITLE FROM MENU DISK
//**************************************************************************************** 

if(isset($action) and $action=="delete_from_menu_disk")
{

	$mysqli->query("DELETE FROM menu_disk_title_various WHERE menu_disk_title_id='$menu_disk_title_id'"); 
	$mysqli->query("DELETE FROM menu_disk_title_tools WHERE menu_disk_title_id='$menu_disk_title_id'");
	$mysqli->query("DELETE FROM menu_disk_title_music WHERE menu_disk_title_id='$menu_disk_title_id'");
	$mysqli->query("DELETE FROM menu_disk_title_game WHERE menu_disk_title_id='$menu_disk_title_id'");
	$mysqli->query("DELETE FROM menu_disk_title_doc_tools WHERE menu_disk_title_id='$menu_disk_title_id'");
	$mysqli->query("DELETE FROM menu_disk_title_doc_games WHERE menu_disk_title_id='$menu_disk_title_id'");
	$mysqli->query("DELETE FROM menu_disk_title_demo WHERE menu_disk_title_id='$menu_disk_title_id'");
	$mysqli->query("DELETE FROM menu_disk_title WHERE menu_disk_title_id='$menu_disk_title_id'");


		// ok, delete done. Now this is a ajax job so we need a return value.
		//
			//list of games for the menu disk
				$sql_games = "SELECT game.game_id,
								game.game_name,
								pub_dev.pub_dev_id,
								pub_dev.pub_dev_name,
								game_year.game_year,
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_game ON (menu_disk_title.menu_disk_title_id = menu_disk_title_game.menu_disk_title_id)
								LEFT JOIN game ON (menu_disk_title_game.game_id = game.game_id)
								LEFT JOIN game_developer ON (game.game_id = game_developer.game_id)
								LEFT JOIN pub_dev ON (game_developer.dev_pub_id = pub_dev.pub_dev_id)
								LEFT JOIN game_year ON (game.game_id = game_year.game_id)
								LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
								WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' GROUP BY game.game_name ORDER BY game.game_name ASC";
				
				$result_games = $mysqli->query($sql_games);
				
				while  ($query_game = $result_games->fetch_array(MYSQLI_BOTH)) 
				{ 		// This smarty is used for creating the list of games
						$smarty->append('game',
	    				array('game_id' => $query_game['game_id'],
						  	  'game_name' => $query_game['game_name'],
						  	  'developer_id' => $query_game['pub_dev_id'],
						  	  'developer_name' => $query_game['pub_dev_name'],
						  	  'game_year' => $query_game['game_year'],
						  	  'menu_disk_title_id' => $query_game['menu_disk_title_id'],
						  	  'menu_types_text' => $query_game['menu_types_text']));
				}
				

				
				$smarty->assign('smarty_action', 'add_game_to_menu_return');
				$smarty->assign('menu_disk_id', $menu_disk_id);
	
	//Send to smarty for return value
	$smarty->display('file:../templates/0/ajax_menus_detail.html');












}



//****************************************************************************************
// delete serie
//**************************************************************************************** 

if($action=="delete_gameseries")
{
if(isset($game_series_id)) 
{
	$mysqli->query("DELETE FROM game_series WHERE game_series_id='$game_series_id'"); 
	$mysqli->query("DELETE FROM game_series_cross WHERE game_series_id='$game_series_id'"); 
	mysqli_free_result(); 
}

header("Location: ../games/games_series_main.php");

}


