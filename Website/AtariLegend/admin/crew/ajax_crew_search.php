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

if (isset($action) and $action=="crew_browse")
	{
		
			if($query =="num") {	
			
			$sql_crew = $mysqli->query("SELECT * FROM crew
						WHERE crew_name REGEXP '^[0-9].*' 
						ORDER BY crew_name ASC")
			    	   or die ("Couldn't query Crew database");
			}
			else 
			{
			
			$sql_crew = $mysqli->query("SELECT * FROM crew
						WHERE crew_name LIKE '$query%' 
						ORDER BY crew_name ASC")
			    	   or die ("Couldn't query Crew database");
			}
		
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
}

if (isset($action) and $action=="crew_gen_browse")
{
						if($query =="num") 
						{	
						$sql_crew = $mysqli->query("SELECT * FROM crew
						WHERE crew_name REGEXP '^[0-9].*' 
						ORDER BY crew_name ASC")
							or die ("Couldn't query Crew database");
						}
						else 
						{			
						$sql_crew = $mysqli->query("SELECT * FROM crew
						WHERE crew_name LIKE '$query%' 
						ORDER BY crew_name ASC")
						or die ("Couldn't query Crew database");
						}
		echo '<select name="sub_crew[]" id="subCrewList" size="10" multiple style="width:200px;">';
		while  ($crew=$sql_crew->fetch_array(MYSQLI_BOTH)) 
		{  
			$crew_id = $crew['crew_id'];
			$crew_name = $crew['crew_name'];
			
			echo "<option value=\"$crew_id\">$crew_name</option>";

		}
		echo '</select>';
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
			
			$query_temporary = $mysqli->query("SELECT * FROM temp WHERE ind_name LIKE '$query%' ORDER BY ind_name ASC") or die("Failed to query temporary table");
			$mysqli->query("DROP TABLE temp");
						
			}
		echo '<SELECT id="ind_id" name="ind_id" size="10" style="width:200px;">';
		while  ($genealogy_ind=$query_temporary->fetch_array(MYSQLI_BOTH)) 
			{  
				
			$ind_id = $genealogy_ind['ind_id'];
			$ind_name = $genealogy_ind['ind_name'];
			
			echo "<option value=\"$ind_id\">$ind_name</option>";

		}
		echo '</select>';
}

	/*	$smarty->assign('crew_main_tpl', '1');

		//Send all smarty variables to the templates
		$smarty->display('file:../templates/0/index.html');*/

//close the connection
mysqli_close($mysqli);
?>
