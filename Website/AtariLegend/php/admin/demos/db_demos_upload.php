<?php
/***************************************************************************
 *                                demos_upload.php
 *                            ------------------------
 *   begin                : Saturday, november 12, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *	 actual update        : Creation of file
 *
 *   Id: demos_upload.php,v 0.10 2005/11/12 17:15 ST Gravedigger
 *
 ***************************************************************************/

//****************************************************************************************
// This is the main page for the demo downloads. 
//**************************************************************************************** 

//load all common functions
include("../../includes/common.php");
include("../../includes/admin.php");

//****************************************************************************************
// We wanna add a new download
//**************************************************************************************** 
if (isset($action) and $action == 'add_download' )
{
	require_once('../includes/pclzip.lib.php');
	
$demo_download_name = $_FILES['demo_download_name'];

	if(isset($demo_download_name))
	{
      
		$file_name=$_FILES['demo_download_name']['name'];
		
		$tempfilename = $_FILES['demo_download_name']['tmp_name'];
		
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
		if ($ext=="stx" || $ext=="msa") 
		
		{} // pretty isn't it? ;)
		
		else
		
		{ exit ("Try uploading a diskimage type that is allowed, like stx or msa not $ext"); }
		
		// create a timestamp for the date of upload
		$timestamp = time();
		
		// Insert the ext,timestamp and the demo id into the demo download table.
		$sdbquery = $mysqli->query("INSERT INTO demo_download (demo_id,demo_ext,date) VALUES ('$demo_id','$ext','$timestamp')")
		or die("ERROR! Couldn't insert date, ext and demo id");
		
		//select the newly created demo_download_id from the demo_download table
		$DEMODOWN = $mysqli->query("SELECT demo_download_id FROM demo_download
	   					   		 ORDER BY demo_download_id desc")
					or die ("Database error - selecting demo_download");
		
		$demodownrow = $DEMODOWN->fetch_row();
		
		// Time to unzip the file to the temporary directory
		$archive = new PclZip("$tempfilename");
  		
			if ($archive->extract(PCLZIP_OPT_PATH, "$demo_file_temp_path") == 0) {
    		die("Error : ".$archive->errorInfo(true));
  			}

		// rename diskimage to increment number
		rename("$demo_file_temp_path$filename", "$demo_file_temp_path$demodownrow[0].$ext") or die("couldn't rename the file");
		
		//Time to rezip file and place it in the proper location.
		$archive = new PclZip("$demo_file_path$demodownrow[0].zip");
  		$v_list = $archive->create("$demo_file_temp_path$demodownrow[0].$ext",
       		                      PCLZIP_OPT_REMOVE_ALL_PATH);
  			if ($v_list == 0) {
    		die("Error : ".$archive->errorInfo(true));
  			}
		
		// Time to do the safeties, here we do a md5 file hash that we later enter into the database, this will be used in the download
		// function to check everytime the file is being downloaded... if the hashes don't match, then datacorruption have changed the file.
		$crc = md5_file ( "$demo_file_path$demodownrow[0].zip");
		
		$sdbquery = $mysqli->query("UPDATE demo_download SET md5 = '$crc' WHERE demo_download_id = '$demodownrow[0]'")
				or die("Couldn't insert md5hash");
		
		// Add entry to search table for search purposes
		$mysqli->query("UPDATE demo_search SET download='1' WHERE demo_id='$demo_id'");
		
		// Chmod file so that we can backup/delete files through ftp.
		chmod("$demo_file_path$demodownrow[0].zip", 0777);
		
		// Delete the unzipped file in the temporary directory
		unlink ("$demo_file_temp_path$demodownrow[0].$ext");
	}
		header("Location: ../demos/demos_upload.php?demo_id=$demo_id");
}

//****************************************************************************************
// When the update button has been pressed, the file name and comments get updated
//**************************************************************************************** 
if (isset($action) and $action == 'update_download')
{

if (isset($cracker)) {
	$mysqli->query("UPDATE demo_download SET cracker='$cracker' WHERE demo_download_id='$demo_download_id'");
}
if (isset($supplier)) {
	$mysqli->query("UPDATE demo_download SET supplier='$supplier' WHERE demo_download_id='$demo_download_id'");
}
if (isset($screen)) {
	$mysqli->query("UPDATE demo_download SET screen='$screen' WHERE demo_download_id='$demo_download_id'");
}
if (isset($language)) {
	$mysqli->query("UPDATE demo_download SET language='$language' WHERE demo_download_id='$demo_download_id'");
}
if (isset($trainer)) {
	$mysqli->query("UPDATE demo_download SET trainer='$trainer' WHERE demo_download_id='$demo_download_id'");
}
if (isset($legend)) {
	$mysqli->query("UPDATE demo_download SET legend='$legend' WHERE demo_download_id='$demo_download_id'");
}
if (isset($disks)) {
	$mysqli->query("UPDATE demo_download SET disks='$disks' WHERE demo_download_id='$demo_download_id'");
}
if (isset($set_nr)) {
	$mysqli->query("UPDATE demo_download SET set_nr='$set_nr' WHERE demo_download_id='$demo_download_id'");
}
if (isset($harddrive)) {
	$mysqli->query("UPDATE demo_download SET harddrive='$harddrive' WHERE demo_download_id='$demo_download_id'");
}
if (isset($disable)) {
	$mysqli->query("UPDATE demo_download SET disable='$disable' WHERE demo_download_id='$demo_download_id'");
}
if (isset($version)) {
	$mysqli->query("UPDATE demo_download SET version='$version' WHERE demo_download_id='$demo_download_id'");
}
if (isset($tos)) {
	$mysqli->query("UPDATE demo_download SET tos='$tos' WHERE demo_download_id='$demo_download_id'");
}
		header("Location: ../demos/demos_upload.php?demo_id=$demo_id");
}

//****************************************************************************************
// This is where the file name and comments get deleted
//**************************************************************************************** 
if (isset($action) and $action == "delete_download")
{
	$mysqli->query("DELETE from demo_download WHERE demo_download_id='$demo_download_id'");
	unlink ("$demo_file_path$demo_download_id.zip");
		header("Location: ../demos/demos_upload.php?demo_id=$demo_id");
}


//close the connection
mysqli_close($mysqli);
?>
