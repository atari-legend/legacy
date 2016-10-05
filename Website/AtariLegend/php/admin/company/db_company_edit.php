<?php
/***************************************************************************
*                                db_company_edit.php
*                            --------------------------
*   begin                : Sunday, August 7, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : Creation of file
*   Id: db_company_edit,v 0.10 2005/08/07 14:40 Gatekeeper
*   Id: db_company_edit,v 0.20 2016/07/31 14:40 Gatekeeper
*		- AL 2.0 - adding messages
*   Id: db_company_edit,v 0.21 2016/08/19 22:57 Gatekeeper
*		- adding change log
*
***************************************************************************/

/*
************************************************************************************************
The company edit page
************************************************************************************************
*/

include("../../includes/common.php");
include("../../includes/admin.php");

// Here we delete the company logo image
if ( isset($action) and $action == 'delete_logo' )
{
	
	$sql = "SELECT pub_dev_imgext FROM pub_dev_text WHERE pub_dev_id='$comp_id'";
	$pub_dev_query = $mysqli->query($sql);
	list ($pub_dev_imgext) = $pub_dev_query->fetch_array(MYSQLI_BOTH); 

	$mysqli->query("UPDATE pub_dev_text SET pub_dev_imgext='' WHERE pub_dev_id='$comp_id'");
	unlink ("$company_screenshot_save_path$comp_id.$pub_dev_imgext");
	
	$_SESSION['edit_message'] = "Company logo deleted";
	
	create_log_entry('Company', $comp_id, 'Logo', $comp_id, 'Delete', $_SESSION['user_id']);
	
	header("Location: ../company/company_edit.php?comp_id=$comp_id");
}

//If we want to upload a logo
if ( isset($action) and $action == 'add_logo' )
{
	$image = $_FILES['company_pic'];

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
		elseif ( $type_image=='image/jpeg')
			{
				$ext='jpg';
			} 
		
		 if ($ext!=="")
		 	{
       			// Rename the uploaded file to its autoincrement number and move it to its proper place.
	  			 $query = $mysqli->query("SELECT * FROM pub_dev_text WHERE pub_dev_id='$comp_id'");
	   
	  			 $num_row = get_rows($query);
	   
	 			  if ( $num_row==0 )
	   			  {
	   			  	$mysqli->query("INSERT INTO pub_dev_text (pub_dev_id,pub_dev_imgext) VALUES ('$comp_id','$ext')");
	 			  }
	   			  else
	     	      {
	  	 			 $mysqli->query("UPDATE pub_dev_text SET pub_dev_imgext='$ext' WHERE pub_dev_id='$comp_id'");
	   			  }
	   
	  			  $file_data = rename("$tmp_name", "$company_screenshot_save_path$comp_id.$ext");
	
				  chmod("$company_screenshot_save_path$comp_id.$ext", 0777);
				  
				  create_log_entry('Company', $comp_id, 'Logo', $comp_id, 'Insert', $_SESSION['user_id']);
				  
				  $_SESSION['edit_message'] = "Company logo succesfully uploaded";
			}
	}

header("Location: ../company/company_edit.php?comp_id=$comp_id");

}

//update the info of the individual
if ( isset($action) and $action == 'update' )
{
	$sdbquery = $mysqli->query("UPDATE pub_dev SET pub_dev_name = '$comp_name' WHERE pub_dev_id = $comp_id")
				or die("Couldn't Update into pub_dev");
			
	$COMPANYtext = $mysqli->query("SELECT pub_dev_id FROM pub_dev_text 
								WHERE pub_dev_id = $comp_id")
			  or die ("Database error - selecting pub_dev_text");
		
	$pubdevrowtext = get_rows($COMPANYtext);

	if ( $pubdevrowtext < 1 )
	{
		$sdbquery = $mysqli->query("INSERT INTO pub_dev_text (pub_dev_id, pub_dev_profile) VALUES ($comp_id, '$textfield')") 
					or die("Couldn't insert into pub_dev_text");
	}
	else
	{
		$sdbquery = $mysqli->query("UPDATE pub_dev_text SET pub_dev_profile = '$textfield' WHERE pub_dev_id = $comp_id")
					or die("Couldn't Update into pub_dev_text");
	}
	
	create_log_entry('Company', $comp_id, 'Company', $comp_id, 'Update', $_SESSION['user_id']);
	
	$_SESSION['edit_message'] = "Company succesfully updated";

	header("Location: ../company/company_edit.php?comp_id=$comp_id");

}

//if we want to delete the company (from the edit page)
if ( $action == 'delete_comp' )
{	
	// Here we delete the company image
	$sql = "SELECT pub_dev_imgext FROM pub_dev_text WHERE pub_dev_id='$comp_id'";
	$pub_dev_query = $mysqli->query($sql);
	list ($pub_dev_imgext) = $pub_dev_query->fetch_array(MYSQLI_BOTH); 
	
	if ( $pub_dev_imgext <> '' )
	{
		unlink ("$company_screenshot_path$comp_id.$pub_dev_imgext");
	}
	
	create_log_entry('Company', $comp_id, 'Company', $comp_id, 'Delete', $_SESSION['user_id']);
	
	$sql = $mysqli->query("DELETE FROM pub_dev WHERE pub_dev_id = '$comp_id'");
	$sql = $mysqli->query("DELETE FROM pub_dev_text WHERE pub_dev_id = '$comp_id'");
	$sql = $mysqli->query("DELETE FROM game_developer WHERE dev_pub_id = '$comp_id'");
	$sql = $mysqli->query("DELETE FROM game_publisher WHERE pub_dev_id = '$comp_id'");
	
	$_SESSION['edit_message'] = "Company succesfully deleted";

	header("Location: ../company/company_main.php");

}

//Insert a new individual
if ( $action == "insert_comp" )
{	
	if ( $comp_name == '' )
	{
		$_SESSION['edit_message'] = "Please fill in a company name";
		header("Location: ../company/company_main.php");
	}
	else
	{
		$sql = $mysqli->query("INSERT INTO pub_dev (pub_dev_name) VALUES ('$comp_name')");  

		//get the id of the inserted individual
		$COMPANY = $mysqli->query("SELECT pub_dev_id FROM pub_dev
	   					    	ORDER BY pub_dev_id desc")
				  or die ("Database error - selecting company");
		
		$pubdevrow = $COMPANY->fetch_row();

		$id = $pubdevrow[0];	

		$sdbquery = $mysqli->query("INSERT INTO pub_dev_text (pub_dev_id, pub_dev_profile) VALUES ($id, '$textfield')") 
					or die("Couldn't insert into pub_dev_text");
					
		create_log_entry('Company', $id, 'Company', $id, 'Insert', $_SESSION['user_id']);
	
		$_SESSION['edit_message'] = "Company succesfully inserted";
		
		header("Location: ../company/company_edit.php?comp_id=$id");
	}
}

//close the connection
mysqli_close($mysqli);
?>
