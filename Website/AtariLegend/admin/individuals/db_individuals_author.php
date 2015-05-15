<?php
/***************************************************************************
*                                db_individuals_auhtor.php
*                            -----------------------------
*   begin                : Saturday, August 6, 2005
*   copyright            : (C) 2005 Atari Legend
*   actual update        : Creation of file
*
*
***************************************************************************/

//****************************************************************************************
// The db Author main page
//**************************************************************************************** 

include("../includes/common.php");

if ( isset($action) and $action == 'insert' )
{
	$sql_author = mysql_query("INSERT INTO author_type (author_type_info) VALUES ('$newtype')")
				  or die("Couldn't insert into author_type");
	
	$smarty->assign("message",'Insert succesfull');

header("Location: ../individuals/individuals_author.php");
}

if ( isset($action) and $action == 'edit' )
{
	$sql_author = mysql_query("UPDATE author_type set author_type_info='$newtype' WHERE author_type_id=$type_id")
				  or die("Couldn't edit the author type");
	
	$smarty->assign("message",'Update succesfull');

header("Location: ../individuals/individuals_author.php");
}

if ( isset($action) and $action == 'delete' )
{
	$sql_author = mysql_query("DELETE FROM author_type WHERE author_type_id = $type_id")
				  or die("Couldn't delete from author_type");
	
	$smarty->assign("message",'Delete succesfull');

header("Location: ../individuals/individuals_author.php");
}

//close the connection
mysql_close();
?>
