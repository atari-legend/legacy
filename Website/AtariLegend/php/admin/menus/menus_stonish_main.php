<?php
/***************************************************************************
 *                                menus_stonish_main.php
 *                            -----------------------------
 *   begin                : November 21, 2016
 *   copyright            : (C) 2016 Atari Legend
 *   email                : admin@atarilegend.com
 *                          Created file
 *
 ***************************************************************************/

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php");

/*
 ************************************************************************************************
 This is the main page with the stonish integration links
 ************************************************************************************************
 */
$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "menus_stonish_main.html");
?>
