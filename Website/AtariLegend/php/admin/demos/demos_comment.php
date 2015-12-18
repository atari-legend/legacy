<?php
/***************************************************************************
*                                demos_comment.php
*                            -----------------------
*   begin                : Sunday, november 13, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*							
*
*   Id: demos_comment.php,v 0.10 2005/11/13 Silver Surfer
*
***************************************************************************/

include("../../includes/common.php");

$v_counter= (isset($_GET["v_counter"]) ? $_GET["v_counter"] : 0);


//********************************************************************************************* 
// User comments
//*********************************************************************************************  

if ( isset($view) and $view == "users_comments" ) 
{ 
	$where_clause = "WHERE users.user_id = '$users_id'"; 
	
	//Build next/back links, part for users_comments only
	$users_comments = "&c_counter=$c_counter&users_id=$users_id&view=users_comments";

}
else { $where_clause = ""; $view = "latest_comments";}


$sql_build = "SELECT *
							FROM demo_user_comments
							LEFT JOIN comments ON ( demo_user_comments.comments_id = comments.comments_id )
							LEFT JOIN users ON ( comments.user_id = users.user_id )
							LEFT JOIN demo ON ( demo_user_comments.demo_id = demo.demo_id )
							 " . $where_clause . "
							ORDER BY comments.timestamp DESC LIMIT  " . $v_counter . ", 15";

$sql_comment = $mysqli->query($sql_build);

// get the total nr of comments in the DB
$query_total_number = $mysqli->query("SELECT * FROM demo_user_comments") or die ("Couldn't get the total number of comments");
$v_rows_total = $query_total_number->num_rows;
$smarty->assign('total_nr_comments', $v_rows_total);



// count number of comments
$query_number = $mysqli->query("SELECT * FROM demo_user_comments
							 LEFT JOIN comments ON ( demo_user_comments.comments_id = comments.comments_id )
							 LEFT JOIN users ON ( comments.user_id = users.user_id ) " . $where_clause) or die("Couldn't get the number of comments");

$v_rows = $query_number->num_rows;

$smarty->assign('nr_comments', $v_rows);


// lets put the comments in a smarty array
while ($query_comment = $sql_comment->fetch_array(MYSQLI_BOTH)) 
{
	
//Select a random screenshot record
	$query_demo = $mysqli->query("SELECT 
							   screenshot_demo.demo_id,
							   screenshot_demo.screenshot_id,
							   screenshot_main.imgext
						   	   FROM screenshot_demo 
						       LEFT JOIN screenshot_main ON (screenshot_demo.screenshot_id = screenshot_main.screenshot_id) 
							   WHERE screenshot_demo.demo_id = $query_comment[demo_id]						   	   
						   	   ORDER BY RAND() LIMIT 1"); 
							   
	$sql_demo = $query_demo->fetch_array(MYSQLI_BOTH);  

// Retrive userstats from database
	$query_user = $mysqli->query("SELECT *
							   FROM demo_user_comments
							   LEFT JOIN comments ON ( demo_user_comments.comments_id = comments.comments_id )
							   WHERE user_id = $query_comment[user_id]") or die ("Could not count user comments");
	$usercomment_number = $query_user->num_rows;
	
	$query_submitinfo = $mysqli->query("SELECT * FROM demo_submitinfo WHERE user_id = $query_comment[user_id]") 
						or die ("Could not count user submissions");
	$usersubmit_number = $query_submitinfo->num_rows;
	
	//Get the dataElements we want to place on screen
	$v_demo_image  = $demo_screenshot_path;
	$v_demo_image .= $sql_demo['screenshot_id'];
	$v_demo_image .= '.';
	$v_demo_image .= $sql_demo['imgext'];
	
	$oldcomment = $query_comment['comment'];

	$oldcomment = InsertALCode($oldcomment);
	$oldcomment = InsertSmillies($oldcomment);
	$oldcomment = nl2br($oldcomment);
	$oldcomment = stripslashes($oldcomment);
	
	$user_joindate = convert_timestamp($query_comment['join_date']);
	$date = convert_timestamp($query_comment['timestamp']);
	
	 $smarty->append('comments',
	    array('comment' => $oldcomment,
			  'date' => $date,
			  'demo' => $query_comment['demo_name'],
			  'demo_id' => $query_comment['demo_id'],
			  'image' => $v_demo_image,
			  'user_name' => $query_comment['userid'],
			  'users_id' => $query_comment['user_id'],
			  'demo_user_comments_id' => $query_comment['demo_user_comments_id'],
			  'user_comment_nr' => $usercomment_number,
			  'user_joindate' => $user_joindate,
			  'usersubmit_number' => $usersubmit_number,
			  'comment_id' => $query_comment['comments_id'],
			  'email' => $query_comment['email']));
}

//Check if back arrow is needed 
if($v_counter > 0)
{
// Build the link
	$v_linkback =('?v_counter=' . ($v_counter - 15 . $users_comments));
}

//Check if we need to place a next arrow
if($v_rows > ($v_counter + 15))
{
//Build the link
	$v_linknext =('?v_counter=' . ($v_counter + 15 . $users_comments));
}

if (empty($v_linkback)) {$v_linkback="";}
if (empty($v_linknext)) {$v_linknext="";}
if (empty($users_comments)) {$users_comments="";}
if (empty($c_counter)) {$c_counter="";}

$smarty->assign('links',
	     array('linkback' => $v_linkback,
			   'linknext' => $v_linknext,
			   'v_counter' => $v_counter,
			   'view' => $view,
			   'users_comments' => $users_comments,
			   'c_counter' => $c_counter));

//Send all smarty variables to the templates
$smarty->display('file:../../../templates/html/admin/demos_comment.html');
?>
