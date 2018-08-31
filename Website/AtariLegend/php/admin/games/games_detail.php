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

require_once __DIR__."/../../common/DAO/GameReleaseDAO.php";
require_once __DIR__."/../../common/DAO/GameDAO.php";
require_once __DIR__."/../../common/DAO/IndividualDAO.php";
require_once __DIR__."/../../common/DAO/PubDevDAO.php";
require_once __DIR__."/../../common/DAO/ProgrammingLanguageDAO.php";
require_once __DIR__."/../../common/DAO/GameGenreDAO.php";

$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);
$gameDao = new \AL\Common\DAO\GameDAO($mysqli);
$individualDao = new \Al\Common\DAO\IndividualDAO($mysqli);
$pubDevDao = new \AL\Common\DAO\PubDevDAO($mysqli);
$ProgrammingLanguageDao = new \AL\Common\DAO\ProgrammingLanguageDAO($mysqli);
$GameGenreDao = new \AL\Common\DAO\GameGenreDAO($mysqli);

//***********************************************************************************
//Let's get the general game info first.
//***********************************************************************************
$sql_game = $mysqli->query("SELECT game_name,
               game.game_id,
               game_development.development,
               game_unreleased.unreleased,
               game_unfinished.unfinished,
               game_wanted.game_wanted_id,
               game_arcade.arcade
               FROM game
               LEFT JOIN game_unreleased ON (game.game_id = game_unreleased.game_id)
               LEFT JOIN game_development ON (game.game_id = game_development.game_id)
               LEFT JOIN game_arcade ON (game.game_id = game_arcade.game_id)
               LEFT JOIN game_unfinished ON (game.game_id = game_unfinished.game_id)
               LEFT JOIN game_wanted ON (game.game_id = game_wanted.game_id)
                 WHERE game.game_id='$game_id'") or die("Error getting game info: " . $mysqli->error);

while ($game_info = $sql_game->fetch_array(MYSQLI_BOTH)) {
        
    $smarty->assign('game_info', array(
        'game_name' => $game_info['game_name'],
        'game_id' => $game_info['game_id'],
        'game_development' => $game_info['development'],
        'game_unreleased' => $game_info['unreleased'],
        'game_unfinished' => $game_info['unfinished'],
        'game_wanted' => $game_info['game_wanted_id'],
        'game_arcade' => $game_info['arcade']
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
$smarty->assign('game_genres', $GameGenreDao->getAllGameGenres());
$smarty->assign('game_genres_cross', $GameGenreDao->getGameGenresForGame($game_id));


//*******************************************************************************************
//get the programming languages and the programming languages already selected for this game
//*******************************************************************************************
$smarty->assign('programming_languages', $ProgrammingLanguageDao->getAllProgrammingLanguages());
$smarty->assign('game_programming_languages', $ProgrammingLanguageDao->getProgrammingLanguagesForGame($game_id));


//**********************************************************************************
//Get the author info
//**********************************************************************************
$smarty->assign('individuals', $individualDao->getAllIndividuals());

// Get the author types
$sql_author = $mysqli->query("SELECT * FROM author_type ORDER BY author_type_info ASC") or die("Couldn't query author_types");

while ($author = $sql_author->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('author_types', array(
        'author_type' => $author['author_type_info'],
        'author_type_id' => $author['author_type_id']
    ));
}

//Starting off with displaying the authors that are linked to the game and having a delete option for them */
$sql_gameauthors = $mysqli->query("SELECT * FROM game_author
                  LEFT JOIN individuals ON (game_author.ind_id = individuals.ind_id)
                  LEFT JOIN author_type ON (game_author.author_type_id = author_type.author_type_id)
                  WHERE game_author.game_id='$game_id' ORDER BY author_type.author_type_id, individuals.ind_name") or die("Error loading authors");

while ($game_author = $sql_gameauthors->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('game_author', array(
        'game_author_id' => $game_author['game_author_id'],
        'ind_name' => $game_author['ind_name'],
        'ind_id' => $game_author['ind_id'],
        'author_type_info' => $game_author['author_type_info'],
        'author_type_id' => $game_author['author_type_id']
    ));
}

//**********************************************************************************
//Get the companies info
//**********************************************************************************

$smarty->assign('pubdevs', $pubDevDao->getPubDevsStartingWith("^[0-9]"));

//let's get the publishers for this game
$sql_publisher = $mysqli->query("SELECT * FROM pub_dev
                 LEFT JOIN game_publisher ON ( pub_dev.pub_dev_id = game_publisher.pub_dev_id )
                 -- Developer role is still needed here as it's the old game_extra_info tables
                 -- It's still used by publishers that are linked directly to a game, which
                 -- need to be cleaned up. That will be removed once all game publishers have
                 -- been merged into releases
                 LEFT JOIN developer_role ON ( game_publisher.game_extra_info_id = developer_role.id )
                 LEFT JOIN continent ON ( game_publisher.continent_id = continent.continent_id )
                 WHERE game_publisher.game_id = '$game_id' ORDER BY pub_dev_name ASC") or die("Couldn't query publishers: ".$mysqli->error);

while ($publishers = $sql_publisher->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('publishers', array(
        'pub_dev_id' => $publishers['pub_dev_id'],
        'pub_dev_name' => $publishers['pub_dev_name'],
        'game_extra_info' => $publishers['role'],
        'game_extra_info_id' => $publishers['id'],
        'continent_id' => $publishers['continent_id'],
        'continent_name' => $publishers['continent_name']
    ));
}

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
//Get all the continents
//**********************************************************************************

$sql_continent = $mysqli->query("SELECT * FROM continent ORDER BY continent_name ASC") or die("Couldn't query continent database");

while ($continent = $sql_continent->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('continents', array(
        'continent_id' => $continent['continent_id'],
        'continent_name' => $continent['continent_name']
    ));
}

//**********************************************************************************
//Get the developer roles
//**********************************************************************************

$sql_developer_role = $mysqli->query("SELECT * FROM developer_role ORDER BY role ASC") or die("Couldn't query developer_role database");

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
//The game statistics below on the page
//***********************************************************************************

//Get the number of screenshots!
$numberscreen = $mysqli->query("SELECT count(*) as count FROM screenshot_game WHERE game_id = '$game_id'") or die("couldn't get number of screenshots");
$array = $numberscreen->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_screenshots", $array['count']);

//check the number of boxscans
$numberbox = $mysqli->query("SELECT count(*) as count FROM game_boxscan WHERE game_id = '$game_id'") or die("couldn't get number of boxscans");
$array = $numberbox->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_boxscans", $array['count']);

//Check how many reviews a game has
$numberreviews = $mysqli->query("SELECT count(*) as count FROM review_game WHERE game_id = '$game_id'") or die("couldn't get number of reviews");
$array = $numberreviews->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_reviews", $array['count']);

//check how many pics there are in the game gallery
$numbergallery = $mysqli->query("SELECT count(*) as count FROM game_gallery WHERE game_id = '$game_id'") or die("couldn't get number of gallery pics");
$array = $numbergallery->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_pics", $array['count']);

//check how many music files this game has
$numbermusic = $mysqli->query("SELECT count(*) as count FROM game_music WHERE game_id = '$game_id'") or die("couldn't get number of music files");
$array = $numbermusic->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_music", $array['count']);

//check how many magazine reviews this game has
$numbermag = $mysqli->query("SELECT count(*) as count FROM magazine_game WHERE game_id = '$game_id'") or die("couldn't get number of mag reviews");
$array = $numbermag->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_magazines", $array['count']);

$number_comments = $mysqli->query("SELECT count(*) as count FROM game_user_comments WHERE game_id = '$game_id'") or die("couldn't get number of comments");

$array = $number_comments->fetch_array(MYSQLI_BOTH);

$smarty->assign("nr_comments", $array['count']);

$smarty->assign("game_id", $game_id);
$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games_detail.html");

//close the connection
mysqli_close($mysqli);
