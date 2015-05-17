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
include("../includes/common.php"); 

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
		$query_number = $mysqli->query("SELECT count(*) FROM demo") or die("Couldn't get the number of demos");
		$v_rows = mysql_result($query_number,0,0) or die("Couldn't get the number of demos");

		$smarty->assign('demos_nr', $v_rows); 
		
		$smarty->assign("user_id",$_SESSION['user_id']);
		$smarty->assign('demos_main_tpl', '1');

		//Send all smarty variables to the templates
		$smarty->display('file:../templates/0/index.tpl');
//close the connection
mysql_close();
?>
