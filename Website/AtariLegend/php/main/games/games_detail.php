<?php
/***************************************************************************
 *                                games_detail.php
 *                            ------------------------------
 *   begin                : Thursday, 20 July, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *
 *   Id: games_detail.php,v 0.10 20/07/2017 17:37 STG
 ****************************************************************************/

//****************************************************************************************
// This is the detail page of a game.
//****************************************************************************************

//load all common functions
require "../../config/common.php";
require_once __DIR__."/../../common/DAO/GameReleaseDAO.php";
require_once __DIR__."/../../common/DAO/GameSeriesDAO.php";
require_once __DIR__."/../../common/DAO/ResolutionDAO.php";
require_once __DIR__."/../../common/DAO/SystemDAO.php";
require_once __DIR__."/../../common/DAO/PubDevDAO.php";
require_once __DIR__."/../../common/DAO/LocationDAO.php";
require_once __DIR__."/../../common/DAO/ProgrammingLanguageDAO.php";
require_once __DIR__."/../../common/DAO/GameGenreDAO.php";
require_once __DIR__."/../../common/DAO/PortDAO.php";
require_once __DIR__."/../../common/DAO/EngineDAO.php";
require_once __DIR__."/../../common/DAO/ControlDAO.php";
require_once __DIR__."/../../common/DAO/GameReleaseAkaDAO.php";
require_once __DIR__."/../../common/DAO/LanguageDAO.php";
require_once __DIR__."/../../common/DAO/EmulatorDAO.php";
require_once __DIR__."/../../common/DAO/TrainerOptionDAO.php";
require_once __DIR__."/../../common/DAO/MemoryDAO.php";
require_once __DIR__."/../../common/DAO/TosDAO.php";
require_once __DIR__."/../../common/DAO/CopyProtectionDAO.php";
require_once __DIR__."/../../common/DAO/DiskProtectionDAO.php";
require_once __DIR__."/../../common/DAO/SoundHardwareDAO.php";
require_once __DIR__."/../../common/DAO/GameProgressSystemDAO.php";
require_once __DIR__."/../../common/DAO/GameReleaseScanDAO.php";
require_once __DIR__."/../../common/DAO/GameDAO.php";

$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);
$gameSeriesDao = new \AL\Common\DAO\GameSeriesDAO($mysqli);
$resolutionDao = new \AL\Common\DAO\ResolutionDao($mysqli);
$systemDao = new \AL\Common\DAO\SystemDao($mysqli);
$pubDevDao = new \AL\Common\DAO\PubDevDAO($mysqli);
$locationDao = new \AL\Common\DAO\LocationDAO($mysqli);
$programmingLanguageDao = new \AL\Common\DAO\ProgrammingLanguageDAO($mysqli);
$gameGenreDao = new \AL\Common\DAO\GameGenreDAO($mysqli);
$portDao = new \AL\Common\DAO\portDAO($mysqli);
$engineDao = new \AL\Common\DAO\engineDAO($mysqli);
$controlDao = new \AL\Common\DAO\controlDAO($mysqli);
$gameReleaseAkaDao = new \AL\Common\DAO\GameReleaseAkaDAO($mysqli);
$languageDao = new \AL\Common\DAO\LanguageDAO($mysqli);
$emulatorDao = new \AL\Common\DAO\EmulatorDAO($mysqli);
$trainerOptionDao = new \AL\Common\DAO\TrainerOptionDAO($mysqli);
$memoryDao = new \AL\Common\DAO\MemoryDAO($mysqli);
$tosDao = new \AL\Common\DAO\TosDAO($mysqli);
$copyProtectionDao = new \AL\Common\DAO\CopyProtectionDAO($mysqli);
$diskProtectionDao = new \AL\Common\DAO\DiskProtectionDAO($mysqli);
$soundHardwareDao = new \AL\Common\DAO\SoundHardwareDAO($mysqli);
$gameProgressSystemDao = new \AL\Common\DAO\GameProgressSystemDAO($mysqli);
$gameReleaseScanDao = new \AL\Common\DAO\GameReleaseScanDAO($mysqli);
$gameDao = new \AL\Common\DAO\GameDAO($mysqli);

