<?php
/***************************************************************************
*                                crew_main.php
*                            --------------------------
*   begin                : Sunday, August 28, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: crew_main.php,v 0.10 2005/10/29 Silver
*
***************************************************************************/

/*
***********************************************************************************
This is the crew page contructor
***********************************************************************************
*/

//load all common functions
include("../../includes/common.php");
include("../../includes/admin.php");


if (isset($new_crew)) 
{
	$smarty->assign('new_crew', $new_crew);
}

if (isset($message)) 
{
	$smarty->assign('message', $message);
}
	
	//
		$sql_crew = $mysqli->query("SELECT * FROM crew WHERE crew_name REGEXP '^[0-9].*' 
						ORDER BY crew_name ASC")
			    	   or die ("Couldn't query Crew database");
		
		while  ($crew=$sql_crew->fetch_array(MYSQLI_BOTH)) 
		{  
			$smarty->append('crew',
	    		 array('crew_id' => $crew['crew_id'],
				 	   'crew_name' => $crew['crew_name']));
		}




				// Create dropdown values a-z
				$az_value = az_dropdown_value(0);
				$az_output = az_dropdown_output(0);
						   
				$smarty->assign('az_value', $az_value);
				$smarty->assign('az_output', $az_output);

		//Send all smarty variables to the templates
		$smarty->display('file:../../../templates/html/admin/crew_main.html');

//close the connection
mysqli_close($mysqli);
?>
