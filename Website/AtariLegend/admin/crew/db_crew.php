<?php
/***************************************************************************
*                                db_crew.php
*                            -----------------------
*   begin                : Saturday, Sept 24, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : New section.
*						  
*							
*
*   Id: db_crew.php,v 1.10 2005/10/29 Silver Surfer
*
***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../includes/common.php"); 

if ($action=="stop")
{
echo "test";
exit;
}

if($action=="insert_crew")

{

//****************************************************************************************
// Adding a new crew
//**************************************************************************************** 

if(isset($new_crew)) 
{

		$mysqli->query("INSERT INTO crew (crew_name) VALUES ('$new_crew')"); 


	mysqli_free_result(); 
}
// we are sending the $new_crew value to the main page again to place that one 
// in the search field would the user want to edit the crew right away.
header("Location: ../crew/crew_main.php?new_crew=$new_crew");

}

if($action=="add_logo")

{

//****************************************************************************************
// Adding logo to crew
//**************************************************************************************** 

	
	$image = $_FILES['crew_pic'];

	$tmp_name=$image['tmp_name']; 

	if ($tmp_name!=='none')
	{
	// Check what extention the file has and if it is allowed.
	
		$ext="";
		$type_image = $image['type'];
		
		// set extension
		if ( $type_image=='image/x-png')
			{
				$ext='png';
			}
		
		elseif ( $type_image=='image/png')
			{
				$ext='png';
			}
			
		elseif ( $type_image=='image/gif')
			{
				$ext='gif';
			} 
		elseif ( $type_image=='image/pjpeg')
			{
				$ext='jpg';
			} 
		
		 if ($ext!=="")
		 	{
			
       			// Rename the uploaded file to its autoincrement number and move it to its proper place.
	  			 $mysqli->query("UPDATE crew SET crew_logo='$ext' WHERE crew_id='$crew_select'");
	   			
	   
	  			 $file_data = rename("$tmp_name", "$crew_logo_path$crew_select.$ext");
	
				 chmod("$crew_logo_path$crew_select.$ext", 0777);
			}
	}
header("Location: ../crew/crew_editor.php?crew_select=$crew_select&crewsearch=$crewsearch&crewbrowse=$crewbrowse");

}

if($action=="delete_logo")

{

//****************************************************************************************
// Delete Logo
//**************************************************************************************** 
			
       			$sql_crew = $mysqli->query("SELECT crew_logo FROM crew
						WHERE crew_id = '$crew_select'")
			    	   or die ("Couldn't query Crew database");
					   
				$crew=$sql_crew->fetch_array(MYSQLI_BOTH);		
				
				
	  			 $mysqli->query("UPDATE crew SET crew_logo='' WHERE crew_id='$crew_select'");
	   			
				 unlink ("$crew_logo_path$crew_select.$crew[crew_logo]");

header("Location: ../crew/crew_editor.php?crew_select=$crew_select&crewsearch=$crew_search&crewbrowse=$crewbrowse&action=main");

}

if($action=="delete_crew")

{

//****************************************************************************************
// Delete Crew... keep track of this one, it will need updating as often as we add functionality.
//**************************************************************************************** 
			
	if (isset($crew_select))
	{
	
		$sql_crew = $mysqli->query("SELECT crew_logo FROM crew
						WHERE crew_id = '$crew_select'")
			    	   or die ("Couldn't query Crew database");
					   
		$crew=$sql_crew->fetch_array(MYSQLI_BOTH);
	
	
		$mysqli->query("DELETE FROM crew WHERE crew_id='$crew_select'");
		$mysqli->query("DELETE FROM sub_crew WHERE crew_id='$crew_select'");
		$mysqli->query("DELETE FROM sub_crew WHERE parent_id='$crew_select'");
		$mysqli->query("DELETE FROM crew_individual WHERE crew_id='$crew_select'");
	   			
				 unlink ("$crew_logo_path$crew_select.$crew[crew_logo]");
	}

header("Location: ../crew/crew_main.php");

}

if($action=="update_main_info")

{

//****************************************************************************************
// update main crew info
//**************************************************************************************** 
			
       			$sql_crew = $mysqli->query("SELECT * FROM crew
						WHERE crew_id = '$crew_select'")
			    	   or die ("Couldn't query Crew database");
					   
				$crew=$sql_crew->fetch_array(MYSQLI_BOTH);		
				
				if ($crew_name !='')
				{
				$mysqli->query("UPDATE crew SET crew_name='$crew_name' WHERE crew_id='$crew_select'");
				}
				
				$textfield = trim($textfield);
				
				if ($textfield !='')
				{
				$textfield = addslashes($textfield);
				$mysqli->query("UPDATE crew SET crew_history='$textfield' WHERE crew_id='$crew_select'");
				
				}

header("Location: ../crew/crew_editor.php?crew_select=$crew_select&crewsearch=$crewsearch&crewbrowse=$crewbrowse&action=main");
}

if($action=="parent_crew")

{

//****************************************************************************************
// add subcrews
//**************************************************************************************** 

foreach($sub_crew as $value)
{
		$mysqli->query("INSERT INTO sub_crew (parent_id,crew_id) VALUES ('$crew_select','$value')");
}

header("Location: ../crew/crew_genealogy.php?crew_select=$crew_select&crewsearch=$crewsearch&crewbrowse=$crewbrowse&action=genealogy");
}

if($action=="add_member")

{

//****************************************************************************************
// add individual members to crew
//**************************************************************************************** 

if(isset($ind_id))
{
		$mysqli->query("INSERT INTO crew_individual (crew_id,ind_id) VALUES ('$crew_select','$ind_id')");
}

header("Location: ../crew/crew_genealogy.php?crew_select=$crew_select&crewsearch=$crewsearch&crewbrowse=$crewbrowse&action=genealogy");
}

if($action=="delete_crew_member")

{

//****************************************************************************************
// delete individual members
//**************************************************************************************** 

if(isset($crew_individual_id))
{
		$mysqli->query("DELETE FROM crew_individual WHERE crew_individual_id='$crew_individual_id'");

}

header("Location: ../crew/crew_genealogy.php?crew_select=$crew_select&crewsearch=$crewsearch&crewbrowse=$crewbrowse&action=genealogy");
}

if($action=="delete_subcrew")

{

//****************************************************************************************
// Delete Subcrew
//**************************************************************************************** 

if(isset($sub_crew_id))
{
		$mysqli->query("DELETE FROM sub_crew WHERE sub_crew_id='$sub_crew_id'");

}

header("Location: ../crew/crew_genealogy.php?crew_select=$crew_select&crewsearch=$crewsearch&crewbrowse=$crewbrowse&action=genealogy");
}


if($action=="update_nick")

{

//****************************************************************************************
// Update nicknames for crew members
//**************************************************************************************** 

if(isset($individual_nicks_id) and isset($crew_individual_id))
{
	if ($individual_nicks_id == "-")
	{
		$mysqli->query("UPDATE crew_individual SET individual_nicks_id='' WHERE crew_individual_id='$crew_individual_id'") or die("Failed to remove nickname");
	}
	else
	{
		$mysqli->query("UPDATE crew_individual SET individual_nicks_id='$individual_nicks_id' WHERE crew_individual_id='$crew_individual_id'") or die("Failed to update nickname information");
	}
}

header("Location: ../crew/crew_genealogy.php?crew_select=$crew_select&crewsearch=$crewsearch&crewbrowse=$crewbrowse&action=genealogy");
}?>

