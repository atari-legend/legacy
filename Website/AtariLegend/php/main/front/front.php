<?php
/***************************************************************************
 *                                front.php
 *                            -----------------------
 *   begin                : Tuesday, April 14, 2015
 *   copyright            : (C) 2015 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : Creation of file
 *
 *   Id: news.php,v 0.1 2015/04/14 22:54 ST Graveyard
 ***************************************************************************/

//*********************************************************************************************
// This is the php for the front page of AtariLegend
//*********************************************************************************************

//load all common functions
require "../../config/common.php";

//Load all tiles
require "../../common/tiles/latest_news_tile.php";
require "../../common/tiles/trivia_tile.php";
require "../../common/tiles/did_you_know_tile.php";
require "../../common/tiles/latest_reviews_tile.php";
require "../../common/tiles/who_is_it_tile.php";
require "../../common/tiles/screenstar.php";
require "../../common/tiles/tile_stats.php";
require "../../common/tiles/hotlinks_tile.php";
require "../../common/tiles/spotlight_tile.php";

//Create the id's for dynamic positioning of the tiles
$smarty->assign('date_quote_tile', 'datequote_position_front');
$smarty->assign('tile_open_db', 'tile_open_db_front');
$smarty->assign('did_you_know_tile', 'didyouknow_position_front');
$smarty->assign('hotlinks_tile', 'hotlinks_position_front');
$smarty->assign('screenstar_tile', 'screenstar_position_front');
$smarty->assign('statistics_tile', 'statistics_position_front');
$smarty->assign('who_is_it_tile', 'whoisit_position_front');
$smarty->assign('class_tile', 'class_position_front');
$smarty->assign('almobile_tile', 'almobile_tile_front');
$smarty->assign('tile_social_corner', 'social_corner_position_front');
$smarty->assign('spotlight_tile', 'spotlight_position_front');
$smarty->assign('al_tv', 'altv_position_front');

$smarty->assign('database_dumps_path', $database_dumps_path);

if (isset($action) and $action == 'register') {
    $smarty->assign("action", 'register');
}

if (isset($action) and $action == 'reset') {
    $smarty->assign("action", 'reset');
}

if (isset($action) and $action == 'new_pwd') {
    $smarty->assign("q", $q);
    $smarty->assign("action", 'new_pwd');
}

if (isset($action) and $action == 'construction') {
    $_SESSION['edit_message'] = 'This section will be available soon - currently under construction';
    if (isset($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        header('Location: /');
    }
    die();
}

//We are using this var to have the frontpage animation happen only once we visit AL
if (isset($action) and $action=='first_time') {
    $smarty->assign('smarty_action', 'first_time');
}

//Send all smarty variables to the templates
$smarty->display("file:".$mainsite_template_folder."frontpage.html");

//close the connection
mysqli_close($mysqli);
