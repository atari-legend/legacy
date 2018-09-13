<?php
/***************************************************************************
 *                                games_config.php
 *                            ------------------------
 *   begin                : Wednesday, September 12, 2018
 *   copyright            : (C) 2018 Atari Legend
 *   actual update        : Creation of file
 *
 ***************************************************************************/

//****************************************************************************************
// This is the main configuration page for the game section
//****************************************************************************************

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");
include("../../admin/games/quick_search_games.php");

require_once __DIR__."/../../common/DAO/EngineDAO.php";
require_once __DIR__."/../../common/DAO/ProgrammingLanguageDAO.php";
require_once __DIR__."/../../common/DAO/GameGenreDAO.php";
require_once __DIR__."/../../common/DAO/PortDAO.php";
require_once __DIR__."/../../common/DAO/IndividualRoleDAO.php";

$engineDao = new \AL\Common\DAO\EngineDAO($mysqli);
$programmingLanguageDao = new \AL\Common\DAO\ProgrammingLanguageDAO($mysqli);
$gameGenreDao = new \AL\Common\DAO\GameGenreDAO($mysqli);
$portDao = new \AL\Common\DAO\PortDAO($mysqli);
$individualRoleDao = new \Al\Common\DAO\IndividualRoleDAO($mysqli);

//***********************************************************************************
//get the engines & the engines already selected for this game
//***********************************************************************************
$smarty->assign('engines', $engineDao->getAllEngines());

//*******************************************************************************************
//get the programming languages and the programming languages already selected for this game
//*******************************************************************************************
$smarty->assign('programming_languages', $programmingLanguageDao->getAllProgrammingLanguages());

//***********************************************************************************
//get the game categories & the categories already selected for this game
//***********************************************************************************
$smarty->assign('game_genres', $gameGenreDao->getAllGameGenres());

//***********************************************************************************
//get the game ports & the port for this game
//***********************************************************************************
$smarty->assign('ports', $portDao->getAllPorts());

// Get the indivual roles
$smarty->assign('individual_roles', $individualRoleDao->getAllIndividualRoles());

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games_config.html");

//close the connection
mysqli_close($mysqli);
