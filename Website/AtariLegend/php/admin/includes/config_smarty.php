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

require('../libs/Smarty.class.php');
$smarty = new Smarty;

$smarty->template_dir = '../templates/0/';
$smarty->compile_dir = '../../templates_c/';
$smarty->config_dir = '../../configs/';
$smarty->cache_dir = '../../cache/';

error_reporting(E_ALL); 

?>
