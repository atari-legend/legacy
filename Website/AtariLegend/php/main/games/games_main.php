<?php
/***************************************************************************
 *                                games_main.php
 *                            --------------------------
 *   begin                : Friday, June 16, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : admin@atarilegend.com
 *
 *   Id: games_main.php,v 0.10 2017/06/16 20:42 Gatekeeper - creation of file
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the game browse page where you can navigate your way through the games db
 ***********************************************************************************
 */

//load all common functions
require "../../config/common.php";

//Load this include to fill the pub and dev field. No need to reinvent the wheel, right? Or is this lazy coding? :-)
require "../../admin/games/quick_search_games.php";

//load the tiles
require "../../common/tiles/who_is_it_tile.php";
require "../../common/tiles/tile_stats.php";
require "../../common/tiles/screenstar.php";
require "../../common/tiles/latest_comments_tile.php";
require "../../common/tiles/changes_per_month_tile.php";

require_once __DIR__."/../../common/DAO/GameReleaseDAO.php";
require_once __DIR__."/../../common/DAO/GameGenreDAO.php";
require_once __DIR__."/../../common/Model/Breadcrumb.php" ;

$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);
$GameGenreDao = new \AL\Common\DAO\GameGenreDAO($mysqli);

//no special position necesarry for the tiles (compared to the front page)
//but I just declare the smarty var to avoid error
$smarty->assign('who_is_it_tile', '');
$smarty->assign('statistics_tile', '');

// Get all releases years
$smarty->assign('releases_year', $gameReleaseDao->getAllReleasesYears());

// get the genres for the genre dropdown
$smarty->assign('game_genre', $GameGenreDao->getAllGameGenres());

if (isset($mode) and ($mode ==! '')) {
    $smarty->assign("mode", $mode);
} else {
    $smarty->assign("mode", "standard");
}

if (isset($stats) and ($stats == 1)) {
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

$smarty->assign(
    'breadcrumb',
    array(
        new AL\Common\Model\Breadcrumb("/games/games_main.php", "Games")
    )
);

//Send all smarty variables to the templates
$smarty->display("file:" . $mainsite_template_folder. "games_main.html");

//close the connection
mysqli_close($mysqli);