/**
 * Generates an SEO-friendly description of a game, depending on the data available
 *
 * @param $game_name Name of the game
 * @param $game_akas Optional names the game is known as
 * @param $game_releases Game releases
 * @param $game_genres Genre(s) the game belong to
 * @param $game_developers Developer(s) of the game
 * @param $screenshots Number of screenshots available
 * @param $boxscans Number of boxscans available
 * @param $reviews Number of reviews available
 * return A text description of the game
 */
function generate_game_description(
    $game_name,
    $game_akas,
    $game_releases,
    $game_genres,
    $game_developers,
    $screenshots,
    $boxscans,
    $reviews
) {
    $desc = "$game_name is a ";

    if ($game_genres) {
        for ($i = 0; $i < count($game_genres); $i++) {
            $desc .= strtolower($game_genres[$i]->getName());
            if ($i+1 < count($game_genres)) {
                $desc .= ", ";
            }
        }
        $desc .= " ";
    }

    $desc .= "game for the Atari ST ";

    if ($game_developers) {
        $desc .= "developed by ".join($game_developers, ", ")." ";
    }

    if ($game_releases) {
        $years = [];
        foreach ($game_releases as $release) {
            if ($release->getDate()) {
                $year = date("Y", strtotime($release->getDate()));
                if ($release->getPublisher() != null) {
                    $years[] = $year." (by ".$release->getPublisher()->getName().")";
                } else {
                    // Avoid duplicate dates
                    if (!in_array($year, $years)) {
                        $years[] = $year;
                    }
                }
            }
        }
        if ($years) {
            $desc .= "released in ".join($years, ", ");
        }
    }

    // Fixup a/an for vowels: "a Atari ST game" should be "an Atari ST game"
    // In theory it's not really about vowels, but how the word is pronounced,
    // but using vowels for approximation is good enough.
    // Replace any " a ..." followed by a vowel with " an ..."
    $desc = preg_replace("/ a ([aeiou])/i", " an $1", $desc);

    // Remove last trailing space, which may happen if the game has a developer
    // but no release date
    $desc = trim($desc);

    // Append extra info (number of screenshots, reviews, etc) in brackets
    // after the description
    $extra_info = [];

    if (count($game_releases) > 1) {
        $extra_info[] = count($game_releases)." releases";
    }

    if ($screenshots) {
        $extra_info[] = "$screenshots screenshot".(($screenshots > 1) ? "s" : "");
    }
    if ($boxscans) {
        $extra_info[] = "$boxscans box scan".(($boxscans > 1) ? "s" : "");
    }
    if ($reviews) {
        $extra_info[] = "$reviews review".(($reviews > 1) ? "s" : "");
    }

    if ($extra_info) {
        $desc .= " (".join($extra_info, ", ").")";
    }

    $desc .= ".";

    if (count($game_akas) > 0) {
        $desc .= " It's also known as: ".join($game_akas, ", ").".";
    }

    return $desc;
}

//***********************************************************************************
//Let's get the general game info first.
//***********************************************************************************
$sql_game = $mysqli->query(
    "SELECT game_name,
               game.game_id,
               game.game_series_id
               FROM game
               WHERE game.game_id='$game_id'"
) or die("Error getting game info");

if ($game_info = $sql_game->fetch_array(MYSQLI_BOTH)) {
    $smarty->assign(
        'game_info', array(
        'game_name' => $game_info['game_name'],
        'game_id' => $game_info['game_id']
        )
    );
}

//Get the game data --> new way of working
$smarty->assign('game', $gameDao->getGame($game_id));

// Get the programming languages
$smarty->assign('programming_languages', $programmingLanguageDao->getAllProgrammingLanguages());
$smarty->assign('game_programming_languages', $programmingLanguageDao->getProgrammingLanguagesForGame($game_id));

$smarty->assign('resolutions', $resolutionDao->getAllResolutionsAsMap());
$smarty->assign('systems', $systemDao->getAllSystemsAsMap());
$smarty->assign('locations', $locationDao->getAllLocationsAsMap());

// Get all releases
$releases = $gameReleaseDao->getReleasesForGame($game_id);
$smarty->assign('releases', $releases);

if ($game_info["game_series_id"] != null) {
    $smarty->assign('series', $gameSeriesDao->getGameSeries($game_info["game_series_id"]));
    $smarty->assign('series_games', $gameSeriesDao->getGamesForSeries($game_info["game_series_id"]));
}

