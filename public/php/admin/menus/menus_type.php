<?php
/***************************************************************************
 *                                menus_type.php
 *                            --------------------------
 *   begin                : September 04, 2016
 *   copyright            : (C) 2016 Atari Legend
 *   email                : admin@atarilegend.com
 *                          Created file
 *
 ***************************************************************************/

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");
require_once __DIR__."/../../common/DAO/MenuTypeDAO.php";

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

$menutypeDao = new AL\Common\DAO\MenuTypeDAO($mysqli);
/*
 ************************************************************************************************
 This is the menus search list page
 ************************************************************************************************
 */

//Get list of all menu types
$smarty->assign('menu_type', $menutypeDao->getAllMenuTypes());

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "menus/menus_type.html");

//close the connection
mysqli_free_result($result_menus_type);
