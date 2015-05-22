<?php
/***************************************************************************
*                                link_cat_mod.php
*                            -----------------------
*   begin                : Saturday, April 24, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: link_ca_mod.php,v 0.10 2005/04/24 Silver Surfer
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
		
		$rowcat=$CATSQL->fetch_array(MYSQLI_BOTH);
		
		$smarty->assign('category',
	    array('category_name' => $rowcat['website_category_name'],
			  'category_id' => $rowcat['website_category_id']));
	
	// Do the category selector
	$RESULT=$mysqli->query("SELECT * FROM website_category ORDER BY website_category_name");

	$sel='';
	
	while ($rowlinkcat=$RESULT->fetch_array(MYSQLI_BOTH)) 
	{ 
		$sel='';
			if($rowcat['parent_category']==$rowlinkcat['website_category_id']) 
			{
				$sel="SELECTED"; 
			}
		
		$smarty->append('category_list',
	    			array('category_id' => $rowlinkcat['website_category_id'],
						  'category_name' => $rowlinkcat['website_category_name'],
						  'selected' => $sel));
	} 

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/link_cat_mod.html');
?>
