<?/***************************************************************************
*                                news_add_images.php
*                            ---------------------------
*   begin                : Sunday, May 1, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : File creation
*							 
*							
*
*   Id: news_add_images.php,v 0.10 2004/05/01 ST Graveyard
*
***************************************************************************/

/*
***********************************************************************************
In this section we can add or delete a newsimage
***********************************************************************************
*/

include("../includes/common.php");
include("../includes/config.php"); 


if ($action=="image_upload")
{
//****************************************************************************************
// This is where we handle the uploaded images and rename them and save them to db and hd
//**************************************************************************************** 

if(isset($news_image))
{
	$file_ext=$_FILES['news_image']['type'];

	if ($file_ext=='image/jpeg')
	{
		$ext='jpg';
	}
	elseif ($file_ext=='image/gif')
	{
		$ext='gif';
	}
	elseif ($file_ext=='image/x-png')
	{
		$ext='png';
	}
	elseif ($file_ext=='image/png')
	{
		$ext='png';
	}
		
	if (isset($ext))
	{
		if ($image_name=='')
		{
			$message = "You forgot to add an image comment!";
		}
		else
		{
		$file_name=$_FILES['news_image']['name'];
		$file_name_tmp=$_FILES['news_image']['tmp_name'];
		// Debug
		//echo "$file_name";
		//print_r($news_image);
		//exit;
			
			// Insert the description and the image into the news_image table.
			$sdbquery = mysql_query("INSERT INTO news_image (news_image_name,news_image_ext) VALUES ('$image_name','$ext')")
		 				or die("Couldn't insert image!");
		
			//select the newly created news_image_id from the news_image table
			$NEWS = mysql_query("SELECT news_image_id FROM news_image
	   					   		 ORDER BY news_image_id desc")
					or die ("Database error - selecting news_image_id");
		
			$newsimagerow = mysql_fetch_row($NEWS);
		
			// Rename the uploaded file to its autoincrement number and move it to its proper place.
			$file_data = rename("$file_name_tmp", "$news_images_path$newsimagerow[0].$ext");
		
			chmod("$news_images_path$newsimagerow[0].$ext", 0777);
		}
	}
	else
	{
		$message = "Filetype not supported";
	}

	mysql_close();
	}
}

$smarty->assign('message', $message);
$smarty->assign('news_add_images_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();
?>