<?php
/***************************************************************************
 *                                games_upload.php
 *                            ------------------------
 *   begin                : Tuesday, november 9, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *	 actual update        : Creation of file
 *
 *   Id: games_upload.php,v 0.10 2005/11/09 15:10 ST Gravedigger
 *
 ***************************************************************************/

//****************************************************************************************
// This is the main page for the game downloads. 
//**************************************************************************************** 

//load all common functions
include("../../includes/common.php"); 


//****************************************************************************************
// We wanna add a new download
//**************************************************************************************** 
if (isset($action) and $action == 'add_download' )
{
	require_once('../includes/pclzip.lib.php');
	
	$game_download_name = $_FILES['game_download_name'];

	if(isset($game_download_name))
	{
      
		$file_name=$_FILES['game_download_name']['name'];
		
		$tempfilename = $_FILES['game_download_name']['tmp_name'];
		
		// Time for zip magic
		$zip = new PclZip("$tempfilename");
  			
			// Obtain the contentlist of the zip file.
  			if (($list = $zip->listContent()) == 0) {
   	 		die("Error : ".$zip->errorInfo(true));
  			}
  		
		// Get the filename from the returned array
		$filename = $list[0]['filename'];
  
  		// Split the filename to get the extention
  		$ext = strrchr ( $filename, "." );
  
  		// Get rid of the . in the extention
  		$ext = explode ( ".", $ext );
  
  		// convert to lowercase just incase....  
  		$ext = strtolower ( $ext[1] );
		
		// check if the extention is valid.
		if ($ext=="stx" || $ext=="msa" || $ext=="st") 
		
		{} // pretty isn't it? ;)
		
		else
		
		{ exit ("Try uploading a diskimage type that is allowed, like stx or msa not $ext"); }
		
		// create a timestamp for the date of upload
		$timestamp = time();
		
		// Insert the ext,timestamp and the game id into the game download table.
		$sdbquery = $mysqli->query("INSERT INTO game_download (game_id,game_ext,date) VALUES ('$game_id','$ext','$timestamp')")
		or die("ERROR! Couldn't insert date, ext and game id");
		
		//select the newly created game_download_id from the game_download table
		$GAMEDOWN = $mysqli->query("SELECT game_download_id FROM game_download
	   					   		 ORDER BY game_download_id desc")
					or die ("Database error - selecting game_download");
		
		$gamedownrow = $GAMEDOWN->fetch_row();
		
		// Time to unzip the file to the temporary directory
		$archive = new PclZip("$tempfilename");
  		
			if ($archive->extract(PCLZIP_OPT_PATH, "$game_file_temp_path") == 0) {
    		die("Error : ".$archive->errorInfo(true));
  			}

		// rename diskimage to increment number
		rename("$game_file_temp_path$filename", "$game_file_temp_path$gamedownrow[0].$ext") or die("couldn't rename the file");
		
		//Time to rezip file and place it in the proper location.
		$archive = new PclZip("$game_file_path$gamedownrow[0].zip");
  		$v_list = $archive->create("$game_file_temp_path$gamedownrow[0].$ext",
       		                      PCLZIP_OPT_REMOVE_ALL_PATH);
  			if ($v_list == 0) {
    		die("Error : ".$archive->errorInfo(true));
  			}
		
		// Time to do the safeties, here we do a md5 file hash that we later enter into the database, this will be used in the download
		// function to check everytime the file is being downloaded... if the hashes don't match, then datacorruption have changed the file.
		$crc = md5_file ( "$game_file_path$gamedownrow[0].zip");
		
		$sdbquery = $mysqli->query("UPDATE game_download SET md5 = '$crc' WHERE game_download_id = '$gamedownrow[0]'")
				or die("Couldn't insert md5hash");
		
		// Add entry to search table for search purposes
		
		$mysqli->query("UPDATE game_search SET download='1' WHERE game_id='$game_id'");
		
		// Chmod file so that we can backup/delete files through ftp.
		chmod("$game_file_path$gamedownrow[0].zip", 0777);
		
		// Delete the unzipped file in the temporary directory
		unlink ("$game_file_temp_path$gamedownrow[0].$ext");
		
		header("Location: ../games/games_upload.php?game_id=$game_id");
	}
}

//****************************************************************************************
// When the update button has been pressed, the file name and comments get updated
//**************************************************************************************** 
if (isset($action) and $action == 'update_download')
{

if (isset($cracker)) {
	$mysqli->query("UPDATE game_download SET cracker='$cracker' WHERE game_download_id='$game_download_id'");
}
if (isset($supplier)) {
	$mysqli->query("UPDATE game_download SET supplier='$supplier' WHERE game_download_id='$game_download_id'");
}
if (isset($screen)) {
	$mysqli->query("UPDATE game_download SET screen='$screen' WHERE game_download_id='$game_download_id'");
}
if (isset($language)) {
	$mysqli->query("UPDATE game_download SET language='$language' WHERE game_download_id='$game_download_id'");
}
if (isset($trainer)) {
	$mysqli->query("UPDATE game_download SET trainer='$trainer' WHERE game_download_id='$game_download_id'");
}
if (isset($legend)) {
	$mysqli->query("UPDATE game_download SET legend='$legend' WHERE game_download_id='$game_download_id'");
}
if (isset($disks)) {
	$mysqli->query("UPDATE game_download SET disks='$disks' WHERE game_download_id='$game_download_id'");
}
if (isset($set_nr)) {
	$mysqli->query("UPDATE game_download SET set_nr='$set_nr' WHERE game_download_id='$game_download_id'");
}
if (isset($intro)) {
	$mysqli->query("UPDATE game_download SET intro='$intro' WHERE game_download_id='$game_download_id'");
}
if (isset($harddrive)) {
	$mysqli->query("UPDATE game_download SET harddrive='$harddrive' WHERE game_download_id='$game_download_id'");
}
if (isset($disable)) {
	$mysqli->query("UPDATE game_download SET disable='$disable' WHERE game_download_id='$game_download_id'");
}
if (isset($version)) {
	$mysqli->query("UPDATE game_download SET version='$version' WHERE game_download_id='$game_download_id'");
}
if (isset($tos)) {
	$mysqli->query("UPDATE game_download SET tos='$tos' WHERE game_download_id='$game_download_id'");
}
		header("Location: ../games/games_upload.php?game_id=$game_id");
}

//****************************************************************************************
// This is where the file name and comments get deleted
//**************************************************************************************** 
if (isset($action) and $action == "delete_download")
{
	$mysqli->query("DELETE from game_download WHERE game_download_id='$game_download_id'");
	unlink ("$game_file_path$game_download_id.zip");
		header("Location: ../games/games_upload.php?game_id=$game_id");
}

//close the connection
mysqli_close($mysqli);
?>
