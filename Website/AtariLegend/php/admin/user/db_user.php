<?php
/***************************************************************************
*                                db_user.php
*                            -----------------------
*   begin                : friday, November 11, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : file creation
*							
*
*
***************************************************************************/

/*
***********************************************************************************
This is the database modification area for the cpanel
***********************************************************************************
*/
// include common variables and functions
include("../../includes/common.php");
include("../../includes/admin.php");

// Here we add the avatar image
if (isset($action) and $action == 'avatar_upload')
{	
	$image = $_FILES['image'];
	
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
				// Rename the uploaded file to the users id number and move it to its proper place.
				$mysqli->query("UPDATE users SET avatar_ext='$ext' WHERE user_id='$user_id_selected'");
				$file_data = rename("$tmp_name", "$user_avatar_save_path$user_id_selected.$ext");
				chmod("$user_avatar_save_path$user_id_selected.$ext", 0777);
			}
		
		// check for size specs
		$imginfo = getimagesize("$user_avatar_save_path$user_id_selected.$ext") or die("getimagesize not working");
		$width = $imginfo[0];
		$height = $imginfo[1];
		
		if ($width<101 and $height<101)
		{
		
		}
		else
		{
		$smarty->assign('message', 'Upload failed due to not confirming to specs.');
		$mysqli->query("UPDATE users SET avatar_ext='' WHERE user_id='$user_id_selected'");
		unlink ("$user_avatar_save_path$user_id_selected.$ext");
		}
	}
}

//Delete avatar

if (isset($action) and $action=="delete_avatar")
{

$sql = "SELECT avatar_ext FROM users WHERE user_id='$user_id_selected'";
	$avatar_query = $mysqli->query($sql);
	list ($avatar_ext) = $avatar_query->fetch_array(MYSQLI_BOTH);
	
	$mysqli->query("UPDATE users SET avatar_ext='' WHERE user_id='$user_id_selected'");
	unlink ("$user_avatar_save_path$user_id_selected.$avatar_ext");

}

if (isset($action) and $action == 'reset_pwd')
{
	$mysqli->query("UPDATE users SET password='' WHERE user_id='$user_id_selected'");
}

if (isset($action) and $action == 'modify_user')
{
	if ( isset($user_pwd) && $user_pwd != '' )
	{
			$md5pass = md5($user_pwd);
			$mysqli->query("UPDATE users SET userid='$user_name', password='$md5pass', email='$user_email', permission='$user_permission', user_website='$user_website', user_icq='$user_icq', user_msnm='$user_msnm', user_aim='$user_aim' WHERE user_id='$user_id_selected'");
	}
	else
	{
			$mysqli->query("UPDATE users SET userid='$user_name', email='$user_email', permission='$user_permission', user_website='$user_website', user_icq='$user_icq', user_msnm='$user_msnm', user_aim='$user_aim' WHERE user_id='$user_id_selected'");
	}
}

	header("Location: ../user/user_detail.php");

//close the connection
mysqli_close($mysqli);
?>
