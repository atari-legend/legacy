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
include("../includes/common.php"); 

if (isset($action) and $action=="crew_browse" and isset($query))

			$sql_crew = $mysqli->query("SELECT * FROM crew
						WHERE crew_name LIKE '$query%' 
						ORDER BY crew_name ASC")
			    	   or die ("Couldn't query Crew database");
		
		while  ($crew=$sql_crew->fetch_array(MYSQLI_BOTH)) 
		{  
			$crew_id = $crew['crew_id'];
			$crew_name = $crew['crew_name'];
			
			echo "
			<li class=\"leftnav_list\">
				<a href=\"../crew/crew_editor.php?crew_select=$crew_id&crewsearch=$crewsearch&crewbrowse=$crewbrowse\" class=\"LEFTNAV\">
				$crew_name
				</a>
			</li>";

		}




	/*	$smarty->assign('crew_main_tpl', '1');

		//Send all smarty variables to the templates
		$smarty->display('file:../templates/0/index.html');*/

//close the connection
mysqli_close($mysqli);
?>