$system_incompatible = [];
$emulator_incompatible = [];
$system_enhanced = [];
$release_resolution = [];
$release_location = [];
$trainerOptions = [];
$memoryEnhancements = [];
$memoryMinimum = [];
$memoryIncompatible = [];
$tos_incompatible = [];
$copyProtections = [];
$diskProtections = [];
$release_language = [];

foreach ($releases as $release) {
    $system_incompatible[$release->getId()] = $systemDao->getIncompatibleSystemsForRelease($release->getId());
    $system_enhanced[$release->getId()] = $systemDao->getEnhancedSystemsForRelease($release->getId());
    $release_resolution[$release->getId()] = $resolutionDao->getResolutionsForRelease($release->getId());
    $release_location[$release->getId()] = $locationDao->getLocationsForRelease($release->getId());
    $release_akas[$release->getId()] = $gameReleaseAkaDao->getAllGameReleaseAkas($release->getId());
    $emulator_incompatible[$release->getId()] =
        $emulatorDao->getIncompatibleEmulatorsWithNameForRelease($release->getId());
    $distributors[$release->getId()] = $pubDevDao->getDistributorsForRelease($release->getId());
    $trainerOptions[$release->getId()] = $trainerOptionDao->getTrainerOptionsForRelease($release->getId());
    $memoryEnhancements[$release->getId()] = $memoryDao->getMemoryForRelease($release->getId());
    $memoryMinimum[$release->getId()] = $memoryDao->getMinimumMemoryForRelease($release->getId());
    $memoryIncompatible[$release->getId()] = $memoryDao->getMemoryIncompatibleForRelease($release->getId());
    $tos_incompatible[$release->getId()] = $tosDao->getIncompatibleTosWithNameForRelease($release->getId());
    $copyProtections[$release->getId()] = $copyProtectionDao->getCopyProtectionsForRelease($release->getId());
    $diskProtections[$release->getId()] = $diskProtectionDao->getDiskProtectionsForRelease($release->getId());
    $release_language[$release->getId()] = $languageDao->getAllGameReleaseLanguages($release->getId());
}
$smarty->assign('system_incompatible', $system_incompatible);
$smarty->assign('emulator_incompatible', $emulator_incompatible);
$smarty->assign('system_enhanced', $system_enhanced);
$smarty->assign('release_resolution', $release_resolution);
$smarty->assign('release_location', $release_location);
$smarty->assign('release_akas', $release_akas);
$smarty->assign('distributors', $distributors);
$smarty->assign('trainerOptions', $trainerOptions);
$smarty->assign('memoryEnhancements', $memoryEnhancements);
$smarty->assign('memoryMinimum', $memoryMinimum);
$smarty->assign('memoryIncompatible', $memoryIncompatible);
$smarty->assign('tos_incompatible', $tos_incompatible);
$smarty->assign('copyProtections', $copyProtections);
$smarty->assign('releaseLanguages', $release_language);
$smarty->assign('diskProtections', $diskProtections);

//***********************************************************************************
//get the game genres & the genres already selected for this game
//***********************************************************************************
$game_genres = $gameGenreDao->getGameGenresForGame($game_id);
$smarty->assign('game_genres', $game_genres);

//***********************************************************************************
//get the game port info
//***********************************************************************************
$port = $portDao->getPortForGame($game_id);
$smarty->assign('port', $port);

//***********************************************************************************
//get the external sound hardware
//***********************************************************************************
$soundHardware = $soundHardwareDao->getSoundHardwareForGame($game_id);
$smarty->assign('soundHardware', $soundHardware);

//***********************************************************************************
//get the progress system
//***********************************************************************************
$progressSystem = $gameProgressSystemDao->getProgressSystemForGame($game_id);
$smarty->assign('progressSystem', $progressSystem);

//***********************************************************************************
//get the engines & the engines already selected for this game
//***********************************************************************************
$game_engines = $engineDao->getGameEnginesForGame($game_id);
$smarty->assign('game_engines', $game_engines);

//***********************************************************************************
//get the controls & the controls already selected for this game
//***********************************************************************************
$game_controls = $controlDao->getGameControlsForGame($game_id);
$smarty->assign('game_controls', $game_controls);

