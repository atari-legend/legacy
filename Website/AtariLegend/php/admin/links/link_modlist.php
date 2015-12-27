<?php
/***************************************************************************
*                                link_modlist.php
*                            -----------------------
*   begin                : Saturday, Jan 08, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : re-creation of code from scratch into new file.
*							
*
*   Id: link_modlist.php,v 0.10 2005/01/08 Silver Surfer
*   Id: link_modlist.php,v 0.20 2015/09/12 ST Graveyard
*   Id: link_modlist.php,v 0.30 2015/12/24 ST Graveyard - Add right side in 1920
*
***************************************************************************/

/*
***********************************************************************************
In this section we modify links
***********************************************************************************
*/

include("../../includes/common.php");
include("../../includes/quick_search_games.php");
include("../../includes/admin.php");

if(empty($catpick)) 
{
	$catpick=1;
}
	
$SQL = "SELECT website_category_id, website_category_name FROM website_category ORDER BY website_category_name";
$linkcategorysql = $mysqli->query($SQL) or die("Couldn't query categories");

list($website_category_id,$website_category_name) = $linkcategorysql->fetch_array(MYSQLI_BOTH);

mysqli_data_seek($linkcategorysql,0) or die("what happend?");
while (list($category_id,$category_name) = $linkcategorysql->fetch_array(MYSQLI_BOTH)) 
{
	if ($category_id==$website_category_id) 
	{
		$selected="SELECTED";
	}
	else 
	{
		$selected="";
	}

	if ($catpick==$category_id) 
	{
		$selected="SELECTED";
	}
	else 
	{
		$selected="";
	}

	$smarty->append('category',
		array('category_id' => $category_id,
			'category_name' => $category_name,
			'selected' => $selected));
} 


if(isset($catpick)) 
{
	$website_category_id=$catpick;
}

$LINKSQL = $mysqli->query("SELECT * FROM website 
						LEFT JOIN website_description ON (website.website_id = website_description.website_id)
						LEFT JOIN website_category_cross ON (website.website_id = website_category_cross.website_id) 
						WHERE website_category_cross.website_category_id=$website_category_id ORDER by website.website_name")
		   or die ("Couldn't query website and website description");


while  ($rowlink = $LINKSQL->fetch_array(MYSQLI_BOTH)) 
{  
	$timestamp = convert_timestamp($rowlink['website_date']); 
	$submitted = get_username_from_id($rowlink['website_user_sub']);
	$website_image = $website_image_path;
	$website_image .= $rowlink['website_id'];
	$website_image .= ".";
	$website_image .= $rowlink['website_imgext'];
	
	$smarty->append('link_list',
			array('website_id' => $rowlink['website_id'],
				  'website_name' => $rowlink['website_name'],
				  'website_url' => $rowlink['website_url'],
				  'website_description' => $rowlink['website_description_text'],
				  'website_image' => $website_image,
				  'timestamp' => $timestamp,
				  'submitted' => $submitted,
				  'website_imgext' => $rowlink['website_imgext']));
}

$smarty->assign('left_nav', 'leftnav_position_linkmodlist');
$smarty->assign('quick_search_games', 'quick_search_games_linkmodlist');	

//Send all smarty variables to the templates
$smarty->display('file:../../../templates/html/admin/link_modlist.html');
?>
