<?php
/***************************************************************************
 *                             ajax_games_detail.php
 *                            -----------------------
 *   begin                : July 2015
 *   copyright            : (C) 2015 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : Creation
 *
 *   Id: ajax_games_detail.php,v 0.2 2015/07 Silver Surfer
 *   Id: ajax_games_detail.php,v 0.3 2015/11/06 STG
 *  Id: ajax_games_detail.php,v 0.4 2016/08/18 STG
 *              - removed AJAX bug / added template config include
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 Build game series page
 ***********************************************************************************
 */
include("../../config/common.php");
include("../../config/admin.php");

require_once __DIR__."/../../common/DAO/PubDevDAO.php";

$pubDevDao = new \AL\Common\DAO\PubDevDAO($mysqli);

if ((isset($action)
    and ($action == "company_publisher_browse"
        or $action == "company_developer_browse"))) {
    $smarty->assign('smarty_action', $action);
    $smarty->assign(
        'letter',
        ($query == 'num') ? '0-9' : $query
    );
    $smarty->assign('pubdevs', $pubDevDao->getPubDevsStartingWith(
        ($query == 'num') ? '^[0-9]' : '^'.$query
    ));
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games/ajax_games_detail.html");
