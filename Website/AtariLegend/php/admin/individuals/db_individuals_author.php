<?php
/***************************************************************************
*                                db_individuals_auhtor.php
*                            ---------------------------------
*   begin                : Saturday, August 6, 2005
*   copyright            : (C) 2005 Atari Legend
*   actual update        : Creation of file
*
*   Id: db_individuals_auhtor.php,v 0.20 2016/08/01 23:59 Gatekeeper
*				- AL 2.0
*
***************************************************************************/

//****************************************************************************************
// The db Author main page
//**************************************************************************************** 

include("../../includes/common.php");
include("../../includes/admin.php");

if ( isset($action) and $action == 'insert' )
{
	$sql_author = $mysqli->query("INSERT INTO author_type (author_type_info) VALUES ('$newtype')")
				  or die("Couldn't insert into author_type");
	
	$_SESSION['edit_message'] = "Insert succesfull";

	header("Location: ../individuals/individuals_author.php");
}

if ( isset($action) and $action == 'edit' )
{
	$sql_author = $mysqli->query("UPDATE author_type set author_type_info='$newtype' WHERE author_type_id=$type_id")
				  or die("Couldn't edit the author type");
	
	$_SESSION['edit_message'] = "Update succesfull";

	header("Location: ../individuals/individuals_author.php");
}

if ( isset($action) and $action == 'delete' )
{
	$sql_author = $mysqli->query("DELETE FROM author_type WHERE author_type_id = $type_id")
				  or die("Couldn't delete from author_type");

	$_SESSION['edit_message'] = "Delete succesfull";

	header("Location: ../individuals/individuals_author.php");
}

//close the connection
mysqli_close($mysqli);
?>
