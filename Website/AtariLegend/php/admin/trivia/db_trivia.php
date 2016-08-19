<?php
/***************************************************************************
*                                db_trivia.php
*                            -----------------------
*   begin                : Saturday, May 1, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : re-creation of code from scratch into new file.
*						  						
*   Id: db_trivia.php,v 1.00 2005/05/01 Silver Surferµ
*   Id: db_trivia.php,v 1.00 2015/12/21 ST Graveyard - Added messages
*   Id: db_trivia.php,v 1.00 2016/08/19 ST Graveyard - Added change log
*
***************************************************************************/

// This document contain all the code needed to operate the trivia database.
// We are using the action var to separate all the queries.

include("../../includes/common.php");
include("../../includes/admin.php"); 

if(isset($action) and $action =="did_you_know_insert")
{
//****************************************************************************************
// Insert did you know quote!
//**************************************************************************************** 
	$trivia_text = $mysqli->real_escape_string($trivia_text);
	
	$sql = $mysqli->query("INSERT INTO trivia (trivia_text) VALUES ('$trivia_text')") or die("Couldn't insert trivia text");
	
	$new_trivia_id = $mysqli->insert_id;
	
	create_log_entry('Trivia', $new_trivia_id, 'DYK', $new_trivia_id, 'Insert', $_SESSION['user_id']);
	
	$_SESSION['edit_message'] = "trivia quote added to the database";
		
	header("Location: ../trivia/did_you_know.php");

	mysqli_close($mysqli);

}

if(isset($action) and $action=="did_you_know_delete")

{

//****************************************************************************************
// Delete did you know quote!
//**************************************************************************************** 
	
	create_log_entry('Trivia', $trivia_id, 'DYK', $trivia_id, 'Delete', $_SESSION['user_id']);
	
	$sql = $mysqli->query("DELETE FROM trivia WHERE trivia_id = '$trivia_id'") or die("Couldn't delete trivia text");
	$_SESSION['edit_message'] = "trivia quote has been deleted";
	
	header("Location: ../trivia/did_you_know.php");

	mysqli_close($mysqli);

}

if (isset($action) and $action=="delete_trivia_quote")

{

//****************************************************************************************
// Delete trivia quote!
//**************************************************************************************** 

if (isset($trivia_quote_id))

	{
	create_log_entry('Trivia', $trivia_quote_id, 'Quote', $trivia_quote_id, 'Delete', $_SESSION['user_id']);
	
	$sql = $mysqli->query("DELETE FROM trivia_quotes WHERE trivia_quote_id = '$trivia_quote_id'") or die("couldn't delete trivia quote");
	
	$_SESSION['edit_message'] = "trivia quote has been deleted";
	header("Location: ../trivia/manage_trivia_quotes.php");
	}
}


if (isset($action) and $action=="add_trivia")

{

//****************************************************************************************
// Add trivia quote!
//**************************************************************************************** 

if (isset($trivia_quote))

	{
		
	$trivia_quote = $mysqli->real_escape_string($trivia_quote);
	
	$mysqli->query("INSERT INTO trivia_quotes (trivia_quote) VALUES ('$trivia_quote')") or die("couldn't add trivia quote");
	
	$new_trivia_id = $mysqli->insert_id;
	create_log_entry('Trivia', $new_trivia_id, 'Quote', $new_trivia_id, 'Insert', $_SESSION['user_id']);
	
	$_SESSION['edit_message'] = "trivia quote added to the database";
	
	header("Location: ../trivia/manage_trivia_quotes.php");
	}	
}


if (isset($action) and $action=="trivia_upload")

{

//****************************************************************************************
// Upload trivia and add to db - THIS IS NOT USED AT AL2.0 (WAS AL 1.0)
//**************************************************************************************** 

//Here we'll be looping on each of the inputs on the page that are filled in with an image!

$image = $_FILES['image'];

foreach($image['tmp_name'] as $key=>$tmp_name)
{
	
	if ($tmp_name!=='none')
	{
	// Check what extention the file has and if it is allowed.
	
		$ext="";
		$type_image = $image['type'][$key];
		
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
		 
		// First we insert extension of the file... this also creates an autoinc number for us.
		$sdbquery = $mysqli->query("INSERT INTO trivia_screens (trivia_screens_id, imgext, skin_id) VALUES ('', '$ext', 'skin')")
					or die ("Database error - inserting screenshots");
		
		//select the newly entered screenshot_id from the main table
		$SCREENSHOT = $mysqli->query("SELECT trivia_screens_id FROM trivia_screens
	   					   		   ORDER BY trivia_screens_id desc")
					  or die ("Database error - selecting screenshots");
		
		$screenshotrow = $SCREENSHOT->fetch_row();
		$screenshot_id = $screenshotrow[0];
		
		// Rename the uploaded file to its autoincrement number and move it to its proper place.
		$file_data = rename($image['tmp_name'][$key], "$trivia_screenshot_path$screenshotrow[0].$ext");
		
		chmod("$trivia_screenshot_path$screenshotrow[0].$ext", 0777);
		}
	}
}

mysqli_close($mysqli);
header("Location: ../trivia/manage_trivia_screens.php");

}

if (isset($action) and $action=="delete_trivia_screen")

{

//****************************************************************************************
// Delete the trivia screenshot - THIS IS NOT USED AT AL2.0 (WAS AL 1.0)
//**************************************************************************************** 

	if (isset($imageid))
	{
		//get the extension 
		$SCREENSHOT = $mysqli->query("SELECT * FROM trivia_screens
								   WHERE trivia_screens_id = '$imageid'")
								 or die ("Database error - selecting screenshots");
		
		$screenshotrow = $SCREENSHOT->fetch_array(MYSQLI_BOTH);
		$screenshot_ext = $screenshotrow['imgext'];

		$sql = $mysqli->query("DELETE FROM trivia_screens WHERE trivia_screens_id = '$imageid' ");

		$new_path = $trivia_screenshot_path;
		$new_path .= $imageid;
		$new_path .= ".";
		$new_path .= $screenshot_ext;

		unlink ("$new_path");

		mysqli_close($mysqli); 
		
		header("Location: ../trivia/manage_trivia_screens.php");
	}
}
?>
