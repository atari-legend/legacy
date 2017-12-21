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
        game_year.game_year
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
      LEFT JOIN game_year on (game_year.game_id = game.game_id)
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
         game_year.game_year
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

    //
    // Here comes a bunch of tickbox checks.
    //

    if (isset($falcon_only) and $falcon_only == "1") {
        $falcon_only_select = " AND game_falcon_only.falcon_only =$falcon_only";
        $smarty->assign('games_falcon_only', '1');
    }

    if (isset($falcon_enhanced) and $falcon_enhanced == "1") {
        $falcon_enhanced_select = " AND game_falcon_enhan.falcon_enhanced =$falcon_enhanced";
        $smarty->assign('games_falcon_enhanced', '1');
    }

    if (isset($falcon_rgb) and $falcon_rgb == "1") {
        $falcon_rgb_select = " AND game_falcon_rgb.falcon_rgb =$falcon_rgb";
        $smarty->assign('games_falcon_rgb', '1');
    }

    if (isset($falcon_vga) and $falcon_vga == "1") {
        $falcon_vga_select = " AND game_falcon_vga.falcon_vga =$falcon_vga";
        $smarty->assign('games_falcon_vga', '1');
    }

    if (isset($ste_only) and $ste_only == "1") {
        $ste_only_select = " AND game_ste_only.ste_only =$ste_only";
        $smarty->assign('games_ste_only', '1');
    }

    if (isset($ste_enhanced) and $ste_enhanced == "1") {
        $ste_enhanced_select = " AND game_ste_enhan.ste_enhanced =$ste_enhanced";
        $smarty->assign('games_ste_enhanced', '1');
    }

    if (isset($free) and $free == "1") {
        $free_select = " AND game_free.free =$free";
        $smarty->assign('games_free', '1');
    }

    if (isset($arcade) and $arcade == "1") {
        $arcade_select = " AND game_arcade.arcade =$arcade";
        $smarty->assign('games_arcade', '1');
    }

    if (isset($development) and $development == "1") {
        $development_select = " AND game_development.development =$development";
        $smarty->assign('games_development', '1');
    }

    if (isset($unreleased) and $unreleased == "1") {
        $unreleased_select = " AND game_unreleased.unreleased =$unreleased";
    }

    if (isset($wanted) and $wanted == "1") {
        $wanted_select = " AND game_wanted.wanted =$wanted";
    }

    if (isset($monochrome) and $monochrome == "1") {
        $monochrome_select = " AND game_monochrome.monochrome =$monochrome";
    }

    if (isset($stos) and $stos == "1") {
        $stos_select = " AND game_stos.stos =$stos";
    }

    if (isset($unfinished) and $unfinished == "1") {
        $unfinished_select = " AND game_unfinished.unfinished =$unfinished";
    }

    if (isset($seuck) and $seuck == "1") {
        $seuck_select = " AND game_seuck.seuck =$seuck";
    }

    if (isset($stac) and $stac == "1") {
        $stac_select = " AND game_stac.stac =$stac";
    }

    //Before we start the build the query, we check if there is at least
    //one search field filled in or used!

    if ($publisher_select == "" and $gamebrowse_select == "" and $gamesearch == "" and $developer_select == "" and empty($year_select) and empty($falcon_only_select) and empty($falcon_enhanced_select) and empty($falcon_rgb_select) and empty($falcon_vga_select) and empty($ste_only_select) and empty($ste_enhanced_select) and empty($unreleased_select) and empty($development_select) and empty($arcade_select) and empty($wanted_select) and empty($monochrome_select) and empty($stos_select) and empty($unfinished_select) and empty($seuck_select) and empty($stac_select)) {
        $edit_message             = "Please fill in one of the fields";
        $_SESSION['edit_message'] = $edit_message;

        header("Location: ../games/games_main.php");
    } else {
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
        if (isset($falcon_only) and $falcon_only == "1") {
            $RESULTGAME .= $falcon_only_select;
        }
        if (isset($falcon_enhanced) and $falcon_enhanced == "1") {
            $RESULTGAME .= $falcon_enhanced_select;
        }
        if (isset($falcon_rgb) and $falcon_rgb == "1") {
            $RESULTGAME .= $falcon_rgb_select;
        }
        if (isset($falcon_vga) and $falcon_vga == "1") {
            $RESULTGAME .= $falcon_vga_select;
        }
        if (isset($ste_only) and $ste_only == "1") {
            $RESULTGAME .= $ste_only_select;
        }
        if (isset($ste_enhanced) and $ste_enhanced == "1") {
            $RESULTGAME .= $ste_enhanced_select;
        }
        if (isset($free) and $free == "1") {
            $RESULTGAME .= $free_select;
        }
        if (isset($arcade) and $arcade == "1") {
            $RESULTGAME .= $arcade_select;
        }
        if (isset($development) and $development == "1") {
            $RESULTGAME .= $development_select;
        }
        if (isset($unreleased) and $unreleased == "1") {
            $RESULTGAME .= " AND game_unreleased.unreleased =$unreleased";
        }
        if (isset($unfinished) and $unfinished == "1") {
            $RESULTGAME .= " AND game_unfinished.unfinished =$unfinished";
        }
        if (isset($monochrome) and $monochrome == "1") {
            $RESULTGAME .= " AND game_mono.monochrome =$monochrome";
        }
        if (isset($seuck) and $seuck == "1") {
            $RESULTGAME .= " AND game_seuck.seuck = $seuck";
        }
        if (isset($stos) and $stos == "1") {
            $RESULTGAME .= " AND game_stos.stos = $stos";
        }
        if (isset($stac) and $stac == "1") {
            $RESULTGAME .= " AND game_stac.stac = $stac";
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
                if (isset($falcon_only) and $falcon_only == "1") {
                    $RESULTAKA .= $falcon_only_select;
                }
                if (isset($falcon_enhanced) and $falcon_enhanced == "1") {
                    $RESULTAKA .= $falcon_enhanced_select;
                }
                if (isset($falcon_rgb) and $falcon_rgb == "1") {
                    $RESULTAKA .= $falcon_rgb_select;
                }
                if (isset($falcon_vga) and $falcon_vga == "1") {
                    $RESULTAKA .= $falcon_vga_select;
                }
                if (isset($ste_only) and $ste_only == "1") {
                    $RESULTAKA .= $ste_only_select;
                }
                if (isset($ste_enhanced) and $ste_enhanced == "1") {
                    $RESULTAKA .= $ste_enhanced_select;
                }
                if (isset($free) and $free == "1") {
                    $RESULTAKA .= $free_select;
                }
                if (isset($arcade) and $arcade == "1") {
                    $RESULTAKA .= $arcade_select;
                }
                if (isset($development) and $development == "1") {
                    $RESULTAKA .= $development_select;
                }
                if (isset($unreleased) and $unreleased == "1") {
                    $RESULTAKA .= " AND game_unreleased.unreleased =$unreleased";
                }
                if (isset($unfinished) and $unfinished == "1") {
                    $RESULTAKA .= " AND game_unfinished.unfinished =$unfinished";
                }
                if (isset($monochrome) and $monochrome == "1") {
                    $RESULTAKA .= " AND game_mono.monochrome =$monochrome";
                }
                if (isset($seuck) and $seuck == "1") {
                    $RESULTAKA .= " AND game_seuck.seuck = $seuck";
                }
                if (isset($stos) and $stos == "1") {
                    $RESULTAKA .= " AND game_stos.stos = $stos";
                }
                if (isset($stac) and $stac == "1") {
                    $RESULTAKA .= " AND game_stac.stac = $stac";
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
}
