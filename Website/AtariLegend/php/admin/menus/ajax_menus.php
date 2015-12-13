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

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/ajax_menus.html');
?>
