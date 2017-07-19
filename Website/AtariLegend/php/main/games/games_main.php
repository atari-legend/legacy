<?php
/***************************************************************************
 *                                games_main.php
 *                            --------------------------
 *   begin                : Friday, June 16, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : admin@atarilegend.com
 *
 *   Id: games_main.php,v 0.10 2017/06/16 20:42 Gatekeeper - creation of file
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the game browse page where you can navigate your way through the games db
 ***********************************************************************************
 */

//load all common functions
include("../../config/common.php");

//Load this include to fill the pub and dev field. No need to reinvent the wheel, right? Or is this lazy coding? :-)
include("../../admin/games/quick_search_games.php");

//load the tiles
include("../../common/tiles/who_is_it_tile.php");
include("../../common/tiles/tile_stats.php");
include("../../common/tiles/screenstar.php");
include("../../common/tiles/latest_comments_tile.php");
include("../../common/tiles/changes_per_month_tile.php");

//no special position necesarry for the tiles (compared to the front page)
//but I just declare the smarty var to avoid error
$smarty->assign('who_is_it_tile', '');
$smarty->assign('statistics_tile', '');

// get the game_years from the game_year table
$sql_year = $mysqli->query("SELECT distinct game_year from game_year order by game_year") 
                     or die ("problems getting data from game_year table");

while ($game_year = $sql_year->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('game_year', array(
            'game_year' => $game_year['game_year']));
}

// get the categories for the genre dropdown
$sql_cat = $mysqli->query("SELECT * from game_cat order by game_cat_name") 
                     or die ("problems getting data from game_cat table");

while ($game_cat = $sql_cat->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('game_cat', array(
            'game_cat_name' => $game_cat['game_cat_name'],
            'game_cat_id' => $game_cat['game_cat_id']));
}

if ( isset($mode) and ( $mode ==! '' ) )
{
    $smarty->assign("mode", $mode);
}
else
{
    $smarty->assign("mode", "standard");
}

if ( isset($stats) and ($stats == 1) )
{
    $smarty->assign("stats", "1");
}                      
                      
date_default_timezone_set('UTC');
$start = microtime(true);

$result   = $mysqli->query("SELECT * FROM game");
$games_nr = $result->num_rows;
 
$smarty->assign("games_nr", $games_nr);

if (isset($_SESSION['edit_message'])) {
    $smarty->assign("message", $_SESSION['edit_message']);
}

//Send all smarty variables to the templates
$smarty->display("file:" . $mainsite_template_folder. "games_main.html");

//close the connection
mysqli_close($mysqli);
