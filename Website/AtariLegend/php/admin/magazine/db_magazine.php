<?php
/***************************************************************************
*                                db_magazine.php
*                            -----------------------
*   begin                : Saturday, Jan 08, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : re-creation of code from scratch into new file.							
*
*   Id: db_magazine.php,v 1.00 2005/09/11 Silver Surfer
*   Id: db_magazine.php,v 1.10 2016/08/19 STG - add change log
*
***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../../includes/common.php");
include("../../includes/admin.php"); 

if(isset($action) and $action=="insert_magazine")

{

//****************************************************************************************
// This is where we insert the magazine name into the database
//**************************************************************************************** 

$mysqli->query("INSERT INTO magazine (magazine_name) VALUES ('$newmag')")
			or die("Unable to insert magazine into database");  

// Redirect back to previous page
header("Location: ../magazine/magazine_add.php");
}


if(isset($action) and $action=="add_issue")

{

//****************************************************************************************
// This is where we insert new issues
//**************************************************************************************** 

if(isset($newissue) and isset($magazine_id)) 
{

	$mysqli->query("INSERT INTO magazine_issue (magazine_issue_nr,magazine_id) VALUES ('$newissue','$magazine_id')"); 
	
	mysqli_close($mysqli); 
}

// Redirect back to previous page
header("Location: ../magazine/magazine_edit.php?magazine_id=$magazine_id");
}


if(isset($action) and $action=="delete_issue")

{

//****************************************************************************************
// This is where we delete issue
//**************************************************************************************** 

$sqldel = $mysqli->query("SELECT * FROM magazine_issue WHERE magazine_issue_id='$magazine_issue_id'") or die ("Error retriving magazines");
		$fetchdel = $sqldel->fetch_array(MYSQLI_BOTH);
		
		$do_delete = $mysqli->query("DELETE FROM magazine_issue WHERE magazine_issue_id='$magazine_issue_id'") or die("couldn't delete issue!");
		$do_delete = $mysqli->query("DELETE FROM magazine_game WHERE magazine_issue_id='$magazine_issue_id'") or die("couldn't delete score!");
		
		//remove potential coverscan
		
			if ($fetchdel[magazine_issue_imgext]!=='') {
		
				unlink ("$magazine_scan_path$magazine_issue_id.$fetchdel[magazine_issue_imgext]");
			}
		
// Redirect back to previous page
header("Location: ../magazine/magazine_edit.php?magazine_id=$magazine_id");
}

if(isset($action) and $action=="coverscan_upload")

{

//****************************************************************************************
// This is where we upload coverscans
//**************************************************************************************** 

	$coverscan = $_FILES['coverscan'];
	if(isset($coverscan))
	{
      	$imgext="jpg";
	  	
		// Insert the image extention to the database.
		$sdbquery = $mysqli->query("UPDATE magazine_issue SET magazine_issue_imgext='$imgext' WHERE magazine_issue_id='$magazine_issue_id'")
		or die("ERROR! Couldn't insert extension");
		
		
		// Rename the uploaded file to its issue autoincrement number and move it to its proper place.
		$file_data = rename($_FILES['coverscan']['tmp_name'], "$magazine_scan_path$magazine_issue_id.$imgext")
		or die("ERROR couldn't upload and move file!!");
		
		chmod("$magazine_scan_path$magazine_issue_id.$imgext", 0777);
	
	}

mysqli_close($mysqli);

// Redirect back to previous page
header("Location: ../magazine/magazine_issue_edit.php?magazine_issue_id=$magazine_issue_id");
}

if(isset($action) and $action=="delete_coverscan")

{

//****************************************************************************************
// This is where we delete coverscans
//**************************************************************************************** 

$sqldel = $mysqli->query("SELECT * FROM magazine_issue WHERE magazine_issue_id='$magazine_issue_id'") or die ("Error retriving magazines");
		$fetchdel = $sqldel->fetch_array(MYSQLI_BOTH);
		
		//remove coverscan
		
			if ($fetchdel['magazine_issue_imgext']!=='') 
			{
				unlink ("$magazine_scan_path$magazine_issue_id.$fetchdel[magazine_issue_imgext]");
			}
			
			$sdbquery = $mysqli->query("UPDATE magazine_issue SET magazine_issue_imgext='' WHERE magazine_issue_id='$magazine_issue_id'")
			or die("ERROR! Couldn't delete extension");
			

mysqli_close($mysqli);

// Redirect back to previous page
header("Location: ../magazine/magazine_issue_edit.php?magazine_issue_id=$magazine_issue_id");
}
if(isset($action) and $action=="score_delete")
{
	//****************************************************************************************
	// This is where we delete review scores
	//**************************************************************************************** 
	$do_delete = $mysqli->query("DELETE FROM magazine_game WHERE magazine_game_id='$magazine_game_id'") or die("couldn't delete score!");
	
	create_log_entry('Games', $game_id, 'Mag score', $game_id, 'Delete', $_SESSION['user_id']);
	
	$_SESSION['edit_message'] = "magazine link and score deleted";
				
	mysqli_close($mysqli);

	// Redirect back to previous page
	header("Location: ../magazine/magazine_review_score.php?game_id=$game_id");
}

if(isset($action) and $action=="set_score")
{
	//****************************************************************************************
	// This is where we set review scores
	//**************************************************************************************** 
	if (isset($score))
	{
		$mysqli->query("INSERT INTO magazine_game (magazine_issue_id,game_id,score) VALUES ('$magazine_issue_id','$game_id','$score')") 
		or die("Couldn't update the magazine table");
	}

	create_log_entry('Games', $game_id, 'Mag score', $game_id, 'Insert', $_SESSION['user_id']);
			
	$_SESSION['edit_message'] = "magazine link and score added";		
			
	mysqli_close($mysqli);

	// Redirect back to previous page
	header("Location: ../magazine/magazine_review_score.php?game_id=$game_id");
}
