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
$continue = 0;
//Allright lets do the first query
$query = $mysqli->query("SELECT menu_disk.menu_disk_id,
										menu_disk.state,
										stonish_allmenus.id_allmenus,
										stonish_allmenus.stateofdisk
										FROM menu_disk
										LEFT JOIN stonish_legend ON ( menu_disk.menu_disk_id = stonish_legend.menu_disk_id )								
										LEFT JOIN stonish_allmenus ON ( stonish_legend.id_allmenus = stonish_allmenus.id_allmenus )
										ORDER BY menu_disk.menu_disk_id"); 
					 
//Lets do some stuff.
while ($result = $query->fetch_array(MYSQLI_BOTH))  
{	
$count=$count+1;
	$menu_disk_id = $result['menu_disk_id'];
	$state = $result['state'];
	$id_allmenus = $result['id_allmenus'];
	$stateofdisk = $result['stateofdisk'];

 if ($state==$stateofdisk and (isset($stateofdisk) and $stateofdisk!=="")) 
	{
		echo "<font color='green'>$count - $menu_disk_id state is OK and according to the Stonish DB</font>";
	}
	else
	{
		//if (isset($action) and $action=="do_update")
		if (isset($stateofdisk) and $stateofdisk!=="") 
			{
				if (isset($action) and $action=="do_update")
				{
					$sql = $mysqli->query("UPDATE menu_disk SET state='$stateofdisk' 
					    WHERE menu_disk_id='$menu_disk_id'");
					echo "<font color='blue'>$count - $menu_disk_id has been updated according to the stonish DB</font>";
				}
				else
				{
					echo "<font color='red'>$count - $menu_disk_id state is NOT OK and need to be updated according to the Stonish DB</font>";
					$continue = 1;
				}
			}
	}

	echo "<br/>";
}

		if ($continue==1)
		{
		
		echo "<br/><br/>
		
		<a href=\"../wendy/stonish_import_state.php?action=do_update\">DO UPDATE</a><br/>
		";
		
		}
?>
