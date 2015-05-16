<?php
/***************************************************************************
*                                db_demos_submissions.php
*                            -------------------------------
*   begin                : Sunday, December 04, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : created this page
*
*   Id: db_demos_submissions.php,v 1.10 2005/09/19 Silver Surfer
*
***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../includes/common.php"); 

if($action=="update_submission")

{

//****************************************************************************************
// This is where the submissions get "sent" to "done"
//**************************************************************************************** 

if (isset($submit_id))
{
		$commentquery = mysql_query("UPDATE demo_submitinfo SET demo_done = '1' WHERE demo_submitinfo_id='$submit_id'") or die("couldn't update demo_submissions quote");
		
		$sql_user = mysql_query("SELECT user_id FROM demo_submitinfo WHERE demo_submitinfo_id='$submit_id'");
		
		list($user_id) = mysql_fetch_array($sql_user);
		$karma_action = "demo_submission";
		
		UserKarma($user_id,$karma_action);
}

header("Location: ../demos/submission_demos.php?v_counter=$v_counter");
}



// Delete
if($action=="delete_submission")

{

//****************************************************************************************
// This is the demo comment edit place
//**************************************************************************************** 

	if (isset($submit_id))
	{
		$sql = mysql_query("DELETE FROM demo_submitinfo WHERE demo_submitinfo_id = '$submit_id'") or die("couldn't delete demo_submissions quote");
	}


if ($list == "done")
{
header("Location: ../demos/submission_demos.php?v_counter=$v_counter&list=$list");
}
else
{
header("Location: ../demos/submission_demos.php?v_counter=$v_counter");
}
}
