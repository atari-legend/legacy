<?
/***************************************************************************
*                                user_detail.php
*                            -----------------------
*   begin                : friday, November 11, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : file creation
*							
*
*   Id: user_detail.php,v 0.10 2005/05/01 ST Graveman
*
***************************************************************************/

/*
***********************************************************************************
This is the user detail page
***********************************************************************************
*/
// include common variables and functions
include("../includes/common.php");
include("../includes/config.php");

if (empty($action)) {$action='';} 

// Here we add the website image
if ($action == 'avatar_upload')
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
				mysql_query("UPDATE users SET avatar_ext='$ext' WHERE user_id='$user_id_selected'");
				$file_data = rename("$tmp_name", "$user_avatar_path$user_id_selected.$ext");
				chmod("$user_avatar_path$user_id_selected.$ext", 0777);
			}
		
		// check for size specs
		$imginfo = getimagesize("$user_avatar_path$user_id_selected.$ext") or die("getimagesize not working");
		$width = $imginfo[0];
		$height = $imginfo[1];
		
		if ($width<101 and $height<101)
		{
		
		}
		else
		{
		$smarty->assign('message', 'Upload failed due to not confirming to specs.');
		mysql_query("UPDATE users SET avatar_ext='' WHERE user_id='$user_id_selected'");
		unlink ("$user_avatar_path$user_id_selected.$ext");
		}
	}
}

//Delete avatar

if ($action=="delete_avatar")
{

$sql = "SELECT avatar_ext FROM users WHERE user_id='$user_id_selected'";
	$avatar_query = mysql_query($sql);
	list ($avatar_ext) = mysql_fetch_row($avatar_query);
	
	mysql_query("UPDATE users SET avatar_ext='' WHERE user_id='$user_id_selected'");
	unlink ("$user_avatar_path$user_id_selected.$avatar_ext");

}

if ($action == 'reset_pwd')
{
	mysql_query("UPDATE users SET password='' WHERE user_id='$user_id_selected'");
}

if ($action == 'modify_user')
{
	if ( $user_pwd != '' )
	{
		$md5pass = md5($user_pwd);
		echo $md5pass;
		mysql_query("UPDATE users SET userid='$user_name', password='$md5pass', email='$user_email', permission='$user_permission', user_website='$user_website', user_icq='$user_icq', user_msnm='$user_msnm', user_aim='$user_aim' WHERE user_id='$user_id_selected'");
	}
	else
	{
		mysql_query("UPDATE users SET userid='$user_name', email='$user_email', permission='$user_permission', user_website='$user_website', user_icq='$user_icq', user_msnm='$user_msnm', user_aim='$user_aim' WHERE user_id='$user_id_selected'");
	}
}

if ($action == 'delete_user')
{
	//First we need to do a hell of a lot checks before we can delete an actual user.
	$sql = mysql_query("SELECT * FROM comments
						LEFT JOIN game_user_comments ON (comments.comments_id = game_user_comments.comment_id)
						LEFT JOIN game ON ( game_user_comments.game_id = game.game_id )
						WHERE comments.user_id = $user_id_selected");
	
	if ( mysql_num_rows($sql) > 0 )
	{
		$smarty->assign("message",'Deletion failed - This user has submitted game comments - Delete it in the appropriate section');
		
		$smarty->assign('user_id_selected', $user_id_selected);
	}
	else
	{
		$sql = mysql_query("SELECT * FROM review_main
							LEFT JOIN review_game ON (review_main.review_id = review_game.review_id)
							LEFT JOIN game ON ( review_game.game_id = game.game_id )
							WHERE review_main.member_id = $user_id_selected");
		
		if ( mysql_num_rows($sql) > 0 )
		{
			$smarty->assign("message",'Deletion failed - This user has submitted game reviews - Delete it in the appropriate section');
		}
		else
		{
			$sql = mysql_query("SELECT * FROM game_submitinfo 
				   				LEFT JOIN game ON (game_submitinfo.game_id = game.game_id)
								WHERE user_id = $user_id_selected");
			if ( mysql_num_rows($sql) > 0 )
			{
				$smarty->assign("message",'Deletion failed - This user has submitted game info - Delete it in the appropriate section');
			}
			else
			{
				$sql = mysql_query("SELECT * FROM website WHERE website_user_sub = $user_id_selected");
				
				if ( mysql_num_rows($sql) > 0 )
				{
					$smarty->assign("message",'Deletion failed - This user has submitted links - Delete it in the appropriate section');
				}
				else
				{
					$sql = mysql_query("SELECT * FROM news WHERE user_id = $user_id_selected");
				
					if ( mysql_num_rows($sql) > 0 )
					{
						$smarty->assign("message",'Deletion failed - This user has submitted news updates - Delete it in the appropriate section');
					}
					else
					{
						$sql = mysql_query("SELECT * FROM comments
						LEFT JOIN demo_user_comments ON (comments.comments_id = demo_user_comments.comment_id)
						LEFT JOIN demo ON ( demo_user_comments.demo_id = demo.demo_id )
						WHERE comments.user_id = $user_id_selected");
	
						if ( mysql_num_rows($sql) > 0 )
						{
							$smarty->assign("message",'Deletion failed - This user has submitted demo comments - Delete it in the appropriate section');
						}
						else
						{
							mysql_query("DELETE from users WHERE user_id='$user_id_selected'") or die ('deleting user failed');
	
							$smarty->assign('message', 'User deleted succesfully');
							$smarty->assign('user_main_tpl', '1');

							//Send all smarty variables to the templates
							$smarty->display('file:../templates/0/index.tpl');
						}
					}
				}
			}
		}
	}
}

//Lets get all the date of the selected user
	$sql_users = mysql_query("SELECT * FROM users 
		  					  WHERE user_id = $user_id_selected")
		 	     or die ("Couldn't query users Database");
	
	while ($query_users = mysql_fetch_array($sql_users))  
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
		if ($query_users['avatar_ext']!=="")
		{
		$imginfo = getimagesize("$user_avatar_path$user_id_selected.$query_users[avatar_ext]");
		$width = $imginfo[0];
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
							  'width' => $width,
							  'image' => "$user_avatar_path$query_users[user_id].$query_users[avatar_ext]",
							  'user_aim' => $query_users['user_aim']));
	}

$smarty->assign('user_detail_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();
?>
