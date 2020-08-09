<?php
/***************************************************************************
 *                                games_detail.php
 *                            ------------------------
 *   begin                : Tuesday, September 6, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *   actual update        : Creation of file
 *
 *   Id: games_detail.php,v 0.10 2005/10/06 17:41 Zombieman
 *   Id: games_detail.php,v 0.20 2015/11/01 11:11 STG
 *   Id: games_detail.php,v 0.21 2016/07/20 22:49 STG
 *          - added nr of comments check
 *   Id: games_detail.php,v 0.22 2017/01/06 STG - added falcon vga and rgb option
 *
 ***************************************************************************/

//****************************************************************************************
// This is the detail page of a game. Change all the specifics over here!
//****************************************************************************************

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");
include("../../admin/games/quick_search_games.php");
include("../../admin/tiles/tile_shortlog.php");

require_once __DIR__."/../../common/DAO/GameReleaseDAO.php";
require_once __DIR__."/../../common/DAO/GameDAO.php";
require_once __DIR__."/../../common/DAO/IndividualDAO.php";
require_once __DIR__."/../../common/DAO/PubDevDAO.php";
require_once __DIR__."/../../common/DAO/ProgrammingLanguageDAO.php";
require_once __DIR__."/../../common/DAO/PortDAO.php";
require_once __DIR__."/../../common/DAO/GameGenreDAO.php";
require_once __DIR__."/../../common/DAO/IndividualRoleDAO.php";
require_once __DIR__."/../../common/DAO/GameIndividualDAO.php";
require_once __DIR__."/../../common/DAO/IndividualDAO.php";
require_once __DIR__."/../../common/DAO/EngineDAO.php";
require_once __DIR__."/../../common/DAO/ControlDAO.php";
require_once __DIR__."/../../common/DAO/SoundHardwareDAO.php";
require_once __DIR__."/../../common/DAO/GameProgressSystemDAO.php";

$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);
$gameDao = new \AL\Common\DAO\GameDAO($mysqli);
$individualDao = new \Al\Common\DAO\IndividualDAO($mysqli);
$pubDevDao = new \AL\Common\DAO\PubDevDAO($mysqli);
$programmingLanguageDao = new \AL\Common\DAO\ProgrammingLanguageDAO($mysqli);
$portDao = new \AL\Common\DAO\PortDAO($mysqli);
$gameGenreDao = new \AL\Common\DAO\GameGenreDAO($mysqli);
$individualRoleDao = new \Al\Common\DAO\IndividualRoleDAO($mysqli);
$gameIndividualDao = new \Al\Common\DAO\GameIndividualDAO($mysqli);
$individualDao = new \Al\Common\DAO\IndividualDAO($mysqli);
$engineDao = new \AL\Common\DAO\EngineDAO($mysqli);
$controlDao = new \AL\Common\DAO\ControlDAO($mysqli);
$soundHardwareDao = new \AL\Common\DAO\SoundHardwareDAO($mysqli);
$gameProgressSystemDao = new \AL\Common\DAO\GameProgressSystemDAO($mysqli);

