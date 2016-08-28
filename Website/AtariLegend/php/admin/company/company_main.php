<?php
/***************************************************************************
*                                company_main.php
*                            --------------------------
*   begin                : Sunday, August 7, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : Creation of file
*   Id: company_main.php,v 0.10 2005/08/07 14:29 Gatekeeper
*   Id: company_main.php,v 0.20 2016/07/31 22:49 Gatekeeper
*			- AL 2.0
*
***************************************************************************/

/*
************************************************************************************************
The main company (developer/publisher) page
************************************************************************************************
*/

include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php"); 

//Get the companies
$sql_company = $mysqli->query("SELECT * FROM pub_dev ORDER BY pub_dev_name ASC")
			     or die ("Couldn't query Publisher and Developer database");
		
while  ($company=$sql_company->fetch_array(MYSQLI_BOTH)) 
{  
	$smarty->append('company',
	    	 array('comp_id' => $company['pub_dev_id'],
				   'comp_name' => $company['pub_dev_name']));
}

$smarty->assign("user_id",$_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."company_main.html");

//close the connection
mysqli_close($mysqli);
?>
