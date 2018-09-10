<?php
/***************************************************************************
 *                                games_list.php
 *                            --------------------------
 *   begin                : Sunday, August 28, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *
 *   Id: games_list.php,v 0.10 2005/08/28 17:30 Gatekeeper
 *   Id: games_list.php,v 0.20 2015/10/31 10:13 Gatekeeper
 *   Id: games_list.php,v 0.30 2015/12/30 21:47 Gatekeeper - remove message var
 *   Id: games_list.php,v 0.31 2017/01/06 17:37 Gatekeeper - Falcon vga & rgb
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the game browse page where you can navigate your way through the games db
 ***********************************************************************************
 */

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

date_default_timezone_set('UTC');
$start = microtime(true);

// First create base sql statements

$RESULTGAME = "SELECT game.game_id,
        game.game_name,
        game_boxscan.game_boxscan_id,
        screenshot_game.screenshot_id,
        game_music.music_id,
        game_download.game_download_id,
        pd1.pub_dev_name AS 'publisher_name',
        pd1.pub_dev_id AS 'publisher_id',
        pd2.pub_dev_name AS 'developer_name',
        pd2.pub_dev_id AS 'developer_id',
        YEAR(game_release.date) AS game_release_year
        FROM game
        LEFT JOIN game_boxscan ON (game_boxscan.game_id = game.game_id)
        LEFT JOIN screenshot_game ON (screenshot_game.game_id = game.game_id)
        LEFT JOIN game_music ON (game_music.game_id = game.game_id)
        LEFT JOIN game_download ON (game_download.game_id = game.game_id)
        LEFT JOIN game_development ON (game.game_id = game_development.game_id)
        LEFT JOIN game_unreleased ON (game.game_id = game_unreleased.game_id)
        LEFT JOIN game_unfinished ON (game.game_id = game_unfinished.game_id)
        LEFT JOIN game_programming_language ON (game.game_id = game_programming_language.game_id)
        LEFT JOIN game_engine ON (game.game_id = game_engine.game_id)
        LEFT JOIN game_wanted ON (game.game_id = game_wanted.game_id)
        LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)
        LEFT JOIN pub_dev pd2 ON (pd2.pub_dev_id = game_developer.dev_pub_id)
        LEFT JOIN game_release ON (game_release.game_id = game.game_id)
        LEFT JOIN pub_dev pd1 ON (pd1.pub_dev_id = game_release.pub_dev_id)
        WHERE ";

$RESULTAKA = "SELECT
         game_aka.game_id,
         game_aka.aka_name,
         game_boxscan.game_boxscan_id,
         screenshot_game.screenshot_id,
         game_music.music_id,
         game_download.game_download_id,
         pd1.pub_dev_name as 'publisher_name',
         pd1.pub_dev_id as 'publisher_id',
         pd2.pub_dev_name as 'developer_name',
         pd2.pub_dev_id as 'developer_id',
         YEAR(game_release.date) as game_release_year
      FROM game_aka
      LEFT JOIN game ON (game_aka.game_id = game.game_id)
      LEFT JOIN game_boxscan ON (game_boxscan.game_id = game_aka.game_id)
      LEFT JOIN screenshot_game ON (screenshot_game.game_id = game.game_id)
      LEFT JOIN game_music ON (game_music.game_id = game.game_id)
      LEFT JOIN game_download ON (game_download.game_id = game.game_id)
      LEFT JOIN game_development ON (game.game_id = game_development.game_id)
      LEFT JOIN game_unreleased ON (game.game_id = game_unreleased.game_id)
      LEFT JOIN game_unfinished ON (game.game_id = game_unfinished.game_id)
      LEFT JOIN game_programming_language ON (game.game_id = game_programming_language.game_id)
      LEFT JOIN game_engine ON (game.game_id = game_engine.game_id)
      LEFT JOIN game_wanted ON (game.game_id = game_wanted.game_id)
      LEFT JOIN game_developer ON (game.game_id = game_developer.game_id)
      LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)
      LEFT JOIN game_release on (game_release.game_id = game.game_id)
      LEFT JOIN pub_dev pd1 ON (game_release.pub_dev_id = pd1.pub_dev_id)
     WHERE ";

if (empty($action)) {
    $action = '';
}
/*
 ***********************************************************************************
 Firstly , we are gonna check which parts of the search functions are used in the main
 screen and we're gonna fill some extra variables accordingly. These variables will be
 used to create the querystring later.
 ***********************************************************************************
 */
