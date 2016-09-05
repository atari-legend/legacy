<?php
/***************************************************************************
*                                menus_list.php
*                            --------------------------
*   begin                : June 05, 2015
*   copyright            : (C) 2015 Atari Legend
*   email                : admin@atarilegend.com
*						   Created file
* 	id : menus_list.php ,v 0.10 2016/08/26 ST Graveyard 23:22
*			- AL 2.0
*
***************************************************************************/

//load all common functions
include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php"); 

/*
************************************************************************************************
This is the menus search list page
************************************************************************************************
*/
$start1=gettimeofday();
list($start2, $start3) = explode(":", exec('date +%N:%S'));
				
		//In all cases we search we start searching through the menu_set table
		//first. We look for menus released by crews/individuals
		$sql_menus = "SELECT menu_set.menu_sets_id,
						menu_set.menu_sets_name,
						crew.crew_id,
						crew.crew_name,
						individuals.ind_id,
						individuals.ind_name,
						menu_types_main.menu_types_text	
						FROM menu_set 
						LEFT JOIN crew_menu_prod ON (menu_set.menu_sets_id = crew_menu_prod.menu_sets_id)
						LEFT JOIN crew ON (crew_menu_prod.crew_id = crew.crew_id)
						LEFT JOIN ind_menu_prod ON (menu_set.menu_sets_id = ind_menu_prod.menu_sets_id)
						LEFT JOIN individuals ON (ind_menu_prod.ind_id = individuals.ind_id)
						LEFT JOIN menu_type ON (menu_set.menu_sets_id = menu_type.menu_sets_id)
						LEFT JOIN menu_types_main ON (menu_type.menu_types_main_id = menu_types_main.menu_types_main_id)
						ORDER BY menu_sets_name ASC";
		
		$result_menus= $mysqli->query($sql_menus) or die ("error in query");
		
			$rows = $result_menus->num_rows;
			if ( $rows > 0 )
			{ $i = 0;
				while ( $row=$result_menus->fetch_array(MYSQLI_BOTH) ) 
				{  
					$i++;
				
					//check how many menus there are for the game
					$numbermenus = $mysqli->query("SELECT count(*) as count FROM menu_disk WHERE menu_sets_id='$row[menu_sets_id]'")
				    			  or die ("couldn't get number of zaks");
				
					$array = $numbermenus->fetch_array(MYSQLI_BOTH);
				
					$smarty->append('menus',
	   			 	 array('menu_sets_id' => $row['menu_sets_id'],
						   'menu_sets_name' => $row['menu_sets_name'],
						   'crew_id' => $row['crew_id'],
						   'crew_name' => $row['crew_name'],
						   'ind_id' => $row['ind_id'],
						   'ind_name' => $row['ind_name'],
						   'menu_type' => $row['menu_types_text'],
						   'numbermenus' => $array['count']));	
				}	
				
				$end1=gettimeofday();
				$totaltime1 = (float)($end1['sec'] - $start1['sec']) + ((float)($end1['usec'] - $start1['usec'])/1000000);

				$smarty->assign('querytime', $totaltime1);
				$smarty->assign('nr_of_entries', $i);
				
				$smarty->assign("user_id",$_SESSION['user_id']);

				//Send all smarty variables to the templates
				$smarty->display("file:".$cpanel_template_folder."menus_list.html");

				//close the connection
				mysqli_free_result($numbermenus);	
		}
?>
