<?php
/***************************************************************************
*                                link_cat_del.php
*                            -----------------------
*   begin                : Saturday, April 25, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: link_ca_del.php,v 0.10 2005/04/25 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
In this section we modify links
***********************************************************************************
*/

include("../includes/common.php");


		$CATSQL = $mysqli->query("SELECT * FROM website_category
								WHERE website_category_id='$category_id'")
				   or die ("Error while querying the category database");
		
		$rowcat=mysql_fetch_array ($CATSQL);
		
		$smarty->assign('category',
	    array('category_name' => $rowcat['website_category_name'],
			  'category_id' => $rowcat['website_category_id']));
	
	// count links in the category
	
	$website = $mysqli->query ("SELECT website_category_id FROM website_category_cross WHERE website_category_id='$category_id'");
	
	$website_count = get_rows($website); // count how many links there are within a category
	
		$smarty->assign('website_count',
	    array('count' => $website_count));
	
	// Do the category selector
	$RESULT=$mysqli->query("SELECT * FROM website_category ORDER BY website_category_name");

	while ($rowlinkcat=$RESULT->fetch_array(MYSQLI_BOTH)) 
	{ 
		$sel='';
			if($rowcat['website_category_id']!==$rowlinkcat['website_category_id']) 
			{
				$smarty->append('category_list',
	    			array('category_id' => $rowlinkcat['website_category_id'],
						  'category_name' => $rowlinkcat['website_category_name']));
			}
	} 

$smarty->assign('link_cat_del_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');




?>