//**********************************************************************************
//Get the author info
//**********************************************************************************
//Starting off with displaying the authors that are linked to the game and having a delete option for them */
$sql_game_individuals = $mysqli->query(
    "SELECT * FROM individuals
                        LEFT JOIN individual_text ON (individual_text.ind_id = individuals.ind_id)
                        LEFT JOIN game_individual ON (game_individual.individual_id = individuals.ind_id)
                        LEFT JOIN individual_role ON (game_individual.individual_role_id = individual_role.id)
                        WHERE game_individual.game_id='$game_id' ORDER BY individual_role.id, individuals.ind_name"
) or die("Error loading authors");

$nr_interviews = 0;

while ($game_individual = $sql_game_individuals->fetch_array(MYSQLI_BOTH)) {
    $nickname = '';
    $nick_id = '';
    $interview_id = '';

    if ($game_individual['ind_imgext'] == 'png'
        or $game_individual['ind_imgext'] == 'jpg'
        or $game_individual['ind_imgext']
    ) {
        $v_ind_image  = $individual_screenshot_path;
        $v_ind_image .= $game_individual['ind_id'];
        $v_ind_image .= '.';
        $v_ind_image .= $game_individual['ind_imgext'];
    } else {
        $v_ind_image = "none";
    }

    if (preg_match("/[a-z]/i", $game_individual['ind_profile'])) {
        $profile = $game_individual['ind_profile'];
    } else {
        $profile = 'none';
    }

    if (isset($game_individual['individual_id'])) {
        // Get nickname information
        $sql_nick = $mysqli->query("SELECT * FROM individual_nicks where ind_id=$game_individual[individual_id]")
            or die("problem getting nickname");

        while ($ind_nicks = $sql_nick->fetch_array(MYSQLI_BOTH)) {
            $ind_id = $ind_nicks['nick_id'];
            $sql_nickname = $mysqli->query("SELECT * FROM individuals WHERE ind_id=$ind_id");

            while ($ind_nickname = $sql_nickname->fetch_array(MYSQLI_BOTH)) {
                $nickname = $ind_nickname['ind_name'];
                $nick_id = $ind_nicks['nick_id'];
            }
        }

        //Get the interview
        $sql_interview = $mysqli->query(
            "SELECT * FROM interview_main
            LEFT JOIN interview_text ON (interview_main.interview_id = interview_text.interview_id)
            LEFT JOIN users ON (interview_main.user_id = users.user_id)
            WHERE ind_id=$game_individual[individual_id]"
        ) or die("problem getting interview");
        while ($interview = $sql_interview->fetch_array(MYSQLI_BOTH)) {
            $nr_interviews++;

            $interview_id = $interview['interview_id'];

            $interview_date = date("d/m/Y", $interview['interview_date']);

            //Structure and manipulate the comment text
            $int_text = $interview['interview_intro'];

            //fixxx the enters
            $int_text = stripslashes($int_text);
            $int_text = InsertALCode($int_text); // disabled this as it wrecked the design.
            $int_text = trim($int_text);
            $int_text = RemoveSmillies($int_text);

            if ($v_ind_image != 'none') {
                $smarty->append(
                    'interviews',
                    array( 'ind_id' => $game_individual['id'],
                           'ind_name' => $game_individual['ind_name'],
                           'ind_img' => $v_ind_image,
                           'int_id' => $interview['interview_id'],
                           'int_text' => $int_text,
                           'int_date' => $interview_date,
                           'int_user_id' => $interview['user_id'],
                           'int_userid' => $interview['userid']
                        )
                );
            }
        }
    }

    $smarty->append(
        'game_individual', array(
        'id' => $game_individual['id'],
        'ind_name' => $game_individual['ind_name'],
        'ind_id' => $game_individual['ind_id'],
        'ind_nick' => $nickname,
        'ind_nick_id' => $nick_id,
        'ind_profile' => $profile,
        'ind_img' => $v_ind_image,
        'interview_id' => $interview_id,
        'individual_role' => $game_individual['name']
        )
    );
}

if ($nr_interviews > 0) {
    $nr_interviews = $nr_interviews - 1; //*smarty index starting at 0
    $num = mt_rand(0, $nr_interviews);
    $smarty->assign("random_interview_nr", $num);
}

//**********************************************************************************
//Get the companies info
//**********************************************************************************
//let's get the developers for this game
$sql_developer = $mysqli->query(
    "SELECT * FROM game_developer
                  LEFT JOIN pub_dev ON ( pub_dev.pub_dev_id = game_developer.dev_pub_id )
                  LEFT JOIN pub_dev_text ON (pub_dev.pub_dev_id = pub_dev_text.pub_dev_id )
                  LEFT JOIN developer_role ON ( game_developer.developer_role_id = developer_role.id )
                  WHERE game_developer.game_id = '$game_id' ORDER BY pub_dev_name ASC"
) or die("Couldn't query developers");

