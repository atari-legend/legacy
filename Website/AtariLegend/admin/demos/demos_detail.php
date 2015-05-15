<?php
/***************************************************************************
 *                                demos_detail.php
 *                            ------------------------
 *   begin                : Sunday, October 30, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *
 *   Id: demos_detail.php,v 0.10 2005/10/30 14:30 Zombieman
 *
 ***************************************************************************/

//****************************************************************************************
// This is the detail page of a demo. Change all the specifics over here!
//**************************************************************************************** 

//load all common functions
include("../includes/common.php"); 

//***********************************************************************************
//If delete aka link has been pressed
//***********************************************************************************
if ( isset($action) and $action == 'delete_aka' )
{
	$sql_aka = mysql_query("DELETE FROM demo_aka WHERE demo_aka_id = '$demo_aka_id' and demo_id = '$demo_id'") 
 			   or die ("Couldn't delete aka");
}

//***********************************************************************************
//If add aka button has been pressed
//***********************************************************************************
if ( isset($action) and $action == 'demo_aka' )
{
	$sql_aka = mysql_query("INSERT INTO demo_aka (demo_id, aka_name) VALUES ('$demo_id','$demo_aka')")
 			   or die ("Couldn't insert aka demos");
}

//***********************************************************************************
//If delete creator button has been pressed
//***********************************************************************************
if ( isset($action) and $action == 'delete_author' )
{
	if(isset($demo_author_id)) 
	{	
		foreach($demo_author_id as $author) 
		{
			mysql_query("DELETE FROM demo_author WHERE demo_author_id = '$author' and demo_id = '$demo_id'"); 
		}
	}
}

//***********************************************************************************
//If delete crew button has been pressed
//***********************************************************************************
if ( isset($action) and $action == 'delete_crew' )
{
	if(isset($demo_crew_id)) 
	{
		foreach($demo_crew_id as $crew) 
		{
			mysql_query("DELETE FROM crew_demo_prod WHERE crew_id = '$crew' and demo_id = '$demo_id'"); 
		}
	}
}

//***********************************************************************************
//If add crew button has been pressed
//***********************************************************************************
if ( isset($action) and $action == 'add_crew' )
{
	$sql = mysql_query("INSERT INTO crew_demo_prod (demo_id,crew_id) VALUES ('$demo_id','$crew_id_select')") or die ("crew insertion failed");  
}


//***********************************************************************************
//If the add creator button has been pressed
//***********************************************************************************
if ( isset($action) and $action == 'add_author' )
{
	$sql = mysql_query("INSERT INTO demo_author (demo_id,ind_id,author_type_id) VALUES ('$demo_id','$ind_id','$author_type_id')") or die ("individual insertion failed");  
}


//***********************************************************************************
//If the modify button has been pressed, update the necesarry tables 
//***********************************************************************************
	if ( isset($action) and $action == 'modify_demo' )
	{
		// demo_table
		$sdbquery  = mysql_query("UPDATE demo SET demo_name='$demo_name' WHERE demo_id=$demo_id") or die ("trouble updating demo"); 
		
		// demo year
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM demo_year WHERE demo_id='$demo_id'");	
		$sdbquery = mysql_query("INSERT INTO demo_year (demo_id,demo_year) VALUES ($demo_id,$Date_Year)");	
		
		// DUMP TABLE UPDATE
		$sdbquery = mysql_query("UPDATE demo_search SET year='$Date_Year' WHERE demo_id='$demo_id'") or die ("couldn't update dumptable - year");	

		// Delete the category crosses currently in the database for this game
		$sdbquery  = mysql_query("DELETE FROM demo_cat_cross WHERE demo_id=$demo_id");	

		// Insert the values from the passed category array
		if(isset($category)) 
		{
			foreach ($category as $cat) 
			{
				$sdbquery  = mysql_query("INSERT INTO demo_cat_cross (demo_id,demo_cat_id) VALUES ($demo_id,$cat)");	
			}
		}
		
		// Update the STE ONLY tick box info
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM demo_ste_only WHERE demo_id='$demo_id'");	
	
		// then insert the new value if it has been passed.
		if(isset($ste_only))
		{
			$sdbquery = mysql_query("INSERT INTO demo_ste_only (demo_id,ste_only) VALUES ('$demo_id','$ste_only')");
		} 

		// Update the STE ENHANCED tick box info
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM demo_ste_enhan WHERE demo_id='$demo_id'");	

		// then insert the new value if it has been passed.
		if(isset($ste_enhanced))
		{	
			$sdbquery = mysql_query("INSERT INTO demo_ste_enhan (demo_id,ste_enhanced) VALUES ('$demo_id','$ste_enhanced')");
		} 

		// Update the FALCON ONLY tick box info
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM demo_falcon_only WHERE demo_id='$demo_id'");	

		// then insert the new value if it has been passed.
		if(isset($falcon_only))
		{
			$sdbquery = mysql_query("INSERT INTO demo_falcon_only (demo_id,falcon_only) VALUES ('$demo_id','$falcon_only')");
		} 

		// Update the FALCON ENHANCED tick box info
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM demo_falcon_enhan WHERE demo_id='$demo_id'");	

		// then insert the new value if it has been passed.
		if(isset($falcon_enhanced))
		{
			$sdbquery = mysql_query("INSERT INTO demo_falcon_enhan (demo_id,falcon_enhanced) VALUES ('$demo_id','$falcon_enhanced')");
		} 
		
		// Update the MONO ONLY tick box info
		// Start off by deleting previos value
		$sdbquery = mysql_query("DELETE FROM demo_mono_only WHERE demo_id='$demo_id'");	

		// then insert the new value if it has been passed.
		if(isset($mono_only))
		{
			$sdbquery = mysql_query("INSERT INTO demo_mono_only (demo_id,mono_only) VALUES ('$demo_id','$mono_only')");
		} 

		$smarty->assign("message",'Demo has been modified correctly');
	}


