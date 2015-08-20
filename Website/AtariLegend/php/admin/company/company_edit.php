<?php
/***************************************************************************
*                                company_edit.php
*                            --------------------------
*   begin                : Sunday, August 7, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : Creation of file
*   Id: company_edit.php,v 0.10 2005/08/07 14:40 Gatekeeper
*
***************************************************************************/

/*
************************************************************************************************
The company edit page
************************************************************************************************
*/

include("../includes/common.php");

if ($comp_id == '-')
{
		$message = 'please select a publsiher/developer';
		$smarty->assign("message",$message);
		
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
		$smarty->assign('company_main_tpl', '1');

		//Send all smarty variables to the templates
		$smarty->display('../templates/0/index.html');
}
else
{
//Get the company data
$sql_company = $mysqli->query("SELECT * FROM pub_dev 
						    LEFT JOIN pub_dev_text ON (pub_dev.pub_dev_id = pub_dev_text.pub_dev_id )
							WHERE pub_dev.pub_dev_id=$comp_id");

while  ($company=$sql_company->fetch_array(MYSQLI_BOTH))  
{  
	//The interviewed person's picture
	if ( $company['pub_dev_imgext'] == 'png' or  
		 $company['pub_dev_imgext'] == 'jpg' or 
		 $company['pub_dev_imgext'] == 'gif')
	{
		$v_ind_image  = $company_screenshot_path;
		$v_ind_image .= $comp_id;
		$v_ind_image .= '.';
		$v_ind_image .= $company['pub_dev_imgext'];
	}
	else
	{
		$v_ind_image = "none";
	}

	$smarty->assign('company',
	    	 array('comp_id' => $comp_id,
				   'comp_name' => $company['pub_dev_name'],
				   'comp_profile' => $company['pub_dev_profile'],
				   'comp_screenshot_path' => $company_screenshot_path,
				   'comp_image' => $v_ind_image));
}

$smarty->assign("user_id",$_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/company_edit.html');
}

//close the connection
mysqli_close($mysqli);
?>
