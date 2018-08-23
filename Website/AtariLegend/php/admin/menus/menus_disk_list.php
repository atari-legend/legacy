<?php
/***************************************************************************
 *                                menus_disk_list.php
 *                            --------------------------
 *   begin                : June 05, 2015
 *   copyright            : (C) 2015 Atari Legend
 *   email                : admin@atarilegend.com
 *                         Created file - Silver Surfer
 *
 *  id : menus_disk_list.php ,v 0.10 2016/08/26 ST Graveyard 23:22
 *          - AL 2.0
 *
 ***************************************************************************/

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");
require_once __DIR__."/../../lib/Db.php";
require_once __DIR__."/../../common/DAO/MenuSetDAO.php";
require_once __DIR__."/../../common/DAO/MenusDiskListDAO.php";
require_once __DIR__."/../../common/DAO/CrewDAO.php";
require_once __DIR__."/../../common/DAO/IndividualDAO.php";
require_once __DIR__."/../../common/DAO/MenuTypeDAO.php";

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

$menusDao = new AL\Common\DAO\MenusDiskListDAO($mysqli);
$menusetDao = new AL\Common\DAO\MenuSetDAO($mysqli);
$crewDao = new AL\Common\DAO\CrewDAO($mysqli);
$individualDao = new AL\Common\DAO\IndividualDAO($mysqli);
$menutypeDao = new AL\Common\DAO\MenuTypeDAO($mysqli);

/*
 ************************************************************************************************
 This is the menus disk search list page
 ************************************************************************************************
 */
$start1 = gettimeofday();
list($start2, $start3) = explode(":", exec('date +%N:%S'));

//Get menu disk list array from db and push it to smarty
$smarty->assign('menus_list', $menusDao->getMenuDisksForSet($menu_sets_id));

$menu_disk_rows = count($menusDao->getMenuDisksForSet($menu_sets_id));

//Get menu set list array from db and push it to smarty
$smarty->assign('menuset_list', $menusetDao->getMenuSets());

// Get menu set information on selected Set
$menuset_info = $menusetDao->getMenuSetInfo($menu_sets_id);
$smarty->assign('menuset_info', $menuset_info);

// Get Crew data for the crew search
$smarty->assign('crews', $crewDao->getCrewsStartingWith("num"));

// Get individual data for the author search
$smarty->assign('individuals', $individualDao->getIndividualsStartingWith("num"));

//Get list of crews connected to this menu set
$smarty->assign('connected_crew', $menusetDao->getCrewsForMenuSet($menu_sets_id));

//Get list of individuals connected to this menu set
$smarty->assign('connected_ind', $menusetDao->getIndividualsForMenuSet($menu_sets_id));

//Get list of all menu types
$smarty->assign('menu_types', $menutypeDao->getAllMenuTypes());

//Get list of menu types connected to menu set
$smarty->assign('connected_menu_types', $menutypeDao->getMenuTypesForMenuSet($menu_sets_id));

$end1       = gettimeofday();
$totaltime1 = (float) ($end1['sec'] - $start1['sec']) + ((float) ($end1['usec'] - $start1['usec']) / 1000000);

// Create dropdown values a-z
$az_value  = az_dropdown_value(0);
$az_output = az_dropdown_output(0);

$smarty->assign('az_value', $az_value);
$smarty->assign('az_output', $az_output);

$smarty->assign('querytime', $totaltime1);
$smarty->assign('nr_of_entries', $menu_disk_rows);

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "menus_disk_list.html");