$game_developers = [];
while ($developers = $sql_developer->fetch_array(MYSQLI_BOTH)) {
    $game_developers[] = rtrim($developers['pub_dev_name']);
    if ($developers['pub_dev_imgext'] == 'png'
        or $developers['pub_dev_imgext'] == 'jpg'
        or $developers['pub_dev_imgext'] == 'gif'
    ) {
        //$v_ind_image = $company_screenshot_path;
        $v_ind_image = $company_screenshot_save_path;
        $v_ind_image .= $developers['pub_dev_id'];
        $v_ind_image .= '.';
        $v_ind_image .= $developers['pub_dev_imgext'];

        $v_ind_image_pop = $company_screenshot_path;
        $v_ind_image_pop .= $developers['pub_dev_id'];
        $v_ind_image_pop .= '.';
        $v_ind_image_pop .= $developers['pub_dev_imgext'];
    } else {
        $v_ind_image = "none";
        $v_ind_image_pop = "none";
    }

    if (preg_match("/[a-z]/i", $developers['pub_dev_profile'])) {
        $profile = $developers['pub_dev_profile'];
    } else {
        $profile = 'none';
    }

    $smarty->append(
        'developer', array(
        'pub_id' => $developers['dev_pub_id'],
        'pub_name' => $developers['pub_dev_name'],
        'pub_profile' =>$profile,
        'extra_info' => $developers['role'],
        'logo' => $v_ind_image,
        'logo_pop' => $v_ind_image_pop,
        'logo_path' => $company_screenshot_path
        )
    );

    $smarty->append(
        'developers', array(
        'pub_id' => $developers['dev_pub_id'],
        'pub_name' => $developers['pub_dev_name'],
        'pub_profile' =>$profile,
        'extra_info' => $developers['role'],
        'logo' => $v_ind_image,
        'logo_pop' => $v_ind_image_pop,
        'logo_path' => $company_screenshot_path
        )
    );
}

//***********************************************************************************
//AKA's
//***********************************************************************************
$sql_aka = $mysqli->query(
    "SELECT * FROM game_aka
                           LEFT JOIN language ON (language.id = game_aka.language_id)
                           WHERE game_id='$game_id'"
) or die("Couldn't query aka games");
$nr_aka = 0;
$game_akas = [];
while ($aka = $sql_aka->fetch_array(MYSQLI_BOTH)) {
    $game_akas[] = $aka['aka_name'];
    $smarty->append(
        'aka', array(
        'game_aka_name' => $aka['aka_name'],
        'game_id' => $aka['game_id'],
        'language' => $aka['name'],
        'game_aka_id' => $aka['game_aka_id']
        )
    );
    $smarty->append(
        'akas', array(
        'game_aka_name' => $aka['aka_name'],
        'game_id' => $aka['game_id'],
        'language' => $aka['name'],
        'game_aka_id' => $aka['game_aka_id']
        )
    );
    $nr_aka++;
}

//***********************************************************************************
//Get the screenshots
//***********************************************************************************
//Get the screenshots for this game, if they exist
$sql_screenshots = $mysqli->query(
    "SELECT * FROM screenshot_game
                    LEFT JOIN screenshot_main ON (screenshot_game.screenshot_id = screenshot_main.screenshot_id)
                    WHERE screenshot_game.game_id = '$game_id' ORDER BY screenshot_game.screenshot_id"
) or die("Database error - selecting screenshots");

$count = 0;

$game_screenshots_count = 0;

while ($screenshots = $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
    $game_screenshots_count++;
    //Ready screenshots path and filename
    $screenshot_image = $game_screenshot_save_path;
    $screenshot_image .= $screenshots['screenshot_id'];
    $screenshot_image .= '.';
    $screenshot_image .= $screenshots['imgext'];

    $screenshot_image_pop = $game_screenshot_path;
    $screenshot_image_pop .= $screenshots['screenshot_id'];
    $screenshot_image_pop .= '.';
    $screenshot_image_pop .= $screenshots['imgext'];

    $smarty->append(
        'screenshots', array(
        'count' => $count,
        'path' => $game_screenshot_path,
        'screenshot_image' => $screenshot_image,
        'screenshot_image_pop' => $screenshot_image_pop,
        'id' => $screenshots['screenshot_id']
        )
    );
    $count++;
}

