<?php
/***************************************************************************
*                                user_detail.php
*                            -----------------------
*   begin                : friday, November 11, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : file creation
*							
*
*   Id: user_detail.php,v 0.20 2015/08/22 ST Graveman
*
***************************************************************************/

/*
***********************************************************************************
This is the user detail page
***********************************************************************************
*/
// include common variables and functions
include("../../includes/common.php");

// Here we add the website image
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

//Lets get all the date of the selected user
	$sql_users = $mysqli->query("SELECT * FROM users 
							  WHERE user_id = $user_id_selected")
				 or die ("Couldn't query users Database");
	
	while ($query_users = $sql_users->fetch_array(MYSQLI_BOTH))
	{
		$email = trim($query_users['email']);
		
		if ($query_users['join_date']!=='')
		{
		$join_date = convert_timestamp($query_users['join_date']);
		}
		if ($query_users['last_visit']!=='')
		{
		$last_visit = convert_timestamp($query_users['last_visit']);
		}
		$smarty->assign('users',
						array('user_id' => $query_users['user_id'],
							  'user_name' => $query_users['userid'],
							  'user_pwd' => $query_users['password'],
							  'user_email' => $query_users['email'],
							  'user_permission' => $query_users['permission'],
							  'user_website' => $query_users['user_website'],
							  'user_icq' => $query_users['user_icq'],
							  'user_msnm' => $query_users['user_msnm'],
							  'avatar_ext' => $query_users['avatar_ext'],
							  'image' => "$user_avatar_path$query_users[user_id].$query_users[avatar_ext]",
							  'user_aim' => $query_users['user_aim']));
	}
	
$smarty->assign('left_nav', 'leftnav_position_userdetails');	

//Send all smarty variables to the templates
$smarty->display('extends:../../../templates/html/admin/main.html|../../../templates/html/admin/frontpage.html|../../../templates/html/admin/left_nav.html|../../../templates/html/admin/user_detail.html');


//close the connection
mysqli_close($mysqli);
?>
