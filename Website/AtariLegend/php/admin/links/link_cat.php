<?php
/***************************************************************************
*                                link_cat.php
*                            -----------------------
*   begin                : Saturday, Jan 08, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: link_mod.php,v 0.10 2005/01/08 Silver Surfer
*   Id: link_mod.php,v 0.20 2015/10/01 STG
*
***************************************************************************/

/*
***********************************************************************************
In this section we modify links
***********************************************************************************
*/

include("../../includes/common.php");

//****************************************************************************************
// Delete the categorie from the tables
//**************************************************************************************** 
if (isset($action) and $action=="del_cat")
{
	//check if the categorie has some websites linked to it
	$website_count = $mysqli->query("SELECT website_id FROM website_category_cross WHERE website_category_id = '$category_id'");
	$nr_of_links = get_rows($website_count);
	
	if ($nr_of_links == 0)
	{
		$sql = $mysqli->query("DELETE FROM website_category WHERE website_category_id = '$category_id'") or die("Failed to delete category");
		$smarty->assign('message', 'Category deleted');
	}
	else
	{
		$smarty->assign('message', 'Category still has websites linked to it');
	}	
}

$website = $mysqli->query("SELECT website_category_id, website_category_name FROM website_category ORDER by website_category_name");

while($category_row = $website->fetch_array(MYSQLI_BOTH))
{

	$website_count = $mysqli->query("SELECT website_id FROM website_category_cross WHERE website_category_id = '$category_row[website_category_id]'");
	$nr_of_links = get_rows($website_count);

	$smarty->append('category',
	array('category_name' => $category_row['website_category_name'],
		  'category_id' => $category_row['website_category_id'],
		  'category_count' => $nr_of_links));
} 

$smarty->assign('left_nav', 'leftnav_position_linkcat');

//Send all smarty variables to the templates
$smarty->display('file:../../../templates/html/admin/link_cat.html');
?>
