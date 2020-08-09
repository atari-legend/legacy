<?php
/***************************************************************************
 *                                menus_list.php
 *                            --------------------------
 *   begin                : June 05, 2015
 *   copyright            : (C) 2015 Atari Legend
 *   email                : admin@atarilegend.com
 *                         Created file
 *  id : menus_list.php ,v 0.10 2016/08/26 ST Graveyard 23:22
 *          - AL 2.0
 *
 ***************************************************************************/

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");
require_once __DIR__."/../../common/DAO/MenuSetDAO.php";

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

$menusDao = new AL\Common\DAO\MenuSetDAO($mysqli);
/*
 ************************************************************************************************
 This is the menus search list page
 ************************************************************************************************
 */
$start1 = gettimeofday();
list($start2, $start3) = explode(":", exec('date +%N:%S'));

//In all cases we search we start searching through the menu_set table
//first. We look for menus released by crews/individuals
$smarty->assign('menus_list', $menusDao->getMenuSets());

$rows = count($menusDao->getMenuSets());

$end1 = gettimeofday();
$totaltime1 = (float) ($end1['sec'] - $start1['sec']) + ((float) ($end1['usec'] - $start1['usec']) / 1000000);

$smarty->assign('querytime', $totaltime1);
$smarty->assign('nr_of_entries', $rows);

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "menus/menus_list.html");
