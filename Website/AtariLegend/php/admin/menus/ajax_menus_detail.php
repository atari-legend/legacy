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
*   Id: ajax_menus.php,v 0.2 2016/08/31 STG 19:55
*			- Add logs
*
***************************************************************************/

/*
***********************************************************************************
Build game series page
***********************************************************************************
*/
include("../../includes/common.php");
include("../../includes/admin.php");
	
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
						individuals.ind_id,
						individuals.ind_name,
						menu_disk_state.state_id,
						menu_disk_state.menu_state,
						menu_disk_year.menu_disk_year_id,
						menu_disk_year.menu_year,
						menu_disk_submenu.parent_id
						FROM menu_disk 
						LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
						LEFT JOIN crew_menu_prod ON (menu_set.menu_sets_id = crew_menu_prod.menu_sets_id)
						LEFT JOIN crew ON (crew_menu_prod.crew_id = crew.crew_id)
						LEFT JOIN ind_menu_prod ON (menu_set.menu_sets_id = ind_menu_prod.menu_sets_id)
						LEFT JOIN individuals ON (ind_menu_prod.ind_id = individuals.ind_id)
						LEFT JOIN menu_disk_state ON ( menu_disk.state = menu_disk_state.state_id)
						LEFT JOIN menu_disk_year ON ( menu_disk.menu_disk_id = menu_disk_year.menu_disk_id)
						LEFT JOIN menu_disk_submenu ON ( menu_disk.menu_disk_id = menu_disk_submenu.menu_disk_id)
						WHERE menu_disk.menu_disk_id = '$menu_disk_id'";
				
				$result_menus= $mysqli->query($sql_menus);
				$row=$result_menus->fetch_array(MYSQLI_BOTH);

				$menu_disk_state = $row['state_id'];
				$menu_disk_year = $row['menu_disk_year_id'];
				$menu_disk_parent = $row['parent_id'];
				
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
						   'ind_id' => $row['ind_id'],
						   'ind_name' => $row['ind_name'],
						   'menu_year' => $row['menu_year'],
						   'menu_state' => $row['menu_state']));
				
				//list of games for the menu disk
				$sql_games = "SELECT game.game_name AS 'software_name',
								game.game_id AS 'software_id',
								pub_dev.pub_dev_name AS 'developer_name',
								pub_dev.pub_dev_id AS 'developer_id',
								game_year.game_year AS 'year',
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text,
								menu_disk_title_set.menu_disk_title_set_chain
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_set ON (menu_disk_title_set.menu_disk_title_id = menu_disk_title.menu_disk_title_id)
								LEFT JOIN menu_disk_title_game ON (menu_disk_title.menu_disk_title_id = menu_disk_title_game.menu_disk_title_id)
								LEFT JOIN game ON (menu_disk_title_game.game_id = game.game_id)
								LEFT JOIN game_developer ON (game.game_id = game_developer.game_id)
								LEFT JOIN pub_dev ON (game_developer.dev_pub_id = pub_dev.pub_dev_id)
								LEFT JOIN game_year ON (game.game_id = game_year.game_id)
								LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
								WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '1' ORDER BY game.game_name ASC";
				
				$sql_demos = "SELECT demo.demo_name AS 'software_name',
								demo.demo_id AS 'software_id',
								crew.crew_name AS 'developer_name',
								crew.crew_id AS 'developer_id',
								demo_year.demo_year AS 'year',
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text,
								menu_disk_title_set.menu_disk_title_set_chain
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_set ON (menu_disk_title_set.menu_disk_title_id = menu_disk_title.menu_disk_title_id)
								LEFT JOIN menu_disk_title_demo ON (menu_disk_title.menu_disk_title_id = menu_disk_title_demo.menu_disk_title_id)
								LEFT JOIN demo ON (menu_disk_title_demo.demo_id = demo.demo_id)
								LEFT JOIN demo_year ON (demo.demo_id = demo_year.demo_id)
								LEFT JOIN crew_demo_prod ON (demo.demo_id = crew_demo_prod.demo_id)
								LEFT JOIN crew ON (crew_demo_prod.crew_id = crew.crew_id)
								LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
								WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '2' ORDER BY demo.demo_name ASC";				
				
				$sql_tools = "SELECT tools.tools_name AS 'software_name',
								tools.tools_id AS 'software_id',
								'' AS developer_name,
								'' AS developer_id,
								'' AS year,
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text,
								menu_disk_title_set.menu_disk_title_set_chain
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_set ON (menu_disk_title_set.menu_disk_title_id = menu_disk_title.menu_disk_title_id)
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
							  'game_id' => $query['software_id'],
							  'set_chain' => $query['menu_disk_title_set_chain'],
						  	  'developer_name' => $query['developer_name'],
							  'developer_id' => $query['developer_id'],
						  	  'year' => $query['year'],
						  	  'menu_disk_title_id' => $query['menu_disk_title_id'],
						  	  'menu_types_text' => $query['menu_types_text']));
				}
				
				// Get the doc disks
				//list of games for the menu disk
				$sql_doc_games = "SELECT game.game_name AS 'software_name',
										 game.game_id AS 'software_id',
										 game_year.game_year AS 'year',
										 pub_dev.pub_dev_name AS 'developer_name',
										 pub_dev.pub_dev_id AS 'developer_id',
										 doc_disk_game.doc_id AS 'doc_id',
										 doc.doc_type_id,
										 menu_types_main.menu_types_text,
										 menu_disk_title.menu_disk_title_id AS 'menu_disk_title_id'
										 FROM menu_disk_title
										 LEFT JOIN menu_disk_title_doc_games ON (menu_disk_title.menu_disk_title_id = menu_disk_title_doc_games.menu_disk_title_id)
										 LEFT JOIN doc_disk_game ON (menu_disk_title_doc_games.doc_games_id = doc_disk_game.doc_disk_game_id)
										 LEFT JOIN doc ON (doc_disk_game.doc_id = doc.doc_id)
										 LEFT JOIN game ON (game.game_id = doc_disk_game.game_id)
										 LEFT JOIN game_developer ON (game.game_id = game_developer.game_id)
										 LEFT JOIN pub_dev ON (game_developer.dev_pub_id = pub_dev.pub_dev_id)
										 LEFT JOIN game_year ON (game.game_id = game_year.game_id)
										 LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
										 WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '6' ORDER BY game.game_name ASC";
										 
				$sql_doc_tools = "SELECT tools.tools_name AS 'software_name',
										 tools.tools_id AS 'software_id',
										 '' AS year,
										 '' AS developer_name,
										 '' AS developer_id,
										 doc_disk_tool.doc_id AS 'doc_id',
										 doc.doc_type_id,
										 menu_types_main.menu_types_text,
										 menu_disk_title.menu_disk_title_id AS 'menu_disk_title_id'
										 FROM menu_disk_title
										 LEFT JOIN menu_disk_title_doc_tools ON (menu_disk_title.menu_disk_title_id = menu_disk_title_doc_tools.menu_disk_title_id)
										 LEFT JOIN doc_disk_tool ON (menu_disk_title_doc_tools.doc_tools_id = doc_disk_tool.doc_disk_tool_id)
										 LEFT JOIN doc ON (doc_disk_tool.doc_id = doc.doc_id)
										 LEFT JOIN tools ON (tools.tools_id = doc_disk_tool.tools_id)
										 LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
										 WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '6' ORDER BY tools.tools_name ASC";
					 
				$temp_query2 = $mysqli->query("CREATE TEMPORARY TABLE temp2 ENGINE=MEMORY $sql_doc_games") or die(mysqli_error());
				$temp_query2 = $mysqli->query("INSERT INTO temp2 $sql_doc_tools") or die(mysqli_error());

				$temp_query2 = $mysqli->query("SELECT * FROM temp2 GROUP BY menu_disk_title_id ORDER BY software_name ASC") or die("does not compute4");

				while  ($query = $temp_query2->fetch_array(MYSQLI_BOTH)) 
				{
					// This smarty is used for creating the list of games
					$smarty->append('doc_game',
					array('game_name' => $query['software_name'],
						  'game_id' => $query['software_id'],
						  'year' => $query['year'],
						  'developer_name' => $query['developer_name'],
						  'developer_id' => $query['developer_id'],
						  'doc_id' => $query['doc_id'],
						  'doc_type_id' => $query['doc_type_id'],
						  'menu_types_text' => $query['menu_types_text'],
						  'menu_disk_title_id' => $query['menu_disk_title_id']));
				}
				
				//get the doc types
				$sql_doc_type = "SELECT * from doc_type";
				$query_doc_type = $mysqli->query($sql_doc_type) or die ("error in the doc_type query");	

				while  ($query_type = $query_doc_type->fetch_array(MYSQLI_BOTH)) 
				{
					$smarty->append('doc_type',
					array('doc_type_id' => $query_type['doc_type_id'],
						  'doc_type_name' => $query_type['doc_type_name']));
				}
				
				
				// Get the menudisk credits
				$sql_individuals = "SELECT 
									individuals.ind_id,
									individuals.ind_name,
									menu_disk_credits.menu_disk_credits_id,
									menu_disk_credits.individual_nicks_id,
									author_type.author_type_info
									FROM individuals 
									LEFT JOIN menu_disk_credits ON (individuals.ind_id = menu_disk_credits.ind_id)
									LEFT JOIN author_type ON (menu_disk_credits.author_type_id = author_type.author_type_id)
									WHERE menu_disk_credits.menu_disk_id = '$menu_disk_id'
									ORDER BY individuals.ind_name ASC";
				
				$query_individual = $mysqli->query($sql_individuals);
				
				$query_ind_id = "";
				
				while  ($query = $query_individual->fetch_array(MYSQLI_BOTH)) 
				{
					if ( $query_ind_id <> $query['ind_id'] )
					{					
						$sql_ind_nick = "SELECT 
										individual_nicks.individual_nicks_id,
										individual_nicks.nick
										FROM individuals 
										LEFT JOIN individual_nicks ON (individuals.ind_id = individual_nicks.ind_id)
										WHERE individuals.ind_id = '$query[ind_id]'";
						
						$query_ind_nick = $mysqli->query($sql_ind_nick) or die ("error in the nickname query");	

						while  ($query_nick = $query_ind_nick->fetch_array(MYSQLI_BOTH)) 
						{
							$smarty->append('ind_nick',
							array('ind_id' => $query['ind_id'],
								  'individual_nicks_id' => $query_nick['individual_nicks_id'],
								  'nick' => $query_nick['nick']));
						}
					}
										
					// This smarty is used for for the menu_disk credits
					$smarty->append('individuals',
					array('menu_disk_credits_id' => $query['menu_disk_credits_id'],
						  'ind_id' => $query['ind_id'],
						  'ind_name' => $query['ind_name'],
						  'menu_disk_id' => $menu_disk_id,
						  'individual_nicks_id' => $query['individual_nicks_id'],
						  'author_type_info' => $query['author_type_info']));
					
					$query_ind_id = $query['ind_id'];
				}
				
				// Menu state dropdown
				$query_menu_state = $mysqli->query("SELECT * FROM menu_disk_state ORDER BY state_id ASC");
				
				while  ($query = $query_menu_state->fetch_array(MYSQLI_BOTH)) 
				{
					// This smarty is used for for the menu_disk credits
					$smarty->append('state_id', $query['state_id']);
					$smarty->append('menu_state', $query['menu_state']);
				}
				
				// Parent dropdown
				$sql_parent = "SELECT menu_disk.menu_sets_id,
								menu_set.menu_sets_name,
								menu_disk.menu_disk_id,
								menu_disk.menu_disk_number,
								menu_disk.menu_disk_letter,
								menu_disk.menu_disk_version,
								menu_disk.menu_disk_part
								FROM menu_disk 
								LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)";
				
				$result_parent= $mysqli->query($sql_parent) or die ("problem with parent query");
				while ($row = $result_parent->fetch_array(MYSQLI_BOTH))
				{
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
					
					if(isset($row['menu_disk_version']) and $row['menu_disk_version']!=='') 
					{
						$menu_disk_name .= " v$row[menu_disk_version]";
					}
					
					$smarty->append('parent',
					array('parent_id' => $row['menu_disk_id'],
						  'parent_name' => $menu_disk_name));
						  
				}
				
				
				//Get the screenshots for this menu if they exist
				$sql_screenshots = $mysqli->query("SELECT * FROM screenshot_menu
									LEFT JOIN screenshot_main ON (screenshot_menu.screenshot_id = screenshot_main.screenshot_id)
									WHERE screenshot_menu.menu_disk_id = '$menu_disk_id' ORDER BY screenshot_menu.screenshot_id")
										or die ("Database error - selecting screenshots");

				$count = 1;
				$v_screenshots =0;
				while ( $screenshots=$sql_screenshots->fetch_array(MYSQLI_BOTH)) 
				{
					//Ready screenshots path and filename
					$screenshot_image  = $menu_screenshot_path;
					$screenshot_image .= $screenshots['screenshot_id'];
					$screenshot_image .= '.';
					$screenshot_image .= $screenshots['imgext'];
								
					$smarty->append('screenshots',
							 array('count' => $count,
								   'path' => $game_screenshot_path,
								   'screenshot_image' => $screenshot_image,
								   'id' => $screenshots['screenshot_id']));

					$count++;
					$v_screenshots++;
				}

				$smarty->assign("screenshots_nr",$v_screenshots);
				
				
				//************************************************************************************************
				//Let's get the menu info for the file name concatenation, and the download data for disks already
				//uploaded
				//************************************************************************************************
				//get the existing downloads
				$SQL_DOWNLOADS = $mysqli->query("SELECT * FROM menu_disk_download WHERE menu_disk_id='$menu_disk_id'")
								 or die ("Error getting download info");		

				$nr_downloads = 0;
				while ($downloads=$SQL_DOWNLOADS->fetch_array(MYSQLI_BOTH)) 
				{					
					$filepath = $menu_file_path;
									
					//start filling the smarty object
					$smarty->append('downloads',
							 array('menu_disk_download_id' => $downloads['menu_disk_download_id'],
								   'filename' => $downloads['menu_disk_download_id'],
								   'filepath' => $filepath));

					$nr_downloads++;
				}
				
				//In all cases we search we start searching through the menu_set table
				//first
				$sql_menus = "SELECT menu_disk.menu_sets_id,
								menu_set.menu_sets_name,
								menu_disk.menu_disk_number,
								menu_disk.menu_disk_letter,
								menu_disk.menu_disk_version,
								menu_disk.menu_disk_part
								FROM menu_disk 
								LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
								WHERE menu_disk.menu_disk_id = '$menu_disk_id'";
				
				$result_menus= $mysqli->query($sql_menus) or die ("error in query disk name");
				
				while ( $row=$result_menus->fetch_array(MYSQLI_BOTH) ) 
				{  
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
				}
				
				$smarty->assign('menu_disk_name',$menu_disk_name);			

				$smarty->assign('download_nr',$nr_downloads);			
											
				$smarty->assign('menu_state_id', $menu_disk_state);
				$smarty->assign('menu_year_id', $menu_disk_year);
				$smarty->assign('menu_parent_id', $menu_disk_parent);
				
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
						individuals.ind_id,
						individuals.ind_name,
						menu_disk_state.menu_state
						FROM menu_disk 
						LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
						LEFT JOIN crew_menu_prod ON (menu_set.menu_sets_id = crew_menu_prod.menu_sets_id)
						LEFT JOIN crew ON (crew_menu_prod.crew_id = crew.crew_id)
						LEFT JOIN ind_menu_prod ON (menu_set.menu_sets_id = ind_menu_prod.menu_sets_id)
						LEFT JOIN individuals ON (ind_menu_prod.ind_id = individuals.ind_id)
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
						   'ind_id' => $row['ind_id'],
						   'ind_name' => $row['ind_name'],
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