$smarty->assign("nr_screenshots", $count);

//***********************************************************************************
//Get the boxscans
//***********************************************************************************
$IMAGE = $mysqli->query("SELECT * FROM game_boxscan WHERE game_id='$game_id' ORDER BY game_boxscan_id")
    or die("Database error - selecting gamebox scan");

$imagenum_rows = $IMAGE->num_rows;

// if no boxscans are attached
$smarty->assign('numberscans', $imagenum_rows);

$front=0;

$game_boxscans_count = 0;

if ($imagenum_rows > 0) {
    while ($rowimage = $IMAGE->fetch_array(MYSQLI_BOTH)) { // First check if front cover
        $game_boxscans_count++;
        if ($rowimage['game_boxscan_side'] == 0) {
            $front++;

            $front_image_filename = "$game_boxscan_save_path$rowimage[game_boxscan_id].$rowimage[imgext]";
            $front_image_pop_filename = "$game_boxscan_path$rowimage[game_boxscan_id].$rowimage[imgext]";

            $smarty->append(
                'boxscan', array(
                'game_boxscan_id' => $rowimage['game_boxscan_id'],
                'image' => $front_image_filename,
                'image_pop' => $front_image_pop_filename
                )
            );
        } else { // Else back covers
            $couple = $mysqli->query(
                "SELECT game_boxscan_id FROM game_box_couples "
                ."WHERE game_boxscan_cross=$rowimage[game_boxscan_id]"
            )
                or die("Database error - selecting gamebox scan");
            $couplerow        = $couple->fetch_row();

            $back_image_filename = "$game_boxscan_save_path$rowimage[game_boxscan_id].$rowimage[imgext]";
            $back_image_pop_filename = "$game_boxscan_path$rowimage[game_boxscan_id].$rowimage[imgext]";

            $smarty->append(
                'boxscan', array(
                'game_boxscan_id' => $rowimage['game_boxscan_id'],
                'image' => $back_image_filename,
                'image_pop' => $back_image_pop_filename
                )
            );
        }
    }
}

$smarty->assign("nr_box", $front);


// Get box scans for all release
// This is temporary until we revamp the games/relase details page
$nr_of_release_scans=0;

$smarty->assign('release_scans', []);
foreach ($releases as $release) {
    $release_scans = $gameReleaseScanDao->getScansForRelease($release->getId());
    foreach ($release_scans as $scan) {
        $smarty->append('release_scans', $scan);
        $nr_of_release_scans++;
    }
}

$smarty->assign("nr_release", $nr_of_release_scans);

//***********************************************************************************
//Get the comments
//***********************************************************************************
//Select the comments from the DB
$sql_comment = $mysqli->query(
    "SELECT *
                                FROM game_user_comments
                                LEFT JOIN comments ON ( game_user_comments.comment_id = comments.comments_id )
                                LEFT JOIN users ON ( comments.user_id = users.user_id )
                                LEFT JOIN game ON ( game_user_comments.game_id = game.game_id )
                                WHERE game_user_comments.game_id = '$game_id'
                                ORDER BY comments.timestamp desc"
) or die("Syntax Error! Couldn't not get the comments!");

                                // lets put the comments in a smarty array

while ($query_comment = $sql_comment->fetch_array(MYSQLI_BOTH)) {
    $oldcomment = $query_comment['comment'];
    $oldcomment = nl2br($oldcomment);
    $oldcomment = InsertALCode($oldcomment);
    $oldcomment = trim($oldcomment);
    $oldcomment = RemoveSmillies($oldcomment);
    $oldcomment = stripslashes($oldcomment);

    $comment = stripslashes($query_comment['comment']);
    $comment = trim($comment);
    $comment = RemoveSmillies($comment);

    //this is needed, because users can change their own comments on the website, however this is done with JS
    //(instead of a post with pure HTML) The translation of the 'enter' breaks is different in JS, so in JS I do
    //a conversion to a <br>. However, when we edit a comment, this <br> should not be
    //visible to the user, hence again, now this conversion in php
    $breaks = array("<br />","<br>","<br/>");
    $comment = str_ireplace($breaks, "\r\n", $comment);

    $date = date("d/m/y", $query_comment['timestamp']);

    $smarty->append(
        'comments', array(
            'comment' => $oldcomment,
            'comment_edit' => $comment,
            'comment_id' => $query_comment['comment_id'],
            'date' => $date,
            'game' => $query_comment['game_name'],
            'game_id' => $query_comment['game_id'],
            'user_name' => $query_comment['userid'],
            'user_id' => $query_comment['user_id'],
            'user_fb' => $query_comment['user_fb'],
            'user_website' => $query_comment['user_website'],
            'user_twitter' => $query_comment['user_twitter'],
            'user_af' => $query_comment['user_af'],
            'user_avatar_ext' => $query_comment['avatar_ext'],
            'show_email' => $query_comment['show_email'],
            'email' => $query_comment['email']
        )
    );
}

