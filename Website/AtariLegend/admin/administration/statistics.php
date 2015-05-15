<?php
/***************************************************************************
*                                statistics.php
*                            -----------------------
*   begin                : Friday, Oct 03, 2003
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : 	Website images added, 
*							 
*							
*
*   Id: statistics.php,v 0.10 2003/10/03 23:00 Silver Surfer
*
***************************************************************************/

include("../includes/common.php"); 

foreach (KarmaGood() as $key => $value)
{
	$smarty->append('karma_good',
	    			array('karma' => $value[0],
						  'user_name' => $value[1],
						  'user_id' => $value[2]));
   
}

foreach (KarmaBad() as $key => $value)
{
	$smarty->append('karma_bad',
	    			array('karma' => $value[0],
						  'user_name' => $value[1],
						  'user_id' => $value[2]));
   
}

	// START - NUMBER OF GAMES IN ARCHIVE
	$sql = "SELECT COUNT(*) AS count FROM game";
	$query = mysql_query($sql);
	$gamecount = mysql_fetch_array($query);
	$stack[] = "$gamecount[count] games in archive";

	// END - NUMBER OF GAMES IN ARCHIVE
	
	mysql_free_result($query);
	
	// START - COUNT GAME SCREENSHOTS IN ARCHIVE
	$sql = "SELECT COUNT(*) AS count FROM screenshot_game";
	$query = mysql_query($sql);
	$gamescreencount = mysql_fetch_array($query);
	$stack[] = "$gamescreencount[count] game screenshots in archive";
	
	// END - COUNT GAME SCREENSHOTS IN ARCHIVE
	
	mysql_free_result($query);
	
	// START - COUNT HOW MANY GAMES HAS SCREENSHOT
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM screenshot_game";
	$query = mysql_query($sql);
	$screencount = mysql_fetch_array($query);
	$stack[] = "$screencount[count] games have screenshots";

	// END - COUNT HOW MANY GAMES HAS SCREENSHOT
	
	mysql_free_result($query);
	
		// START - COUNT COMPANIES IN ARCHIVE
	$sql = "SELECT COUNT(*) AS count FROM pub_dev";
	$query = mysql_query($sql);
	$pubdev = mysql_fetch_array($query);
	$stack[] = "$pubdev[count] companies in the archive";
	
	// END - COUNT COMPANIES IN ARCHIVE
	
	mysql_free_result($query);
	
	// START - COUNT HOW MANY GAMES HAS PUBLISHER ASSIGNED
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_publisher";
	$query = mysql_query($sql);
	$publisher = mysql_fetch_array($query);
	$stack[] = "$publisher[count] games have a publisher assigned";
	
	// END - COUNT HOW MANY GAMES HAS PUBLISHER ASSIGNED
	
	mysql_free_result($query);
	
		// START - COUNT HOW MANY GAMES HAS DEVELOPER ASSIGNED
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_developer";
	$query = mysql_query($sql);
	$developer = mysql_fetch_array($query);
	$stack[] = "$developer[count] games have a developer assigned";
	
	// END - COUNT HOW MANY GAMES HAS DEVELOPER ASSIGNED
	
	mysql_free_result($query);
	
	// START - COUNT HOW MANY GAMES HAS BOXSCANS
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_boxscan";
	$query = mysql_query($sql);
	$boxscan = mysql_fetch_array($query);
	$stack[] = "$boxscan[count] games have boxscans assigned";

	// END - COUNT HOW MANY GAMES HAS BOXSCANS
	
	mysql_free_result($query);
	
		// START - COUNT HOW MANY GAMES HAS CATEGORIES SET
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_cat_cross";
	$query = mysql_query($sql);
	$game_category = mysql_fetch_array($query);
	$stack[] = "$game_category[count] games have category set";

	// END - COUNT HOW MANY GAMES HAS CATEGORIES SET
	
	mysql_free_result($query);
	
	// START - COUNT NUMBER OF DOWNLOADABLE FILES
	$sql = "SELECT COUNT(game_id) AS count FROM game_download";
	$query = mysql_query($sql);
	$game_files = mysql_fetch_array($query);
	$stack[] = "$game_files[count] files for download";
	
	// END - COUNT NUMBER OF DOWNLOADABLE FILES
	
	mysql_free_result($query);
	
		// START - COUNT HOW MANY GAMES HAS DOWNLOAD
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_download";
	$query = mysql_query($sql);
	$game_download = mysql_fetch_array($query);
	$stack[] = "$game_download[count] games have download";
	
	// END - COUNT HOW MANY GAMES HAS DOWNLOAD
	
	mysql_free_result($query);
	
		// START - RELEASE YEAR STATS
	$sql = "SELECT COUNT(game_id) AS count FROM game_year";
	$query = mysql_query($sql);
	$game_year = mysql_fetch_array($query);
	$stack[] = "$game_year[count] games have a release year set";
	
	// END - RELEASE YEAR STATS
	
	mysql_free_result($query);
	
		// START - GAME REVIEW STATS
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM review_game";
	$query = mysql_query($sql);
	$review_game = mysql_fetch_array($query);
	$stack[] = "$review_game[count] games have been reviewed";
	
	// END - GAME REVIEW STATS
	
	mysql_free_result($query);
	
		// START - USER STATS
	$sql = "SELECT COUNT(user_id) AS count FROM users";
	$query = mysql_query($sql);
	$users = mysql_fetch_array($query);
	$stack[] = "$users[count] registered users";
	
	// END - USER STATS
	
	mysql_free_result($query);
	
		// START - ARTICLE STATS
	$sql = "SELECT COUNT(DISTINCT article_id) AS count FROM article_main";
	$query = mysql_query($sql);
	$article_main = mysql_fetch_array($query);
	$stack[] = "$article_main[count] articles in archive";
	
	// END - ARTICLE STATS
	
	mysql_free_result($query);
	
		// START - LINKS STATS
	$sql = "SELECT COUNT(website_id) AS count FROM website";
	$query = mysql_query($sql);
	$website = mysql_fetch_array($query);
	$stack[] = "$website[count] links in archive";
	
	// END - LINKS STATS
	
	mysql_free_result($query);
	
		// START - music STATS
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_music";
	$query = mysql_query($sql);
	$music = mysql_fetch_array($query);
	$stack[] = "$music[count] games have music attached";
	
	// END - music STATS
	
	mysql_free_result($query);
	
		// START - music STATS
	$sql = "SELECT COUNT(music_id) AS count FROM game_music";
	$query = mysql_query($sql);
	$music = mysql_fetch_array($query);
	$stack[] = "$music[count] gamemusic files are uploaded";

	// END - music STATS
	
	// smack the stack into a smarty var and pray it works
	foreach ($stack as $value) {
   			$smarty->append('statistics',
	    			array('value' => $value));
			}

$smarty->assign('statistics_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

	?>
