<?php
/***************************************************************************
*                             ajax_menus.php
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
extract($_REQUEST);
include("../../includes/connect.php");
include("../../includes/config.php");
include("../../includes/config_smarty.php");
include("../../includes/constants.php");
include("../../includes/functions.php");
	
	// EDIT BOX FOR A MENU DISK!!!			
	if (isset($action) and $action=="edit_disk_box" and $menu_disk_id!=='')
	{
		
		$sql_menus = "SELECT menu_disk.menu_sets_id,
						menu_set.menu_sets_name,
						menu_disk.menu_disk_id,
						menu_disk.menu_disk_number,
						menu_disk.menu_disk_letter,
						menu_disk.menu_disk_version,
						menu_disk.menu_disk_part,
						crew.crew_id,
						crew.crew_name,
						menu_disk_state.state_id,
						menu_disk_state.menu_state
						FROM menu_disk 
						LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
						LEFT JOIN crew_menu_prod ON (menu_set.menu_sets_id = crew_menu_prod.menu_sets_id)
						LEFT JOIN crew ON (crew_menu_prod.crew_id = crew.crew_id)
						LEFT JOIN menu_disk_state ON ( menu_disk.state = menu_disk_state.state_id)
						WHERE menu_disk.menu_disk_id = '$menu_disk_id'";
				
				$result_menus= $mysqli->query($sql_menus);
				$row=$result_menus->fetch_array(MYSQLI_BOTH);

				$menu_disk_state = $row['state_id'];
				
				// Create Menu disk name
				$menu_disk_name = "$row[menu_sets_name] ";
				if(isset($row['menu_disk_number'])) {$menu_disk_name .= "$row[menu_disk_number]";}
				if(isset($row['menu_disk_letter'])) {$menu_disk_name .= "$row[menu_disk_letter]";}
				if(isset($row['menu_disk_part'])) 
					{
						if (is_numeric($row['menu_disk_part']))
							{$menu_disk_name .= " part $row[menu_disk_part]";}
							else 
							{
								$menu_disk_name .= "$row[menu_disk_part]";
							}
					}
				if(isset($row['menu_disk_version']) and $row['menu_disk_version']!=='') {$menu_disk_name .= " v$row[menu_disk_version]";}
					
					$smarty->assign('menus',
	   			 	 array('menu_sets_id' => $row['menu_sets_id'],
						   'menu_sets_name' => $row['menu_sets_name'],
						   'menu_disk_name' => $menu_disk_name,
						   'menu_disk_id' => $row['menu_disk_id'],
						   'menu_disk_number' => $row['menu_disk_number'],
						   'menu_disk_letter' => $row['menu_disk_letter'],
						   'menu_disk_version' => $row['menu_disk_version'],
						   'menu_disk_part' => $row['menu_disk_part'],
						   'crew_id' => $row['crew_id'],
						   'crew_name' => $row['crew_name'],
						   'menu_state' => $row['menu_state']));
				
				//list of games for the menu disk
				$sql_games = "SELECT game.game_name AS 'software_name',
								pub_dev.pub_dev_name AS 'developer_name',
								game_year.game_year AS 'year',
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_game ON (menu_disk_title.menu_disk_title_id = menu_disk_title_game.menu_disk_title_id)
								LEFT JOIN game ON (menu_disk_title_game.game_id = game.game_id)
								LEFT JOIN game_developer ON (game.game_id = game_developer.game_id)
								LEFT JOIN pub_dev ON (game_developer.dev_pub_id = pub_dev.pub_dev_id)
								LEFT JOIN game_year ON (game.game_id = game_year.game_id)
								LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
								WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '1' ORDER BY game.game_name ASC";
				
				$sql_demos = "SELECT demo.demo_name AS 'software_name',
								crew.crew_name AS 'developer_name',
								demo_year.demo_year AS 'year',
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_demo ON (menu_disk_title.menu_disk_title_id = menu_disk_title_demo.menu_disk_title_id)
								LEFT JOIN demo ON (menu_disk_title_demo.demo_id = demo.demo_id)
								LEFT JOIN demo_year ON (demo.demo_id = demo_year.demo_id)
								LEFT JOIN crew_demo_prod ON (demo.demo_id = crew_demo_prod.demo_id)
								LEFT JOIN crew ON (crew_demo_prod.crew_id = crew.crew_id)
								LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
								WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '2' ORDER BY demo.demo_name ASC";				
				
				$sql_tools = "SELECT tools.tools_name AS 'software_name',
								'' AS developer_name,
								'' AS year,
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_tools ON (menu_disk_title.menu_disk_title_id = menu_disk_title_tools.menu_disk_title_id)
								LEFT JOIN tools ON (menu_disk_title_tools.tools_id = tools.tools_id)
								LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
								WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '3' ORDER BY tools.tools_name ASC";
				
				$temp_query = $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_games") or die(mysqli_error());
				$temp_query = $mysqli->query("INSERT INTO temp $sql_demos") or die(mysqli_error());
				$temp_query = $mysqli->query("INSERT INTO temp $sql_tools") or die(mysqli_error());

				$temp_query = $mysqli->query("SELECT * FROM temp GROUP BY menu_disk_title_id ORDER BY software_name ASC") or die("does not compute3");

				
				while  ($query = $temp_query->fetch_array(MYSQLI_BOTH)) 
				{ 		
					
					// This smarty is used for creating the list of games
						$smarty->append('game',
	    				array('game_name' => $query['software_name'],
						  	  'developer_name' => $query['developer_name'],
						  	  'year' => $query['year'],
						  	  'menu_disk_title_id' => $query['menu_disk_title_id'],
						  	  'menu_types_text' => $query['menu_types_text']));
				}
				
				// Get the menudisk credits
				$sql_individuals = "SELECT 
									individuals.ind_id,
									individuals.ind_name,
									menu_disk_credits.menu_disk_credits_id,
									author_type.author_type_info
									FROM individuals 
									LEFT JOIN menu_disk_credits ON (individuals.ind_id = menu_disk_credits.ind_id)
									LEFT JOIN author_type ON (menu_disk_credits.author_type_id = author_type.author_type_id)
									WHERE menu_disk_credits.menu_disk_id = '$menu_disk_id'
									ORDER BY individuals.ind_name ASC";
				
				$query_individual = $mysqli->query($sql_individuals);
				
				while  ($query = $query_individual->fetch_array(MYSQLI_BOTH)) 
				{
						// This smarty is used for for the menu_disk credits
						$smarty->append('individuals',
	    				array('menu_disk_credits_id' => $query['menu_disk_credits_id'],
						  	  'ind_id' => $query['ind_id'],
						  	  'ind_name' => $query['ind_name'],
						  	  'menu_disk_id' => $menu_disk_id,
						  	  'author_type_info' => $query['author_type_info']));
				}
				
				// Menu state dropdown
				$query_menu_state = $mysqli->query("SELECT * FROM menu_disk_state ORDER BY state_id ASC");
				
				while  ($query = $query_menu_state->fetch_array(MYSQLI_BOTH)) 
				{
					// This smarty is used for for the menu_disk credits
					$smarty->append('state_id', $query['state_id']);
					$smarty->append('menu_state', $query['menu_state']);
				}
				 			
				$smarty->assign('menu_state_id', $menu_disk_state);
				
				$smarty->assign('smarty_action', 'edit_disk_box');
				$smarty->assign('menu_disk_id', $menu_disk_id);
	}

	// CLOSE EDIT BOX FOR A MENU DISK!			
	if (isset($action) and $action=="close_edit_disk_box" and $menu_disk_id!=='')
	{
		
		$sql_menus = "SELECT menu_disk.menu_sets_id,
						menu_set.menu_sets_name,
						menu_disk.menu_disk_id,
						menu_disk.menu_disk_number,
						menu_disk.menu_disk_letter,
						menu_disk.menu_disk_version,
						menu_disk.menu_disk_part,
						crew.crew_id,
						crew.crew_name,
						menu_disk_state.menu_state
						FROM menu_disk 
						LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
						LEFT JOIN crew_menu_prod ON (menu_set.menu_sets_id = crew_menu_prod.menu_sets_id)
						LEFT JOIN crew ON (crew_menu_prod.crew_id = crew.crew_id)
						LEFT JOIN menu_disk_state ON ( menu_disk.state = menu_disk_state.state_id)
						WHERE menu_disk.menu_disk_id = '$menu_disk_id'";
				
				$result_menus= $mysqli->query($sql_menus);
				$row=$result_menus->fetch_array(MYSQLI_BOTH);
				
				// Create Menu disk name
				$menu_disk_name = "$row[menu_sets_name] ";
				if(isset($row['menu_disk_number'])) {$menu_disk_name .= "$row[menu_disk_number]";}
				if(isset($row['menu_disk_letter'])) {$menu_disk_name .= "$row[menu_disk_letter]";}
				if(isset($row['menu_disk_part'])) 
					{
						if (is_numeric($row['menu_disk_part']))
							{$menu_disk_name .= " part $row[menu_disk_part]";}
							else 
							{
								$menu_disk_name .= "$row[menu_disk_part]";
							}
					}
				if(isset($row['menu_disk_version']) and $row['menu_disk_version']!=='') {$menu_disk_name .= " v$row[menu_disk_version]";}

					$smarty->assign('menus',
	   			 	 array('menu_sets_id' => $row['menu_sets_id'],
						   'menu_sets_name' => $row['menu_sets_name'],
						   'menu_disk_name' => $menu_disk_name,
						   'menu_disk_id' => $row['menu_disk_id'],
						   'menu_disk_number' => $row['menu_disk_number'],
						   'menu_disk_letter' => $row['menu_disk_letter'],
						   'menu_disk_version' => $row['menu_disk_version'],
						   'menu_disk_part' => $row['menu_disk_part'],
						   'crew_id' => $row['crew_id'],
						   'crew_name' => $row['crew_name'],
						   'menu_state' => $row['menu_state']));
		
		
				$smarty->assign('smarty_action', 'close_edit_disk_box');
				$smarty->assign('menu_disk_id', $menu_disk_id);
	}

	// POP ADD INTRO CREDITS
	if (isset($action) and $action=="add_intro_credit")
	{
	
				// Create individuals array
				$menu_disk_id = $query;
				
				$sql_individuals = "SELECT ind_id,ind_name FROM individuals ORDER BY ind_name ASC";
				$sql_aka = "SELECT ind_id,nick FROM individual_nicks ORDER BY nick ASC";
			
				//Create a temporary table to build an array with both names and nicknames
				$mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_individuals") or die("failed to create temporary table");
				$mysqli->query("INSERT INTO temp $sql_aka") or die("failed to insert akas into temporary table");
			
				$query_temporary = $mysqli->query("SELECT * FROM temp WHERE ind_name LIKE 'a%' ORDER BY ind_name ASC") or die("Failed to query temporary table");
				$mysqli->query("DROP TABLE temp");
			

				while  ($genealogy_ind=$query_temporary->fetch_array(MYSQLI_BOTH)) 
				{  
					$smarty->append('ind',
							array('ind_id' => $genealogy_ind['ind_id'],
									'ind_name' => $genealogy_ind['ind_name']));
				
				}
				
				// Get Author types for 
					
					$sql_author_types = "SELECT * FROM author_type ORDER BY author_type_info ASC";
					$query_author = $mysqli->query($sql_author_types) or die("Failed to query author_type table");
					
					while  ($author_ind=$query_author->fetch_array(MYSQLI_BOTH)) 
					{  
						$smarty->append('author_type',
								array('author_type_id' => $author_ind['author_type_id'],
									  'author_type_info' => $author_ind['author_type_info']));
					}

				// Create dropdown values a-z
				$az_value = az_dropdown_value(0);
				$az_output = az_dropdown_output(0);
						   
				$smarty->assign('az_value', $az_value);
				$smarty->assign('az_output', $az_output);
	
				$smarty->assign('smarty_action', 'add_intro_credit');
				$smarty->assign('menu_disk_id', $menu_disk_id);
	}
	
if (isset($action) and $action=="ind_gen_browse")
{
	if(isset($query)) 
		{	
			$sql_individuals = "SELECT ind_id,ind_name FROM individuals ORDER BY ind_name ASC";
			$sql_aka = "SELECT ind_id,nick FROM individual_nicks ORDER BY nick ASC";
			
			//Create a temporary table to build an array with both names and nicknames
			$mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_individuals") or die("failed to create temporary table");
			$mysqli->query("INSERT INTO temp $sql_aka") or die("failed to insert akas into temporary table");
			
			if($query=="num")
			{
			$query_temporary = $mysqli->query("SELECT * FROM temp WHERE ind_name REGEXP '^[0-9].*' ORDER BY ind_name ASC") or die("Failed to query temporary table");	
			}
			else
			{
			$query_temporary = $mysqli->query("SELECT * FROM temp WHERE ind_name LIKE '$query%' ORDER BY ind_name ASC") or die("Failed to query temporary table");
			}
			$mysqli->query("DROP TABLE temp");
						
			}
		while  ($genealogy_ind=$query_temporary->fetch_array(MYSQLI_BOTH)) 
			{  
			$smarty->append('author_type',
					array('ind_id' => $genealogy_ind['ind_id'],
						  'ind_name' => $genealogy_ind['ind_name']));
			}

			$smarty->assign('smarty_action', 'ind_gen_browse');
}

if (isset($action) and $action=="ind_gen_search")
{
	if(isset($query) and $query!=="empty") 
		{	
			$sql_individuals = "SELECT ind_id,ind_name FROM individuals ORDER BY ind_name ASC";
			$sql_aka = "SELECT ind_id,nick FROM individual_nicks ORDER BY nick ASC";
			
			//Create a temporary table to build an array with both names and nicknames
			$mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_individuals") or die("failed to create temporary table");
			$mysqli->query("INSERT INTO temp $sql_aka") or die("failed to insert akas into temporary table");
			
			$query_temporary = $mysqli->query("SELECT * FROM temp WHERE ind_name LIKE '%$query%' ORDER BY ind_name ASC") or die("Failed to query temporary table");
			$mysqli->query("DROP TABLE temp");
						
		}
		elseif ($query=="empty")
		{
			$sql_individuals = "SELECT ind_id,ind_name FROM individuals ORDER BY ind_name ASC";
			$sql_aka = "SELECT ind_id,nick FROM individual_nicks ORDER BY nick ASC";
			
			//Create a temporary table to build an array with both names and nicknames
			$mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_individuals") or die("failed to create temporary table");
			$mysqli->query("INSERT INTO temp $sql_aka") or die("failed to insert akas into temporary table");
			
			$query_temporary = $mysqli->query("SELECT * FROM temp WHERE ind_name LIKE '%a%' ORDER BY ind_name ASC") or die("Failed to query temporary table");
			$mysqli->query("DROP TABLE temp");
		}	
			
		while  ($genealogy_ind=$query_temporary->fetch_array(MYSQLI_BOTH)) 
			{  
			$smarty->append('author_type',
					array('ind_id' => $genealogy_ind['ind_id'],
						  'ind_name' => $genealogy_ind['ind_name']));
			}

			$smarty->assign('smarty_action', 'ind_gen_browse');
}

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."ajax_menus_detail.html");
?>
