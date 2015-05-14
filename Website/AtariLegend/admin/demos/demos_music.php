<?
/***************************************************************************
*                                demos_music.php
*                            --------------------------
*   begin                : saturday, November 19, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*						   Created file
*						
*   Id: demos_music.php,v 0.10 2005/11/19 ST Graveyard
*
***************************************************************************/

//load all common functions
include("../includes/common.php"); 

/*
************************************************************************************************
This is the demo music main page
************************************************************************************************
*/
$start1=gettimeofday();
list($start2, $start3) = explode(":", exec('date +%N:%S'));
				
if ($action == 'search')
{
	//check the $gamebrowse select
	if ($demobrowse == "")
	{
		$demobrowse_select = "";
	}
	elseif ($demobrowse == '-')
	{
		$demobrowse_select = "";
	}
	elseif ($demobrowse == 'num')
	{
		$demobrowse_select = "demo.demo_name REGEXP '^[0-9].*' AND ";
	}
	else
	{
		$demobrowse_select = "demo.demo_name LIKE '$gamebrowse%' AND ";
	}
	
	//Before we start the build the query, we check if there is at least
	//one search field filled in or used! 
	
	if ( $demobrowse_select == ""  and $demosearch == "" )
	{
		$smarty->assign("message","Please fill in one of the search fields");
		
		$smarty->assign("user_id",$_SESSION['user_id']);
		$smarty->assign('demos_music_tpl', '1');

		//Send all smarty variables to the templates
		$smarty->display('file:../templates/0/index.tpl');

		//close the connection
		mysql_close();
	}
	else
	{
		//In all cases we search we start searching through the demo table
		//first
		$RESULTDEMO = "SELECT 
							demo.demo_id, 
							demo.demo_name, 
							crew.crew_name, 
							crew.crew_id, 
							demo_year.demo_year
					   FROM demo
					   LEFT JOIN crew_demo_prod ON ( demo.demo_id = crew_demo_prod.demo_id ) 
					   LEFT JOIN crew ON ( crew_demo_prod.crew_id = crew.crew_id ) 
					   LEFT JOIN demo_year ON ( demo_year.demo_id = demo.demo_id ) WHERE ";
		
		$RESULTDEMO .= $demobrowse_select;
		$RESULTDEMO .= "demo.demo_name LIKE '%$demosearch%'"; 
		$RESULTDEMO .= ' ORDER BY demo.demo_name ASC';
		
		$demos = mysql_query($RESULTDEMO);
		
		if (!$demos)
		{
			echo "Couldn't query demos database for demos starting with a certain number";
		}
		else
		{
			$rows = mysql_num_rows($demos);
			if ( $rows > 0 )
			{
				while ( $row=mysql_fetch_assoc($demos) ) 
				{  
					$i++;
				
					//check how many muzaks there are for the game
					$numberzaks = mysql_query("SELECT count(*) as count FROM demo_music WHERE demo_id='$row[demo_id]'")
				    			  or die ("couldn't get number of zaks");
				
					$array = mysql_fetch_array($numberzaks);
				
					$smarty->append('music',
	   			 	 array('demo_id' => $row['demo_id'],
						   'demo_name' => $row['demo_name'],
						   'demo_crew' => $row['crew_name'],
						   'demo_year' => $row['demo_year'],
						   'number_zaks' => $array['count']));	
				}	
				
				$end1=gettimeofday();
				$totaltime1 = (float)($end1['sec'] - $start1['sec']) + ((float)($end1['usec'] - $start1['usec'])/1000000);

				$smarty->assign('querytime', $totaltime1);
				$smarty->assign('nr_of_entries', $i);
				
				$smarty->assign("user_id",$_SESSION['user_id']);
				$smarty->assign('demos_music_list_tpl', '1');
				
				//Send all smarty variables to the templates
				$smarty->display('file:../templates/0/index.tpl');

				//close the connection
				mysql_close();	
			}	
			else
			{
				$smarty->assign("message","No entries for your query!");
		
				$smarty->assign("user_id",$_SESSION['user_id']);
				$smarty->assign('demos_music_tpl', '1');

				//Send all smarty variables to the templates
				$smarty->display('file:../templates/0/index.tpl');

				//close the connection
				mysql_close();
			}
		}
	}
}
else
{
	$smarty->assign("user_id",$_SESSION['user_id']);
	$smarty->assign('demos_music_tpl', '1');

	//Send all smarty variables to the templates
	$smarty->display('file:../templates/0/index.tpl');

	//close the connection
	mysql_close();
}
?>
