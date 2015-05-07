<?
/***************************************************************************
*                                magazine_edit.php
*                            -----------------------
*   begin                : Saturday, Sept 11, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: magazine_edit.php.php,v 1.10 2005/09/11 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
Edit Issues!
***********************************************************************************
*/

include("../includes/common.php");
include("../includes/config.php");

$sql_magazine = mysql_query("SELECT * FROM magazine WHERE magazine_id='$magazine_id'") or die ("Error retriving magazines info");
			
list ($magazine_id,$magazine_name) = mysql_fetch_row($sql_magazine); 
	
	$smarty->assign('magazine',
	   			  array('magazine_id' => $magazine_id,
					    'magazine_name' => $magazine_name));
			
			// Query for issues
			$sql = mysql_query("SELECT * FROM magazine_issue WHERE magazine_id='$magazine_id' ORDER BY magazine_issue_nr ASC") or die ("Error retriving issues");
			
			while ($fetch = mysql_fetch_array($sql)) 
			{

			if ($fetch['magazine_issue_imgext']!=='') { $scan = 'scan'; } else { $scan='No Scan'; }


			$smarty->append('issues',
	   			  	  array('magazine_issue_id' => $fetch['magazine_issue_id'],
					        'magazine_issue_nr' => $fetch['magazine_issue_nr'],
							'scan' => $scan));
			}
	
 
$smarty->assign('magazine_edit_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
?>
