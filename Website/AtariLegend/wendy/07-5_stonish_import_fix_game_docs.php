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

$menu_types_main_id = 1;
//Allright lets do the first query
//$query = $mysqli->query("SELECT * FROM tools"); 
if (isset($continue) and $continue==1)
{
$query = $mysqli->query("SELECT * FROM menu_disk_title_game"); 
					 
//Lets do some stuff.
while ($result = $query->fetch_array(MYSQLI_BOTH))  
{	
$count=$count+1;
	$menu_disk_title_game_id = $result['menu_disk_title_game_id'];
	$menu_disk_title_id = $result['menu_disk_title_id'];

//echo "$tools_name added to: - Menudisk $menu_disk_id<br/>";

		//Start Insert software into menu tables.
		$sql = "DELETE FROM menu_disk_title WHERE menu_disk_title_id='$menu_disk_title_id'";

		$mysqli->query($sql) or die("first delete failed... start looking for that backup.");
		echo "$sql - OK!<br/>";
		//$last_id = $mysqli->insert_id;

		$sql2 = "DELETE FROM menu_disk_title_game WHERE menu_disk_title_game_id='$menu_disk_title_game_id'";

		$mysqli->query($sql2) or die("second delete failed... start looking for that backup.");
		echo "---$sql2 - OK!<br/>";
}

//Lets start repopulating the menudisk title games tables

$query = $mysqli->query("SELECT menu_disk.menu_disk_id,
								stonish_legend.id_allmenus
								FROM menu_disk
								LEFT JOIN stonish_legend ON (menu_disk.menu_disk_id = stonish_legend.menu_disk_id)"); 
while ($result = $query->fetch_array(MYSQLI_BOTH))  
{	

	$menu_disk_id = $result['menu_disk_id'];
	$id_allmenus = $result['id_allmenus'];

	$query2 = $mysqli->query("SELECT stonish_software.idlegend
								FROM stonish_allcontent
								LEFT JOIN stonish_software ON (stonish_allcontent.content = stonish_software.id_software)
								WHERE stonish_software.typeofsoftware='1' AND stonish_software.id_software!='0' AND stonish_allcontent.type=''
								 AND stonish_allcontent.id_menus ='$id_allmenus'"); 
			
			while ($result2 = $query2->fetch_array(MYSQLI_BOTH))  
			{
				$game_id = $result2['idlegend'];

				$sql = "INSERT INTO menu_disk_title (menu_disk_id,menu_types_main_id) VALUES ('$menu_disk_id','$menu_types_main_id')";
				
				$mysqli->query($sql) or die("first insert failed... start looking for that backup.");
				echo "$sql - OK!<br/>";
				
				$last_id = $mysqli->insert_id;
				
				$sql2 = "INSERT INTO menu_disk_title_game (menu_disk_title_id,game_id) VALUES ('$last_id','$game_id')";
				
				$mysqli->query($sql2) or die("second insert failed... start looking for that backup.");
				echo "---$sql2 - OK!<br/>";
				
			}		


}
}
else {
	
	echo "Ok, lets face it guys, Silver Surfer made a big boo boo and now it need to be fixed!!!<br/>
	<br/>
	So what is wrong?<br/>
	<br/>
	Well, with the initial import of the menus the games was also inserted to the menu_disk_title tables... now that is correct... partly. 
	Some of the stonish db rows were type-tagged with forexample \"docs\" or \"datadisk\". This populated the AL db with lots of game entried
	 that infact were doc files or others<br/><br/>
	
	So what this script will do is to delete all records from menu_disk_title_game table and the corresponding rows in menu_disk_title table.<br/>
	After that, we will repopulate these 2 tables with the correct game information.<br/><br/>
	
	<a href=\"../wendy/07-5_stonish_import_fix_game_docs.php?continue=1\">Continue</a>";
	
	
}

?>
