<?php
/***************************************************************************
*                                db_links.php
*                            -----------------------
*   begin                : Saturday, Jan 08, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : re-creation of code from scratch into new file.
*						  
*							
*
*   Id: db_links.php,v 1.00 2005/01/08 Silver Surfer
*	Id: db_links.php,v 2.00 2015/10/21 Grave
*
***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../../includes/common.php");
include("../../includes/admin.php");
if(isset($action) and $action=="addnew_link")

{
//****************************************************************************************
// This is where the actual links will be inserted into the DB!!
//**************************************************************************************** 
$timestamp = time();
$name = trim($name);

$mysqli->query("INSERT INTO website (website_name, website_url, website_date, website_user_sub) VALUES ('$name', '$url','$timestamp','$user_id')")
			or die("Unable to insert website into database");  

$karma_action = "weblink";

UserKarma($user_id,$karma_action);
			
$RESULT=$mysqli->query("SELECT * FROM website WHERE website_name='$name' AND website_url='$url'")
			or die("Unable to select website database");
$rowlink= $RESULT->fetch_array(MYSQLI_BOTH);

if($descr!=='') 
{
	$mysqli->query("INSERT INTO website_description (website_id, website_description_text) VALUES ('$rowlink[website_id]', '$descr')")
				or die("Unable to insert website description into database"); 
}

if($category!=='') 
{
	$mysqli->query("INSERT INTO website_category_cross (website_id, website_category_id) VALUES ('$rowlink[website_id]', '$category')")
					or die("Unable to insert website category into database");  
}

header("Location: ../links/link_modlist.php?catpick=$category");
}

//add category
if (isset($action) and $action=="add_cat")

{
//****************************************************************************************
// add category to the tables
//**************************************************************************************** 	
	if($cat_id!=='') 
	{
		$mysqli->query("INSERT INTO website_category_cross (website_id, website_category_id) VALUES ('$website_id', '$cat_id')")
			or die("Unable to insert category into database");  
	}
	
	header("Location: ../links/link_mod.php?website_id=$website_id");
}


//delete category from website (only website_cat_cross)
if (isset($action) and $action=="delete_category")

{
//****************************************************************************************
// delete category from the tables
//**************************************************************************************** 	
	if(category_id!=='') 
	{
		$sql = $mysqli->query("DELETE FROM website_category_cross WHERE website_category_id = '$category_id' and website_id = '$website_id'") or die("Failed to delete category");
	}
	
	header("Location: ../links/link_mod.php?website_id=$website_id");
}


// LINK DELETE AREA //

if (isset($action) and $action=="link_delete")

{

//****************************************************************************************
// Delete the links from the tables
//**************************************************************************************** 
$RESULT=$mysqli->query("SELECT website_category_id FROM website_category_cross WHERE website_id = '$website_id'")
			or die("Unable to select the website_category_id");
$rowcat=$RESULT->fetch_array(MYSQLI_BOTH);

	$sql = "SELECT website_imgext FROM website WHERE website_id='$website_id'";
	$website_query = $mysqli->query($sql);
	list ($website_imgext) = $website_query->fetch_array(MYSQLI_BOTH);
	
	unlink ("$website_image_path$website_id.$website_imgext");

$sql = $mysqli->query("DELETE FROM website WHERE website_id = '$website_id'") or die("Failed to delete website");
$sql = $mysqli->query("DELETE FROM website_description WHERE website_id = '$website_id'") or die("Failed to delete website");
$sql = $mysqli->query("DELETE FROM website_category_cross WHERE website_id = '$website_id'") or die("Failed to delete website");

mysqli_close(); 

header("Location: ../links/link_modlist.php?catpick=$rowcat[website_category_id]");
}

// LINK UPDATE AREA //

if(isset($action) and $action=='modify_link')

{

//****************************************************************************************
// This is where the links are modified
//**************************************************************************************** 

// Here we add the website image
if (isset($_POST['file_upload']) and $_POST['file_upload'] == "yes" and isset($_FILES['image']))
{	
	$image = $_FILES['image'];
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
		elseif ( $type_image=='image/jpeg')
		{
			$ext='jpg';
		} 
		
		if ($ext!=="")
		{
			// Rename the uploaded file to its autoincrement number and move it to its proper place.
			$mysqli->query("UPDATE website SET website_imgext='$ext' WHERE website_id='$website_id'");
			$file_data = rename("$tmp_name", "$website_image_save_path$website_id.$ext");
			chmod("$website_image_save_path$website_id.$ext", 0777);
		}
	}
}
// Here we delete the website image
if ($delete_image=='yes')
{
	$sql = "SELECT website_imgext FROM website WHERE website_id='$website_id'";
	$website_query = $mysqli->query($sql);
	list ($website_imgext) = $website_query->fetch_array(MYSQLI_BOTH);
	$full_filename = "$website_image_save_path$website_id.$website_imgext";

	chmod($full_filename, 0777) or die("Couldn't set file permissions");
	$mysqli->query("UPDATE website SET website_imgext='' WHERE website_id='$website_id'") or die("unable to delete the file from the database");
	unlink ("$website_image_save_path$website_id.$website_imgext") or die("unable to delete the file from server");
}

// Do the website updating

$mysqli->query("UPDATE website SET website_name='$website_name', website_url='$website_url' WHERE website_id='$website_id'");
//$mysqli->query("UPDATE website_category_cross SET website_category_id='$category' WHERE website_id='$website_id'"); 

$sql_desc = $mysqli->query("SELECT * FROM website_description WHERE website_id='$website_id'");

$num_desc = get_rows ($sql_desc);

	if ($num_desc==0) {

		if (isset($website_description_text)) {
		
			$mysqli->query("INSERT INTO website_description (website_id, website_description_text) VALUES ('$website_id', '$website_description_text')");
		
		}
	}
	
	if ($num_desc==1) {
		
		if (isset($website_description_text)) {
		
			$mysqli->query("UPDATE website_description SET website_description_text='$website_description_text' WHERE website_id='$website_id'");
			
		}
		
		if (!isset($website_description_text)) {
		
			$mysqli->query("DELETE FROM website_description WHERE website_id = '$website_id'");
		
		}
	}

mysqli_close($mysqli); 

header("Location: ../links/link_mod.php?website_id=$website_id");
}

if(isset($action) and $action=="approve_link")

{

//**************************************************************************************************************************
// This is where the actual links will be inserted into the DB if they have been submitted from the frontpage and validated.
//**************************************************************************************************************************

$sql = "SELECT * FROM website_validate WHERE website_id='$validate_website_id'";

$result = $mysqli->query($sql) or die("couldn't query website_validate");

list($website_id,$name,$url,$website_date,$category,$descr,$user_id) = $result->fetch_array(MYSQLI_BOTH);

$karma_action = "weblink";

//UserKarma($user_id,$karma_action);

$mysqli->query("INSERT INTO website (website_name, website_url, website_date, website_user_sub) VALUES ('$validate_website_name', '$validate_website_url','$website_date',$user_id)");  

$RESULT = $mysqli->query("SELECT * FROM website ORDER BY website_id DESC LIMIT 0,1");
$rowlink = $RESULT->fetch_array(MYSQLI_BOTH);

if(isset($descr)) 
{
	$mysqli->query("INSERT INTO website_description (website_id, website_description_text) VALUES ('$rowlink[website_id]', '$validate_website_description_text')"); 
}

if(isset($category)) 
{
	$mysqli->query("INSERT INTO website_category_cross (website_id, website_category_id) VALUES ('$rowlink[website_id]', '$validate_category')"); 
}

$sql = $mysqli->query("DELETE FROM website_validate WHERE website_id = '$validate_website_id'");

mysqli_close(); 
 
header("Location: ../links/link_addnew.php");
}

if(isset($action) and $action=="val_delete")

{

//**************************************************************************************************************************
// This is where we delete links that has been submitted that we don't want.
//**************************************************************************************************************************

$sql = $mysqli->query("DELETE FROM website_validate WHERE website_id = '$website_id'");

mysqli_close(); 
 
header("Location: ../links/link_addnew.php");
}

if(isset($action) and $action=="new_cat")

{

//**************************************************************************************************************************
// This is where we insert new categories into the archive
//**************************************************************************************************************************

$sql = $mysqli->query("INSERT INTO website_category (website_category_name) VALUES ('$newcat')"); 

mysqli_close(); 
 
header("Location: ../links/link_cat.php");
}

if(isset($action) and $action=='mod_cat')

{

//****************************************************************************************
// Modify category
//**************************************************************************************** 

$sql = $mysqli->query("UPDATE website_category SET website_category_name='$category_name',parent_category='$category' WHERE website_category_id='$category_id'");

mysqli_close(); 

header("Location: ../links/link_cat.php");

}

if(isset($action) and $action=='del_cat')

{

//****************************************************************************************
// Modify category
//**************************************************************************************** 

if ($move=="yes") // move the links connected to a category before killing the category.

	{
	$mysqli->query("UPDATE website_category_cross SET website_category_id='$new_category' WHERE website_category_id='$category_id'");
	}

// Delete!
$sql = $mysqli->query("DELETE FROM website_category_cross WHERE website_category_id = '$category_id'");
$sql = $mysqli->query("DELETE FROM website_category WHERE website_category_id = '$category_id'");

mysqli_close(); 

header("Location: ../links/link_cat.php");

}
