<?
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
include("../includes/common.php"); 

//****************************************************************************************
// We wanna add a new download
//**************************************************************************************** 
if (isset($action) and $action == 'add_download' )
{
	require_once('../includes/pclzip.lib.php');
	
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
		$sdbquery = mysql_query("INSERT INTO demo_download (demo_id,demo_ext,date) VALUES ('$demo_id','$ext','$timestamp')")
		or die("ERROR! Couldn't insert date, ext and demo id");
		
		//select the newly created demo_download_id from the demo_download table
		$DEMODOWN = mysql_query("SELECT demo_download_id FROM demo_download
	   					   		 ORDER BY demo_download_id desc")
					or die ("Database error - selecting demo_download");
		
		$demodownrow = mysql_fetch_row($DEMODOWN);
		
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
		
		$sdbquery = mysql_query("UPDATE demo_download SET md5 = '$crc' WHERE demo_download_id = '$demodownrow[0]'")
				or die("Couldn't insert md5hash");
		
		// Add entry to search table for search purposes
		mysql_query("UPDATE demo_search SET download='1' WHERE demo_id='$demo_id'");
		
		// Chmod file so that we can backup/delete files through ftp.
		chmod("$demo_file_path$demodownrow[0].zip", 0777);
		
		// Delete the unzipped file in the temporary directory
		unlink ("$demo_file_temp_path$demodownrow[0].$ext");
	}
}

//****************************************************************************************
// When the update button has been pressed, the file name and comments get updated
//**************************************************************************************** 
if (isset($action) and $action == 'update_download')
{
	mysql_query("UPDATE demo_download SET cracker='$cracker', supplier='$supplier', screen='$screen', language='$language', trainer='$trainer', legend='$legend', disks='$disks', set_nr='$set_nr', intro='$intro', harddrive='$harddrive', disable='$disable', version='$version', tos='$tos' WHERE demo_download_id='$demo_download_id'");
}

//****************************************************************************************
// This is where the file name and comments get deleted
//**************************************************************************************** 
if (isset($action) and $action == "delete_download")
{
	mysql_query("DELETE from demo_download WHERE demo_download_id='$demo_download_id'");
	unlink ("$demo_file_path$demo_download_id.zip");
}

//************************************************************************************************
//Let's get the demo info for the file name concatenation, and the download data for disks already
//uploaded
//************************************************************************************************
$SQL_DEMO_INFO = mysql_query("SELECT * FROM demo 
							   LEFT JOIN crew_demo_prod ON (demo.demo_id = crew_demo_prod.demo_id)
							   LEFT JOIN crew ON (crew_demo_prod.crew_id = crew.crew_id)
							   LEFT JOIN demo_year ON (demo.demo_id = demo_year.demo_id)
						   	   WHERE demo.demo_id='$demo_id'")
			  or die ("Error getting demo info");

$demo_info=mysql_fetch_array ($SQL_DEMO_INFO); 

//get some basic demo info
$smarty->assign('demo',
		 array('demo_id' => $demo_id,
		 	   'demo_name' => $demo_info['demo_name']));

//get the existing downloads
$SQL_DOWNLOADS = mysql_query("SELECT * FROM demo_download WHERE demo_id='$demo_id'")
			  	 or die ("Error getting download info");		

$nr_downloads = 1;

while ($downloads=mysql_fetch_array($SQL_DOWNLOADS)) 
{
	// first lets create the filenames
	$filename = "$demo_info[demo_name]";
	
	if ($demo_info['demo_year']=='') { $filename .= " (19xx)"; } else { $filename .= " ($demo_info[demo_year])";}
	if ($demo_info['crew_id']!=='') { $filename .= "($demo_info[crew_name])"; }
	if ($downloads['demo_ext']=="stx") { $filename .="[pasti]";}
	if ($downloads['demo_ext']=="msa") { $filename .="[MSA]";}
	if ($downloads['cracker']!=="") { $filename .="[cr $downloads[cracker]]";}
	if ($downloads['supplier']!=="") { $filename .="[su $downloads[supplier]]";}
	if ($downloads['screen']!=="") { $filename .="[$downloads[screen]]";}
	if ($downloads['language']!=="") { $filename .="[$downloads[language]]";}
	if ($downloads['trainer']!=="") { $filename .="[$downloads[trainer]]";}
	if ($downloads['legend']=="1") { $filename .="[AL]";}
	if ($downloads['disks']!=="0" || $downloads['disks']!=="") { $filename .=" Disk $downloads[disks]";}
	$filename .=".zip";
	
	$filepath = $demo_file_path;
	$filepath .= $downloads['demo_download_id'];
	
	//convert the date
	$date = convert_timestamp($downloads['date']);
	
	//start filling the smarty object
	$smarty->append('downloads',
	    	 array('demo_download_id' => $downloads['demo_download_id'],
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
$smarty->assign('demos_upload_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();
?>
