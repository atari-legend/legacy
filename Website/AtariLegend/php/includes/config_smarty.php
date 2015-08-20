<?php 
/***************************************************************************
*                                config_smarty.php
*                            -----------------------
*   begin                : Saturday, January 12, 2004
*   copyright            : (C) 2003 Atari Legend
*   email                : maarten.martens@freebel.net
*
*   Id: config_smarty.php,v 0.10 2004/01/12 20:47 Gatekeeper
*
***************************************************************************/

//This file confirgures the smarty dirs

require('../../../templates/html/includes/smarty/libs/Smarty.class.php');
$smarty = new Smarty;

$smarty->template_dir = '../../../templates/';
$smarty->compile_dir = '../../../templates/html/includes/smarty/templates_c/';
$smarty->config_dir = '../../../templates/html/includes/smarty/configs/';
$smarty->cache_dir = '../../../templates/html/includes/smarty/cache/';
?>
