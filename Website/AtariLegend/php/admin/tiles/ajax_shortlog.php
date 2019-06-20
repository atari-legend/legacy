<?php
/***************************************************************************
*                              ajax_shortlog.php
*                            --------------------------
*   begin                : August 15, 2018
*   copyright            : (C) 2018 Atari Legend
*   email                : admin@atarilegend.com
*
*
***************************************************************************/

//*********************************************************************************************
// Ajax
//*********************************************************************************************

include("../../config/common.php");
include("../../config/admin.php");

require_once __DIR__."/../../common/DAO/ChangeLogDAO.php";

$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);

$smarty->assign('changelog', $changeLogDao->getChangeLogForSection('Games'));

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "tiles/ajax_shortlog.html");
