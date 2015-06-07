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
include("../includes/config.php");
include("../includes/config_smarty.php");
include("../includes/constants.php");
	
	// Crew browse function			
	if (isset($action) and $action=="crew_browse")
	{
				
				// Do a simple gamesearch... no aka's or the likes of that.
				
					if (isset($query) and $query== "num")
					{
						$crewbrowse_select = " WHERE crew_name REGEXP '^[0-9].*'";
					}
					else
					{
					$crewbrowse_select = " WHERE crew_name LIKE '$query%'";
					}
				
				 $sql_build = "SELECT * FROM crew ";

				$sql_build .= $crewbrowse_select;
				$sql_build .= " ORDER BY crew_name ASC";
				
				$query = $mysqli->query($sql_build)
				 		   		 	or die ("Couldn't query crew Database ($sql_build)");
				
				$smarty->assign('smarty_action', 'crew_list');

				while  ($query_crew = $query->fetch_array(MYSQLI_BOTH)) 
				{ 		// This smarty is used for creating the list of crews
						$smarty->append('crew',
	    				array('crew_id' => $query_crew['crew_id'],
						  	  'crew_name' => $query_crew['crew_name']));
				}



	}

	// Add new menu disk box			
	if (isset($action) and $action=="add_new_disk_box")
	{
				$smarty->assign('smarty_action', 'add_new_disk_box');
				$smarty->assign('menu_sets_id', $menu_sets_id);
	}

	// Edit box for a menu disk!			
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
						menu_disk.state
						FROM menu_disk 
						LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
						LEFT JOIN crew_menu_prod ON (menu_set.menu_sets_id = crew_menu_prod.menu_sets_id)
						LEFT JOIN crew ON (crew_menu_prod.crew_id = crew.crew_id)
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
						   'state' => $row['state']));
		
		
				$smarty->assign('smarty_action', 'edit_disk_box');
				$smarty->assign('menu_disk_id', $menu_disk_id);
	}

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/ajax_menus.html');
?>
