<?
/***************************************************************************
*                                company_main.php
*                            --------------------------
*   begin                : Sunday, August 7, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : Creation of file
*   Id: company_main.php,v 0.10 2005/08/07 14:29 Gatekeeper
*
***************************************************************************/

/*
************************************************************************************************
The main company (developer/publisher) page
************************************************************************************************
*/

include("../includes/common.php");
include("../includes/config.php"); 

if (empty($action)) {$action='';}
//if we want to delete the individual (from the edit page)
if ( $action == 'delete_comp' )
{	
	// Here we delete the company image
	$sql = "SELECT pub_dev_imgext FROM pub_dev_text WHERE pub_dev_id='$comp_id'";
	$pub_dev_query = mysql_query($sql);
	list ($pub_dev_imgext) = mysql_fetch_row($pub_dev_query);
	
	if ( $pub_dev_imgext <> '' )
	{
		unlink ("$company_screenshot_path$comp_id.$pub_dev_imgext");
	}
	
	$sql = mysql_query("DELETE FROM pub_dev WHERE pub_dev_id = '$comp_id'");
	$sql = mysql_query("DELETE FROM pub_dev_text WHERE pub_dev_id = '$comp_id'");
	$sql = mysql_query("DELETE FROM game_developer WHERE dev_pub_id = '$comp_id'");
	$sql = mysql_query("DELETE FROM game_publisher WHERE pub_dev_id = '$comp_id'");

	// DUMPTABLE this isn't used anymore
	//$sql = mysql_query("UPDATE game_search SET publisher_name='', publisher_name='' WHERE publisher_id='$comp_id'") or die("Couldn't update dump table -publisher");
	//$sql = mysql_query("UPDATE game_search SET developer_name='', developer_name='' WHERE developer_id='$comp_id'") or die("Couldn't update dump table -developer");

	$message = "Company succesfully deleted";
	$smarty->assign("message",$message);
}

//Insert a new individual
if ( $action == "insert_comp" )
{	
	if ( $comp_name == '' )
	{
		$message = "Please fill in a company name";
		$smarty->assign("message",$message);
	}
	else
	{
		$sql = mysql_query("INSERT INTO pub_dev (pub_dev_name) VALUES ('$comp_name')");  

		//get the id of the inserted individual
		$COMPANY = mysql_query("SELECT pub_dev_id FROM pub_dev
	   					    	ORDER BY pub_dev_id desc")
				  or die ("Database error - selecting company");
		
		$pubdevrow = mysql_fetch_row($COMPANY);

		$id = $pubdevrow[0];	

		$sdbquery = mysql_query("INSERT INTO pub_dev_text (pub_dev_id, pub_dev_profile) VALUES ($id, '$textfield')") 
					or die("Couldn't insert into pub_dev_text");

		$message = "Company succesfully inserted";
		$smarty->assign("message",$message);
	}
}

//Get the companies
$sql_company = mysql_query("SELECT * FROM pub_dev ORDER BY pub_dev_name ASC")
			     or die ("Couldn't query Publisher and Developer database");
		
while  ($company=mysql_fetch_array($sql_company)) 
{  
	$smarty->append('company',
	    	 array('comp_id' => $company['pub_dev_id'],
				   'comp_name' => $company['pub_dev_name']));
}

$smarty->assign("user_id",$_SESSION['user_id']);
$smarty->assign('company_main_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();
?>
