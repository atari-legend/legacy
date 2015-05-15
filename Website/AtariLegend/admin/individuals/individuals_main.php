<?php
/***************************************************************************
*                                Individuals_main.php
*                            --------------------------
*   begin                : Saturday, August 6, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : Creation of file
*   Id: Individuals_main.php,v 0.10 2005/08/06 15:04 Gatekeeper
*
***************************************************************************/

/*
************************************************************************************************
The main individual page
************************************************************************************************
*/

include("../includes/common.php");

//if we want to delete the individual (from the edit page)
if (empty($action)) {$action = "";}
if ( $action == 'delete_ind' )
{	
	//first delete picture
	$sql_photo = "SELECT ind_imgext FROM individual_text WHERE ind_id='$ind_id'";
	$photo = mysql_query($sql_photo);
	list ($ind_imgext) = mysql_fetch_row($photo);
	
	if ( $ind_imgext <> '' )
	{
		unlink ("$individual_screenshot_path$ind_id.$ind_imgext");
	}
	
	$sdbquery = mysql_query("SELECT * FROM interview_main WHERE ind_id='$ind_id'")
				or die ("Error getting interview info");
	if ( mysql_num_rows($sdbquery) > 0 )
	{
		$smarty->assign("message",'Deletion failed - This individual is interviewed - Delete it in the appropriate section');
	}
	else
	{
		$sdbquery = mysql_query("SELECT * FROM game_author WHERE ind_id='$ind_id'")
					or die ("Error getting interview info");
		if ( mysql_num_rows($sdbquery) > 0 )
		{
			$smarty->assign("message",'Deletion failed - This individual is linked to a game - Delete it in the appropriate section');
		}
		else
		{
			//then delete the rest
			$sql = mysql_query("DELETE FROM individuals WHERE ind_id = $ind_id");
			$sql = mysql_query("DELETE FROM individual_text WHERE ind_id = $ind_id");
			$sql = mysql_query("DELETE FROM individual_nicks WHERE ind_id = $ind_id");
		    $smarty->assign("message",'individual succesfully deleted');
		}
	}
}

//Insert a new individual
if ( $action == 'insert_ind' )
{	
	if ( $ind_name == '' )
	{
		$message = "Please fill in an individual name";
		$smarty->assign("message",$message);
	}
	else
	{
		$sql_individuals = mysql_query("INSERT INTO individuals (ind_name) VALUES ('$ind_name')");  

		//get the id of the inserted individual
		$individuals = mysql_query("SELECT ind_id FROM individuals
	  	 					    	ORDER BY ind_id desc")
				  or die ("Database error - selecting individuals");
		
		$indrow = mysql_fetch_row($individuals);

		$id = $indrow[0];	

		$sdbquery = mysql_query("INSERT INTO individual_text (ind_id, ind_profile) VALUES ($id, '$textfield')") 
					or die("Couldn't insert into individual_text");
				
		$message = "individual succesfully inserted";
		$smarty->assign("message",$message);
	}
}


//Get the individuals
$sql_individuals = "SELECT * FROM individuals ORDER BY ind_name ASC";
$sql_aka = "SELECT ind_id,nick FROM individual_nicks ORDER BY nick ASC";

//Create a temporary table to build an array with both names and nicknames
mysql_query("CREATE TEMPORARY TABLE temp ENGINE = MEMORY $sql_individuals") or die("failed to create temporary table");
mysql_query("INSERT INTO temp $sql_aka") or die("failed to insert akas into temporary table");
			
$query_temporary = mysql_query("SELECT * FROM temp ORDER BY ind_name ASC") or die("Failed to query temporary table");
mysql_query("DROP TABLE temp");
				   
				   
while  ($individuals=mysql_fetch_array($query_temporary)) 
{  
	if ( $individuals['ind_name'] != '' )
	{
		$smarty->append('individuals',
	    		 array('ind_id' => $individuals['ind_id'],
					   'ind_name' => $individuals['ind_name']));
	}
}

$smarty->assign("user_id",$_SESSION['user_id']);
$smarty->assign('individuals_main_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();
?>
