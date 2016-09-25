<?php
/***************************************************************************
*                             ajax_addset_menus.php
*                            -----------------------
*   begin                : Thursday, Sept 22, 2016
*   copyright            : (C) 2016 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : creation of file
						   
*							
*
*   Id: ajax_addset_menus.php,v 0.1 2016/09/22 STG
*
***************************************************************************/

/* here we will add a game set/chain for a set */

include("../../includes/common.php");
include("../../includes/admin.php");

//get all the title chains to fill the dropdown
$sql_games_chain = "SELECT game.game_id AS 'software_id',
					game.game_name AS 'software_name',
					menu_set.menu_sets_name,
					menu_disk.menu_disk_id,
					menu_disk.menu_disk_number,
					menu_disk.menu_disk_letter,
					menu_disk.menu_disk_part,
					menu_disk.menu_disk_version,
					menu_disk_title_set.menu_disk_title_set_id,
					menu_disk_title_set.menu_disk_title_set_nr,
					menu_disk_title_set.menu_disk_title_set_chain,
					menu_disk_title_set.menu_disk_title_id
					FROM menu_disk_title_set
					LEFT JOIN menu_disk_title_game ON (menu_disk_title_game.menu_disk_title_id = menu_disk_title_set.menu_disk_title_id)
					LEFT JOIN game ON (game.game_id = menu_disk_title_game.game_id)
					LEFT JOIN menu_disk_title ON (menu_disk_title.menu_disk_title_id = menu_disk_title_game.menu_disk_title_id)
					LEFT JOIN menu_disk ON ( menu_disk.menu_disk_id = menu_disk_title.menu_disk_id )
					LEFT JOIN menu_set ON (menu_set.menu_sets_id = menu_disk.menu_sets_id)
					WHERE menu_disk_title.menu_types_main_id = '1'";
					
$sql_demos_chain = "SELECT demo.demo_id AS 'software_id',
					demo.demo_name AS 'software_name',
					menu_set.menu_sets_name,
					menu_disk.menu_disk_id,
					menu_disk.menu_disk_number,
					menu_disk.menu_disk_letter,
					menu_disk.menu_disk_part,
					menu_disk.menu_disk_version,
					menu_disk_title_set.menu_disk_title_set_id,
					menu_disk_title_set.menu_disk_title_set_nr,
					menu_disk_title_set.menu_disk_title_set_chain,
					menu_disk_title_set.menu_disk_title_id
					FROM menu_disk_title_set
					LEFT JOIN menu_disk_title_demo ON (menu_disk_title_demo.menu_disk_title_id = menu_disk_title_set.menu_disk_title_id)
					LEFT JOIN demo ON (demo.demo_id = menu_disk_title_demo.demo_id)
					LEFT JOIN menu_disk_title ON (menu_disk_title.menu_disk_title_id = menu_disk_title_demo.menu_disk_title_id)
					LEFT JOIN menu_disk ON ( menu_disk.menu_disk_id = menu_disk_title.menu_disk_id )
					LEFT JOIN menu_set ON (menu_set.menu_sets_id = menu_disk.menu_sets_id)
					WHERE menu_disk_title.menu_types_main_id = '2'";

$sql_tools_chain = "SELECT tools.tools_id AS 'software_id',
					tools.tools_name AS 'software_name',
					menu_set.menu_sets_name,
					menu_disk.menu_disk_id,
					menu_disk.menu_disk_number,
					menu_disk.menu_disk_letter,
					menu_disk.menu_disk_part,
					menu_disk.menu_disk_version,
					menu_disk_title_set.menu_disk_title_set_id,
					menu_disk_title_set.menu_disk_title_set_nr,
					menu_disk_title_set.menu_disk_title_set_chain,
					menu_disk_title_set.menu_disk_title_id
					FROM menu_disk_title_set
					LEFT JOIN menu_disk_title_tools ON (menu_disk_title_tools.menu_disk_title_id = menu_disk_title_set.menu_disk_title_id)
					LEFT JOIN tools ON (tools.tools_id = menu_disk_title_tools.tools_id)
					LEFT JOIN menu_disk_title ON (menu_disk_title.menu_disk_title_id = menu_disk_title_tools.menu_disk_title_id)
					LEFT JOIN menu_disk ON ( menu_disk.menu_disk_id = menu_disk_title.menu_disk_id )
					LEFT JOIN menu_set ON (menu_set.menu_sets_id = menu_disk.menu_sets_id)
					WHERE menu_disk_title.menu_types_main_id = '3'";

