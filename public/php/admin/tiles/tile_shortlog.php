<?php
/***************************************************************************
*                              tile_shortlog.php
*                            --------------------------
*   begin                : September 12, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: tile_bug_report.php,v 0.10 2017/09/12 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php code for the 'bug report' tile
//*********************************************************************************************

require_once __DIR__."/../../common/DAO/ChangeLogDAO.php";

$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);

$smarty->assign('changelog', $changeLogDao->getChangeLogForSection('Games'));