//***********************************************************************************
//Get the reviews
//***********************************************************************************
$sql_review = $mysqli->query(
    "
SELECT * FROM game
LEFT JOIN review_game ON (game.game_id = review_game.game_id)
LEFT JOIN review_main ON (review_game.review_id = review_main.review_id)
LEFT JOIN review_score ON (review_main.review_id = review_score.review_id)
LEFT JOIN users ON (review_main.user_id = users.user_id)
WHERE game.game_id = '$game_id' AND review_main.review_edit = '0'"
)
or die("Error - Couldn't query review data");

$game_reviews_count = 0;
while ($query_review = $sql_review->fetch_array(MYSQLI_BOTH)) {
    $game_reviews_count++;
    $review_date = date("F j, Y", $query_review['review_date']);

    //Structure and manipulate the review text
    $review_text = $query_review['review_text'];

    $pos_start = strpos($review_text, '[frontpage]');
    $pos_end = strpos($review_text, '[/frontpage]');
    $nr_char = $pos_end - $pos_start;

    $review_text  = substr($review_text, $pos_start, $nr_char);
    $review_text = nl2br($review_text);
    $review_text = InsertALCode($review_text); // disabled this as it wrecked the design.
    $review_text = trim($review_text);
    $review_text = RemoveSmillies($review_text);

    //Get a screenshots and the comments of this review
    $query_screenshots_review = $mysqli->query(
        "SELECT * FROM review_main
        LEFT JOIN screenshot_review ON (review_main.review_id = screenshot_review.review_id)
        LEFT JOIN screenshot_main ON (screenshot_review.screenshot_id = screenshot_main.screenshot_id)
        LEFT JOIN review_comments ON (screenshot_review.screenshot_review_id = review_comments.screenshot_review_id)
        WHERE review_main.review_id = '$query_review[review_id]' AND review_main.review_edit = '0'
        ORDER BY RAND() LIMIT 1"
    ) or die("Error - Couldn't query review screenshots");

    $sql_screenshots_review = $query_screenshots_review->fetch_array(MYSQLI_BOTH);

    $new_path = $game_screenshot_path;
    $new_path .= $sql_screenshots_review['screenshot_id'];
    $new_path .= ".";
    $new_path .= $sql_screenshots_review['imgext'];

    $smarty->append(
        'review', array(
            'user_name' => $query_review['userid'],
            'user_id' => $query_review['user_id'],
            'review_id' => $query_review['review_id'],
            'email' => $query_review['email'],
            'game_id' => $query_review['game_id'],
            'date' => $review_date,
            'game_name' => $query_review['game_name'],
            'text' => $review_text,
            'screenshot' => $new_path,
            'comment' => $sql_screenshots_review['comment_text']
        )
    );
    $smarty->append(
        'reviews', array(
            'user_name' => $query_review['userid'],
            'user_id' => $query_review['user_id'],
            'review_id' => $query_review['review_id'],
            'email' => $query_review['email'],
            'game_id' => $query_review['game_id'],
            'date' => $review_date,
            'game_name' => $query_review['game_name'],
            'text' => $review_text,
            'screenshot' => $new_path,
            'comment' => $sql_screenshots_review['comment_text']
        )
    );
}

//***********************************************************************************
//Get Similar game
//***********************************************************************************
//select a random similar game
$sql_similar = $mysqli->query(
    "SELECT * FROM game_similar WHERE game_similar.game_id = '$game_id' "
    ."ORDER BY RAND() LIMIT 1"
)
    or die("Error - Couldn't get similar game");