$temp_query = $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_games_chain") or die(mysqli_error());
$temp_query = $mysqli->query("INSERT INTO temp $sql_demos_chain") or die(mysqli_error());
$temp_query = $mysqli->query("INSERT INTO temp $sql_tools_chain") or die("you are a cock");

$temp_query = $mysqli->query("SELECT * FROM temp ORDER BY menu_sets_name, software_name ASC") or die("does not compute3");

$menu_disk_name_compare = "";

while  ($row = $temp_query->fetch_array(MYSQLI_BOTH)) 
{
	// Create Menu disk name
	if(isset($row['menu_sets_name']))
	{
		if(isset($row['menu_sets_name'])) {$menu_disk_name = "$row[menu_sets_name]";}
		
		$menu_disk_name .= " - "; 
		$menu_disk_name .= $row['software_name'];
		
		if ($menu_disk_name_compare == $menu_disk_name)
		{
			$menu_disk_name_compare = $menu_disk_name;
			if ( $row['menu_disk_title_id'] == $menu_disk_title_id )
			{
				$smarty->assign('select_chain_data', $row['menu_disk_title_set_nr'] );
				$smarty->assign('select_chain_nr', $row['menu_disk_title_set_chain'] );
			}
		}
		else
		{
			$smarty->append('chain_data',
			array('menu_disk_title_set_id' => $row['menu_disk_title_set_id'],
				  'menu_disk_title_set_nr' => $row['menu_disk_title_set_nr'],
				  'menu_disk_title_set_chain' => $row['menu_disk_title_set_chain'],
				  'menu_disk_title_id' => $menu_disk_title_id,
				  'menu_disk_name' => $menu_disk_name));
			if ( $row['menu_disk_title_id'] == $menu_disk_title_id )
			{
				$smarty->assign('select_chain_data', $row['menu_disk_title_set_nr'] );
				$smarty->assign('select_chain_nr', $row['menu_disk_title_set_chain'] );
			}
			
			$menu_disk_name_compare = $menu_disk_name;
		}
	}
}

//get the titles from this set
//First get the setnr
$sql_set_nr = "SELECT menu_disk_title_set_nr FROM menu_disk_title_set WHERE menu_disk_title_id = '$menu_disk_title_id'";
$query_ser_nr = $mysqli->query($sql_set_nr) or die ("problem with set nr query");
$query_data = $query_ser_nr->fetch_array(MYSQLI_BOTH);
$set_nr = $query_data['menu_disk_title_set_nr'];	

