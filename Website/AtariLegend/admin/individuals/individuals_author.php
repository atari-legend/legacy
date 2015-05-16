<?php
/***************************************************************************
*                                individuals_auhtor.php
*                            -----------------------------
*   begin                : Saturday, August 6, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : Creation of file
*   Id: individuals_auhtor.php,v 0.10 2005/08/06 19:07 Gatekeeper
*
***************************************************************************/

//****************************************************************************************
// The Author main page
//**************************************************************************************** 

include("../includes/common.php");

if ( isset($action) and $action == 'insert' )
{
	$sql_author = mysql_query("INSERT INTO author_type (author_type_info) VALUES ('$newtype')")
				  or die("Couldn't insert into author_type");
	
	$smarty->assign("message",'Insert succesfull');
}

if ( isset($action) and $action == 'edit' )
{
	$sql_author = mysql_query("UPDATE author_type set author_type_info='$newtype' WHERE author_type_id=$type_id")
				  or die("Couldn't edit the author type");
	
	$smarty->assign("message",'Update succesfull');
}

if ( isset($action) and $action == 'delete' )
{
	$sql_author = mysql_query("DELETE FROM author_type WHERE author_type_id = $type_id")
				  or die("Couldn't delete from author_type");
	
	$smarty->assign("message",'Delete succesfull');
}

if ( isset($action) and $action == 'load' )
{
		
	$sql_author = mysql_query("SELECT * FROM author_type WHERE author_type_id = '$type_id' 
							   ORDER BY author_type_info ASC")
			      or die ("Couldn't query author_types");
			  
	while  ($author=mysql_fetch_array($sql_author)) 
	{  
		$smarty->assign('author_types_load',
	 		 array('author_type' => $author['author_type_info'],
				   'author_type_id' => $author['author_type_id']));
	
		$smarty->assign("load", '1');
	}
}

$sql_author = mysql_query("SELECT * FROM author_type ORDER BY author_type_info ASC")
		      or die ("Couldn't query author_types");
		
while  ($author=mysql_fetch_array($sql_author)) 
{  
	$smarty->append('author_types',
 		 array('author_type' => $author['author_type_info'],
			   'author_type_id' => $author['author_type_id']));
}

$smarty->assign("user_id",$_SESSION['user_id']);
$smarty->assign('individuals_author_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();