if (isset($action) and $action == "search") {
    if (isset($gamesearch)) {
        $gamesearch = $mysqli->real_escape_string($gamesearch);
    } else {
        $gamesearch = "";
    }

    //check the $gamebrowse select
    if (empty($gamebrowse) or $gamebrowse == '-') {
        $gamebrowse_select = "";
        $akabrowse_select  = "";
    } elseif ($gamebrowse == 'num') {
        $gamebrowse_select = "AND game.game_name REGEXP '^[0-9].*'";
        $akabrowse_select  = "AND game_aka.aka_name REGEXP '^[0-9].*'";
    } else {
        $gamebrowse_select = "AND game.game_name LIKE '$gamebrowse%'";
        $akabrowse_select  = "AND game_aka.aka_name LIKE '$gamebrowse%'";
    }

    //check the publisher select
    if (empty($publisher) or $publisher == '-') {
        $publisher_select = "";
    } else {
        $publisher_select = " AND pd1.pub_dev_id = $publisher";
    }

    //check the developer select
    if (empty($developer) or $developer == '-') {
        $developer_select = "";
    } elseif ($developer == "null") {
        $developer_select = " AND pd2.pub_dev_id IS NULL";
    } else {
        $developer_select = " AND pd2.pub_dev_id = $developer";
    }

    //check to see if the year has been clicked
    if (empty($year) or $year == '-') {
        $year_select = '';
    } elseif ($year == "no_year_set") {
        $year_select = " AND game_release.date IS NULL";
    } else {
        $year_select = " AND CONVERT(YEAR(game_release.date), CHAR(4)) = $year";
    }

    //
    // Here comes a bunch of tickbox checks.
    //

    if (isset($arcade) and $arcade == "1") {
        $arcade_select = " AND game.port_id ='1'";
    }

    if (isset($development) and $development == "1") {
        $development_select = " AND game_development.development =$development";
    }

    if (isset($unreleased) and $unreleased == "1") {
        $unreleased_select = " AND game_unreleased.unreleased =$unreleased";
    }

    if (isset($wanted) and $wanted == "1") {
        $wanted_select = " AND game_wanted.game_wanted_id IS NOT NULL";
    }

    if (isset($stos) and $stos == "1") {
        $stos_select = " AND game_programming_language.programming_language_id = 1";
    }

    if (isset($unfinished) and $unfinished == "1") {
        $unfinished_select = " AND game_unfinished.unfinished =$unfinished";
    }

    if (isset($seuck) and $seuck == "1") {
        $seuck_select = " AND game_engine.engine_id ='1'";
    }

    if (isset($stac) and $stac == "1") {
        $stac_select = " AND game_engine.engine_id ='2'";
    }
    if (isset($no_boxscan) and $no_boxscan == "1") {
        $no_boxscan_select = " AND game_boxscan.game_id IS NULL";
    }
    if (isset($no_screenshot) and $no_screenshot == "1") {
        $no_screenshot_select = " AND screenshot_game.game_id IS NULL";
    }

    /*
     ***********************************************************************************
     Now we're gonna start building the querystring. First we'll be checking of we are
     searching on a publisher only, a developer only, or if we are using a combination
     of search features. If we are searching for a pub or dev only, we create a different
     querystring for faster output
     ***********************************************************************************
     */
    if (!empty($gamesearch)) {
        $RESULTGAME .= "game.game_name LIKE '%$gamesearch%'";
        $RESULTAKA .= "game_aka.aka_name LIKE '%$gamesearch%'";
    } else {
        $RESULTGAME .= "game.game_name LIKE '%'";
        $RESULTAKA .= "game_aka.aka_name LIKE '%'";
    }
    $RESULTGAME .= $gamebrowse_select;
    $RESULTGAME .= $publisher_select;
    $RESULTGAME .= $developer_select;
    $RESULTAKA .= $akabrowse_select;
    $RESULTAKA .= $publisher_select;
    $RESULTAKA .= $developer_select;
    if (isset($year_select)) {
        $RESULTGAME .= $year_select;
        $RESULTAKA .= $year_select;
    }
    if (isset($falcon_only) and $falcon_only == "1") {
        $RESULTGAME .= $falcon_only_select;
        $RESULTAKA .= $falcon_only_select;
    }
    if (isset($falcon_enhanced) and $falcon_enhanced == "1") {
        $RESULTGAME .= $falcon_enhanced_select;
        $RESULTAKA .= $falcon_enhanced_select;
    }
    if (isset($falcon_rgb) and $falcon_rgb == "1") {
        $RESULTGAME .= $falcon_rgb_select;
        $RESULTAKA .= $falcon_rgb_select;
    }
    if (isset($falcon_vga) and $falcon_vga == "1") {
        $RESULTGAME .= $falcon_vga_select;
        $RESULTAKA .= $falcon_vga_select;
    }
    if (isset($ste_only) and $ste_only == "1") {
        $RESULTGAME .= $ste_only_select;
        $RESULTAKA .= $ste_only_select;
    }
    if (isset($free) and $free == "1") {
        $RESULTGAME .= $free_select;
        $RESULTAKA .= $free_select;
    }
    if (isset($commercial) and $commercial == "1") {
        $RESULTGAME .= $free_select;
        $RESULTAKA .= $free_select;
    }
    if (isset($arcade) and $arcade == "1") {
        $RESULTGAME .= $arcade_select;
        $RESULTAKA .= $arcade_select;
    }
    if (isset($development) and $development == "1") {
        $RESULTGAME .= $development_select;
        $RESULTAKA .= $development_select;
    }
    if (isset($unreleased) and $unreleased == "1") {
        $RESULTGAME .= $unreleased_select;
        $RESULTAKA .= $unreleased_select;
    }
    if (isset($unfinished) and $unfinished == "1") {
        $RESULTGAME .= $unfinished_select;
        $RESULTAKA .= $unfinished_select;
    }
    if (isset($monochrome) and $monochrome == "1") {
        $RESULTGAME .= $monochrome_select;
        $RESULTAKA .= $monochrome_select;
    }
    if (isset($seuck) and $seuck == "1") {
        $RESULTGAME .= $seuck_select;
        $RESULTAKA .= $seuck_select;
    }
    if (isset($stos) and $stos == "1") {
        $RESULTGAME .= $stos_select;
        $RESULTAKA .= $stos_select;
    }
    if (isset($stac) and $stac == "1") {
        $RESULTGAME .= $stac_select;
        $RESULTAKA .= $stac_select;
    }
    if (isset($no_boxscan) and $no_boxscan == "1") {
        $RESULTGAME .= $no_boxscan_select;
        $RESULTAKA .= $no_boxscan_select;
    }
    if (isset($no_screenshot) and $no_screenshot == "1") {
        $RESULTGAME .= $no_screenshot_select;
        $RESULTAKA .= $no_screenshot_select;
    }
    if (isset($wanted) and $wanted == "1") {
        $RESULTGAME .= $wanted_select;
        $RESULTAKA .= $wanted_select;
    }

    $RESULTGAME .= ' GROUP BY game.game_id, game.game_name HAVING COUNT(DISTINCT game.game_id, game.game_name) = 1';
    $RESULTGAME .= ' ORDER BY game_name ASC';
    $RESULTAKA .= ' GROUP BY game_aka.game_id, game_aka.aka_name HAVING COUNT(DISTINCT game_aka.game_id, game_aka.aka_name) = 1';
    $RESULTAKA .= ' ORDER BY game_aka.aka_name ASC';


    $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $RESULTGAME") or die(mysqli_error());
    $mysqli->query("INSERT INTO temp $RESULTAKA") or die(mysqli_error());

    $temp_query = $mysqli->query("SELECT * FROM temp ORDER BY game_name ASC") or die("does not compute3");

    $rows = $temp_query->num_rows;
    if ($rows > 0) {
        while ($sql_game_search = $temp_query->fetch_array(MYSQLI_BOTH)) {

            //Game names can only be 40 chars long
            if (strlen($sql_game_search['game_name']) > 40) {
                $game_name = substr($sql_game_search['game_name'], 0, 40);
                $game_name = $game_name . '...';
            } else {
                $game_name = $sql_game_search['game_name'];
            }

            //publishers can only be 18 chars long
            if (strlen($sql_game_search['publisher_name']) > 18) {
                $pub_name = substr($sql_game_search['publisher_name'], 0, 18);
                $pub_name = $pub_name . '...';
            } else {
                $pub_name = $sql_game_search['publisher_name'];
            }

            //developers can only be 18 chars long
            if (strlen($sql_game_search['developer_name']) > 18) {
                $dev_name = substr($sql_game_search['developer_name'], 0, 18);
                $dev_name = $dev_name . '...';
            } else {
                $dev_name = $sql_game_search['developer_name'];
            }

            $smarty->append('game_search', array(
                        'game_id' => $sql_game_search['game_id'],
                        'game_name' => $game_name,
                        'publisher_id' => $sql_game_search['publisher_id'],
                        'publisher_name' => $pub_name,
                        'developer_id' => $sql_game_search['developer_id'],
                        'developer_name' => $dev_name,
                        'year' => $sql_game_search['game_release_year'],
                        'music' => $sql_game_search['music_id'],
                        'boxscan' => $sql_game_search['game_boxscan_id'],
                        'download' => $sql_game_search['game_download_id'],
                        'screenshot' => $sql_game_search['screenshot_id']
                    ));
        }
        $time_elapsed_secs = microtime(true) - $start;
        $smarty->assign("nr_of_games", $rows);
        $smarty->assign("query_time", $time_elapsed_secs);

        $mysqli->query("DROP TABLE temp") or die("does not compute4");

        $smarty->assign("user_id", $_SESSION['user_id']);

        //Send all smarty variables to the templates
        $smarty->display("file:" . $cpanel_template_folder . "ajax_game_search.html");
    } else {
        // If there are no search results
        $smarty->assign("nr_of_games", 'none');
        $smarty->display("file:" . $cpanel_template_folder . "ajax_game_search.html");
    }
}
