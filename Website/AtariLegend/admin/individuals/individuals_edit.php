<?
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
include("../includes/config.php"); 

if ($ind_id == '-')
{
		$message = 'please select an individual';
		$smarty->assign("message",$message);
		
		//Get the individuals
		$sql_individuals = mysql_query("SELECT * FROM individuals ORDER BY ind_name ASC")
				 		   or die ("Couldn't query individual database");
		
		while  ($individuals=mysql_fetch_array($sql_individuals)) 
		{  
			$smarty->append('individuals',
	   		 	 array('ind_id' => $individuals[ind_id],
					   'ind_name' => $individuals[ind_name]));
		}

		$smarty->assign("user_id",$_SESSION[user_id]);
		$smarty->assign('individuals_main_tpl', '1');

		//Send all smarty variables to the templates
		$smarty->display('file:../templates/0/index.tpl');
}
else
{

// Here we delete the individual image
if ( $action == 'delete_pic' )
{
	
	$sql_photo = "SELECT ind_imgext FROM individual_text WHERE ind_id='$ind_id'";
	$photo = mysql_query($sql_photo);
	list ($ind_imgext) = mysql_fetch_row($photo);

	mysql_query("UPDATE individual_text SET ind_imgext='' WHERE ind_id='$ind_id'");
	unlink ("$individual_screenshot_path$ind_id.$ind_imgext");
}

//If we want to upload a photo
if ( $action == 'add_photo' )
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
	   			mysql_query("UPDATE individual_text SET ind_imgext='$ext' WHERE ind_id='$ind_id'");
	  			$file_data = rename("$tmp_name", "$individual_screenshot_path$ind_id.$ext");
	   
	  			chmod("$individual_screenshot_path$ind_id.$ext", 0777);
			}
	}
}

//update the info of the individual
if ( $action == 'update' )
{
	$sdbquery = mysql_query("UPDATE individuals SET ind_name = '$ind_name' WHERE ind_id = $ind_id")
				or die("Couldn't Update into individuals");

	$INDIVIDUALtext = mysql_query("SELECT ind_id FROM individual_text 
								    WHERE ind_id = $ind_id")
			  or die ("Database error - selecting individual_text");
		
	$indrowtext = mysql_numrows($INDIVIDUALtext);

	if ( $indrowtext < 1 )
	{
		$sdbquery = mysql_query("INSERT INTO individual_text (ind_id, ind_profile, ind_email) VALUES ($ind_id, '$textfield', '$ind_email')") 
					or die("Couldn't insert into individual_text (profile,email)");
	}
	else
	{
		$sdbquery = mysql_query("UPDATE individual_text SET ind_profile = '$textfield', ind_email = '$ind_email' WHERE ind_id = '$ind_id'")
					or die("Couldn't Update into individual_text (profile,email)");
	}

	$message = 'Individual succesfully updated';
	$smarty->assign("message",$message);
}

// Add nicknames
if ($action == "add_nick")
{

	if ($ind_nick !='')
	{

		$sdbquery = mysql_query("INSERT INTO individual_nicks (ind_id, nick) VALUES ($ind_id, '$ind_nick')") 
			        	or die("Couldn't insert into individual_nicks");
						
			$message = 'Individual succesfully updated';
			$smarty->assign("message",$message);
	}
}

// Delete Nickname
if ($action == "delete_nick")
{

	if (isset($nick_id))
	{
		mysql_query("DELETE FROM individual_nicks WHERE individual_nicks_id='$nick_id'")
			or die("Failed to delete nickname");
		
			$message = 'Nickname succesfully deleted';
			$smarty->assign("message",$message);
	}
}


//Get the individual data
$sql_individuals = mysql_query("SELECT * FROM individuals 
								 LEFT JOIN individual_text ON (individuals.ind_id = individual_text.ind_id )
								 WHERE individuals.ind_id=$ind_id");

while ( $individuals=mysql_fetch_array($sql_individuals) ) 
{  
	//The interviewed person's picture
	if ( $individuals[ind_imgext] == 'png' or  
		 $individuals[ind_imgext] == 'jpg' or 
		 $individuals[ind_imgext] == 'gif')
	{
		$v_ind_image  = $individual_screenshot_path;
		$v_ind_image .= $ind_id;
		$v_ind_image .= '.';
		$v_ind_image .= $individuals[ind_imgext];
	}
	else
	{
		$v_ind_image = "none";
	}

	$smarty->assign('individuals',
	    	 array('ind_id' => $ind_id,
				   'ind_name' => $individuals[ind_name],
				   'ind_profile' => $individuals[ind_profile],
				   'ind_screenshot_path' => $individual_screenshot_path,
				   'ind_email' => $individuals[ind_email],
				   'ind_image' => $v_ind_image));
}

// Get nickname information
$sql_individuals = mysql_query("SELECT * FROM individual_nicks WHERE ind_id=$ind_id");

while ( $ind_nicks=mysql_fetch_array($sql_individuals) ) 
{  

	$smarty->append('nicks',
	    	 array('nick_id' => $ind_nicks[individual_nicks_id],
				   'nick_name' => $ind_nicks[nick]));
}

$smarty->assign("user_id",$_SESSION[user_id]);
$smarty->assign('individuals_edit_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
}

//close the connection
mysql_close();
?>
