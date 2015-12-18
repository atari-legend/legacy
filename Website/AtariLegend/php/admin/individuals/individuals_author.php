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

include("../../includes/common.php");

if ( isset($action) and $action == 'load' )
{
		
	$sql_author = $mysqli->query("SELECT * FROM author_type WHERE author_type_id = '$type_id' 
							   ORDER BY author_type_info ASC")
			      or die ("Couldn't query author_types");
			  
	while  ($author=$sql_author->fetch_array(MYSQLI_BOTH)) 
	{  
		$smarty->assign('author_types_load',
	 		 array('author_type' => $author['author_type_info'],
				   'author_type_id' => $author['author_type_id']));
	
		$smarty->assign("load", '1');
	}
}

$sql_author = $mysqli->query("SELECT * FROM author_type ORDER BY author_type_info ASC")
		      or die ("Couldn't query author_types");
		
while  ($author=$sql_author->fetch_array(MYSQLI_BOTH)) 
{  
	$smarty->append('author_types',
 		 array('author_type' => $author['author_type_info'],
			   'author_type_id' => $author['author_type_id']));
}

$smarty->assign("user_id",$_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display('file:../../../templates/html/admin/individuals_author.html');

//close the connection
mysqli_close($mysqli);
