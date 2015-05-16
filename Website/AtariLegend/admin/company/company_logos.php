<?php
/***************************************************************************
*                                company_logos.php
*                            -----------------------
*   begin                : Sunday, August 7, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : Creation of file
*   Id: company_logos.php,v 0.10 2005/08/07 14:40 Gatekeeper
*							
*
*   Id: company_logos.php,v 0.10 2005/08/07 Grave
*
***************************************************************************

***************************************************************************
A little logo preview page
***************************************************************************/

include("../includes/common.php");

$sql_logos = mysql_query ("SELECT *
				  			FROM pub_dev 
				  			LEFT JOIN pub_dev_text ON (pub_dev.pub_dev_id = pub_dev_text.pub_dev_id) 
				  			WHERE pub_dev_text.pub_dev_imgext <> 'NULL'
				  			ORDER BY pub_dev.pub_dev_name");

while ( $logos = mysql_fetch_array($sql_logos) )
{

	
	$company_image  = $company_screenshot_path;
	$company_image .= $logos['pub_dev_id'];
	$company_image .= '.';
	$company_image .= $logos['pub_dev_imgext'];

	$smarty->append('company',
	    	 array('comp_id' => $logos['pub_dev_id'],
			'company_image' => $company_image,
				   'comp_name' => $logos['pub_dev_name']));
}

$smarty->assign("user_id",$_SESSION['user_id']);
$smarty->assign('company_logos_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();
