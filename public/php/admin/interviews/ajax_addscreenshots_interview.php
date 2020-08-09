<?php
/********************************************************************************
 *                                ajax_addscreenshots_interview.php
 *                            --------------------------------------
 *   begin                : Thursday, November 2, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *   actual update        : Creation of file
 *
 *********************************************************************************/

//****************************************************************************************
// Add screenshots to an interview
//****************************************************************************************

include("../../config/common.php");
include("../../config/admin.php");

$smarty->assign('interview_id', $interview_id);

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."interviews/ajax_interview_add_screenshots.html");
