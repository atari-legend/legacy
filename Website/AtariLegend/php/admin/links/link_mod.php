<?php
/***************************************************************************
*                                link_mod.php
*                            -----------------------
*   begin                : Saturday, Jan 08, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: link_mod.php,v 0.10 2005/01/08 Silver Surfer
*   Id: link_mod.php,v 0.20 2015/09/27 STG
*
***************************************************************************/

/*
***********************************************************************************
In this section we modify links
***********************************************************************************
*/

include("../../includes/common.php");
include("../../includes/admin.php");


$LINKSQL = $mysqli->query("SELECT * FROM website
				LEFT JOIN website_description ON (website.website_id = website_description.website_id)
				WHERE website.website_id='$website_id'")
		   or die ("Error while querying the links database");

$rowlink= $LINKSQL->fetch_array(MYSQLI_BOTH);

	$website_image = $website_image_path;
	$website_image .= $rowlink['website_id'];
	$website_image .= ".";
	$website_image .= $rowlink['website_imgext'];



$smarty->assign('website',
array('website_name' => $rowlink['website_name'],
	  'website_url' => $rowlink['website_url'],
	  'website_id' => $rowlink['website_id'],
//	  'category_id' => $rowlink['website_category_id'],
	  'website_description_text' => $rowlink['website_description_text'],
	  'website_imgext' => $rowlink['website_imgext'],
	  'website_image' => $website_image));

//get the categories of this website
$website = $mysqli->query("SELECT * FROM website_category_cross
					LEFT JOIN website_category ON (website_category_cross.website_category_id = website_category.website_category_id)
					WHERE website_category_cross.website_id = '$website_id'");

while($category_row = $website->fetch_array(MYSQLI_BOTH))
{
	$smarty->append('website_category',
	array('category_name' => $category_row['website_category_name'],
		  'category_id' => $category_row['website_category_id']));
}

//check if the categorie has some websites linked to it
$website_count = $mysqli->query("SELECT * FROM website_category_cross WHERE website_id = '$website_id'");
$nr_of_cats = get_rows($website_count);

$smarty->assign('nr_of_cats', $nr_of_cats);
	  
// Do the category selector
$RESULT=$mysqli->query("SELECT * FROM website_category ORDER BY website_category_name");

$sel='';

while ($rowlinkcat = $RESULT->fetch_array(MYSQLI_BOTH)) 
{ 
/* 	$sel='';
		if($rowlink['website_category_id']==$rowlinkcat['website_category_id']) 
		{
			$sel="SELECTED"; 
		} */
	
	$smarty->append('category',
				array('category_id' => $rowlinkcat['website_category_id'],
					  'category_name' => $rowlinkcat['website_category_name'],
						  'selected' => $sel));
} 

$smarty->assign('left_nav', 'leftnav_position_linkmod');

//Send all smarty variables to the templates
$smarty->display('file:../../../templates/html/admin/link_mod.html');

?>
