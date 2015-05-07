<?
/***************************************************************************
*                                crew_search.php
*                            --------------------------
*   begin                : Sunday, August 28, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: crew_search.php,v 0.10 2005/10/29 Silver
*
***************************************************************************/

/*
***********************************************************************************
This is the crew page contructor
***********************************************************************************
*/

//load all common functions
include("../includes/common.php"); 

if(empty($action)) {$action = "";}

/*if (isset($new_crew)) 
{
	$smarty->assign('new_crew', $new_crew);
}*/

if ($crewsearch !='' and $crewbrowse == '')
{
		$sql_crew = mysql_query("SELECT * FROM crew
									WHERE crew_name LIKE '%$crewsearch%' 
									ORDER BY crew_name ASC")
			    	   or die ("Couldn't query Crew database");
		
		while  ($crew=mysql_fetch_array($sql_crew)) 
		{  
			$smarty->append('crew',
	    		 array('crew_id' => $crew['crew_id'],
				 	   'crew_name' => $crew['crew_name']));
		}
}

elseif ($crewbrowse !='' and $crewsearch == '')
{
			$sql_crew = mysql_query("SELECT * FROM crew
									WHERE crew_name LIKE '$crewbrowse%' 
									ORDER BY crew_name ASC")
			    	   or die ("Couldn't query Crew database");
		
		while  ($crew=mysql_fetch_array($sql_crew)) 
		{  
			$smarty->append('crew',
	    		 array('crew_id' => $crew['crew_id'],
				 	   'crew_name' => $crew['crew_name']));
		}
}

elseif ($crewsearch == '' and $crewbrowse == '')
{

$message="eh... come on! Stop fumbling and search for something!!";
header("Location: ../crew/crew_main.php?message=$message");

}

if ($crew_select !='')
{
// Do query for crew data
$sql_crew = mysql_query("SELECT * FROM crew
						WHERE crew_id = '$crew_select'")
			    	   or die ("Couldn't query Crew database");
					   
			$crew=mysql_fetch_array($sql_crew);		   
				
			$crew_history=stripslashes($crew['crew_history']);		   
					   
$smarty->assign('crew_select',
	    		 array('crew_id' => $crew_select,
				 	   'crew_name' => $crew['crew_name'],
					   'crew_logo' => $crew['crew_logo'],
					   'crew_history' => $crew_history));

}

// set values for main edit of crew... change name etc
if ($action=="main" or $action=="genealogy")
{

$smarty->assign('crew_action',
	    		 array('action' => $action));

}

// set values for genealogy edit of crew...
if (isset($action) and $action=="genealogy")
{
	
	$smarty->assign('crew_action',
	    		 array('action' => $action));
	
	$sql_crewgene = mysql_query("SELECT * FROM crew
						ORDER BY crew_name")
			    	   or die ("Couldn't query Crew database");
					   
			while  ($genealogy=mysql_fetch_array($sql_crewgene)) 
			{  
				$smarty->append('crew_gene',
	    				  array('crew_id' => $genealogy['crew_id'],
					 	 	    'crew_name' => $genealogy['crew_name']));
								
			}
			

			$sql_individuals = "SELECT ind_id,ind_name FROM individuals ORDER BY ind_name ASC";
			$sql_aka = "SELECT ind_id,nick FROM individual_nicks ORDER BY nick ASC";
			
			//Create a temporary table to build an array with both names and nicknames
			mysql_query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_individuals") or die("failed to create temporary table");
			mysql_query("INSERT INTO temp $sql_aka") or die("failed to insert akas into temporary table");
			
			$query_temporary = mysql_query("SELECT * FROM temp ORDER BY ind_name ASC") or die("Failed to query temporary table");
			mysql_query("DROP TABLE temp");
			
			/*$sql_individualgene = mysql_query("SELECT * FROM individuals ORDER BY ind_name")
			    	   or die ("Couldn't query Individual database");*/
			
			$names = "newCat();";
			$names2 = "<br>";
			$last = "a";
					   
			while  ($genealogy_ind=mysql_fetch_array($query_temporary)) 
			{  
			/*	$smarty->append('ind_gene',
	    				  array('ind_id' => $genealogy_ind['ind_id'],
					 	 	    'ind_name' => $genealogy_ind['ind_name']));
			*/					
			$string_name = $genealogy_ind['ind_name'];
			$string_name = strtolower($string_name);
			
			// alfabetic array to loop through
			$alfabetic_array =   array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
				
			
				
				
				for($i = 0; $i < count($alfabetic_array); $i++)
				{
		
					//if ($string_name{0} == $alfabetic_array[$i])
					if (isset($string_name[0]) and $string_name[0] == $alfabetic_array[$i])
					{
					
					if ($last != $alfabetic_array[$i]) { $names .= "newCat();";}
					
					$names .= "O(\"$genealogy_ind[ind_name]\",\"../crew/db_crew.php?action=add_member&crew_select=$crew_select&crewsearch=$crewsearch&crewbrowse=$crewbrowse&ind_id=$genealogy_ind[ind_id]\");";
		
					
					$last = $alfabetic_array[$i];
					}
				
				}
				if (isset($string_name[0]) and $string_name[0] == 'a')
				{
				$smarty->append('ind_gene',
	    				  array('ind_id' => "../crew/db_crew.php?action=add_member&crew_select=$crew_select&crewsearch=$crewsearch&crewbrowse=$crewbrowse&ind_id=$genealogy_ind[ind_id]",
					 	 	    'ind_name' => $genealogy_ind['ind_name']));
				}
				
			}			
			
			// member of crew - subcrew query
			$sql_subcrew = mysql_query("SELECT * FROM sub_crew
										LEFT JOIN crew ON (sub_crew.crew_id = crew.crew_id)
										WHERE sub_crew.parent_id='$crew_select'
										ORDER BY crew.crew_name")
			    	   or die ("Couldn't query Crew database");
					   
			while  ($fetch_subcrew=mysql_fetch_array($sql_subcrew)) 
			{  
				$smarty->append('subcrew',
	    				  array('sub_crew_id' => $fetch_subcrew['sub_crew_id'],
						  		'crew_id' => $fetch_subcrew['crew_id'],
					 	 	    'crew_name' => $fetch_subcrew['crew_name']));
								
			}

	
			$crew_individuals = array();
			// member of crew - individuals query
			$sql_crewind = mysql_query("SELECT * FROM crew_individual
										LEFT JOIN individuals ON (crew_individual.ind_id = individuals.ind_id)
										WHERE crew_individual.crew_id='$crew_select'
										ORDER BY individuals.ind_name")
			    	   or die ("Couldn't query ind database");
				$crew_individual = array();
				
			while  ($fetch_member=mysql_fetch_array($sql_crewind)) 
			{  
				//$crew_individual = array();
				$crew_individual['crew_individual_id'] = $fetch_member['crew_individual_id'];
				$crew_individual['ind_id'] = $fetch_member['ind_id'];
				$crew_individual['ind_name'] = $fetch_member['ind_name'];
				$crew_individual['individual_nicks_id'] = $fetch_member['individual_nicks_id'];
				
				$crew_individuals[] = $crew_individual;

			}
			$smarty->assign( 'crew_individuals', $crew_individuals); 
			

			//Build a list of known nicknames for the crew members
			$sql_ind_nicks = mysql_query("SELECT 
										  individual_nicks.individual_nicks_id,
										  individual_nicks.ind_id,
										  individual_nicks.nick 
										  FROM individual_nicks
										  LEFT JOIN crew_individual ON (individual_nicks.ind_id = crew_individual.ind_id)
										  WHERE crew_individual.crew_id = '$crew_select'") or die ("Couldn't retrieve nick names");	
				while  ($fetch_ind_nicks = mysql_fetch_array($sql_ind_nicks)) 
				{
				
				$smarty->append('nick_names',
	    				  array('individual_nicks_id' => $fetch_ind_nicks['individual_nicks_id'],
						  		'ind_id' => $fetch_ind_nicks['ind_id'],
					 	 	    'nick' => $fetch_ind_nicks['nick']));
				}			
			
		$smarty->assign('ind_array',
	    		 array('names' => $names));
}

// If no choice has been made but a crew has been selected we should be brought to the crew main edit regardless
if ($action=='')
{

$action = "main";

$smarty->assign('crew_action',
	    		 array('action' => $action));

}


// Search variables that got to be sent with the headers all through this module or else the code will dump the user back to the crew_main.php
$smarty->assign('tracking',
	    		 array('crewsearch' => $crewsearch,
				 	   'crewbrowse' => $crewbrowse));


		$smarty->assign('crew_search_tpl', '1');

		//Send all smarty variables to the templates
		$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();
?>
