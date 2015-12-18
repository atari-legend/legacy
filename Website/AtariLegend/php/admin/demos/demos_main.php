<?php
/***************************************************************************
*                                demos_main.php
*                            --------------------------
*   begin                : Sunday, October 30, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: demos_main.php,v 0.10 2005/10/30 12.30 Gatekeeper
*
***************************************************************************/

/*
***********************************************************************************
This is the demo browse page where you can navigate your way through the demo db
***********************************************************************************
*/

//load all common functions
include("../../includes/common.php"); 

$start1=gettimeofday();
list($start2, $start3) = explode(":", exec('date +%N:%S'));


		//let's get all the crews in the DB
		$sql_crew = $mysqli->query("SELECT * FROM crew ORDER BY crew_name ASC")
				     or die ("Couldn't query crew database");
		
		while  ($crew=$sql_crew->fetch_array(MYSQLI_BOTH)) 
		{  
			$smarty->append('crew',
	   			 	 array('crew_id' => $crew['crew_id'],
						   'crew_name' => $crew['crew_name']));
		}
		
		//get the number of demos in the archive
		$query_number = $mysqli->query("SELECT * FROM demo") or die("Couldn't get the number of demos");
		$v_rows = $query_number->num_rows;

		$smarty->assign('demos_nr', $v_rows); 
		
		$smarty->assign("user_id",$_SESSION['user_id']);
		
				// Create dropdown values a-z
				$az_value = az_dropdown_value(0);
				$az_output = az_dropdown_output(0);
						   
				$smarty->assign('az_value', $az_value);
				$smarty->assign('az_output', $az_output);	
		

		//Send all smarty variables to the templates
		$smarty->display('file:../../../templates/html/admin/demos_main.html');
//close the connection
mysqli_close($mysqli);
?>
