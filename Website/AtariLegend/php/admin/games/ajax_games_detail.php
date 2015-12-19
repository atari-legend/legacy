<?php
/***************************************************************************
*                             ajax_games_detail.php
*                            -----------------------
*   begin                : July 2015
*   copyright            : (C) 2015 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : Creation
						   
*							
*
*   Id: ajax_games_detail.php,v 0.2 2015/07 Silver Surfer
*   Id: ajax_games_detail.php,v 0.3 2015/11/06 STG
*
***************************************************************************/

/*
***********************************************************************************
Build game series page
***********************************************************************************
*/
extract($_REQUEST);
include("../../includes/connect.php");
include("../includes/config.php");
include("../includes/config_smarty.php");
include("../includes/constants.php");
				
	if (isset($action) and $action=="company_publisher_browse")
	{
				
				// Do a simple gamesearch... no aka's or the likes of that.
				
					if (isset($query) and $query == "num")
					{
						$gamebrowse_select = " WHERE pub_dev_name REGEXP '^[0-9].*'";
					}
					else
					{
					$gamebrowse_select = " WHERE pub_dev_name LIKE '$query%'";
					}
				
				$sql_build = "SELECT * FROM pub_dev ";

				$sql_build .= $gamebrowse_select;
				$sql_build .= " ORDER BY pub_dev_name ASC";

				$query = $mysqli->query($sql_build)
				 		   		 	or die ("Couldn't query company Database ($sql_build)");
				
				$smarty->assign('smarty_action', 'company_list');
				
				while  ($query_company = $query->fetch_array(MYSQLI_BOTH)) 
				{ 		// This smarty is used for creating the list of games contained within a game series
						$smarty->append('company',
	    				array('company_id' => $query_company['pub_dev_id'],
						  	  'company_name' => $query_company['pub_dev_name']));
				}



	}


//Send all smarty variables to the templates
$smarty->display('file:../../../templates/html/admin/ajax_games_detail.html');
?>
