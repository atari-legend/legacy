<?php
/***************************************************************************
*                                hotlinks_tile.php
*                            ----------------------------
*   begin                : Thurrsday, April 16, 2015
*   copyright            : (C) 2015 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id:   who_is_it_tile.php,v 0.1 2015/04/23 22:31 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php code for the 'hotlinks' tile
//*********************************************************************************************
require_once __DIR__."/../../common/DAO/LinkDAO.php";
$linkDao = new AL\Common\DAO\LinkDAO($mysqli);

$smarty->assign('hotlinks', $linkDao->getRandomLink('Youtube'));
