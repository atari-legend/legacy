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
	$query = $mysqli->query($sql);
	$gamecount = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$gamecount[count] games in archive";

	// END - NUMBER OF GAMES IN ARCHIVE
	
	mysqli_free_result($query);
	
	// START - COUNT GAME SCREENSHOTS IN ARCHIVE
	$sql = "SELECT COUNT(*) AS count FROM screenshot_game";
	$query = $mysqli->query($sql);
	$gamescreencount = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$gamescreencount[count] game screenshots in archive";
	
	// END - COUNT GAME SCREENSHOTS IN ARCHIVE
	
	mysqli_free_result($query);
	
	// START - COUNT HOW MANY GAMES HAS SCREENSHOT
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM screenshot_game";
	$query = $mysqli->query($sql);
	$screencount = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$screencount[count] games have screenshots";

	// END - COUNT HOW MANY GAMES HAS SCREENSHOT
	
	mysqli_free_result($query);
	
		// START - COUNT COMPANIES IN ARCHIVE
	$sql = "SELECT COUNT(*) AS count FROM pub_dev";
	$query = $mysqli->query($sql);
	$pubdev = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$pubdev[count] companies in the archive";
	
	// END - COUNT COMPANIES IN ARCHIVE
	
	mysqli_free_result($query);
	
	// START - COUNT HOW MANY GAMES HAS PUBLISHER ASSIGNED
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_publisher";
	$query = $mysqli->query($sql);
	$publisher = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$publisher[count] games have a publisher assigned";
	
	// END - COUNT HOW MANY GAMES HAS PUBLISHER ASSIGNED
	
	mysqli_free_result($query);
	
		// START - COUNT HOW MANY GAMES HAS DEVELOPER ASSIGNED
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_developer";
	$query = $mysqli->query($sql);
	$developer = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$developer[count] games have a developer assigned";
	
	// END - COUNT HOW MANY GAMES HAS DEVELOPER ASSIGNED
	
	mysqli_free_result($query);
	
	// START - COUNT HOW MANY GAMES HAS BOXSCANS
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_boxscan";
	$query = $mysqli->query($sql);
	$boxscan = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$boxscan[count] games have boxscans assigned";

	// END - COUNT HOW MANY GAMES HAS BOXSCANS
	
	mysqli_free_result($query);
	
		// START - COUNT HOW MANY GAMES HAS CATEGORIES SET
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_cat_cross";
	$query = $mysqli->query($sql);
	$game_category = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$game_category[count] games have category set";

	// END - COUNT HOW MANY GAMES HAS CATEGORIES SET
	
	mysqli_free_result($query);
	
	// START - COUNT NUMBER OF DOWNLOADABLE FILES
	$sql = "SELECT COUNT(game_id) AS count FROM game_download";
	$query = $mysqli->query($sql);
	$game_files = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$game_files[count] files for download";
	
	// END - COUNT NUMBER OF DOWNLOADABLE FILES
	
	mysqli_free_result($query);
	
		// START - COUNT HOW MANY GAMES HAS DOWNLOAD
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_download";
	$query = $mysqli->query($sql);
	$game_download = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$game_download[count] games have download";
	
	// END - COUNT HOW MANY GAMES HAS DOWNLOAD
	
	mysqli_free_result($query);
	
		// START - RELEASE YEAR STATS
	$sql = "SELECT COUNT(game_id) AS count FROM game_year";
	$query = $mysqli->query($sql);
	$game_year = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$game_year[count] games have a release year set";
	
	// END - RELEASE YEAR STATS
	
	mysqli_free_result($query);
	
		// START - GAME REVIEW STATS
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM review_game";
	$query = $mysqli->query($sql);
	$review_game = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$review_game[count] games have been reviewed";
	
	// END - GAME REVIEW STATS
	
	mysqli_free_result($query);
	
		// START - USER STATS
	$sql = "SELECT COUNT(user_id) AS count FROM users";
	$query = $mysqli->query($sql);
	$users = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$users[count] registered users";
	
	// END - USER STATS
	
	mysqli_free_result($query);
	
		// START - ARTICLE STATS
	$sql = "SELECT COUNT(DISTINCT article_id) AS count FROM article_main";
	$query = $mysqli->query($sql);
	$article_main = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$article_main[count] articles in archive";
	
	// END - ARTICLE STATS
	
	mysqli_free_result($query);
	
		// START - LINKS STATS
	$sql = "SELECT COUNT(website_id) AS count FROM website";
	$query = $mysqli->query($sql);
	$website = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$website[count] links in archive";
	
	// END - LINKS STATS
	
	mysqli_free_result($query);
	
		// START - music STATS
	$sql = "SELECT COUNT(DISTINCT game_id) AS count FROM game_music";
	$query = $mysqli->query($sql);
	$music = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$music[count] games have music attached";
	
	// END - music STATS
	
	mysqli_free_result($query);
	
		// START - music STATS
	$sql = "SELECT COUNT(music_id) AS count FROM game_music";
	$query = $mysqli->query($sql);
	$music = $query->fetch_array(MYSQLI_BOTH);
	$stack[] = "$music[count] gamemusic files are uploaded";

	// END - music STATS
	
	// smack the stack into a smarty var and pray it works
	foreach ($stack as $value) {
   			$smarty->append('statistics',
	    			array('value' => $value));
			}

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/statistics.html');
?>
