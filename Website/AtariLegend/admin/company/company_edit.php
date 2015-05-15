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
include("../includes/config.php"); 

if ($comp_id == '-')
{
		$message = 'please select a publsiher/developer';
		$smarty->assign("message",$message);
		
		//Get the companies
		$sql_company = mysql_query("SELECT * FROM pub_dev ORDER BY pub_dev_name ASC")
				       or die ("Couldn't query Publisher and Developer database");
		
		while  ($company=mysql_fetch_array($sql_company)) 	
		{  
			$smarty->append('company',
	    		 array('comp_id' => $company[pub_dev_id],
					   'comp_name' => $company[pub_dev_name]));
		}

		$smarty->assign("user_id",$_SESSION[user_id]);
		$smarty->assign('company_main_tpl', '1');

		//Send all smarty variables to the templates
		$smarty->display('file:/var/www/atarilegend/admin_new/templates/0/index.tpl');
}
else
{
// Here we delete the company logo image
if ( $action == 'delete_logo' )
{
	
	$sql = "SELECT pub_dev_imgext FROM pub_dev_text WHERE pub_dev_id='$comp_id'";
	$pub_dev_query = mysql_query($sql);
	list ($pub_dev_imgext) = mysql_fetch_row($pub_dev_query);

	mysql_query("UPDATE pub_dev_text SET pub_dev_imgext='' WHERE pub_dev_id='$comp_id'");
	unlink ("$company_screenshot_path$comp_id.$pub_dev_imgext");
}

//If we want to upload a logo
if ( $action == 'add_logo' )
{
	
	$image = $_FILES['company_pic'];

	$tmp_name=$image['tmp_name']; 

	if ($tmp_name!=='none')
	{
	// Check what extention the file has and if it is allowed.
	
		$ext="";
		$type_image = $image['type'];
		
		// set extension
		if ( $type_image=='image/x-png')
			{
				$ext='png';
			}
		
		elseif ( $type_image=='image/png')
			{
				$ext='png';
			}
			
		elseif ( $type_image=='image/gif')
			{
				$ext='gif';
			} 
		elseif ( $type_image=='image/pjpeg')
			{
				$ext='jpg';
			} 
		
		 if ($ext!=="")
		 	{
			
       			// Rename the uploaded file to its autoincrement number and move it to its proper place.
	  			 $query = mysql_query("SELECT * FROM pub_dev_text WHERE pub_dev_id='$comp_id'");
	   
	  			 $num_row = get_rows($query);
	   
	 			  if ( $num_row==0 )
	   			  {
	   			  	mysql_query("INSERT INTO pub_dev_text (pub_dev_id,pub_dev_imgext) VALUES ('$comp_id','$ext')");
	 			  }
	   			  else
	     	      {
	  	 			 mysql_query("UPDATE pub_dev_text SET pub_dev_imgext='$ext' WHERE pub_dev_id='$comp_id'");
	   			  }
	   
	  			  $file_data = rename("$tmp_name", "$company_screenshot_path$comp_id.$ext");
	
				  chmod("$company_screenshot_path$comp_id.$ext", 0777);
			}
	}
}

//update the info of the individual
if ( $action == 'update' )
{
	$sdbquery = mysql_query("UPDATE pub_dev SET pub_dev_name = '$comp_name' WHERE pub_dev_id = $comp_id")
				or die("Couldn't Update into pub_dev");
	// DUMPTABLE 
	$sql = mysql_query("UPDATE game_search SET publisher_name='$comp_name' WHERE publisher_id='$comp_id'") or die("Couldn't dump table -publisher");
	$sql = mysql_query("UPDATE game_search SET developer_name='$comp_name' WHERE developer_id='$comp_id'") or die("Couldn't dump table -developer");
	// END DUMPTABLE
			
	$COMPANYtext = mysql_query("SELECT pub_dev_id FROM pub_dev_text 
								WHERE pub_dev_id = $comp_id")
			  or die ("Database error - selecting pub_dev_text");
		
	$pubdevrowtext = mysql_numrows($COMPANYtext);

	if ( $pubdevrowtext < 1 )
	{
		$sdbquery = mysql_query("INSERT INTO pub_dev_text (pub_dev_id, pub_dev_profile) VALUES ($comp_id, '$textfield')") 
					or die("Couldn't insert into pub_dev_text");
	}
	else
	{
		$sdbquery = mysql_query("UPDATE pub_dev_text SET pub_dev_profile = '$textfield' WHERE pub_dev_id = $comp_id")
					or die("Couldn't Update into pub_dev_text");
	}
	
	$message = 'Company succesfully updated';
	$smarty->assign("message",$message);
}

//Get the company data
$sql_company = mysql_query("SELECT * FROM pub_dev 
						    LEFT JOIN pub_dev_text ON (pub_dev.pub_dev_id = pub_dev_text.pub_dev_id )
							WHERE pub_dev.pub_dev_id=$comp_id");

while ( $company=mysql_fetch_array($sql_company) ) 
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
$smarty->assign('company_edit_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
}

//close the connection
mysql_close();
?>
