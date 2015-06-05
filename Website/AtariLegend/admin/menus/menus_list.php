<?php
/***************************************************************************
*                                menus_list.php
*                            --------------------------
*   begin                : June 05, 2015
*   copyright            : (C) 2015 Atari Legend
*   email                : admin@atarilegend.com
*						   Created file
*						
*
***************************************************************************/

//load all common functions
include("../includes/common.php"); 

/*
************************************************************************************************
This is the menus search list page
************************************************************************************************
*/
$start1=gettimeofday();
list($start2, $start3) = explode(":", exec('date +%N:%S'));
				
		//In all cases we search we start searching through the menu_set table
		//first
		$sql_menus = "SELECT * FROM menu_set ORDER BY menu_sets_name ASC";
		
		$result_menus= $mysqli->query($sql_menus);
		
			$rows = $result_menus->num_rows;
			if ( $rows > 0 )
			{ $i = 0;
				while ( $row=$result_menus->fetch_array(MYSQLI_BOTH) ) 
				{  
					$i++;
				
					//check how many muzaks there are for the game
					$numbermenus = $mysqli->query("SELECT count(*) as count FROM menu_disk WHERE menu_sets_id='$row[menu_sets_id]'")
				    			  or die ("couldn't get number of zaks");
				
					$array = $numbermenus->fetch_array(MYSQLI_BOTH);
				
					$smarty->append('menus',
	   			 	 array('menu_sets_id' => $row['menu_sets_id'],
						   'menu_sets_name' => $row['menu_sets_name'],
						   'numbermenus' => $array['count']));	
				}	
				
				$end1=gettimeofday();
				$totaltime1 = (float)($end1['sec'] - $start1['sec']) + ((float)($end1['usec'] - $start1['usec'])/1000000);

				$smarty->assign('querytime', $totaltime1);
				$smarty->assign('nr_of_entries', $i);
				
				$smarty->assign("user_id",$_SESSION['user_id']);

				//Send all smarty variables to the templates
				$smarty->display('file:../templates/0/menus_list.html');

				//close the connection
				mysqli_free_result($numbermenus);	
		}
?>
