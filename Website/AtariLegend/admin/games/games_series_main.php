<?
/***************************************************************************
*                             games_series_main.php
*                            -----------------------
*   begin                : Saturday, Sept 24, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : Creation from scratch for smarty usage
						   
*							
*
*   Id: games_series_main.php,v 0.2 2005/09/24 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
Build game series page
***********************************************************************************
*/

include("../includes/common.php");

	// SERIES LIST DROPDOWN
	
	
				
				$sql_series = mysql_query("SELECT * FROM game_series ORDER BY game_series_name ASC")
				 		    or die ("Couldn't query Game Series Database1");
		
				while  ($query_series = mysql_fetch_array ($sql_series)) 
				{  
				   
				  $smarty->append('game_series',
	    			array('game_series_id' => $query_series[game_series_id],
						  'game_series_name' => $query_series[game_series_name]));
				}
	if ( $series_page == '' ) { }
	else
	{
			global $series_page;
			
			switch ($series_page) 
			{
			case 'add_series' :
				$smarty->assign('series_info',
	    			array('series_page' => $series_page));
				break;
				
			case 'series_editor' :
				// Get the information of the selected gameseries	
				$sql_series2 = mysql_query("SELECT * FROM game_series WHERE game_series_id='$game_series_id'")
									or die ("Couldn't query Game Series Database2");

								$query_series2 = mysql_fetch_array ($sql_series2);
				
				// Check if there is a game linked to this series. For the list of games in a series
				$sql_series_link = mysql_query("SELECT * FROM game_series_cross 
												LEFT JOIN game ON (game_series_cross.game_id = game.game_id)
												LEFT JOIN game_series ON (game_series_cross.game_series_id = game_series.game_series_id)
												WHERE game_series_cross.game_series_id='$game_series_id' ORDER BY game.game_name")
				 		   		 				or die ("Couldn't query Game Series Database3");
				// check how many games is linked to a particular series
				$sql_series_link_nr = mysql_num_rows($sql_series_link);
				
				$smarty->assign('series_info',
	    			array('game_series_id' => $query_series2[game_series_id],
						  'game_series_name' => $query_series2[game_series_name],
						  'sql_series_link_nr' => $sql_series_link_nr,
						  'series_page' => $series_page));
				
				while  ($query_series_link = mysql_fetch_array ($sql_series_link)) 
				{ 		// This smarty is used for creating the list of games contained within a game series
						$smarty->append('series_link',
	    				array('game_series_cross_id' => $query_series_link[game_series_cross_id],
							  'game_id' => $query_series_link[game_id],
						  	  'game_name' => $query_series_link[game_name],
							  'publisher_name' => $query_series_link[publisher_name],
							  'developer_name' => $query_series_link[developer_name],
							  'year' => $query_series_link[year]));
				}
				
				
				
				break;
				
			case 'addgames_series' :
				// Get the information of the selected gameseries	
				$sql_series2 = mysql_query("SELECT * FROM game_series WHERE game_series_id='$game_series_id'")
									or die ("Couldn't query Game Series Database4");

								$query_series2 = mysql_fetch_array ($sql_series2);
				
				// Do a simple gamesearch... no aka's or the likes of that.
				
					if ($gamebrowse == 'num' or $gamebrowse == '' and $gamesearch == '')
					{
						$gamebrowse_select = "game_name REGEXP '^[0-9].*'";
					}
					elseif ($gamebrowse == 'a' or $gamebrowse == 'b' or $gamebrowse == 'c' or $gamebrowse == 'd' or $gamebrowse == 'e' or $gamebrowse == 'f' or $gamebrowse == 'g' or $gamebrowse == 'h' or $gamebrowse == 'i' or $gamebrowse == 'j' or $gamebrowse == 'k' or $gamebrowse == 'l' or $gamebrowse == 'm' or $gamebrowse == 'n' or $gamebrowse == 'o' or $gamebrowse == 'p' or $gamebrowse == 'q' or $gamebrowse == 'r' or $gamebrowse == 's' or $gamebrowse == 't' or $gamebrowse == 'u' or $gamebrowse == 'v' or $gamebrowse == 'w' or $gamebrowse == 'x' or $gamebrowse == 'y' or $gamebrowse == 'z')
					{
					$gamebrowse_select = "game_name LIKE '$gamebrowse%'";
					}
					elseif ($gamesearch !== '' or $gamebrowse == '')
					{
					$gamebrowse_select = "game_name LIKE '%$gamesearch%'";
					}
				
				 $sql_build = "SELECT game.game_id,
							   game.game_name,
							   game_publisher.pub_dev_id as 'publisher_id',
							   pd1.pub_dev_name as 'publisher_name',
							   game_developer.dev_pub_id as 'developer_id',
							   pd2.pub_dev_name as 'developer_name',
							   game_year.game_year_id,
							   game_year.game_year AS 'year',
							   COUNT(screenshot_game.screenshot_id) AS 'screenshot',
							   COUNT(game_music.music_id) AS 'music',
							   COUNT(game_boxscan.game_boxscan_id) AS 'boxscan',
							   COUNT(game_download.game_download_id) AS 'download',
							   game_ste_enhan.ste_enhanced,
							   game_ste_only.ste_only ";
				$sql_build .= "	FROM game ";
				$sql_build .= "	LEFT JOIN game_year on (game_year.game_id = game.game_id) ";
				$sql_build .= " LEFT JOIN game_publisher ON (game_publisher.game_id = game.game_id)"; 
				$sql_build .= " LEFT JOIN pub_dev pd1 ON (pd1.pub_dev_id = game_publisher.pub_dev_id)"; 
				$sql_build .= " LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)";
				$sql_build .= " LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)"; 

				$sql_build .= " LEFT JOIN game_boxscan ON (game_boxscan.game_id = game.game_id) ";
				$sql_build .= " LEFT JOIN screenshot_game ON (screenshot_game.game_id = game.game_id) ";
				$sql_build .= " LEFT JOIN game_music ON (game_music.game_id = game.game_id) ";
				$sql_build .= " LEFT JOIN game_download ON (game_download.game_id = game.game_id) ";

				$sql_build .= " LEFT JOIN game_ste_enhan ON (game.game_id = game_ste_enhan.game_id) 
								LEFT JOIN game_ste_only ON (game.game_id = game_ste_only.game_id)";
				$sql_build .= " LEFT JOIN game_falcon_only ON (game_falcon_only.game_id = game.game_id) "; 
				$sql_build .= " LEFT JOIN game_development ON (game_development.game_id = game.game_id) "; 
				$sql_build .= " LEFT JOIN game_wanted ON (game_wanted.game_id = game.game_id) "; 
				$sql_build .= " WHERE ";
				$sql_build .= $gamebrowse_select;
				$sql_build .= " GROUP BY game.game_name";

				$sql_series_link = mysql_query($sql_build)
				 		   		 	or die ("Couldn't query Game Series Database5 ($sql_build)");
				
				$smarty->assign('series_info',
	    			array('game_series_id' => $query_series2[game_series_id],
						  'game_series_name' => $query_series2[game_series_name],
						  'series_page' => $series_page));
				
				while  ($query_series_link = mysql_fetch_array ($sql_series_link)) 
				{ 		// This smarty is used for creating the list of games contained within a game series
						$smarty->append('series_link',
	    				array('game_series_cross_id' => $query_series_link[game_series_cross_id],
							  'game_id' => $query_series_link[game_id],
						  	  'game_name' => $query_series_link[game_name],
							  'publisher_name' => $query_series_link[publisher_name],
							  'developer_name' => $query_series_link[developer_name],
							  'year' => $query_series_link[year]));
				}
				
				
				
				break;
				
				
				
				
			case 'edit_series' :
				
				
				// Get the information of the selected gameseries	
				$sql_series2 = mysql_query("SELECT * FROM game_series WHERE game_series_id='$game_series_id'")
									or die ("Couldn't query Game Series Database6");

								$query_series2 = mysql_fetch_array ($sql_series2);
				
				$smarty->assign('series_info',
	    			array('series_page' => $series_page,
						  'game_series_id' => $query_series2[game_series_id],
						  'game_series_name' => $query_series2[game_series_name]));
				break;
			default :
			}
	}
	

$smarty->assign('games_series_main_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');
?>