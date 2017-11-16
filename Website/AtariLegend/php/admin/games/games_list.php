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
include("../../admin/games/quick_search_games.php");
include("../../config/admin.php");

date_default_timezone_set('UTC');
$start = microtime(true);

$game_attributes_select = "";
$game_attributes_join   = "";

$game_attributes_hardware_select = "";
$game_attributes_hardware_join   = "";

if (isset($attributes)) {
    foreach ($attributes as $attributes_key => $attributes_value) {
        $game_attributes_join .= " LEFT JOIN game_attributes AS ga$attributes_key ON (ga$attributes_key.game_id = game.game_id)
        LEFT JOIN attribute_type AS at$attributes_key ON (at$attributes_key.attribute_type_id = ga$attributes_key.attribute_type_id)";
        $game_attributes_select .= " AND ga$attributes_key.attribute_type_id = $attributes_value";
    }
}
if (isset($attributes_hardware)) {
    foreach ($attributes_hardware as $attributes_key => $attributes_value) {
        $game_attributes_join .= " LEFT JOIN game_attributes_hardware AS gah$attributes_key ON (gah$attributes_key.game_id = game.game_id)
        LEFT JOIN attribute_hardware_type AS aht$attributes_key ON (aht$attributes_key.attribute_hardware_type_id = gah$attributes_key.attribute_hardware_type_id)";
        $game_attributes_select .= " AND gah$attributes_key.attribute_hardware_type_id = $attributes_value";
    }
}

// First create base sql statements

$RESULTGAME = "SELECT
    game.game_id,
    game.game_name,
    game_boxscan.game_boxscan_id,
    screenshot_game.screenshot_id,
    game_music.music_id,
    game_download.game_download_id,
    pd1.pub_dev_name as 'publisher_name',
    pd1.pub_dev_id as 'publisher_id',
    pd2.pub_dev_name as 'developer_name',
    pd2.pub_dev_id as 'developer_id',
    game_year.game_year
FROM game";
$RESULTGAME .= $game_attributes_join;
$RESULTGAME .= $game_attributes_hardware_join;
$RESULTGAME .= "
LEFT JOIN game_boxscan ON (game_boxscan.game_id = game.game_id)
LEFT JOIN screenshot_game ON (screenshot_game.game_id = game.game_id)
LEFT JOIN game_music ON (game_music.game_id = game.game_id)
LEFT JOIN game_download ON (game_download.game_id = game.game_id)
LEFT JOIN game_publisher ON (game_publisher.game_id = game.game_id)
LEFT JOIN pub_dev pd1 ON (pd1.pub_dev_id = game_publisher.pub_dev_id)
LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)
LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)
LEFT JOIN game_year on (game_year.game_id = game.game_id)
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
    game_year.game_year
      FROM game_aka
      LEFT JOIN game ON (game_aka.game_id = game.game_id)";
