<?php
/***************************************************************************
*                                link_validate.php
*                            -----------------------
*   begin                : Saturday, Jan 08, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: link_validate,v 0.10 2005/01/08 Silver Surfer
*
***************************************************************************/


//****************************************************************************************
// VALIDATE LINKS THAT HAVE SUBMITTED THROUGH THE FRONTPAGE
//****************************************************************************************


include("../includes/common.php");

$sql = "SELECT * FROM website_validate
		LEFT JOIN users ON (website_validate.user_id = users.user_id)";

$result = $mysqli->query($sql) or die("couldn't query website_validate");

if (get_rows($result)<1)

	{
		$section = "Validate links";
		$error_msg = "No links has been submitted.";
	
			$smarty->assign('error_msg',
	    			  array('section' => $section,
			  	  			'message' => $error_msg));
	
		$smarty->assign('error_message_tpl', '1');

	}
else
	{

 while ($valrow = $result->fetch_array(MYSQLI_BOTH))
 		{
		
		$link_sub = get_rows(mysql_query("SELECT website_user_sub FROM website WHERE website_user_sub='$valrow[user_id]'"));
		
		$website_date = convert_timestamp($valrow['website_date']); 
		$user_name = get_username_from_id($valrow['user_id']);
				
				$smarty->append('validate',
	    			array('website_id' => $valrow['website_id'],
						  'website_name' => $valrow['website_name'],
						  'website_url' => $valrow['website_url'],
						  'website_date' => $website_date,
						  'website_category' => $valrow['website_category'],
						  'website_description' => $valrow['website_description'],
						  'user_email' => $valrow['email'],
						  'link_sub' => $link_sub,
						  'user_name' => $user_name));
		}
	
	$sql_cat = "SELECT website_category_id,website_category_name FROM website_category
				ORDER BY website_category_name";

		$result_cat = $mysqli->query($sql_cat) or die("couldn't query website_category");
	
			while ($row_cat = $result_cat->fetch_array(MYSQLI_BOTH))
				{
				
				$smarty->append('category',
	    			array('website_category_id' => $row_cat['website_category_id'],
						  'website_category_name' => $row_cat['website_category_name']));
				}
	
	$smarty->assign('link_validate_tpl', '1');
	
	}

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
?>