//***********************************************************************************
//If the delete button has been pressed, delete the necesarry records from the tables
//***********************************************************************************
	if ( isset($action) and $action == 'delete_demo' )
	{
		//First we need to do a hell of a lot checks before we can delete an actual game.
		$sdbquery = mysql_query("SELECT * FROM demo_download WHERE demo_id='$demo_id'")
				 	or die ("Error getting download info");
		if ( mysql_num_rows($sdbquery) > 0 )
		{
			$smarty->assign("message",'Deletion failed - This demo has downloads - Delete it in the appropriate section');
		}
		else
		{
			$sdbquery = mysql_query("SELECT * FROM demo_user_comments WHERE demo_id='$demo_id'")
		 				or die ("Error getting user comments");
			if ( mysql_num_rows($sdbquery) > 0 )
			{
				$smarty->assign("message",'Deletion failed - This demo has user comments - Delete it in the appropriate section');
			}
			else
			{
				$sdbquery = mysql_query("SELECT * FROM demo_submitinfo WHERE demo_id='$demo_id'")
							or die ("Error getting submit info");
				if ( mysql_num_rows($sdbquery) > 0 )
				{
					$smarty->assign("message",'Deletion failed - This demo has info submitted from visitors - Delete it in the appropriate section');
				}
				else
				{
					$sdbquery = mysql_query("SELECT * FROM screenshot_demo WHERE demo_id='$demo_id'")
				 				or die ("Error getting screenshot info");
					if ( mysql_num_rows($sdbquery) > 0 )
					{
						$smarty->assign("message",'Deletion failed - This demo has screenshots - Delete it in the appropriate section');
					}
					else
					{
						$sdbquery = mysql_query("SELECT * FROM demo_music WHERE demo_id='$demo_id'")
				 					or die ("Error getting music info");
						if ( mysql_num_rows($sdbquery) > 0 )
						{
							$smarty->assign("message",'Deletion failed - This demo has music files attached - Delete it in the appropriate section');
						}
						else
						{
							$sdbquery = mysql_query("DELETE FROM demo WHERE demo_id = '$demo_id' ") or die ("Error deleting demo");
							$sdbquery = mysql_query("DELETE FROM crew_demo_prod WHERE demo_id = '$demo_id'") or die ("Error deleting crew_demo_prod");
							$sdbquery = mysql_query("DELETE FROM ind_demo_prod WHERE demo_id = '$demo_id' ") or die ("Error deleting ind_demo_prod");
							$sdbquery = mysql_query("DELETE FROM demo_year WHERE demo_id = '$demo_id' ") or die ("Error deleting demo_year");
							$sdbquery = mysql_query("DELETE FROM demo_cat_cross WHERE demo_id = '$demo_id' ") or die ("Error deleting demo_cat_cross");
							$sdbquery = mysql_query("DELETE FROM demo_falcon_only WHERE demo_id='$demo_id'") or die ("Error deleting demo_falcon_only");
							$sdbquery = mysql_query("DELETE FROM demo_ste_enhan WHERE demo_id='$demo_id'") or die ("Error deleting demo_ste_enhan");
							$sdbquery = mysql_query("DELETE FROM demo_ste_only WHERE demo_id='$demo_id'") or die ("Error deleting demo_ste_only");
							$sdbquery = mysql_query("DELETE FROM demo_aka WHERE demo_id='$demo_id'") or die ("Error deleting demo_aka");
							$sdbquery = mysql_query("DELETE FROM demo_info WHERE demo_id='$demo_id'") or die ("Error deleting demo_info");
							$sdbquery = mysql_query("DELETE FROM demo_emulator WHERE demo_id='$demo_id'") or die ("Error deleting demo_emulator");
							$sdbquery = mysql_query("DELETE FROM demo_author WHERE demo_id='$demo_id'") or die ("Error deleting demo_author");

							// DUMP TABLE
							$sdbquery = mysql_query("DELETE FROM demo_search WHERE game_id = '$demo_id' ");

							//Get the crews to fill the search fields
							$sql_crew = mysql_query("SELECT * FROM crew ORDER BY crew_name ASC")
		 		   	    				or die ("Couldn't query Crews database");
		
							while  ($crew=mysql_fetch_array($sql_crew)) 
							{  
								$smarty->append('crew',
				    				 array('crew_id' => $crew['crew_id'],
									 	   'crew_name' => $crew['crew_name']));
							}
							
							$smarty->assign("message",'Demo has been deleted succesfully');
							
							$smarty->assign("user_id",$_SESSION['user_id']);
							$smarty->assign('demos_main_tpl', '1');

							//Send all smarty variables to the templates
							$smarty->display('file:../templates/0/index.tpl');

							//close the connection
							mysql_close();

						}
					}
				}
			}
		}
	}

