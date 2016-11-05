<?php
/********************************************************************************
 *                                ajax_addfile_menus.php
 *                            --------------------------------------
 *   begin                : Tuesday, September 13, 2016
 *   copyright            : (C) 2016 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : Creation of file
 *
 *********************************************************************************/

//****************************************************************************************
// Add file to a menu
//****************************************************************************************

include("../../includes/common.php");
include("../../includes/admin.php");

$smarty->assign('menu_disk_id', $menu_disk_id);

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."ajax_menus_add_file.html");
