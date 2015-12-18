<?php
/***************************************************************************
*                            magazine_issue_edit.php
*                            -----------------------
*   begin                : Saturday, May 01, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: magazine_issue_edit.php,v 1.10 2005/09/11 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
Add Magazine screens!
***********************************************************************************
*/

include("../../includes/common.php");

	$sql = $mysqli->query("SELECT * FROM magazine
						LEFT JOIN magazine_issue ON (magazine.magazine_id = magazine_issue.magazine_id)
						WHERE magazine_issue_id='$magazine_issue_id'") or die ("Error retriving magazines issue");
	$fetch = $sql->fetch_array(MYSQLI_BOTH);

	if ($fetch['magazine_issue_imgext']!="") 

		{ 
			$scan="1";
			$magazine_image  = $magazine_scan_path;
			$magazine_image .= $fetch['magazine_issue_id'];
			$magazine_image .= '.';
			$magazine_image .= $fetch['magazine_issue_imgext'];
 
		} 
		else 
		{ 
			$scan="";
			 $magazine_image="";
		}
	
		$smarty->assign('magazine',
	   			  array('magazine_id' => $fetch['magazine_id'],
					    'magazine_name' => $fetch['magazine_name'],
						'magazine_issue_id' => $fetch['magazine_issue_id'],
						'magazine_issue_nr' => $fetch['magazine_issue_nr'],
						'scan' => $scan,
						'magazine_image' => $magazine_image));
 
//Send all smarty variables to the templates
$smarty->display('file:../../../templates/html/admin/magazine_issue_edit.html');
?>
