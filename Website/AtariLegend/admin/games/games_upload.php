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
include("../includes/common.php"); 


//****************************************************************************************
// We wanna add a new download
//**************************************************************************************** 
if (isset($action) and $action == 'add_download' )
{
	require_once('../includes/pclzip.lib.php');
	
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
		$sdbquery = mysql_query("INSERT INTO game_download (game_id,game_ext,date) VALUES ('$game_id','$ext','$timestamp')")
		or die("ERROR! Couldn't insert date, ext and game id");
		
		//select the newly created game_download_id from the game_download table
		$GAMEDOWN = mysql_query("SELECT game_download_id FROM game_download
	   					   		 ORDER BY game_download_id desc")
					or die ("Database error - selecting game_download");
		
		$gamedownrow = mysql_fetch_row($GAMEDOWN);
		
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
		
		$sdbquery = mysql_query("UPDATE game_download SET md5 = '$crc' WHERE game_download_id = '$gamedownrow[0]'")
				or die("Couldn't insert md5hash");
		
		// Add entry to search table for search purposes
		
		mysql_query("UPDATE game_search SET download='1' WHERE game_id='$game_id'");
		
		// Chmod file so that we can backup/delete files through ftp.
		chmod("$game_file_path$gamedownrow[0].zip", 0777);
		
		// Delete the unzipped file in the temporary directory
		unlink ("$game_file_temp_path$gamedownrow[0].$ext");
	}
}

//****************************************************************************************
// When the update button has been pressed, the file name and comments get updated
//**************************************************************************************** 
if (isset($action) and $action == 'update_download')
{

if (isset($cracker)) {
	mysql_query("UPDATE game_download SET cracker='$cracker' WHERE game_download_id='$game_download_id'");
}
if (isset($supplier)) {
	mysql_query("UPDATE game_download SET supplier='$supplier' WHERE game_download_id='$game_download_id'");
}
if (isset($screen)) {
	mysql_query("UPDATE game_download SET screen='$screen' WHERE game_download_id='$game_download_id'");
}
if (isset($language)) {
	mysql_query("UPDATE game_download SET language='$language' WHERE game_download_id='$game_download_id'");
}
if (isset($trainer)) {
	mysql_query("UPDATE game_download SET trainer='$trainer' WHERE game_download_id='$game_download_id'");
}
if (isset($legend)) {
	mysql_query("UPDATE game_download SET legend='$legend' WHERE game_download_id='$game_download_id'");
}
if (isset($disks)) {
	mysql_query("UPDATE game_download SET disks='$disks' WHERE game_download_id='$game_download_id'");
}
if (isset($set_nr)) {
	mysql_query("UPDATE game_download SET set_nr='$set_nr' WHERE game_download_id='$game_download_id'");
}
if (isset($intro)) {
	mysql_query("UPDATE game_download SET intro='$intro' WHERE game_download_id='$game_download_id'");
}
if (isset($harddrive)) {
	mysql_query("UPDATE game_download SET harddrive='$harddrive' WHERE game_download_id='$game_download_id'");
}
if (isset($disable)) {
	mysql_query("UPDATE game_download SET disable='$disable' WHERE game_download_id='$game_download_id'");
}
if (isset($version)) {
	mysql_query("UPDATE game_download SET version='$version' WHERE game_download_id='$game_download_id'");
}
if (isset($tos)) {
	mysql_query("UPDATE game_download SET tos='$tos' WHERE game_download_id='$game_download_id'");
}

}

//****************************************************************************************
// This is where the file name and comments get deleted
//**************************************************************************************** 
if (isset($action) and $action == "delete_download")
{
	mysql_query("DELETE from game_download WHERE game_download_id='$game_download_id'");
	unlink ("$game_file_path$game_download_id.zip");
}

//************************************************************************************************
//Let's get the game info for the file name concatenation, and the download data for disks already
//uploaded
//************************************************************************************************
$SQL_GAME_INFO = mysql_query("SELECT * FROM game 
							   LEFT JOIN game_publisher ON (game.game_id = game_publisher.game_id)
							   LEFT JOIN pub_dev ON (game_publisher.pub_dev_id = pub_dev.pub_dev_id)
							   LEFT JOIN game_year ON (game.game_id = game_year.game_id)
						   	   WHERE game.game_id='$game_id'")
			  or die ("Error getting game info");

$game_info=mysql_fetch_array ($SQL_GAME_INFO); 

//get some basic game info
$smarty->assign('game',
		 array('game_id' => $game_id,
		 	   'game_name' => $game_info['game_name']));

//get the existing downloads
$SQL_DOWNLOADS = mysql_query("SELECT * FROM game_download WHERE game_id='$game_id'")
			  	 or die ("Error getting download info");		

$nr_downloads = 1;
while ($downloads=mysql_fetch_array($SQL_DOWNLOADS)) 
{
	// first lets create the filenames
	$filename = "$game_info[game_name]";
	
	if ($game_info['game_year']=='') { $filename .= " (19xx)"; } else { $filename .= " ($game_info[game_year])";}
	if ($game_info['pub_dev_id']!=='') { $filename .= "($game_info[pub_dev_name])"; }
	if ($downloads['game_ext']=="stx") { $filename .="[pasti]";}
	if ($downloads['game_ext']=="msa") { $filename .="[MSA]";}
	if ($downloads['cracker']!=="") { $filename .="[cr $downloads[cracker]]";}
	if ($downloads['supplier']!=="") { $filename .="[su $downloads[supplier]]";}
	if ($downloads['screen']!=="") { $filename .="[$downloads[screen]]";}
	if ($downloads['language']!=="") { $filename .="[$downloads[language]]";}
	if ($downloads['trainer']!=="") { $filename .="[$downloads[trainer]]";}
	if ($downloads['legend']=="1") { $filename .="[AL]";}
	if ($downloads['disks']!=="0" || $downloads['disks']!=="") { $filename .=" Disk $downloads[disks]";}
	$filename .=".zip";
	
	$filepath = $game_file_path;
	$filepath .= $downloads['game_download_id'];
	
	//convert the date
	$date = convert_timestamp($downloads['date']);
	
	//start filling the smarty object
	$smarty->append('downloads',
	    	 array('game_download_id' => $downloads['game_download_id'],
			 	   'cracker' => $downloads['cracker'],
				   'supplier' => $downloads['supplier'],
				   'intro' => $downloads['intro'],
				   'harddrive' => $downloads['harddrive'],
				   'pal_ntsc' => $downloads['screen'],
				   'language' => $downloads['language'],
				   'trainer' => $downloads['trainer'],
				   'disks' => $downloads['disks'],
				   'set_nr' => $downloads['set_nr'],
				   'legend' => $downloads['legend'],
				   'disable' => $downloads['disable'],
				   'filename' => $filename,
				   'filepath' => $filepath,
				   'version' => $downloads['version'],
				   'tos' => $downloads['tos'],
				   'date' => $date));

	$nr_downloads++;
}

$smarty->assign('nr_downloads',$nr_downloads);

$smarty->assign("user_id",$_SESSION['user_id']);
$smarty->assign('games_upload_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();
?>