while ($query_similar = $sql_similar->fetch_array(MYSQLI_BOTH)) {
    //get the game data
    $query_game_similar_data = $mysqli->query(
        "
    SELECT * FROM game
    LEFT JOIN screenshot_game ON (game.game_id = screenshot_game.game_id)
    LEFT JOIN screenshot_main ON (screenshot_game.screenshot_id = screenshot_main.screenshot_id)
    LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)
    LEFT JOIN pub_dev ON (pub_dev.pub_dev_id = game_developer.dev_pub_id)
    WHERE game.game_id = '$query_similar[game_similar_cross]'
    ORDER BY RAND() LIMIT 1"
    )
    or die("Error - Couldn't get similar game data");

    while ($sql_game_similar_data = $query_game_similar_data->fetch_array(MYSQLI_BOTH)) {
        if ($sql_game_similar_data['screenshot_id'] != '') {
            $new_path = $game_screenshot_path;
            $new_path .= $sql_game_similar_data['screenshot_id'];
            $new_path .= ".";
            $new_path .= $sql_game_similar_data['imgext'];
        } else {
            $new_path = 'none';
        }

        $smarty->assign(
            'similar', array(
            'game_id' => $query_similar['game_similar_cross'],
            'game_name' => $sql_game_similar_data['game_name'],
            'game_dev_name' => $sql_game_similar_data['pub_dev_name'],
            'game_dev_id' => $sql_game_similar_data['pub_dev_id'],
            'screenshot' => $new_path )
        );
    }
}

//***********************************************************************************
//Get the game facts
//***********************************************************************************
//load the facts for this games
$query_games_facts = $mysqli->query(
    "SELECT * from game_fact
                                     LEFT JOIN game ON (game.game_id = game_fact.game_id)
                                     WHERE game_fact.game_id = $game_id"
) or die("error in query game facts");

while ($sql_games_facts = $query_games_facts->fetch_array(MYSQLI_BOTH)) {
    //check if there are screenshot added to the submission
    $query_screenshots_facts = $mysqli->query(
        "SELECT * FROM screenshot_main
        LEFT JOIN screenshot_game_fact ON (screenshot_main.screenshot_id = screenshot_game_fact.screenshot_id)
        WHERE screenshot_game_fact.game_fact_id = '$sql_games_facts[game_fact_id]'"
    ) or die("Error - Couldn't query fact screenshots");

    while ($sql_screenshots_facts = $query_screenshots_facts->fetch_array(MYSQLI_BOTH)) {
        $new_path = $game_fact_screenshot_path;
        $new_path .= $sql_screenshots_facts['screenshot_id'];
        $new_path .= ".";
        $new_path .= $sql_screenshots_facts['imgext'];

        $smarty->append(
            'facts_screenshots', array(
            'game_fact_id' => $sql_games_facts['game_fact_id'],
            'game_fact_screenshot' => $new_path
            )
        );
    }

    $fact_text = nl2br($sql_games_facts['game_fact']);
    $fact_text = InsertALCode($fact_text); // disabled this as it wrecked the design.
    $fact_text = trim($fact_text);
    $fact_text = RemoveSmillies($fact_text);

    $smarty->append(
        'facts', array(
        'game_fact_id' => $sql_games_facts['game_fact_id'],
        'game_fact' => $fact_text
        )
    );
}

//*********************************************************************************************
// Get the amiga and C64 id's for the Lemon links
//*********************************************************************************************
$sql_vs = $mysqli->query("SELECT amiga_id, C64_id FROM game_vs WHERE atari_id = '$game_id'")
          or die("Error - Couldn't get the Lemon links");

while ($query_vs = $sql_vs->fetch_array(MYSQLI_BOTH)) {
    $smarty->append(
        'game_vs', array(
        'amiga_id' => $query_vs['amiga_id'],
        'C64_id' => $query_vs['C64_id']
        )
    );
}

$smarty->assign("game_id", $game_id);
$smarty->assign(
    "game_description", generate_game_description(
        $game_info['game_name'],
        $game_akas,
        $releases,
        $game_genres,
        $game_developers,
        $game_screenshots_count,
        $game_boxscans_count,
        $game_reviews_count
    )
);

$smarty->assign('user_avatar_path', $user_avatar_path);

//Send all smarty variables to the templates
$smarty->display("file:" . $mainsite_template_folder . "games/games_detail.new.html");

//close the connection
mysqli_close($mysqli);
