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
if (isset($continue) and $continue==1) {} else {$continue = 0;}
if ($continue==0) {
echo "
<blockquote>
Ok, this is the screenshot stonish to atarilegend conversion utility.<br/>
<br/>
Before continuing you need to:<br/>
<br/>
1. Make sure you have a folder called /data/images/menus_screenshots/<br/>
2. Make sure you have all the stonish screenshots in /data/temp/screenshot/<br/>
3. Make sure you have the database table screenshot_menu.<br/>
4. You have just made a backup of your database!<br/>
<br/>
If you made sure that is done, click continue.<br/>
<br/>
<a href=\"../wendy/stonish_import_screenshot.php?continue=1\">CONTINUE</a><br/>
</blockquote>";

}
elseif ($continue==1)
{

//Allright lets do the first query
$query = $mysqli->query("SELECT menu_disk.menu_disk_id,
								menu_disk.state,
								stonish_allmenus.id_allmenus,
								stonish_allmenus.screenshot
								FROM menu_disk
								LEFT JOIN stonish_legend ON ( menu_disk.menu_disk_id = stonish_legend.menu_disk_id )								
								LEFT JOIN stonish_allmenus ON ( stonish_legend.id_allmenus = stonish_allmenus.id_allmenus )
								WHERE stonish_allmenus.screenshot IS NOT NULL ORDER BY menu_disk.menu_disk_id"); 
					 
//Lets do some stuff.
while ($result = $query->fetch_array(MYSQLI_BOTH))  
{	
$count=$count+1;
	$menu_disk_id = $result['menu_disk_id'];
	$state = $result['state'];
	$id_allmenus = $result['id_allmenus'];
	$screenshot = $result['screenshot'];
	$temp_path = "../data/temp/screenshot/";
	$old_file = "$temp_path$screenshot";
	$ext = "png";
	
	if ($screenshot!=="")
	{
					$mysqli->query("INSERT INTO screenshot_main (imgext) VALUES ('$ext')")
					or die ("Database error - inserting screenshots");
					$last_id = $mysqli->insert_id;
					
					$mysqli->query("INSERT INTO screenshot_menu (menu_disk_id, screenshot_id) VALUES ($menu_disk_id, $last_id)")
					or die ("Database error - inserting screenshots2");
					
					$new_file = "$menu_screenshot_path$last_id.png";
					
		if (!copy($old_file, $new_file)) {
			echo "failed to copy $file...\n";
			}
		
	echo "
	<table>
		<tr>
			<td>$count - menu_disk_id = $menu_disk_id</td>
			<td><img src=\"$old_file\"></td>
			<td>The Deed is DONE!!! New name is $last_id.png</td>
		</tr>
	</table>";
	}
    
		
}
}
?>