if ($set_nr <> '')
{
	$sql_games_chain = "SELECT game.game_id AS 'software_id',
						game.game_name AS 'software_name',
						menu_set.menu_sets_name,
						menu_disk.menu_disk_id,
						menu_disk.menu_disk_number,
						menu_disk.menu_disk_letter,
						menu_disk.menu_disk_part,
						menu_disk.menu_disk_version,
						menu_disk_title_set.menu_disk_title_set_id,
						menu_disk_title_set.menu_disk_title_set_nr,
						menu_disk_title_set.menu_disk_title_set_chain,
						menu_disk_title_set.menu_disk_title_id
						FROM menu_disk_title_set
						LEFT JOIN menu_disk_title_game ON (menu_disk_title_game.menu_disk_title_id = menu_disk_title_set.menu_disk_title_id)
						LEFT JOIN game ON (game.game_id = menu_disk_title_game.game_id)
						LEFT JOIN menu_disk_title ON (menu_disk_title.menu_disk_title_id = menu_disk_title_game.menu_disk_title_id)
						LEFT JOIN menu_disk ON ( menu_disk.menu_disk_id = menu_disk_title.menu_disk_id )
						LEFT JOIN menu_set ON (menu_set.menu_sets_id = menu_disk.menu_sets_id)
						WHERE menu_disk_title.menu_types_main_id = '1' AND menu_disk_title_set.menu_disk_title_set_nr = '$set_nr'
						ORDER BY menu_disk_title_set.menu_disk_title_set_chain ASC";
						
	$sql_demos_chain = "SELECT demo.demo_id AS 'software_id',
						demo.demo_name AS 'software_name',
						menu_set.menu_sets_name,
						menu_disk.menu_disk_id,
						menu_disk.menu_disk_number,
						menu_disk.menu_disk_letter,
						menu_disk.menu_disk_part,
						menu_disk.menu_disk_version,
						menu_disk_title_set.menu_disk_title_set_id,
						menu_disk_title_set.menu_disk_title_set_nr,
						menu_disk_title_set.menu_disk_title_set_chain,
						menu_disk_title_set.menu_disk_title_id
						FROM menu_disk_title_set
						LEFT JOIN menu_disk_title_demo ON (menu_disk_title_demo.menu_disk_title_id = menu_disk_title_set.menu_disk_title_id)
						LEFT JOIN demo ON (demo.demo_id = menu_disk_title_demo.demo_id)
						LEFT JOIN menu_disk_title ON (menu_disk_title.menu_disk_title_id = menu_disk_title_demo.menu_disk_title_id)
						LEFT JOIN menu_disk ON ( menu_disk.menu_disk_id = menu_disk_title.menu_disk_id )
						LEFT JOIN menu_set ON (menu_set.menu_sets_id = menu_disk.menu_sets_id)
						WHERE menu_disk_title.menu_types_main_id = '2' AND menu_disk_title_set.menu_disk_title_set_nr = '$set_nr'
						ORDER BY menu_disk_title_set.menu_disk_title_set_chain ASC";

	$sql_tools_chain = "SELECT tools.tools_id AS 'software_id',
						tools.tools_name AS 'software_name',
						menu_set.menu_sets_name,
						menu_disk.menu_disk_id,
						menu_disk.menu_disk_number,
						menu_disk.menu_disk_letter,
						menu_disk.menu_disk_part,
						menu_disk.menu_disk_version,
						menu_disk_title_set.menu_disk_title_set_id,
						menu_disk_title_set.menu_disk_title_set_nr,
						menu_disk_title_set.menu_disk_title_set_chain,
						menu_disk_title_set.menu_disk_title_id
						FROM menu_disk_title_set
						LEFT JOIN menu_disk_title_tools ON (menu_disk_title_tools.menu_disk_title_id = menu_disk_title_set.menu_disk_title_id)
						LEFT JOIN tools ON (tools.tools_id = menu_disk_title_tools.tools_id)
						LEFT JOIN menu_disk_title ON (menu_disk_title.menu_disk_title_id = menu_disk_title_tools.menu_disk_title_id)
						LEFT JOIN menu_disk ON ( menu_disk.menu_disk_id = menu_disk_title.menu_disk_id )
						LEFT JOIN menu_set ON (menu_set.menu_sets_id = menu_disk.menu_sets_id)
						WHERE menu_disk_title.menu_types_main_id = '3' AND menu_disk_title_set.menu_disk_title_set_nr = '$set_nr'
						ORDER BY menu_disk_title_set.menu_disk_title_set_chain ASC";

	$temp_query = $mysqli->query("CREATE TEMPORARY TABLE temp2 ENGINE=MEMORY $sql_games_chain") or die(mysqli_error());
	$temp_query = $mysqli->query("INSERT INTO temp2 $sql_demos_chain") or die(mysqli_error());
	$temp_query = $mysqli->query("INSERT INTO temp2 $sql_tools_chain") or die("you are a cock");

	$temp_query = $mysqli->query("SELECT * FROM temp2 ORDER BY menu_sets_name, software_name ASC") or die("does not compute3");

	while  ($row = $temp_query->fetch_array(MYSQLI_BOTH)) 
	{
		// Create Menu disk name
		if(isset($row['menu_sets_name']))
		{
			$menu_disk_name = "$row[menu_sets_name] ";
			if(isset($row['menu_disk_number'])) {$menu_disk_name .= "$row[menu_disk_number]";}
			if(isset($row['menu_disk_letter'])) {$menu_disk_name .= "$row[menu_disk_letter]";}
			if(isset($row['menu_disk_part'])) 
			{
				if (is_numeric($row['menu_disk_part']))
				{
					$menu_disk_name .= " part $row[menu_disk_part]";
				}
				else 
				{
					$menu_disk_name .= "$row[menu_disk_part]";
				}
			}
			
			if(isset($row['menu_disk_version']) and $row['menu_disk_version']!=='') 
			{
				$menu_disk_name .= " v$row[menu_disk_version]";
			}
			
			$menu_disk_name .= " - "; 
			$menu_disk_name .= $row['software_name'];
			$menu_disk_name .= " - part "; 
			$menu_disk_name .= $row['menu_disk_title_set_chain'];
			
			$smarty->append('selected_chain_data',
			array('menu_disk_title_set_id' => $row['menu_disk_title_set_id'],
				  'menu_disk_title_set_nr' => $row['menu_disk_title_set_nr'],
				  'menu_disk_title_set_chain' => $row['menu_disk_title_set_chain'],
				  'menu_disk_title_id' => $menu_disk_title_id,
				  'menu_disk_name' => $menu_disk_name));	
		}
	}
}

$smarty->assign('menu_disk_title_id',$menu_disk_title_id);
$smarty->assign('menu_disk_id',$menu_disk_id);
$smarty->assign('title_name',$title_name);

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."ajax_menus_add_set.html");
