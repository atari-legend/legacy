<?php
/********************************************************************************
 *                                ajax_addscreenshots_article.php
 *                            --------------------------------------
 *   begin                : Thursday, April 26, 2018
 *   copyright            : (C) 2018 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : Creation of file
 *
 *********************************************************************************/

//****************************************************************************************
// Add screenshots to an article
//****************************************************************************************

include("../../config/common.php");
include("../../config/admin.php");

$smarty->assign('article_id', $article_id);

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."ajax_article_add_screenshots.html");