$RESULTAKA .= $game_attributes_join;
$RESULTAKA .= $game_attributes_hardware_join;
$RESULTAKA .= "
      LEFT JOIN game_boxscan ON (game_boxscan.game_id = game_aka.game_id)
      LEFT JOIN screenshot_game ON (screenshot_game.game_id = game.game_id)
      LEFT JOIN game_music ON (game_music.game_id = game.game_id)
      LEFT JOIN game_download ON (game_download.game_id = game.game_id)
      LEFT JOIN game_publisher ON (game.game_id = game_publisher.game_id)
      LEFT JOIN pub_dev pd1 ON (game_publisher.pub_dev_id = pd1.pub_dev_id)
      LEFT JOIN game_developer ON (game.game_id = game_developer.game_id)
      LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)
      LEFT JOIN game_year on (game_year.game_id = game.game_id)
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
    } elseif ($publisher == "null") {
        $publisher_select = " AND pd1.pub_dev_id IS NULL";
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
    if (isset($year)) {
        $year_select = " AND game_year.game_year LIKE '$year%'";
    }


    //Before we start the build the query, we check if there is at least
    //one search field filled in or used!

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
    } else {
        $RESULTGAME .= "game.game_name LIKE '%'";
    }
    $RESULTGAME .= $gamebrowse_select;
    $RESULTGAME .= $publisher_select;
    $RESULTGAME .= $developer_select;
    if (isset($year_select)) {
        $RESULTGAME .= $year_select;
    }

    if (isset($game_attributes_select)) {
        $RESULTGAME .= $game_attributes_select;
    }
    if (isset($game_attributes_hardware_select)) {
        $RESULTGAME .= $game_attributes_hardware_select;
    }

    if (isset($wanted) and $wanted == "1") {
        $RESULTGAME .= " AND game_wanted.game_id IS NOT NULL";
    }

    $RESULTGAME .= ' GROUP BY game.game_id, game.game_name HAVING COUNT(DISTINCT game.game_id, game.game_name) = 1';
    $RESULTGAME .= ' ORDER BY game_name ASC';

    $games = $mysqli->query($RESULTGAME);


    if (empty($games)) {
        $edit_message             = "There are problems with the game search, please try again";
        $_SESSION['edit_message'] = $edit_message;
        $smarty->assign("message", $edit_message);

        header("Location: ../games/games_main.php");
    } else {
        $rows = $games->num_rows;
        if ($rows > 0) {
            if (!empty($gamesearch)) {
                $RESULTAKA .= "game_aka.aka_name LIKE '%$gamesearch%'";
            } else {
                $RESULTAKA .= "game_aka.aka_name LIKE '%'";
            }
            $RESULTAKA .= $akabrowse_select;
            $RESULTAKA .= $publisher_select;
            $RESULTAKA .= $developer_select;
            if (isset($year_select)) {
                $RESULTAKA .= $year_select;
            }
            if (isset($game_attributes_select)) {
                $RESULTAKA .= $game_attributes_select;
            }
            if (isset($game_attributes_hardware_select)) {
                $RESULTAKA .= $game_attributes_hardware_select;
            }
            if (isset($wanted) and $wanted == "1") {
                $RESULTAKA .= " AND game_wanted.game_id IS NOT NULL";
            }
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
                    'year' => $sql_game_search['game_year'],
                    'music' => $sql_game_search['music_id'],
                    'boxscan' => $sql_game_search['game_boxscan_id'],
                    'download' => $sql_game_search['game_download_id'],
                    'screenshot' => $sql_game_search['screenshot_id']
                ));
            }
            $time_elapsed_secs = microtime(true) - $start;
            $smarty->assign("nr_of_games", $i);
            $smarty->assign("query_time", $time_elapsed_secs);

            $mysqli->query("DROP TABLE temp") or die("does not compute4");

            //Get the companies to fill the search fields
            //Get publisher values to fill the searchfield
            $sql_publisher = $mysqli->query("SELECT pub_dev.pub_dev_id,
              pub_dev.pub_dev_name
              FROM game_publisher
              LEFT JOIN pub_dev ON (game_publisher.pub_dev_id = pub_dev.pub_dev_id)
              GROUP BY pub_dev.pub_dev_id HAVING COUNT(DISTINCT pub_dev.pub_dev_id) = 1
              ORDER BY pub_dev.pub_dev_name ASC") or die("Problems retriving values from publishers.") or die("error publisher");

            while ($company_publisher = $sql_publisher->fetch_array(MYSQLI_BOTH)) {
                $smarty->append('company_publisher', array(
                    'comp_id' => $company_publisher['pub_dev_id'],
                    'comp_name' => $company_publisher['pub_dev_name']
                ));
            }

            //Get Developer values to fill the searchfield
            $sql_developer = $mysqli->query("SELECT pub_dev.pub_dev_id,
              pub_dev.pub_dev_name
              FROM game_developer
              LEFT JOIN pub_dev ON (game_developer.dev_pub_id = pub_dev.pub_dev_id)
              GROUP BY pub_dev.pub_dev_id HAVING COUNT(DISTINCT pub_dev.pub_dev_id) = 1
              ORDER BY pub_dev.pub_dev_name ASC") or die("Problems retriving values from developers.");

            while ($company_developer = $sql_developer->fetch_array(MYSQLI_BOTH)) {
                $smarty->append('company_developer', array(
                    'comp_id' => $company_developer['pub_dev_id'],
                    'comp_name' => $company_developer['pub_dev_name']
                ));
            }
            $smarty->assign("user_id", $_SESSION['user_id']);

            //Send all smarty variables to the templates
            $smarty->display("file:" . $cpanel_template_folder . "games_list.html");
        } else {
            $edit_message             = "No entries found for your selection";
            $_SESSION['edit_message'] = $edit_message;
            $smarty->assign("message", $edit_message);

            header("Location: ../games/games_main.php");
        }
    }
}
