<?php
/********************************************************************************
 *                                ajax_addscreenshots_menus.php
 *                            --------------------------------------
 *   begin                : Saturday, September 10, 2016
 *   copyright            : (C) 2016 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : Creation of file
 *
 *********************************************************************************/

//****************************************************************************************
// Add screenshots to a menu
//****************************************************************************************

include("../../config/common.php");
include("../../config/admin.php");

$smarty->assign('menu_disk_id', $menu_disk_id);

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."menus/ajax_menus_add_screenshots.html");
