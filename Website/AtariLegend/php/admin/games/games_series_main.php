<?php
/***************************************************************************
 *                             games_series_main.php
 *                            -----------------------
 *   begin                : Saturday, Sept 24, 2005
 *   copyright            : (C) 2003 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : Creation from scratch for smarty usage
 *
 *   Id: games_series_main.php,v 0.2 2005/09/24 Silver Surfer
 *   Id: games_series_main.php,v 0.5 2016/07/24 ST Graveyard
 *                  -AL 2.0
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 Build game series page
 ***********************************************************************************
 */

include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

require_once __DIR__."/../../common/DAO/GameSeriesDAO.php";

$gameSeriesDao = new \AL\Common\DAO\GameSeriesDAO($mysqli);
$smarty->assign('game_series', $gameSeriesDao->getAllGameSeries());

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games_series_main.html");