//***********************************************************************************
//Let's get the general demo info first. 
//***********************************************************************************

	$sql_demo = mysql_query("SELECT 
						   demo.demo_name, 
						   demo.demo_id, 
						   demo_ste_only.ste_only,
						   demo_ste_enhan.ste_enhanced,
						   demo_falcon_only.falcon_only,
						   demo_falcon_enhan.falcon_enhanced,
						   demo_mono_only.mono_only,
						   demo_year.demo_year
						   FROM demo 
					   	   LEFT JOIN demo_ste_only ON (demo.demo_id = demo_ste_only.demo_id)
						   LEFT JOIN demo_ste_enhan ON (demo.demo_id = demo_ste_enhan.demo_id)
						   LEFT JOIN demo_falcon_only ON (demo.demo_id = demo_falcon_only.demo_id)
						   LEFT JOIN demo_falcon_enhan ON (demo.demo_id = demo_falcon_enhan.demo_id)
						   LEFT JOIN demo_mono_only ON (demo.demo_id = demo_mono_only.demo_id)
						   LEFT JOIN demo_year ON (demo.demo_id = demo_year.demo_id)
						   WHERE demo.demo_id='$demo_id'")
				    or die ("Error getting demo info");

					
		while ($demo_info=mysql_fetch_array($sql_demo)) 
		{  
			$demo_year = $demo_info['demo_year'];
			$demo_year .= '01';
			$demo_year .= '01';
			
			$smarty->assign('demo_info',
	    		 array('demo_name' => $demo_info['demo_name'],
				 	   'demo_year' => $demo_year,
				 	   'demo_id' => $demo_info['demo_id'],
				 	   'demo_ste_only' => $demo_info['ste_only'],
					   'demo_ste_enhan' => $demo_info['ste_enhanced'],
					   'demo_falcon_only' => $demo_info['falcon_only'],
					   'demo_falcon_enhan' => $demo_info['falcon_enhanced'],
					   'demo_mono_only' => $demo_info['mono_only']));
		}

//***********************************************************************************
//get the game categories & the categories already selected for this game
//***********************************************************************************

		$sql_categories = mysql_query("SELECT * FROM demo_cat ORDER BY demo_cat_name")
						  or die ("Error loading categories");
		
		while ($categories=mysql_fetch_array ($sql_categories)) 
		{
			$sql_demo_cat = mysql_query("SELECT * FROM demo_cat_cross WHERE demo_id='$demo_id' AND demo_cat_id=$categories[demo_cat_id]")
							or die ("Error loading categorie cross table");
			
			$selected=mysql_num_rows($sql_demo_cat);		
			if ( $selected == 1 )
			{
				$selected = 'selected';
			}
			else
			{
				$selected = '';
			}
			
			$smarty->append('cat',
	    			 array('cat_id' => $categories['demo_cat_id'],
					 	   'cat_name' => $categories['demo_cat_name'],
						   'cat_selected' => $selected)); 
		}

		
//**********************************************************************************		
//Get the author info
//**********************************************************************************

	//Get the individuals
	$sql_individuals = "SELECT ind_id,ind_name FROM individuals ORDER BY ind_name ASC";
	$sql_individuals_aka = "SELECT ind_id,nick FROM individual_nicks ORDER BY nick ASC";

	//Create a temporary table to build an array with both names and nicknames
	mysql_query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_individuals") or die("failed to create temporary table");
	mysql_query("INSERT INTO temp $sql_individuals_aka") or die("failed to insert akas into temporary table");
			
	$query_temporary = mysql_query("SELECT * FROM temp ORDER BY ind_name ASC") or die("Failed to query temporary table");
	mysql_query("DROP TABLE temp");
	
	while  ($individuals=mysql_fetch_array($query_temporary)) 
	{  
		$smarty->append('individuals',
	    		 array('ind_id' => $individuals['ind_id'],
					   'ind_name' => $individuals['ind_name']));
	}

	// Get the author types
	$sql_author = mysql_query("SELECT * FROM author_type ORDER BY author_type_info ASC")
		      or die ("Couldn't query author_types");
		
	while  ($author=mysql_fetch_array($sql_author)) 
	{  
		$smarty->append('author_types',
 			 array('author_type' => $author['author_type_info'],
				   'author_type_id' => $author['author_type_id']));
	}
	
	
	//Starting off with displaying the authors that are linked to the game and having a delete option for them */
	$sql_demoauthors = mysql_query("SELECT * FROM demo_author
									LEFT JOIN individuals ON (demo_author.ind_id = individuals.ind_id)
									LEFT JOIN author_type ON (demo_author.author_type_id = author_type.author_type_id) 
									WHERE demo_author.demo_id='$demo_id' ORDER BY author_type.author_type_id, individuals.ind_name")
						or die ("Error loading authors");
										
	 while  ($demo_author=mysql_fetch_array ($sql_demoauthors)) 
	 {
	 	$smarty->append('demo_author',
 			 array('demo_author_id' => $demo_author['demo_author_id'],
				   'ind_name' => $demo_author['ind_name'],
				   'ind_id' => $demo_author['ind_id'],
				   'auhthor_type_info' => $demo_author['author_type_info']));
		
		$smarty->assign("demo_author_nr",'1');
	 }

//**********************************************************************************		
//Get the crew info
//**********************************************************************************
	
	//let's get all the crews in the DB
	$sql_crew = mysql_query("SELECT * FROM crew ORDER BY crew_name ASC")
			     or die ("Couldn't query crew database");
		
	while  ($crew=mysql_fetch_array($sql_crew)) 
	{  
		$smarty->append('crew',
	   		 	 array('crew_id' => $crew['crew_id'],
					   'crew_name' => $crew['crew_name']));
	}
	
	
	//let's get the crew for this demo
	$sql_crew = mysql_query("SELECT * FROM crew 
								 LEFT JOIN crew_demo_prod ON ( crew.crew_id = crew_demo_prod.crew_id ) 
								 WHERE crew_demo_prod.demo_id = '$demo_id' ORDER BY crew_name ASC")
			        or die ("Couldn't query publishers");
	
	while  ($crew=mysql_fetch_array($sql_crew)) 
	{  
		$smarty->append('demo_crew',
	   		 	 array('crew_id' => $crew['crew_id'],
					   'crew_name' => $crew['crew_name']));
					   
		$smarty->assign("demo_crew_nr",'1');
	}
	

//***********************************************************************************
//AKA's
//***********************************************************************************

	$sql_aka = mysql_query("SELECT * FROM demo_aka WHERE demo_id='$demo_id'")
 			   or die ("Couldn't query aka demos");
	
	$nr_aka=0;
	
	while ($aka = mysql_fetch_array ($sql_aka)) 
	{
		$smarty->append('aka',
	   		 	 array('demo_aka_name' => $aka['aka_name'],
					   'demo_id' => $aka['demo_id'],
					   'demo_aka_id' => $aka['demo_aka_id']));
		$nr_aka++;
	}
	
	$smarty->assign("nr_aka",$nr_aka); 


//***********************************************************************************
//The game statistics below on the page
//***********************************************************************************

//Get the number of screenshots!
$numberscreen = mysql_query("SELECT count(*) as count FROM screenshot_demo WHERE demo_id = '$demo_id'")
		  		or die ("couldn't get number of screenshots");
$array = mysql_fetch_array($numberscreen);

$smarty->assign("nr_screenshots",$array['count']); 

//check how many music files this game has
$numbermusic = mysql_query("SELECT count(*) as count FROM demo_music WHERE demo_id = '$demo_id'")
			     or die ("couldn't get number of music files");
$array = mysql_fetch_array($numbermusic);

$smarty->assign("nr_music",$array['count']); 

//**********************************************************************************		
//Send it all to the template
//**********************************************************************************

$smarty->assign("demo_id",$demo_id);
$smarty->assign("user_id",$_SESSION['user_id']);
$smarty->assign('demo_detail_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();