//***********************************************************************************
//Let's get the general game info first.
//***********************************************************************************
$sql_game = $mysqli->query("SELECT game_name,
               game.game_id,
               game.game_series_id,
               game_series.name as game_series_name
               FROM game
               LEFT JOIN game_series ON (game.game_series_id = game_series.id)
               WHERE game.game_id='$game_id'") or die("Error getting game info: " . $mysqli->error);

while ($game_info = $sql_game->fetch_array(MYSQLI_BOTH)) {
    $smarty->assign('game_info', array(
        'game_name' => $game_info['game_name'],
        'game_id' => $game_info['game_id'],
        'game_series_id' => $game_info['game_series_id'],
        'game_series_name' => $game_info['game_series_name']
    ));
}

$smarty->assign('game', $gameDao->getGame($game_id));
$smarty->assign('game_screenshot', $gameDao->getRandomScreenshot($game_id));

//***********************************************************************************
//get the release dates
//***********************************************************************************
$smarty->assign('game_releases', $gameReleaseDao->getReleasesForGame($game_id));

//***********************************************************************************
//get the game categories & the categories already selected for this game
//***********************************************************************************
$smarty->assign('game_genres', $gameGenreDao->getAllGameGenres());
$smarty->assign('game_genres_cross', $gameGenreDao->getGameGenresForGame($game_id));

//***********************************************************************************
//get the engines & the engines already selected for this game
//***********************************************************************************
$smarty->assign('engines', $engineDao->getAllEngines());
$smarty->assign('game_engines', $engineDao->getGameEnginesForGame($game_id));

//*******************************************************************************************
//get the programming languages and the programming languages already selected for this game
//*******************************************************************************************
$smarty->assign('programming_languages', $programmingLanguageDao->getAllProgrammingLanguages());
$smarty->assign('game_programming_languages', $programmingLanguageDao->getProgrammingLanguagesForGame($game_id));

//***********************************************************************************
//get the game ports & the port for this game
//***********************************************************************************
$smarty->assign('ports', $portDao->getAllPorts());
$smarty->assign('game_port', $portDao->getPortForGame($game_id));

//***********************************************************************************
//get the game progress systems & the progress system for this game
//***********************************************************************************
$smarty->assign('progress_system', $gameProgressSystemDao->getAllProgressSystems());
$smarty->assign('game_progress_system', $gameProgressSystemDao->getProgressSystemForGame($game_id));

//***********************************************************************************
//get the game controls & the controls already selected for this game
//***********************************************************************************
$smarty->assign('game_controls', $controlDao->getAllControls());
$smarty->assign('game_control_cross', $controlDao->getGameControlsForGame($game_id));

//**********************************************************************************
//Get the individuals info
//**********************************************************************************
$smarty->assign('individuals', $individualDao->getAllIndividuals());

// Get the indivual roles
$smarty->assign('individual_roles', $individualRoleDao->getAllIndividualRoles());

//Starting off with displaying the authors that are linked to the game and having a delete option for them */
//get the game_individual entries
$smarty->assign('game_individuals', $gameIndividualDao->getGameIndividualsForGame($game_id));

//**********************************************************************************
//Get the companies info
//**********************************************************************************

$smarty->assign('pubdevs', $pubDevDao->getAllPubDevs());

//let's get the developers for this game
$sql_developer = $mysqli->query("SELECT * FROM pub_dev
    LEFT JOIN game_developer ON ( pub_dev.pub_dev_id = game_developer.dev_pub_id )
    LEFT JOIN developer_role ON ( game_developer.developer_role_id = developer_role.id )
    WHERE game_developer.game_id = '$game_id' ORDER BY pub_dev_name ASC") or die("Couldn't query developers");

while ($developers = $sql_developer->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('developers', array(
        'pub_dev_id' => $developers['pub_dev_id'],
        'pub_dev_name' => $developers['pub_dev_name'],
        'developer_role' => $developers['role'],
        'developer_role_id' => $developers['id']
    ));
}

//**********************************************************************************
//Get the developer roles
//**********************************************************************************

$sql_developer_role = $mysqli->query("SELECT * FROM developer_role ORDER BY role ASC")
    or die("Couldn't query developer_role database");

while ($developer_role = $sql_developer_role->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('developer_role', array(
        'developer_role_id' => $developer_role['id'],
        'developer_role' => $developer_role['role']
    ));
}

//***********************************************************************************
// Game facts
//***********************************************************************************

$sql_facts = $mysqli->query("SELECT COUNT(*) AS C FROM game_fact WHERE game_id = $game_id") or die($mysqli->error);
$facts = $sql_facts->fetch_array(MYSQLI_BOTH);
$smarty->assign('nr_facts', $facts['C']);

//***********************************************************************************
// Similar games
//***********************************************************************************

$sql_similar = $mysqli->query("SELECT COUNT(*) AS C FROM game_similar WHERE game_id = $game_id") or die($mysqli->error);
$similar = $sql_similar->fetch_array(MYSQLI_BOTH);
$smarty->assign('nr_similar', $similar['C']);

//***********************************************************************************
//AKA's
//***********************************************************************************

$sql_aka = $mysqli->query("SELECT * FROM game_aka
                           LEFT JOIN language ON (game_aka.language_id = language.id)
                           WHERE game_id='$game_id'") or die("Couldn't query aka games");

$nr_aka = 0;

while ($aka = $sql_aka->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('aka', array(
        'game_aka_name' => $aka['aka_name'],
        'game_id' => $aka['game_id'],
        'language_id' => $aka['language_id'],
        'game_aka_id' => $aka['game_aka_id']
    ));
    $nr_aka++;
}

$smarty->assign("nr_aka", $nr_aka);

//**********************************************************************************
//Get the languages
//**********************************************************************************

$sql_languages = $mysqli->query("SELECT * FROM language ORDER BY name ASC") or die("Couldn't query language database");

while ($languages = $sql_languages->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('languages', array(
        'id' => $languages['id'],
        'name' => $languages['name']
    ));
}

//***********************************************************************************
//get the sound hardware types
//***********************************************************************************
$smarty->assign('all_sound_hardware', $soundHardwareDao->getAllSoundHardware());
$smarty->assign('linked_sound_hardware', $soundHardwareDao->getSoundHardwareForGame($game_id));

//***********************************************************************************
//get the multiplayer options
//***********************************************************************************
$smarty->assign('multiplayer_types', $gameDao->getMultiplayerTypes());
$smarty->assign('multiplayer_hardware', $gameDao->getMultiplayerHardware());

//***********************************************************************************
//The game statistics below on the page
//***********************************************************************************

//Get the number of screenshots!
$numberscreen = $mysqli->query("SELECT count(*) as count FROM screenshot_game WHERE game_id = '$game_id'")
    or die("couldn't get number of screenshots");
$array = $numberscreen->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_screenshots", $array['count']);

//check the number of boxscans
$numberbox = $mysqli->query("SELECT count(*) as count FROM game_boxscan WHERE game_id = '$game_id'")
    or die("couldn't get number of boxscans");
$array = $numberbox->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_boxscans", $array['count']);

//Check how many reviews a game has
$numberreviews = $mysqli->query("SELECT count(*) as count FROM review_game WHERE game_id = '$game_id'")
    or die("couldn't get number of reviews");
$array = $numberreviews->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_reviews", $array['count']);

//check how many pics there are in the game gallery
$numbergallery = $mysqli->query("SELECT count(*) as count FROM game_gallery WHERE game_id = '$game_id'")
    or die("couldn't get number of gallery pics");
$array = $numbergallery->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_pics", $array['count']);

//check how many music files this game has
$numbermusic = $mysqli->query("SELECT count(*) as count FROM game_music WHERE game_id = '$game_id'")
    or die("couldn't get number of music files");
$array = $numbermusic->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_music", $array['count']);

//check how many magazine reviews this game has
$numbermag = $mysqli->query("SELECT count(*) as count FROM magazine_game WHERE game_id = '$game_id'")
    or die("couldn't get number of mag reviews");
$array = $numbermag->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_magazines", $array['count']);

$number_comments = $mysqli->query("SELECT count(*) as count FROM game_user_comments WHERE game_id = '$game_id'")
    or die("couldn't get number of comments");

$array = $number_comments->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_comments", $array['count']);

$smarty->assign("game_id", $game_id);
$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games/games_detail.html");

//close the connection
mysqli_close($mysqli);
