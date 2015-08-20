<?php
/***************************************************************************
*                                statistics.php
*                            ----------------------------
*   begin                : Tuesday, April 14, 2015
*   copyright            : (C) 2015 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : Creation of file
*
*   Id: statistics.php,v 0.1 2015/04/18 22:56 Silver Surfer
*
***************************************************************************/

//*********************************************************************************************
// This is the php code for the latest news tile
//********************************************************************************************* 

// START - NUMBER OF GAMES IN ARCHIVE
$sql_game_count = $mysqli->query("SELECT COUNT(*) AS count FROM game"); 
$query_game_count = $sql_game_count->fetch_array(MYSQLI_BOTH);
// END - NUMBER OF GAMES IN ARCHIVE						 

// START - NUMBER OF DEMOS IN ARCHIVE
$sql_demo_count = $mysqli->query("SELECT COUNT(*) AS count FROM demo"); 
$query_demo_count = $sql_demo_count->fetch_array(MYSQLI_BOTH);
// END - NUMBER OF DEMOS IN ARCHIVE		
	
// START - COUNT GAME SCREENSHOTS IN ARCHIVE
$sql_gamescreenshot_count = $mysqli->query("SELECT COUNT(*) AS count FROM screenshot_game"); 
$query_gamescreenshot_count = $sql_gamescreenshot_count->fetch_array(MYSQLI_BOTH);
// END - COUNT GAME SCREENSHOTS IN ARCHIVE
	
// START - COUNT HOW MANY GAMES HAS BOXSCANS
$sql_boxscan_count = $mysqli->query("SELECT COUNT(DISTINCT game_id) AS count FROM game_boxscan"); 
$query_boxscan_count = $sql_boxscan_count->fetch_array(MYSQLI_BOTH);	
// END - COUNT HOW MANY GAMES HAS BOXSCANS	
	
// START - COUNT HOW MANY GAMES HAS SCREENSHOT
$sql_gamescreenshot_distinct_count = $mysqli->query("SELECT COUNT(DISTINCT game_id) AS count FROM screenshot_game"); 
$query_gamescreenshot_distinct_count = $sql_gamescreenshot_distinct_count->fetch_array(MYSQLI_BOTH);
// END - COUNT HOW MANY GAMES HAS SCREENSHOT	

// START - COUNT HOW MANY DEMOS HAS SCREENSHOT
$sql_demoscreenshot_distinct_count = $mysqli->query("SELECT COUNT(DISTINCT demo_id) AS count FROM screenshot_demo"); 
$query_demoscreenshot_distinct_count = $sql_demoscreenshot_distinct_count->fetch_array(MYSQLI_BOTH);
// END - COUNT HOW MANY DEMOS HAS SCREENSHOT
	
// START - COUNT HOW MANY GAMES HAS PUBLISHER ASSIGNED
$sql_game_publisher_count = $mysqli->query("SELECT COUNT(DISTINCT game_id) AS count FROM game_publisher"); 
$query_game_publisher_count = $sql_game_publisher_count->fetch_array(MYSQLI_BOTH);	
// END - COUNT HOW MANY GAMES HAS PUBLISHER ASSIGNED

// START - COUNT HOW MANY GAMES HAS DEVELOPER ASSIGNED
$sql_game_developer_count = $mysqli->query("SELECT COUNT(DISTINCT game_id) AS count FROM game_developer"); 
$query_game_developer_count = $sql_game_developer_count->fetch_array(MYSQLI_BOTH);
// END - COUNT HOW MANY GAMES HAS DEVELOPER ASSIGNED	

// START - COUNT HOW MANY GAMES HAS CATEGORIES SET
$sql_game_category_count = $mysqli->query("SELECT COUNT(DISTINCT game_id) AS count FROM game_cat_cross"); 
$query_game_category_count = $sql_game_category_count->fetch_array(MYSQLI_BOTH);
// END - COUNT HOW MANY GAMES HAS CATEGORIES SET

// START - COUNT HOW MANY GAMES HAS DOWNLOAD
$sql_game_download_count = $mysqli->query("SELECT COUNT(DISTINCT game_id) AS count FROM game_download"); 
$query_game_download_count = $sql_game_download_count->fetch_array(MYSQLI_BOTH);
// END - COUNT HOW MANY GAMES HAS DOWNLOAD	

// START - RELEASE YEAR STATS		
$sql_game_year_count = $mysqli->query("SELECT COUNT(game_id) AS count FROM game_year"); 
$query_game_year_count = $sql_game_year_count->fetch_array(MYSQLI_BOTH);
// END - RELEASE YEAR STATS

	// Fill the smarty array
	$smarty->assign('statistics',
	    array('games_number' => $query_game_count['count'],
		  'demos_number' => $query_demo_count['count'],
        	  'games_screenshot' => $query_gamescreenshot_count['count'],
		  'demos_screenshot_distinct' => $query_demoscreenshot_distinct_count['count'],
		  'games_boxscan' => $query_boxscan_count['count'],
		  'game_publisher' => $query_game_publisher_count['count'],
		  'game_developer' => $query_game_developer_count['count'],
		  'game_category' => $query_game_category_count['count'],
		  'game_download' => $query_game_download_count['count'],
		  'game_year' => $query_game_year_count['count'],
		  'games_screenshot_distinct' => $query_gamescreenshot_distinct_count['count']));








?>
