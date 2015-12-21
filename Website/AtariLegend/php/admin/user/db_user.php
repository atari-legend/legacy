<?php
/***************************************************************************
*                                db_user.php
*                            -----------------------
*   begin                : friday, November 11, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : file creation
*							
*   Id: db_user.php,v 1.01 2015/12/21 ST Graveyard - Added messages
*												   - Added more SQL statements
*
***************************************************************************/

/*
***********************************************************************************
This is the database modification area for the cpanel
***********************************************************************************
*/
// include common variables and functions
include("../../includes/common.php");

//****************************************************************************************
// add avatar
//**************************************************************************************** 
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
		$_SESSION['edit_message'] = "Avatar added"
		}
	}
}

//****************************************************************************************
// delete avatar
//**************************************************************************************** 
if (isset($action) and $action=="delete_avatar")
{

$sql = "SELECT avatar_ext FROM users WHERE user_id='$user_id_selected'";
	$avatar_query = $mysqli->query($sql);
	list ($avatar_ext) = $avatar_query->fetch_array(MYSQLI_BOTH);
	
	$mysqli->query("UPDATE users SET avatar_ext='' WHERE user_id='$user_id_selected'");
	$_SESSION['edit_message'] = "Avatar deleted"
	unlink ("$user_avatar_save_path$user_id_selected.$avatar_ext");

}

//****************************************************************************************
// reset pwd
//**************************************************************************************** 
if (isset($action) and $action == 'reset_pwd')
{
	$mysqli->query("UPDATE users SET password='' WHERE user_id='$user_id_selected'");
	$_SESSION['edit_message'] = "Password reset"
}

//****************************************************************************************
// modify user
//**************************************************************************************** 
if (isset($action) and $action == 'modify_user')
{
	if ( isset($user_pwd) && $user_pwd != '' )
	{
			$md5pass = md5($user_pwd);
			$mysqli->query("UPDATE users SET userid='$user_name', password='$md5pass', email='$user_email', permission='$user_permission', user_website='$user_website', user_icq='$user_icq', user_msnm='$user_msnm', user_aim='$user_aim' WHERE user_id='$user_id_selected'");
			$_SESSION['edit_message'] = "User data modified"
	}
	else
	{
			$mysqli->query("UPDATE users SET userid='$user_name', email='$user_email', permission='$user_permission', user_website='$user_website', user_icq='$user_icq', user_msnm='$user_msnm', user_aim='$user_aim' WHERE user_id='$user_id_selected'");
			$_SESSION['edit_message'] = "User data modified"
	}
}

//****************************************************************************************
// delete user
//**************************************************************************************** 
if (isset($action) and $action == 'delete_user')
{
	//First we need to do a hell of a lot checks before we can delete an actual user.
	$sql = $mysqli->query("SELECT * FROM comments
						LEFT JOIN game_user_comments ON (comments.comments_id = game_user_comments.comment_id)
						LEFT JOIN game ON ( game_user_comments.game_id = game.game_id )
						WHERE comments.user_id = '$user_id_selected'") or die ("error selecting game comments");
						
	if ( get_rows($sql) > 0 )
	{
		$_SESSION['edit_message'] = 'Deletion failed - This user has submitted game comments - Delete it in the appropriate section';
		
		$smarty->assign('user_id_selected', $user_id_selected);
	}
	else
	{
		$sql = $mysqli->query("SELECT * FROM review_main
							LEFT JOIN review_game ON (review_main.review_id = review_game.review_id)
							LEFT JOIN game ON ( review_game.game_id = game.game_id )
							WHERE review_main.member_id = '$user_id_selected'") or die ("error selecting game reviews");
		
		if ( get_rows($sql) > 0 )
		{
			$_SESSION['edit_message'] = 'Deletion failed - This user has submitted game reviews - Delete it in the appropriate section';
		}
		else
		{
			$sql = $mysqli->query("SELECT * FROM game_submitinfo 
				   				LEFT JOIN game ON (game_submitinfo.game_id = game.game_id)
								WHERE user_id = '$user_id_selected'") or die ("error selecting game info");
			if ( get_rows($sql) > 0 )
			{
				$_SESSION['edit_message'] = 'Deletion failed - This user has submitted game info - Delete it in the appropriate section';
			}
			else
			{
				$sql = $mysqli->query("SELECT * FROM website WHERE website_user_sub = '$user_id_selected'") or die ("error selecting links");
				
				if ( get_rows($sql) > 0 )
				{
					$_SESSION['edit_message'] = 'Deletion failed - This user has submitted links - Delete it in the appropriate section';
				}
				else
				{
					$sql = $mysqli->query("SELECT * FROM news WHERE user_id = '$user_id_selected'") or die ("error selecting news");
				
					if ( get_rows($sql) > 0 )
					{
						$_SESSION['edit_message'] = 'Deletion failed - This user has submitted news updates - Delete it in the appropriate section';
					}
					else
					{
					 	$sql = $mysqli->query("SELECT * FROM comments
						LEFT JOIN demo_user_comments ON (comments.comments_id = demo_user_comments.comments_id)
						LEFT JOIN demo ON ( demo_user_comments.demo_id = demo.demo_id )
						WHERE comments.user_id = $user_id_selected") or die ("error selecting demo comments");	
	
						if ( get_rows($sql) > 0 )
						{
							$_SESSION['edit_message'] = 'Deletion failed - This user has submitted demo comments - Delete it in the appropriate section';
						}
						else
						{
							$mysqli->query("DELETE from users WHERE user_id='$user_id_selected'") or die ('deleting user failed');
	
							$_SESSION['edit_message'] = 'User deleted succesfully';
 						}
					}
				}
			}
		}
	}
}

header("Location: ../user/user_detail.php");

//close the connection
mysqli_close($mysqli);
?>
