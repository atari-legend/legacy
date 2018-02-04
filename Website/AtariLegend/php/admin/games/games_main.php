<?php
/***************************************************************************
 *                                games_main.php
 *                            --------------------------
 *   begin                : Sunday, August 28, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *
 *   Id: games_main.php,v 0.10 2005/08/28 17:30 Gatekeeper
 *   Id: games_main.php,v 0.20 2015/08/24 22:24 Gatekeeper
 *   Id: games_main.php,v 0.30 2015/12/21 19:47 Gatekeeper - adding the quick search include
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

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

$smarty->assign("user_id", $_SESSION['user_id']);

if (isset($_SESSION['edit_message'])) {
    $smarty->assign("message", $_SESSION['edit_message']);
}

date_default_timezone_set('UTC');
$start = microtime(true);

// First create base sql statements

$RESULTGAME = "SELECT game.game_id,
        game.game_name,
        game_boxscan.game_boxscan_id,
        screenshot_game.screenshot_id,
        game_music.music_id,
        game_download.game_download_id,
        game_falcon_only.falcon_only,
        game_falcon_enhan.falcon_enhanced,
        game_falcon_rgb.falcon_rgb,
        game_falcon_vga.falcon_vga,
        game_ste_enhan.ste_enhanced,
        game_ste_only.ste_only,
        pd1.pub_dev_name as 'publisher_name',
        pd1.pub_dev_id as 'publisher_id',
        pd2.pub_dev_name as 'developer_name',
        pd2.pub_dev_id as 'developer_id',
        YEAR(game_release.date) as game_release_year
        FROM game
        LEFT JOIN game_boxscan ON (game_boxscan.game_id = game.game_id)
        LEFT JOIN screenshot_game ON (screenshot_game.game_id = game.game_id)
        LEFT JOIN game_music ON (game_music.game_id = game.game_id)
        LEFT JOIN game_download ON (game_download.game_id = game.game_id)
        LEFT JOIN game_falcon_only ON (game_falcon_only.game_id = game.game_id)
        LEFT JOIN game_falcon_enhan ON (game.game_id = game_falcon_enhan.game_id)
        LEFT JOIN game_falcon_rgb ON (game_falcon_rgb.game_id = game.game_id)
        LEFT JOIN game_falcon_vga ON (game.game_id = game_falcon_vga.game_id)
        LEFT JOIN game_ste_enhan ON (game.game_id = game_ste_enhan.game_id)
        LEFT JOIN game_ste_only ON (game.game_id = game_ste_only.game_id)
        LEFT JOIN game_free ON (game.game_id = game_free.game_id)
        LEFT JOIN game_arcade ON (game.game_id = game_arcade.game_id)
        LEFT JOIN game_development ON (game.game_id = game_development.game_id)
      LEFT JOIN game_unreleased ON (game.game_id = game_unreleased.game_id)
      LEFT JOIN game_unfinished ON (game.game_id = game_unfinished.game_id)
      LEFT JOIN game_mono ON (game.game_id = game_mono.game_id)
      LEFT JOIN game_seuck ON (game.game_id = game_seuck.game_id)
      LEFT JOIN game_stos ON (game.game_id = game_stos.game_id)
      LEFT JOIN game_stac ON (game.game_id = game_stac.game_id)
      LEFT JOIN game_wanted ON (game.game_id = game_wanted.game_id)
      LEFT JOIN game_publisher ON (game_publisher.game_id = game.game_id)
      LEFT JOIN pub_dev pd1 ON (pd1.pub_dev_id = game_publisher.pub_dev_id)
      LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)
      LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)
      LEFT JOIN game_release on (game_release.game_id = game.game_id)
    WHERE ";

$RESULTAKA = "SELECT
         game_aka.game_id,
         game_aka.aka_name,
         game_boxscan.game_boxscan_id,
         screenshot_game.screenshot_id,
         game_music.music_id,
         game_download.game_download_id,
         game_falcon_only.falcon_only,
         game_falcon_enhan.falcon_enhanced,
         game_falcon_rgb.falcon_rgb,
         game_falcon_vga.falcon_vga,
         game_ste_enhan.ste_enhanced,
         game_ste_only.ste_only,
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
      LEFT JOIN game_falcon_only ON (game_falcon_only.game_id = game.game_id)
      LEFT JOIN game_falcon_enhan ON (game.game_id = game_falcon_enhan.game_id)
      LEFT JOIN game_falcon_rgb ON (game_falcon_rgb.game_id = game.game_id)
      LEFT JOIN game_falcon_vga ON (game.game_id = game_falcon_vga.game_id)
      LEFT JOIN game_ste_enhan ON (game.game_id = game_ste_enhan.game_id)
      LEFT JOIN game_ste_only ON (game.game_id = game_ste_only.game_id)
      LEFT JOIN game_free ON (game.game_id = game_free.game_id)
      LEFT JOIN game_arcade ON (game.game_id = game_arcade.game_id)
      LEFT JOIN game_development ON (game.game_id = game_development.game_id)
      LEFT JOIN game_unreleased ON (game.game_id = game_unreleased.game_id)
      LEFT JOIN game_unfinished ON (game.game_id = game_unfinished.game_id)
      LEFT JOIN game_mono ON (game.game_id = game_mono.game_id)
      LEFT JOIN game_seuck ON (game.game_id = game_seuck.game_id)
      LEFT JOIN game_stos ON (game.game_id = game_stos.game_id)
      LEFT JOIN game_stac ON (game.game_id = game_stac.game_id)
      LEFT JOIN game_wanted ON (game.game_id = game_wanted.game_id)
      LEFT JOIN game_publisher ON (game.game_id = game_publisher.game_id)
      LEFT JOIN pub_dev pd1 ON (game_publisher.pub_dev_id = pd1.pub_dev_id)
      LEFT JOIN game_developer ON (game.game_id = game_developer.game_id)
      LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)
      LEFT JOIN game_release on (game_release.game_id = game.game_id)
     WHERE ";

     $RESULTGAME .= "game.game_name REGEXP '^[0-9].*'";

     $RESULTGAME .= ' GROUP BY game.game_id, game.game_name HAVING COUNT(DISTINCT game.game_id, game.game_name) = 1';
     $RESULTGAME .= ' ORDER BY game_name ASC';

     $games = $mysqli->query($RESULTGAME);

     $RESULTAKA .= "game_aka.aka_name REGEXP '^[0-9].*'";

     $RESULTAKA .= ' GROUP BY game_aka.game_id, game_aka.aka_name HAVING COUNT(DISTINCT game_aka.game_id, game_aka.aka_name) = 1';
     $RESULTAKA .= ' ORDER BY game_aka.aka_name ASC';

     $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $RESULTGAME") or die(mysqli_error());
     $mysqli->query("INSERT INTO temp $RESULTAKA") or die(mysqli_error());

     $temp_query = $mysqli->query("SELECT * FROM temp ORDER BY game_name ASC") or die("does not compute3");

     $i = 0;

     while ($sql_game_search = $temp_query->fetch_array(MYSQLI_BOTH)) {
         $i++;

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
             //'year_id' => $sql_game_search['year_id'],
             'year' => $sql_game_search['game_release_year'],
             'music' => $sql_game_search['music_id'],
             'boxscan' => $sql_game_search['game_boxscan_id'],
             'download' => $sql_game_search['game_download_id'],
             'screenshot' => $sql_game_search['screenshot_id'],
             'falcon_only' => $sql_game_search['falcon_only'],
             'falcon_enhan' => $sql_game_search['falcon_enhanced'],
             'falcon_rgb' => $sql_game_search['falcon_rgb'],
             'falcon_vga' => $sql_game_search['falcon_vga'],
             'ste_enhanced' => $sql_game_search['ste_enhanced'],
             'ste_only' => $sql_game_search['ste_only']
         ));
     }
     $time_elapsed_secs = microtime(true) - $start;
     $smarty->assign("nr_of_games", $i);
     $smarty->assign("query_time", $time_elapsed_secs);

     $mysqli->query("DROP TABLE temp") or die("does not compute4");

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "games_main.html");

//close the connection
mysqli_close($mysqli);
