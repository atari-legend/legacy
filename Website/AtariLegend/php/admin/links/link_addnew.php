<?php
/***************************************************************************
*                                link_addnew.php
*                            -----------------------
*   begin                : Monday, Aug 25, 2003
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: link_addnew.php,v 0.10 2005/01/08 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
In this section we can add a new link to the DB
***********************************************************************************
*/

include("../includes/common.php"); 


	$RESULT=$mysqli->query("SELECT * FROM website_category ORDER BY website_category_name");
	
	while ($rowlinkcat = $RESULT->fetch_array(MYSQLI_BOTH)) 
	{ 
		   			$smarty->append('website_category',
	    			array('website_category_id' => $rowlinkcat['website_category_id'],
						  'website_category_name' => $rowlinkcat['website_category_name']));
	} 

$smarty->assign("user_id",$_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/link_addnew.html');
?>