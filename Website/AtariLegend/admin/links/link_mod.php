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
*
***************************************************************************/

/*
***********************************************************************************
In this section we modify links
***********************************************************************************
*/

include("../includes/common.php");


		$LINKSQL = mysql_query("SELECT * FROM website
								LEFT JOIN website_description ON (website.website_id = website_description.website_id)
								LEFT JOIN website_category_cross ON (website.website_id = website_category_cross.website_id)
								LEFT JOIN website_category ON (website_category_cross.website_category_id  = website_category.website_category_id )
	 							WHERE website.website_id='$website_id'")
				   or die ("Error while querying the links database");
		
		$rowlink=mysql_fetch_array ($LINKSQL);
		
			$website_image = $website_image_path;
			$website_image .= $rowlink['website_id'];
			$website_image .= ".";
			$website_image .= $rowlink['website_imgext'];



		$smarty->assign('website',
	    array('website_name' => $rowlink['website_name'],
			  'website_url' => $rowlink['website_url'],
			  'website_id' => $rowlink['website_id'],
			  'category_id' => $rowlink['website_category_id'],
			  'website_description_text' => $rowlink['website_description_text'],
			  'website_imgext' => $rowlink['website_imgext'],
			  'website_image' => $website_image));
	
	// Do the category selector
	$RESULT=mysql_query("SELECT * FROM website_category ORDER BY website_category_name");

	$sel='';
	
	while ($rowlinkcat=mysql_fetch_array($RESULT)) 
	{ 
		$sel='';
			if($rowlink['website_category_id']==$rowlinkcat['website_category_id']) 
			{
				$sel="SELECTED"; 
			}
		
		$smarty->append('category',
	    			array('category_id' => $rowlinkcat['website_category_id'],
						  'category_name' => $rowlinkcat['website_category_name'],
						  'selected' => $sel));
	} 

$smarty->assign('link_mod_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
?>
