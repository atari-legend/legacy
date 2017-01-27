<?php
/***************************************************************************
*                                stonish import script
*                            -----------------------
*   begin                : Tuesday, April 22, 2015
*   copyright            : (C) 2015 Atari Legend
*   email                : 
*   actual update        : Creation of file
*
*   Id: 
*
***************************************************************************/

//*********************************************************************************************
// This script will import stonish into the AL database
//********************************************************************************************* 

include("../includes/common.php");
$count=1;

$menu_types_main_id = 3;
//Allright lets do the first query
//$query = $mysqli->query("SELECT * FROM tools"); 
if (isset($continue) and $continue==1)
{
$query = $mysqli->query("SELECT *
										FROM stonish_allcontent 
										LEFT JOIN stonish_legend ON (stonish_allcontent.id_menus = stonish_legend.id_allmenus)
										LEFT JOIN tools ON (stonish_allcontent.content = tools.stonish_id)
										WHERE tools.stonish_id IS NOT NULL AND stonish_legend.menu_disk_id IS NOT NULL AND stonish_allcontent.type=''"); 
					 
//Lets do some stuff.
while ($result = $query->fetch_array(MYSQLI_BOTH))  
{	
$count=$count+1;
	$menu_disk_id = $result['menu_disk_id'];
	$tools_id = $result['tools_id'];
	$tools_name = $result['tools_name'];

//echo "$tools_name added to: - Menudisk $menu_disk_id<br/>";

		//Start Insert software into menu tables.
		$sql = "INSERT INTO menu_disk_title (menu_disk_id,menu_types_main_id) VALUES ('$menu_disk_id','$menu_types_main_id')";

		$mysqli->query($sql) or die("first insert failed... start looking for that backup.");
		echo "$sql - OK!<br/>";
		$last_id = $mysqli->insert_id;

		$sql2 = "INSERT INTO menu_disk_title_tools (menu_disk_title_id,tools_id) VALUES ('$last_id','$tools_id')";

		$mysqli->query($sql2) or die("second insert failed... start looking for that backup.");
		echo "---$sql2 - OK!<br/>";
}
}
else {
	
	echo "Are you really sure you want to run this script?<br/>
	<br/>
	What this script will do is to populate the AL menu database with entiries from the tools db, getting the data from the stonish db.<br/>
	<br/>
	Make sure you have a database backup before continuing!<br/><br/>
	
	<a href=\"../wendy/06-5_stonish_import_add_tools_to_menus.php?continue=1\">Continue</a>";
	
	
}

?>
