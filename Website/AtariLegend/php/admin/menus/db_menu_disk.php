<?php
/***************************************************************************
*                                db_menu_disk.php
*                            -----------------------
*   begin                : june 06, 2015
*   copyright            : (C) 2005 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : re-creation of code from scratch into new file.
*
*	id : db_menu_disk.php, v 1.10 2016/08/29 STG
*				- adding the change log
*
***************************************************************************/

// We are using the action var to separate all the queries.

include("../../includes/common.php");
include("../../includes/admin.php"); 

//****************************************************************************************
// Add new menu set
//**************************************************************************************** 

if($action=="menu_set_new")
{
	if(isset($menu_sets_name)) 
	{
		$sql = $mysqli->query("INSERT INTO menu_set (menu_sets_name) VALUES ('$menu_sets_name')");  
		$new_menu_set_id = $mysqli->insert_id;
		
		create_log_entry('Menu set', $new_menu_set_id, 'Menu set', $new_menu_set_id, 'Insert', $_SESSION['user_id']);
		
		mysqli_free_result($sql); 
		$_SESSION['edit_message'] = "New Menu Set added";
	}

header("Location: ../menus/menus_list.php");

}

//****************************************************************************************
// Add new menu disk
//**************************************************************************************** 

if($action=="add_new_menu_disk")
{
	if ($menu_disk_number!=='' or $menu_disk_letter!=='')
	{	
		//first we start with if this is numbered menu disk
		if($menu_disk_number!=='' and $menu_disk_letter=='')
			{
				$sql = $mysqli->query("INSERT INTO menu_disk (menu_sets_id,menu_disk_number) VALUES ('$menu_sets_id','$menu_disk_number')") or die ("Insert of menu disk failed");
				$last_id = $mysqli->insert_id;
				
				if($menu_disk_part!=='') 
					{
					$sql = $mysqli->query("UPDATE menu_disk SET menu_disk_part='$menu_disk_part' 
					    WHERE menu_disk_id='$last_id'");
					}
				if($menu_disk_version!=='') 
					{
					$sql = $mysqli->query("UPDATE menu_disk SET menu_disk_version='$menu_disk_version' 
					    WHERE menu_disk_id='$last_id'");
					}
			
			}
		//Ok, but if it is not a numbered disk but instead it is one of those horrible alphabetic disks
		if($menu_disk_number=='' and $menu_disk_letter!=='')
			{
				$sql = $mysqli->query("INSERT INTO menu_disk (menu_sets_id,menu_disk_letter) VALUES ('$menu_sets_id','$menu_disk_letter')");
				$last_id2 = $mysqli->insert_id;
				if($menu_disk_part!=='') 
					{
					$sql = $mysqli->query("UPDATE menu_disk SET menu_disk_part='$menu_disk_part' 
					    WHERE menu_disk_id='$last_id2'");
					}
				if($menu_disk_version!=='') 
					{
					$sql = $mysqli->query("UPDATE menu_disk SET menu_disk_version='$menu_disk_version' 
					    WHERE menu_disk_id='$last_id2'");
					}
			
			}
				$_SESSION['edit_message'] = "New Menu disk added";			
	}

header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");

}


//****************************************************************************************
// MULTI Add new menu disk
//**************************************************************************************** 

if(isset($action) and $action=="multi_add_new_menu_disk")
{
	if ($first_disk!=='' and $last_disk!=='')
	{	
		//First disk must me a smaller number then last disk
		if($first_disk < $last_disk)
			{	
			$i = $first_disk;
			
			while ($i <= $last_disk)
				{
					$sql = $mysqli->query("INSERT INTO menu_disk (menu_sets_id,menu_disk_number) VALUES ('$menu_sets_id','$i')");
				$i++;
				}
				
			}
		$_SESSION['edit_message'] = "New Menu disks added";
	}

header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");

}

//****************************************************************************************
// Edit menu_set name
//**************************************************************************************** 
if($action=="menu_set_name_update")
{
if(isset($menu_sets_id) and $menu_sets_name!=="") 
{
	$sql = $mysqli->query("UPDATE menu_set SET menu_sets_name='$menu_sets_name' 
					    WHERE menu_sets_id='$menu_sets_id'");  
	mysqli_free_result($sql); 
	
	create_log_entry('Menu set', $menu_sets_id, 'Menu set', $menu_sets_id, 'Update', $_SESSION['user_id']);
	
	$_SESSION['edit_message'] = "Menu Set Name updated!";
}
header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
}


//****************************************************************************************
// Connect crew to menu set
//**************************************************************************************** 
if($action=="menu_set_crew_set")
{
	if(isset($crew_id) and ($crew_id ==! "") and isset($menu_sets_id)) 
	{
		$sql = $mysqli->query("INSERT INTO crew_menu_prod (crew_id,menu_sets_id) VALUES ('$crew_id','$menu_sets_id')");  
		$_SESSION['edit_message'] = "Crew hooked to this Menu disk series";
		create_log_entry('Menu set', $menu_sets_id, 'Crew', $crew_id, 'Insert', $_SESSION['user_id']);
		
		mysqli_free_result($sql); 
	}
	
	if ($crew_id == "")
	{
		$_SESSION['edit_message'] = "Please select a crew";
	}

header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");

}

//****************************************************************************************
// Connect individual to menu set
//**************************************************************************************** 
if($action=="menu_set_ind_set")
{
	if(isset($ind_id) and ($ind_id ==! "") and isset($menu_sets_id)) 
	{
		$sql = $mysqli->query("INSERT INTO ind_menu_prod (ind_id,menu_sets_id) VALUES ('$ind_id','$menu_sets_id')");  
		$_SESSION['edit_message'] = "Individual hooked to this Menu disk series";
		create_log_entry('Menu set', $menu_sets_id, 'Individual', $ind_id, 'Insert', $_SESSION['user_id']);
		
		mysqli_free_result($sql); 
	}

	if ($ind_id == "")
	{
		$_SESSION['edit_message'] = "Please select an individual";
	}

header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");

}

//****************************************************************************************
// Connect menu type to menu set
//**************************************************************************************** 
if($action=="menu_set_type_set")
{
	if(isset($menu_type_browse) and ($menu_type_browse ==! "")  and isset($menu_sets_id)) 
	{
		$sql = $mysqli->query("INSERT INTO menu_type (menu_types_main_id,menu_sets_id) VALUES ('$menu_type_browse','$menu_sets_id')");  
		$_SESSION['edit_message'] = "Menu set hooked to this Menu disk series";
		mysqli_free_result($sql); 
	}
	
	if ($menu_type_browse == "")
	{
		$_SESSION['edit_message'] = "Please select a menu set";
	}
header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");

}


//****************************************************************************************
// Quick add new crew
//**************************************************************************************** 
if($action=="menu_set_crew_add")
{
if(isset($new_crew_name) and isset($menu_sets_id)) 
{
	$sql = $mysqli->query("INSERT INTO crew (crew_name) VALUES ('$new_crew_name')");  
	$new_crew_id = $mysqli->insert_id;
	
	create_log_entry('Crew', $new_crew_id, 'Crew', $new_crew_id, 'Insert', $_SESSION['user_id']);
	
	mysqli_free_result($sql); 
}
$_SESSION['edit_message'] = "$new_crew_name added to the crew database";
header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");

}

//****************************************************************************************
// Quick add new Individual
//**************************************************************************************** 
if($action=="menu_set_ind_add")
{
if(isset($new_ind_name) and isset($menu_sets_id)) 
{
	$sql = $mysqli->query("INSERT INTO Individuals (ind_name) VALUES ('$new_ind_name')");  
	$new_ind_id = $mysqli->insert_id;
	
	create_log_entry('Individuals', $new_ind_id, 'Individual', $new_ind_id, 'Insert', $_SESSION['user_id']);
	
	mysqli_free_result($sql); 
}
$_SESSION['edit_message'] = "$new_ind_name added to the individuals database";
header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");
}

//****************************************************************************************
// This is delete crew from menu series
//**************************************************************************************** 
if($action=="delete_crew_from_menu_set")
{
if(isset($crew_id) and isset($menu_sets_id)) 
{
		create_log_entry('Menu set', $menu_sets_id, 'Crew', $crew_id, 'Delete', $_SESSION['user_id']);
		$mysqli->query("DELETE FROM crew_menu_prod WHERE crew_id='$crew_id' AND menu_sets_id='$menu_sets_id'"); 
}

$_SESSION['edit_message'] = "Crew removed from Menu set";
header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");

}

//****************************************************************************************
// This is the delete menu type from menu series
//**************************************************************************************** 
if($action=="delete_menu_type_from_menu_set")
{
if(isset($menu_type_id) and isset($menu_sets_id)) 
{
		$mysqli->query("DELETE FROM menu_type WHERE menu_types_main_id='$menu_type_id' AND menu_sets_id='$menu_sets_id'"); 
}

$_SESSION['edit_message'] = "Menu type removed from Menu set";
header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");

}


//****************************************************************************************
// This is delete individuel from menu series
//**************************************************************************************** 
if($action=="delete_ind_from_menu_set")
{
if(isset($ind_id) and isset($menu_sets_id)) 
{
		create_log_entry('Menu set', $menu_sets_id, 'Individual', $ind_id, 'Delete', $_SESSION['user_id']);
		$mysqli->query("DELETE FROM ind_menu_prod WHERE ind_id='$ind_id' AND menu_sets_id='$menu_sets_id'"); 
}

$_SESSION['edit_message'] = "Individual removed from Menu set";
header("Location: ../menus/menus_disk_list.php?menu_sets_id=$menu_sets_id");

}

//****************************************************************************************
// Add game to menu disk AJAX DB job
//**************************************************************************************** 
if(isset($action) and $action=="add_title_to_menu")
{
if(isset($software_id) and isset($menu_disk_id)) 
{		
	if (isset($software_type) and $software_type=="Game")
	{
		//Insert new title in menu_disk_title table
		$mysqli->query("INSERT INTO menu_disk_title (menu_disk_id,menu_types_main_id) VALUES ('$menu_disk_id','1')"); 
		$last_id = $mysqli->insert_id; // Get Last autoinc id
		// Specify title in menu_disk_title_game table
		$mysqli->query("INSERT INTO menu_disk_title_game (menu_disk_title_id,game_id) VALUES ('$last_id','$software_id')"); 
		
		$sql = $mysqli->query("SELECT game_name FROM game WHERE game_id = '$software_id'");
		$row=$sql->fetch_array(MYSQLI_BOTH);
		$software_name = $row['game_name'];
	}
	if (isset($software_type) and $software_type=="Demo")
	{
		$mysqli->query("INSERT INTO menu_disk_title (menu_disk_id,menu_types_main_id) VALUES ('$menu_disk_id','2')"); 	
		$last_id = $mysqli->insert_id; // Get Last autoinc id
		// Specify title in menu_disk_title_game table
		$mysqli->query("INSERT INTO menu_disk_title_demo (menu_disk_title_id,demo_id) VALUES ('$last_id','$software_id')");
		
		$sql = $mysqli->query("SELECT demo_name FROM demo WHERE demo_id = '$software_id'");
		$row=$sql->fetch_array(MYSQLI_BOTH);
		$software_name = $row['demo_name']; 			
	}
	if (isset($software_type) and $software_type=="Tool")
	{
		$mysqli->query("INSERT INTO menu_disk_title (menu_disk_id,menu_types_main_id) VALUES ('$menu_disk_id','3')"); 	
		$last_id = $mysqli->insert_id; // Get Last autoinc id
		// Specify title in menu_disk_title_game table
		$mysqli->query("INSERT INTO menu_disk_title_tools (menu_disk_title_id,tools_id) VALUES ('$last_id','$software_id')"); 	
		
		$sql = $mysqli->query("SELECT tools_name FROM tools WHERE tools_id = '$software_id'");
		$row=$sql->fetch_array(MYSQLI_BOTH);
		$software_name = $row['tools_name']; 			
	}	
	
		// ok, insert done. Now this is a ajax job so we need a return value.
		//
			//list of games for the menu disk
				$sql_games = "SELECT game.game_name AS 'software_name',
								pub_dev.pub_dev_name AS 'developer_name',
								game_year.game_year AS 'year',
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_game ON (menu_disk_title.menu_disk_title_id = menu_disk_title_game.menu_disk_title_id)
								LEFT JOIN game ON (menu_disk_title_game.game_id = game.game_id)
								LEFT JOIN game_developer ON (game.game_id = game_developer.game_id)
								LEFT JOIN pub_dev ON (game_developer.dev_pub_id = pub_dev.pub_dev_id)
								LEFT JOIN game_year ON (game.game_id = game_year.game_id)
								LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
								WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '1' ORDER BY game.game_name ASC";
				
				$sql_demos = "SELECT demo.demo_name AS 'software_name',
								crew.crew_name AS 'developer_name',
								demo_year.demo_year AS 'year',
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_demo ON (menu_disk_title.menu_disk_title_id = menu_disk_title_demo.menu_disk_title_id)
								LEFT JOIN demo ON (menu_disk_title_demo.demo_id = demo.demo_id)
								LEFT JOIN demo_year ON (demo.demo_id = demo_year.demo_id)
								LEFT JOIN crew_demo_prod ON (demo.demo_id = crew_demo_prod.demo_id)
								LEFT JOIN crew ON (crew_demo_prod.crew_id = crew.crew_id)
								LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
								WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '2' ORDER BY demo.demo_name ASC";				
				
				$sql_tools = "SELECT tools.tools_name AS 'software_name',
								'' AS developer_name,
								'' AS year,
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_tools ON (menu_disk_title.menu_disk_title_id = menu_disk_title_tools.menu_disk_title_id)
								LEFT JOIN tools ON (menu_disk_title_tools.tools_id = tools.tools_id)
								LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
								WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '3' ORDER BY tools.tools_name ASC";
				
				$temp_query = $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_games") or die(mysqli_error());
				$temp_query = $mysqli->query("INSERT INTO temp $sql_demos") or die(mysqli_error());
				$temp_query = $mysqli->query("INSERT INTO temp $sql_tools") or die(mysqli_error());

				$temp_query = $mysqli->query("SELECT * FROM temp GROUP BY menu_disk_title_id ORDER BY software_name ASC") or die("does not compute3");

				
				while  ($query = $temp_query->fetch_array(MYSQLI_BOTH)) 
				{ 		
					
					// This smarty is used for creating the list of games
						$smarty->append('game',
	    				array('game_name' => $query['software_name'],
						  	  'developer_name' => $query['developer_name'],
						  	  'year' => $query['year'],
						  	  'menu_disk_title_id' => $query['menu_disk_title_id'],
						  	  'menu_types_text' => $query['menu_types_text']));
				}
				
				$osd_message = "$software_name added to menu disk!";
				
				$smarty->assign('smarty_action', 'add_game_to_menu_return');
				$smarty->assign('osd_message', $osd_message);
				$smarty->assign('menu_disk_id', $menu_disk_id);
	
	//Send to smarty for return value
	$smarty->display("file:".$cpanel_template_folder."ajax_menus_detail.html");
	
}

}

//****************************************************************************************
// DELETE TITLE FROM MENU DISK
//**************************************************************************************** 
if(isset($action) and $action=="delete_from_menu_disk")
{

	$mysqli->query("DELETE FROM menu_disk_title_various WHERE menu_disk_title_id='$menu_disk_title_id'"); 
	$mysqli->query("DELETE FROM menu_disk_title_tools WHERE menu_disk_title_id='$menu_disk_title_id'");
	$mysqli->query("DELETE FROM menu_disk_title_music WHERE menu_disk_title_id='$menu_disk_title_id'");
	$mysqli->query("DELETE FROM menu_disk_title_game WHERE menu_disk_title_id='$menu_disk_title_id'");
	$mysqli->query("DELETE FROM menu_disk_title_doc_tools WHERE menu_disk_title_id='$menu_disk_title_id'");
	$mysqli->query("DELETE FROM menu_disk_title_doc_games WHERE menu_disk_title_id='$menu_disk_title_id'");
	$mysqli->query("DELETE FROM menu_disk_title_demo WHERE menu_disk_title_id='$menu_disk_title_id'");
	$mysqli->query("DELETE FROM menu_disk_title WHERE menu_disk_title_id='$menu_disk_title_id'");


		// ok, delete done. Now this is a ajax job so we need a return value.
		//
			//list of games for the menu disk
				$sql_games = "SELECT game.game_name AS 'software_name',
								pub_dev.pub_dev_name AS 'developer_name',
								game_year.game_year AS 'year',
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_game ON (menu_disk_title.menu_disk_title_id = menu_disk_title_game.menu_disk_title_id)
								LEFT JOIN game ON (menu_disk_title_game.game_id = game.game_id)
								LEFT JOIN game_developer ON (game.game_id = game_developer.game_id)
								LEFT JOIN pub_dev ON (game_developer.dev_pub_id = pub_dev.pub_dev_id)
								LEFT JOIN game_year ON (game.game_id = game_year.game_id)
								LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
								WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '1' ORDER BY game.game_name ASC";
				
				$sql_demos = "SELECT demo.demo_name AS 'software_name',
								crew.crew_name AS 'developer_name',
								demo_year.demo_year AS 'year',
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_demo ON (menu_disk_title.menu_disk_title_id = menu_disk_title_demo.menu_disk_title_id)
								LEFT JOIN demo ON (menu_disk_title_demo.demo_id = demo.demo_id)
								LEFT JOIN demo_year ON (demo.demo_id = demo_year.demo_id)
								LEFT JOIN crew_demo_prod ON (demo.demo_id = crew_demo_prod.demo_id)
								LEFT JOIN crew ON (crew_demo_prod.crew_id = crew.crew_id)
								LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
								WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '2' ORDER BY demo.demo_name ASC";				
				
				$sql_tools = "SELECT tools.tools_name AS 'software_name',
								'' AS developer_name,
								'' AS year,
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_tools ON (menu_disk_title.menu_disk_title_id = menu_disk_title_tools.menu_disk_title_id)
								LEFT JOIN tools ON (menu_disk_title_tools.tools_id = tools.tools_id)
								LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
								WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '3' ORDER BY tools.tools_name ASC";
				
				$temp_query = $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_games") or die(mysqli_error());
				$temp_query = $mysqli->query("INSERT INTO temp $sql_demos") or die(mysqli_error());
				$temp_query = $mysqli->query("INSERT INTO temp $sql_tools") or die(mysqli_error());

				$temp_query = $mysqli->query("SELECT * FROM temp GROUP BY menu_disk_title_id ORDER BY software_name ASC") or die("does not compute3");

				
				while  ($query = $temp_query->fetch_array(MYSQLI_BOTH)) 
				{ 		
					
					// This smarty is used for creating the list of games
						$smarty->append('game',
	    				array('game_name' => $query['software_name'],
						  	  'developer_name' => $query['developer_name'],
						  	  'year' => $query['year'],
						  	  'menu_disk_title_id' => $query['menu_disk_title_id'],
						  	  'menu_types_text' => $query['menu_types_text']));
				}
							
				$smarty->assign('smarty_action', 'add_game_to_menu_return');
				$smarty->assign('menu_disk_id', $menu_disk_id);
	
	//Send to smarty for return value
	$smarty->display("file:".$cpanel_template_folder."ajax_menus_detail.html");

}

//****************************************************************************************
// add screenshots to menu disk
//**************************************************************************************** 
if (isset($action) and $action=="add_screens")
{
	//Here we'll be looping on each of the inputs on the page that are filled in with an image!
	$image = $_FILES['image'];
	
	$osd_message = "";
	
	foreach($image['tmp_name'] as $key=>$tmp_name)
	{		
		if ($tmp_name!=="")
		{
		// Check what extention the file has and if it is allowed.
			$ext="";
			$type_image = $image['type'][$key];
			
			// set extension
			if ( $type_image=='image/png')
				{
					$ext='png';
				}
				
			if ( $type_image=='image/x-png')
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
				// First we insert the directory path of where the file will be stored... this also creates an autoinc number for us.
				$sdbquery = $mysqli->query("INSERT INTO screenshot_main (screenshot_id,imgext) VALUES ('','$ext')")
							or die ("Database error - inserting screenshots");

				//select the newly entered screenshot_id from the main table
				$SCREENSHOT = $mysqli->query("SELECT screenshot_id FROM screenshot_main
										   ORDER BY screenshot_id desc")
							  or die ("Database error - selecting screenshots");
				
				$screenshotrow = $SCREENSHOT->fetch_row();
				$screenshot_id = $screenshotrow[0];
				
				$sdbquery = $mysqli->query("INSERT INTO screenshot_menu (menu_disk_id, screenshot_id) VALUES ($menu_disk_id, $screenshot_id)")
							or die ("Database error - inserting screenshots2");
				
				// Rename the uploaded file to its autoincrement number and move it to its proper place.
				$file_data = rename($image['tmp_name'][$key], "$menu_screenshot_save_path$screenshotrow[0].$ext");
				
				chmod("$menu_screenshot_save_path$screenshotrow[0].$ext", 0777);
				
				$osd_message = "Screenshot uploaded";
			}
		}
	}
	
	If ($osd_message=='')
	{
		$osd_message = "No screenshot uploaded";
	}
	
	//Get the screenshots for this menu if they exist
	$sql_screenshots = $mysqli->query("SELECT * FROM screenshot_menu
						LEFT JOIN screenshot_main ON (screenshot_menu.screenshot_id = screenshot_main.screenshot_id)
						WHERE screenshot_menu.menu_disk_id = '$menu_disk_id' ORDER BY screenshot_menu.screenshot_id")
							or die ("Database error - selecting screenshots");

	$count = 1;
	$v_screenshots =0;
	while ( $screenshots=$sql_screenshots->fetch_array(MYSQLI_BOTH)) 
	{
		//Ready screenshots path and filename
		$screenshot_image  = $menu_screenshot_path;
		$screenshot_image .= $screenshots['screenshot_id'];
		$screenshot_image .= '.';
		$screenshot_image .= $screenshots['imgext'];
					
		$smarty->append('screenshots',
				 array('count' => $count,
					   'path' => $menu_screenshot_path,
					   'screenshot_image' => $screenshot_image,
					   'id' => $screenshots['screenshot_id']));

		$count++;
		$v_screenshots++;
	}

	$smarty->assign("screenshots_nr",$v_screenshots);
	$smarty->assign('osd_message', $osd_message);
	$smarty->assign('smarty_action', 'add_screen_to_menu_return');
	$smarty->assign('menu_disk_id', $menu_disk_id);
	
	//Send to smarty for return value
	$smarty->display("file:".$cpanel_template_folder."ajax_menus_detail.html");
}

//****************************************************************************************
// delete screenshots from a menudisk
//**************************************************************************************** 
if (isset($action) and $action=="delete_screen_from_menu_disk")
{
	$sql_menushot = $mysqli->query("SELECT * FROM screenshot_menu
	   					   			  WHERE menu_disk_id = $menu_disk_id 
									  AND screenshot_id = $screenshot_id")
	     		  or die ("Database error - selecting screenshots menu");
						
	$menushot = $sql_menushot->fetch_row();
	$menushotid = $menushot[0];
	
	//get the extension 
	$SCREENSHOT = $mysqli->query("SELECT * FROM screenshot_main
	   					  	  WHERE screenshot_id = '$screenshot_id'")
				  or die ("Database error - selecting screenshots");
		
	$screenshotrow = $SCREENSHOT->fetch_array(MYSQLI_BOTH);
	$screenshot_ext = $screenshotrow['imgext'];

	$sql = $mysqli->query("DELETE FROM screenshot_main WHERE screenshot_id = '$screenshot_id' ");
	$sql = $mysqli->query("DELETE FROM screenshot_menu WHERE screenshot_id = '$screenshot_id' ");

	$new_path = $menu_screenshot_save_path;;
	$new_path .= $screenshot_id;
	$new_path .= ".";
	$new_path .= $screenshot_ext;

	unlink ("$new_path");
	
	//Get the screenshots for this menu if they exist
	$sql_screenshots = $mysqli->query("SELECT * FROM screenshot_menu
						LEFT JOIN screenshot_main ON (screenshot_menu.screenshot_id = screenshot_main.screenshot_id)
						WHERE screenshot_menu.menu_disk_id = '$menu_disk_id' ORDER BY screenshot_menu.screenshot_id")
							or die ("Database error - selecting screenshots");

	$count = 1;
	$v_screenshots =0;
	while ( $screenshots=$sql_screenshots->fetch_array(MYSQLI_BOTH)) 
	{
		//Ready screenshots path and filename
		$screenshot_image  = $menu_screenshot_path;
		$screenshot_image .= $screenshots['screenshot_id'];
		$screenshot_image .= '.';
		$screenshot_image .= $screenshots['imgext'];
					
		$smarty->append('screenshots',
				 array('count' => $count,
					   'path' => $menu_screenshot_path,
					   'screenshot_image' => $screenshot_image,
					   'id' => $screenshots['screenshot_id']));

		$count++;
		$v_screenshots++;
	}

	$smarty->assign("screenshots_nr",$v_screenshots);
	
	$smarty->assign('smarty_action', 'add_screen_to_menu_return');
	$smarty->assign('menu_disk_id', $menu_disk_id);
	
	//Send to smarty for return value
	$smarty->display("file:".$cpanel_template_folder."ajax_menus_detail.html");
	
}

//****************************************************************************************
// delete download from a menudisk
//**************************************************************************************** 
if (isset($action) and $action=="delete_download_from_menu_disk")
{
	$mysqli->query("DELETE from menu_disk_download WHERE menu_disk_download_id='$menu_disk_download_id'");
	unlink ("$menu_file_path$menu_disk_download_id.zip");
	
	//************************************************************************************************
	//Let's get the menu info for the file name concatenation, and the download data for disks already
	//uploaded
	//************************************************************************************************
	//get the existing downloads
	$SQL_DOWNLOADS = $mysqli->query("SELECT * FROM menu_disk_download WHERE menu_disk_id='$menu_disk_id'")
					 or die ("Error getting download info");		

	$nr_downloads = 0;
	while ($downloads=$SQL_DOWNLOADS->fetch_array(MYSQLI_BOTH)) 
	{					
		$filepath = $menu_file_path;
						
		//start filling the smarty object
		$smarty->append('downloads',
				 array('menu_disk_download_id' => $downloads['menu_disk_download_id'],
					   'filename' => $downloads['menu_disk_download_id'],
					   'filepath' => $filepath));

		$nr_downloads++;
	}
	
	//In all cases we search we start searching through the menu_set table
	//first
	$sql_menus = "SELECT menu_disk.menu_sets_id,
					menu_set.menu_sets_name,
					menu_disk.menu_disk_number,
					menu_disk.menu_disk_letter,
					menu_disk.menu_disk_version,
					menu_disk.menu_disk_part
					FROM menu_disk 
					LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
					WHERE menu_disk.menu_disk_id = '$menu_disk_id'";
	
	$result_menus= $mysqli->query($sql_menus) or die ("error in query disk name");
	
	while ( $row=$result_menus->fetch_array(MYSQLI_BOTH) ) 
	{  
		// Create Menu disk name
		$menu_disk_name = "$row[menu_sets_name] ";
		if(isset($row['menu_disk_number'])) {$menu_disk_name .= "$row[menu_disk_number]";}
		if(isset($row['menu_disk_letter'])) {$menu_disk_name .= "$row[menu_disk_letter]";}
		if(isset($row['menu_disk_part'])) 
		{
			if (is_numeric($row['menu_disk_part']))
				{$menu_disk_name .= " part $row[menu_disk_part]";}
				else 
				{
					$menu_disk_name .= "$row[menu_disk_part]";
				}
		}
	}
	
	$smarty->assign('menu_disk_name',$menu_disk_name);	
	$smarty->assign('download_nr',$nr_downloads);		
	
	$smarty->assign('smarty_action', 'add_file_to_menu_return');
	$smarty->assign('menu_disk_id', $menu_disk_id);
	
	//Send to smarty for return value
	$smarty->display("file:".$cpanel_template_folder."ajax_menus_detail.html");
}

//****************************************************************************************
// We wanna add a new download to a menu
//**************************************************************************************** 
if (isset($action) and $action == 'add_file' )
{
	require_once('../../includes/pclzip.lib.php');
	
	$menu_download_name = $_FILES['menu_download_name'];

	if(isset($menu_download_name))
	{	
		
		$file_name=$_FILES['menu_download_name']['name'];
		
		$tempfilename = $_FILES['menu_download_name']['tmp_name'];
		
		// Time for zip magic
		$zip = new PclZip("$tempfilename");
  			
			// Obtain the contentlist of the zip file.
  			if (($list = $zip->listContent()) == 0) {
   	 		die("Error : ".$zip->errorInfo(true));
  			}
  		
		// Get the filename from the returned array
		$filename = $list[0]['filename'];

  		// Split the filename to get the extention
  		$ext = strrchr ( $filename, "." );
  
  		// Get rid of the . in the extention
  		$ext = explode ( ".", $ext );
  
  		// convert to lowercase just incase....  
  		$ext = strtolower ( $ext[1] );
		
		// check if the extention is valid.
		if ($ext=="stx" || $ext=="msa" || $ext=="st") 
		
		{} // pretty isn't it? ;)
		
		else
		
		{ exit ("Try uploading a diskimage type that is allowed, like stx or msa not $ext"); }
			
		// Insert the ext,timestamp and the menu id into the menu download table.
		$sdbquery = $mysqli->query("INSERT INTO menu_disk_download (menu_disk_id,fileext) VALUES ('$menu_disk_id','$ext')")
		or die("ERROR! Couldn't insert date, ext and menu id");
		
		//select the newly created menu_download_id from the menu_download table
		$MENUDOWN = $mysqli->query("SELECT menu_disk_download_id FROM menu_disk_download
	   					   		 ORDER BY menu_disk_download_id desc")
					or die ("Database error - selecting menu_download");
		
		$menudownrow = $MENUDOWN->fetch_row();
		
		// Time to unzip the file to the temporary directory
		$archive = new PclZip("$tempfilename");
  
			if ($archive->extract(PCLZIP_OPT_PATH, "$menu_file_temp_path") == 0) {
    		die("Error : ".$archive->errorInfo(true));
  			}

		// rename diskimage to increment number
		rename("$menu_file_temp_path$filename", "$menu_file_temp_path$menudownrow[0].$ext") or die("couldn't rename the file");
		
		//Time to rezip file and place it in the proper location.
		$archive = new PclZip("$menu_file_path$menudownrow[0].zip");
  		$v_list = $archive->create("$menu_file_temp_path$menudownrow[0].$ext",
       		                      PCLZIP_OPT_REMOVE_ALL_PATH);
  			if ($v_list == 0) {
    		die("Error : ".$archive->errorInfo(true));
  			}
		
		// Time to do the safeties, here we do a sha512 file hash that we later enter into the database, this will be used in the download
		// function to check everytime the file is being downloaded... if the hashes don't match, then datacorruption have changed the file.
		$crc = openssl_digest("$menu_file_path$menudownrow[0].zip", 'sha512');

		//$crc = md5_file ( "$game_file_path$gamedownrow[0].zip");
		
		$sdbquery = $mysqli->query("UPDATE menu_disk_download SET sha512 = '$crc' WHERE menu_disk_download_id = '$menudownrow[0]'")
				or die("Couldn't insert sha512hash");
		
		// Chmod file so that we can backup/delete files through ftp.
		chmod("$menu_file_path$menudownrow[0].zip", 0777);
		
		// Delete the unzipped file in the temporary directory
		unlink ("$menu_file_temp_path$menudownrow[0].$ext");
		
		$osd_message = "menu uploaded";
		
		$smarty->assign('osd_message', $osd_message);
		
		//************************************************************************************************
		//Let's get the menu info for the file name concatenation, and the download data for disks already
		//uploaded
		//************************************************************************************************
		//get the existing downloads
		$SQL_DOWNLOADS = $mysqli->query("SELECT * FROM menu_disk_download WHERE menu_disk_id='$menu_disk_id'")
						 or die ("Error getting download info");		

		$nr_downloads = 0;
		while ($downloads=$SQL_DOWNLOADS->fetch_array(MYSQLI_BOTH)) 
		{					
			$filepath = $menu_file_path;
							
			//start filling the smarty object
			$smarty->append('downloads',
					 array('menu_disk_download_id' => $downloads['menu_disk_download_id'],
						   'filename' => $downloads['menu_disk_download_id'],
						   'filepath' => $filepath));

			$nr_downloads++;
		}
		
		//In all cases we search we start searching through the menu_set table
		//first
		$sql_menus = "SELECT menu_disk.menu_sets_id,
						menu_set.menu_sets_name,
						menu_disk.menu_disk_number,
						menu_disk.menu_disk_letter,
						menu_disk.menu_disk_version,
						menu_disk.menu_disk_part
						FROM menu_disk 
						LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
						WHERE menu_disk.menu_disk_id = '$menu_disk_id'";
		
		$result_menus= $mysqli->query($sql_menus) or die ("error in query disk name");
		
		while ( $row=$result_menus->fetch_array(MYSQLI_BOTH) ) 
		{  
			// Create Menu disk name
			$menu_disk_name = "$row[menu_sets_name] ";
			if(isset($row['menu_disk_number'])) {$menu_disk_name .= "$row[menu_disk_number]";}
			if(isset($row['menu_disk_letter'])) {$menu_disk_name .= "$row[menu_disk_letter]";}
			if(isset($row['menu_disk_part'])) 
			{
				if (is_numeric($row['menu_disk_part']))
					{$menu_disk_name .= " part $row[menu_disk_part]";}
					else 
					{
						$menu_disk_name .= "$row[menu_disk_part]";
					}
			}
		}
		
		$smarty->assign('menu_disk_name',$menu_disk_name);	
		$smarty->assign('download_nr',$nr_downloads);	
		
		$smarty->assign('smarty_action', 'add_file_to_menu_return');
		$smarty->assign('menu_disk_id', $menu_disk_id);
		
		//Send to smarty for return value
		$smarty->display("file:".$cpanel_template_folder."ajax_menus_detail.html");
	}
}


//****************************************************************************************
// ADD MENU CREDITS!
//**************************************************************************************** 

if(isset($action) and $action=="add_intro_credits")
{
if(isset($ind_id) and isset($author_type_id) and isset($menu_disk_id)) 
{
		//Insert individual into the menu_disk credits table
		$mysqli->query("INSERT INTO menu_disk_credits (menu_disk_id,ind_id,author_type_id) VALUES ('$menu_disk_id','$ind_id','$author_type_id')"); 

				// Get the menudisk credits
				$sql_individuals = "SELECT 
									individuals.ind_id,
									individuals.ind_name,
									menu_disk_credits.menu_disk_credits_id,
									author_type.author_type_info
									FROM individuals 
									LEFT JOIN menu_disk_credits ON (individuals.ind_id = menu_disk_credits.ind_id)
									LEFT JOIN author_type ON (menu_disk_credits.author_type_id = author_type.author_type_id)
									WHERE menu_disk_credits.menu_disk_id = '$menu_disk_id'
									ORDER BY individuals.ind_name ASC";
				
				$query_individual = $mysqli->query($sql_individuals);
				
				while  ($query = $query_individual->fetch_array(MYSQLI_BOTH)) 
				{
						// This smarty is used for for the menu_disk credits
						$smarty->append('individuals',
	    				array('menu_disk_credits_id' => $query['menu_disk_credits_id'],
						  	  'ind_id' => $query['ind_id'],
						  	  'ind_name' => $query['ind_name'],
						  	  'menu_disk_id' => $menu_disk_id,
						  	  'author_type_info' => $query['author_type_info']));
				
				}
				
				
				$smarty->assign('smarty_action', 'update_menu_disk_credits');
				//Send to smarty for return value
				$smarty->display("file:".$cpanel_template_folder."ajax_menus_detail.html");
}
}

//****************************************************************************************
// DELETE MENU CREDITS
//**************************************************************************************** 

if(isset($action) and $action=="delete_menu_disk_credits")
{
if(isset($menu_disk_credits_id)) 
{
		//Insert individual into the menu_disk credits table
		$mysqli->query("DELETE FROM menu_disk_credits WHERE menu_disk_credits_id = '$menu_disk_credits_id'"); 

				// Get the menudisk credits
				$sql_individuals = "SELECT 
									individuals.ind_id,
									individuals.ind_name,
									menu_disk_credits.menu_disk_credits_id,
									author_type.author_type_info
									FROM individuals 
									LEFT JOIN menu_disk_credits ON (individuals.ind_id = menu_disk_credits.ind_id)
									LEFT JOIN author_type ON (menu_disk_credits.author_type_id = author_type.author_type_id)
									WHERE menu_disk_credits.menu_disk_id = '$menu_disk_id'
									ORDER BY individuals.ind_name ASC";
				
				$query_individual = $mysqli->query($sql_individuals);
				
				while  ($query = $query_individual->fetch_array(MYSQLI_BOTH)) 
				{
						// This smarty is used for for the menu_disk credits
						$smarty->append('individuals',
	    				array('menu_disk_credits_id' => $query['menu_disk_credits_id'],
						  	  'ind_id' => $query['ind_id'],
						  	  'ind_name' => $query['ind_name'],
						  	  'menu_disk_id' => $menu_disk_id,
						  	  'author_type_info' => $query['author_type_info']));
				
				}
				
				
				$smarty->assign('smarty_action', 'update_menu_disk_credits');
				//Send to smarty for return value
				$smarty->display("file:".$cpanel_template_folder."ajax_menus_detail.html");
}
}

//****************************************************************************************
// UPDATE STATE
//**************************************************************************************** 

if(isset($action) and ( $action=="change_menu_disk_state" or $action=="change_menu_disk_year" ))
{
if(isset($menu_disk_id)) 
{
		if ( $action=="change_menu_disk_state" )
		{
		//Update state
		$sql = $mysqli->query("UPDATE menu_disk SET state='$state_id' 
					    WHERE menu_disk_id='$menu_disk_id'");
		}
		else
		{
			// first check if the menu has already a year entry
			$sql = $mysqli->query("SELECT * FROM menu_disk_year
						WHERE menu_disk_id = '$menu_disk_id'") or die ("error selecting menu disk");
			if ( get_rows($sql) > 0 )
			{		
				//Update year
				$sql = $mysqli->query("UPDATE menu_disk_year SET menu_year='$year_id' 
					    WHERE menu_disk_id='$menu_disk_id'");
			}
			else
			{
				$sql_menu_year = $mysqli->query("INSERT INTO menu_disk_year (menu_year, menu_disk_id) VALUES ('$year_id','$menu_disk_id')") or die ("error inserting menu year"); 
			}
		}
		
				$sql_menus = "SELECT menu_disk.menu_sets_id,
						menu_set.menu_sets_name,
						menu_disk.menu_disk_id,
						menu_disk.menu_disk_number,
						menu_disk.menu_disk_letter,
						menu_disk.menu_disk_version,
						menu_disk.menu_disk_part,
						crew.crew_id,
						crew.crew_name,
						individuals.ind_id,
						individuals.ind_name,
						menu_disk_state.state_id,
						menu_disk_state.menu_state,
						menu_disk_year.menu_disk_year_id,
						menu_disk_year.menu_year
						FROM menu_disk 
						LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
						LEFT JOIN crew_menu_prod ON (menu_set.menu_sets_id = crew_menu_prod.menu_sets_id)
						LEFT JOIN crew ON (crew_menu_prod.crew_id = crew.crew_id)
						LEFT JOIN ind_menu_prod ON (menu_set.menu_sets_id = ind_menu_prod.menu_sets_id)
						LEFT JOIN individuals ON (ind_menu_prod.ind_id = individuals.ind_id)
						LEFT JOIN menu_disk_state ON ( menu_disk.state = menu_disk_state.state_id)
						LEFT JOIN menu_disk_year ON ( menu_disk.menu_disk_id = menu_disk_year.menu_disk_id)
						WHERE menu_disk.menu_disk_id = '$menu_disk_id'";
				
				$result_menus= $mysqli->query($sql_menus) or die ('error in query');
				$row=$result_menus->fetch_array(MYSQLI_BOTH);

				$menu_disk_state = $row['state_id'];
				$menu_disk_year = $row['menu_year'];
				
				// Create Menu disk name
				$menu_disk_name = "$row[menu_sets_name] ";
				if(isset($row['menu_disk_number'])) {$menu_disk_name .= "$row[menu_disk_number]";}
				if(isset($row['menu_disk_letter'])) {$menu_disk_name .= "$row[menu_disk_letter]";}
				if(isset($row['menu_disk_part'])) 
					{
						if (is_numeric($row['menu_disk_part']))
							{$menu_disk_name .= " part $row[menu_disk_part]";}
							else 
							{
								$menu_disk_name .= "$row[menu_disk_part]";
							}
					}
				if(isset($row['menu_disk_version']) and $row['menu_disk_version']!=='') {$menu_disk_name .= " v$row[menu_disk_version]";}
					
					$smarty->assign('menus',
	   			 	 array('menu_sets_id' => $row['menu_sets_id'],
						   'menu_sets_name' => $row['menu_sets_name'],
						   'menu_disk_name' => $menu_disk_name,
						   'menu_disk_id' => $row['menu_disk_id'],
						   'menu_disk_number' => $row['menu_disk_number'],
						   'menu_disk_letter' => $row['menu_disk_letter'],
						   'menu_disk_version' => $row['menu_disk_version'],
						   'menu_disk_part' => $row['menu_disk_part'],
						   'crew_id' => $row['crew_id'],
						   'crew_name' => $row['crew_name'],
						   'ind_id' => $row['ind_id'],
						   'ind_name' => $row['ind_name'],
						   'menu_year' => $row['menu_year'],
						   'menu_state' => $row['menu_state']));
				
				//list of games for the menu disk
				$sql_games = "SELECT game.game_name AS 'software_name',
								pub_dev.pub_dev_name AS 'developer_name',
								game_year.game_year AS 'year',
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_game ON (menu_disk_title.menu_disk_title_id = menu_disk_title_game.menu_disk_title_id)
								LEFT JOIN game ON (menu_disk_title_game.game_id = game.game_id)
								LEFT JOIN game_developer ON (game.game_id = game_developer.game_id)
								LEFT JOIN pub_dev ON (game_developer.dev_pub_id = pub_dev.pub_dev_id)
								LEFT JOIN game_year ON (game.game_id = game_year.game_id)
								LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
								WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '1' ORDER BY game.game_name ASC";
				
				$sql_demos = "SELECT demo.demo_name AS 'software_name',
								crew.crew_name AS 'developer_name',
								demo_year.demo_year AS 'year',
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_demo ON (menu_disk_title.menu_disk_title_id = menu_disk_title_demo.menu_disk_title_id)
								LEFT JOIN demo ON (menu_disk_title_demo.demo_id = demo.demo_id)
								LEFT JOIN demo_year ON (demo.demo_id = demo_year.demo_id)
								LEFT JOIN crew_demo_prod ON (demo.demo_id = crew_demo_prod.demo_id)
								LEFT JOIN crew ON (crew_demo_prod.crew_id = crew.crew_id)
								LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
								WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '2' ORDER BY demo.demo_name ASC";				
				
				$sql_tools = "SELECT tools.tools_name AS 'software_name',
								'' AS developer_name,
								'' AS year,
								menu_disk_title.menu_disk_title_id,
								menu_types_main.menu_types_text
								FROM menu_disk_title
								LEFT JOIN menu_disk_title_tools ON (menu_disk_title.menu_disk_title_id = menu_disk_title_tools.menu_disk_title_id)
								LEFT JOIN tools ON (menu_disk_title_tools.tools_id = tools.tools_id)
								LEFT JOIN menu_types_main ON (menu_disk_title.menu_types_main_id = menu_types_main.menu_types_main_id)
								WHERE menu_disk_title.menu_disk_id = '$menu_disk_id' AND menu_disk_title.menu_types_main_id = '3' ORDER BY tools.tools_name ASC";
				
				$temp_query = $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_games") or die(mysqli_error());
				$temp_query = $mysqli->query("INSERT INTO temp $sql_demos") or die(mysqli_error());
				$temp_query = $mysqli->query("INSERT INTO temp $sql_tools") or die(mysqli_error());

				$temp_query = $mysqli->query("SELECT * FROM temp GROUP BY menu_disk_title_id ORDER BY software_name ASC") or die("does not compute3");

				
				while  ($query = $temp_query->fetch_array(MYSQLI_BOTH)) 
				{ 		
					
					// This smarty is used for creating the list of games
						$smarty->append('game',
	    				array('game_name' => $query['software_name'],
						  	  'developer_name' => $query['developer_name'],
						  	  'year' => $query['year'],
						  	  'menu_disk_title_id' => $query['menu_disk_title_id'],
						  	  'menu_types_text' => $query['menu_types_text']));
				}
				
				// Get the menudisk credits
				$sql_individuals = "SELECT 
									individuals.ind_id,
									individuals.ind_name,
									menu_disk_credits.menu_disk_credits_id,
									author_type.author_type_info
									FROM individuals 
									LEFT JOIN menu_disk_credits ON (individuals.ind_id = menu_disk_credits.ind_id)
									LEFT JOIN author_type ON (menu_disk_credits.author_type_id = author_type.author_type_id)
									WHERE menu_disk_credits.menu_disk_id = '$menu_disk_id'
									ORDER BY individuals.ind_name ASC";
				
				$query_individual = $mysqli->query($sql_individuals);
				
				while  ($query = $query_individual->fetch_array(MYSQLI_BOTH)) 
				{
						// This smarty is used for for the menu_disk credits
						$smarty->append('individuals',
	    				array('menu_disk_credits_id' => $query['menu_disk_credits_id'],
						  	  'ind_id' => $query['ind_id'],
						  	  'ind_name' => $query['ind_name'],
						  	  'menu_disk_id' => $menu_disk_id,
						  	  'author_type_info' => $query['author_type_info']));
				}
				
				// Menu state dropdown
				$query_menu_state = $mysqli->query("SELECT * FROM menu_disk_state ORDER BY state_id ASC");
				
				while  ($query = $query_menu_state->fetch_array(MYSQLI_BOTH)) 
				{
					// This smarty is used for for the menu_disk credits
					$smarty->append('state_id', $query['state_id']);
					$smarty->append('menu_state', $query['menu_state']);
				}
				 			
				$smarty->assign('menu_state_id', $menu_disk_state);
				$smarty->assign('menu_year_id', $menu_disk_year);
				
				$smarty->assign('smarty_action', 'edit_disk_box');
				$smarty->assign('menu_disk_id', $menu_disk_id);

				//Send to smarty for return value
				$smarty->display("file:".$cpanel_template_folder."ajax_menus_detail.html");
}
}
