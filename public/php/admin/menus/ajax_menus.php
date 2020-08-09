<?php
/***************************************************************************
 *                             ajax_menus.php
 *                            -----------------------
 *   begin                : Saturday, Sept 24, 2005
 *   copyright            : (C) 2003 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : Creation from scratch for smarty usage
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 Build game series page
 ***********************************************************************************
 */
include("../../config/common.php");
include("../../config/admin.php");
require_once __DIR__."/../../common/DAO/CrewDAO.php";
require_once __DIR__."/../../common/DAO/IndividualDAO.php";
$crewDao = new AL\Common\DAO\CrewDAO($mysqli);
$individualDao = new AL\Common\DAO\IndividualDAO($mysqli);

// Crew browse function
if (isset($action) and $action == "crew_browse") {
    $smarty->assign('crews', $crewDao->getCrewsStartingWith($query));
    $smarty->assign('smarty_action', 'crew_list');
}

// Individual browse function
if (isset($action) and $action == "ind_browse") {
    $smarty->assign('individuals', $individualDao->getIndividualsStartingWith($query));
    $smarty->assign('smarty_action', 'ind_list');
}

// Add new menu disk box
if (isset($action) and $action == "add_new_disk_box") {
    $smarty->assign('smarty_action', 'add_new_disk_box');
    $smarty->assign('menu_sets_id', $menu_sets_id);
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "menus/ajax_menus.html");
