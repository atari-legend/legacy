<?php
/***************************************************************************
*                                Individuals_edit.php
*                            --------------------------
*   begin                : Saturday, August 6, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : Creation of file
*   Id: Individuals_edit.php,v 0.10 2005/08/06 15:25 Gatekeeper
*
***************************************************************************/

/*
************************************************************************************************
The individuals edit page
************************************************************************************************
*/

include("../includes/common.php");

// Here we delete the individual image
if (isset($ind_id) and isset($action) and $action == 'delete_pic')
{
	
	$sql_photo = "SELECT ind_imgext FROM individual_text WHERE ind_id='$ind_id'";
	$photo = $mysqli->query($sql_photo);
	list ($ind_imgext) = $photo->fetch_row();

	$mysqli->query("UPDATE individual_text SET ind_imgext='' WHERE ind_id='$ind_id'");
	unlink ("$individual_screenshot_path$ind_id.$ind_imgext");
		header("Location: ../individuals/individuals_edit.php?ind_id=$ind_id");
}

//If we want to upload a photo
if (isset($ind_id) and isset($action) and $action == 'add_photo')
{
	
	$image = $_FILES['individual_pic'];

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
	   			$mysqli->query("UPDATE individual_text SET ind_imgext='$ext' WHERE ind_id='$ind_id'");
	  			$file_data = rename("$tmp_name", "$individual_screenshot_path$ind_id.$ext");
	   
	  			chmod("$individual_screenshot_path$ind_id.$ext", 0777);
				header("Location: ../individuals/individuals_edit.php?ind_id=$ind_id");
			}
	}
}

//update the info of the individual
if (isset($ind_id) and isset($action) and $action == 'update')
{
	$sdbquery = $mysqli->query("UPDATE individuals SET ind_name = '$ind_name' WHERE ind_id = $ind_id")
				or die("Couldn't Update into individuals");

	$INDIVIDUALtext = $mysqli->query("SELECT ind_id FROM individual_text 
								    WHERE ind_id = $ind_id")
			  or die ("Database error - selecting individual_text");
		
	$indrowtext = mysql_numrows($INDIVIDUALtext);

	if ( $indrowtext < 1 )
	{
		$sdbquery = $mysqli->query("INSERT INTO individual_text (ind_id, ind_profile, ind_email) VALUES ($ind_id, '$textfield', '$ind_email')") 
					or die("Couldn't insert into individual_text (profile,email)");
	}
	else
	{
		$sdbquery = $mysqli->query("UPDATE individual_text SET ind_profile = '$textfield', ind_email = '$ind_email' WHERE ind_id = '$ind_id'")
					or die("Couldn't Update into individual_text (profile,email)");
	}

	$message = 'Individual succesfully updated';
	$smarty->assign("message",$message);
	header("Location: ../individuals/individuals_edit.php?ind_id=$ind_id");
}

// Add nicknames
if (isset($ind_id) and isset($action) and $action == "add_nick")
{

	if ($ind_nick !='')
	{

		$sdbquery = $mysqli->query("INSERT INTO individual_nicks (ind_id, nick) VALUES ($ind_id, '$ind_nick')") 
			        	or die("Couldn't insert into individual_nicks");
						
			$message = 'Individual succesfully updated';
			$smarty->assign("message",$message);
			header("Location: ../individuals/individuals_edit.php?ind_id=$ind_id");
	}
}

// Delete Nickname
if (isset($ind_id) and isset($action) and $action == "delete_nick")
{

	if (isset($nick_id))
	{
		$mysqli->query("DELETE FROM individual_nicks WHERE individual_nicks_id='$nick_id'")
			or die("Failed to delete nickname");
		
			$message = 'Nickname succesfully deleted';
			$smarty->assign("message",$message);
			header("Location: ../individuals/individuals_edit.php?ind_id=$ind_id");
	}
}

//if we want to delete the individual (from the edit page)
if (isset($ind_id) and isset($action) and $action == 'delete_ind')
{	
	//first delete picture
	$sql_photo = "SELECT ind_imgext FROM individual_text WHERE ind_id='$ind_id'";
	$photo = $mysqli->query($sql_photo);
	list ($ind_imgext) = $photo->fetch_row();
	
	if ( $ind_imgext <> '' )
	{
		unlink ("$individual_screenshot_path$ind_id.$ind_imgext");
	}
	
	$sdbquery = $mysqli->query("SELECT * FROM interview_main WHERE ind_id='$ind_id'")
				or die ("Error getting interview info");
	if ( $sdbquery->num_rows > 0 )
	{
		$smarty->assign("message",'Deletion failed - This individual is interviewed - Delete it in the appropriate section');
	}
	else
	{
		$sdbquery = $mysqli->query("SELECT * FROM game_author WHERE ind_id='$ind_id'")
					or die ("Error getting interview info");
		if ( $sdbquery->num_rows > 0 )
		{
			$smarty->assign("message",'Deletion failed - This individual is linked to a game - Delete it in the appropriate section');
		}
		else
		{
			//then delete the rest
			$sql = $mysqli->query("DELETE FROM individuals WHERE ind_id = $ind_id");
			$sql = $mysqli->query("DELETE FROM individual_text WHERE ind_id = $ind_id");
			$sql = $mysqli->query("DELETE FROM individual_nicks WHERE ind_id = $ind_id");
		    $smarty->assign("message",'individual succesfully deleted');
			header("Location: ../individuals/individuals_main.php");
		}
	}
}




//Insert a new individual
if (isset($action) and $action == 'insert_ind')
{	
	if ( $ind_name == '' )
	{
		$message = "Please fill in an individual name";
		$smarty->assign("message",$message);
		header("Location: ../individuals/individuals_main.php");
	}
	else
	{
		$sql_individuals = $mysqli->query("INSERT INTO individuals (ind_name) VALUES ('$ind_name')");  

		//get the id of the inserted individual
		$individuals = $mysqli->query("SELECT ind_id FROM individuals
	  	 					    	ORDER BY ind_id desc")
				  or die ("Database error - selecting individuals");
		
		$indrow = $individuals->fetch_row();

		$id = $indrow[0];	

		$sdbquery = $mysqli->query("INSERT INTO individual_text (ind_id, ind_profile) VALUES ($id, '$textfield')") 
					or die("Couldn't insert into individual_text");
				
		$message = "individual succesfully inserted";
		$smarty->assign("message",$message);
			header("Location: ../individuals/individuals_edit.php?ind_id=$id");
	}
}


//close the connection
mysql_close();
?>
