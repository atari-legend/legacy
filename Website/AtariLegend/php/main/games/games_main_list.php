<?php
/***************************************************************************
 *                                games_main_list.php
 *                            --------------------------
 *   begin                : Sunday, June 25, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : admin@atarilegend.com
 *
 *   Id: games_main_list.php,v 0.10 2017/06/25 23:19 Gatekeeper
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the game browse page where you can navigate your way through the games db
 ***********************************************************************************
 */

//load all common functions
require "../../config/common.php";

//Load this include to fill the pub and dev field. No need to reinvent the wheel, right? Or is this lazy coding? :-)
require "../../admin/games/quick_search_games.php";

//load the tiles
require "../../common/tiles/latest_comments_tile.php";
require "../../common/tiles/screenstar.php";

require_once __DIR__."/../../common/DAO/GameReleaseDAO.php";
require_once __DIR__."/../../common/Model/Breadcrumb.php" ;

$gameReleaseDao = new \AL\Common\DAO\GameReleaseDAO($mysqli);

// Get all releases years
$smarty->assign('releases_year', $gameReleaseDao->getAllReleasesYears());

date_default_timezone_set('UTC');
$start = microtime(true);

// First create base sql statements
if (empty($game_author)) {
    $RESULTGAME = "SELECT game.game_id,
            game.game_name,
            review_game.review_game_id,
            game_boxscan.game_boxscan_id,
            screenshot_game.screenshot_id,
            game_music.music_id,
            pd2.pub_dev_name as 'developer_name',
            pd2.pub_dev_id as 'developer_id',
            game_genre_cross.game_genre_id,
            game_genre.name
            FROM game
            LEFT JOIN review_game ON (review_game.game_id = game.game_id)
            LEFT JOIN game_boxscan ON (game_boxscan.game_id = game.game_id)
            LEFT JOIN game_genre_cross ON (game_genre_cross.game_id = game.game_id)
            LEFT JOIN game_genre ON (game_genre_cross.game_genre_id = game_genre.id)
            LEFT JOIN screenshot_game ON (screenshot_game.game_id = game.game_id)
            LEFT JOIN game_music ON (game_music.game_id = game.game_id)
            LEFT JOIN game_programming_language ON (game.game_id = game_programming_language.game_id)
            LEFT JOIN game_engine ON (game.game_id = game_engine.game_id)
            LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)
            LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)
            LEFT JOIN game_release on (game_release.game_id = game.game_id)
            LEFT JOIN pub_dev pd1 ON (pd1.pub_dev_id = game_release.pub_dev_id)
        WHERE ";
} else {
    $RESULTGAME = "SELECT game.game_id,
            game.game_name,
            review_game.review_game_id,
            game_boxscan.game_boxscan_id,
            screenshot_game.screenshot_id,
            game_music.music_id,
            pd2.pub_dev_name as 'developer_name',
            pd2.pub_dev_id as 'developer_id',
            game_genre_cross.game_genre_id,
            game_genre.name
            FROM game
            LEFT JOIN game_individual ON (game_individual.game_id = game.game_id)
            LEFT JOIN review_game ON (review_game.game_id = game.game_id)
            LEFT JOIN game_boxscan ON (game_boxscan.game_id = game.game_id)
            LEFT JOIN game_genre_cross ON (game_genre_cross.game_id = game.game_id)
            LEFT JOIN game_genre ON (game_genre_cross.game_genre_id = game_genre.id)
            LEFT JOIN screenshot_game ON (screenshot_game.game_id = game.game_id)
            LEFT JOIN game_music ON (game_music.game_id = game.game_id)
            LEFT JOIN game_programming_language ON (game.game_id = game_programming_language.game_id)
            LEFT JOIN game_engine ON (game.game_id = game_engine.game_id)
            LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)
            LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)
            LEFT JOIN game_release on (game_release.game_id = game.game_id)
            LEFT JOIN pub_dev pd1 ON (pd1.pub_dev_id = game_release.pub_dev_id)
        WHERE ";
}

if (empty($game_author)) {
    $RESULTAKA = "SELECT
             game_aka.game_id,
             game_aka.aka_name,
             review_game.review_game_id,
             game_boxscan.game_boxscan_id,
             screenshot_game.screenshot_id,
             game_music.music_id,
             pd2.pub_dev_name as 'developer_name',
             pd2.pub_dev_id as 'developer_id',
             game_genre_cross.game_genre_id,
             game_genre.name
          FROM game_aka
          LEFT JOIN game ON (game_aka.game_id = game.game_id)
          LEFT JOIN review_game ON (review_game.game_id = game.game_id)
          LEFT JOIN game_genre_cross ON (game_genre_cross.game_id = game.game_id)
          LEFT JOIN game_genre ON (game_genre_cross.game_genre_id = game_genre.id)
          LEFT JOIN game_boxscan ON (game_boxscan.game_id = game_aka.game_id)
          LEFT JOIN screenshot_game ON (screenshot_game.game_id = game.game_id)
          LEFT JOIN game_music ON (game_music.game_id = game.game_id)
          LEFT JOIN game_programming_language ON (game.game_id = game_programming_language.game_id)
          LEFT JOIN game_engine ON (game.game_id = game_engine.game_id)
          LEFT JOIN game_developer ON (game.game_id = game_developer.game_id)
          LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)
          LEFT JOIN game_release on (game_release.game_id = game.game_id)
          LEFT JOIN pub_dev pd1 ON (game_release.pub_dev_id = pd1.pub_dev_id)
         WHERE ";
} else {
    $RESULTAKA = "SELECT
             game_aka.game_id,
             game_aka.aka_name,
             review_game.review_game_id,
             game_boxscan.game_boxscan_id,
             screenshot_game.screenshot_id,
             game_music.music_id,
             pd2.pub_dev_name as 'developer_name',
             pd2.pub_dev_id as 'developer_id',
             game_genre_cross.game_genre_id,
             game_genre.name
          FROM game_aka
          LEFT JOIN game ON (game_aka.game_id = game.game_id)
          LEFT JOIN game_individual ON (game_individual.game_id = game.game_id)
          LEFT JOIN review_game ON (review_game.game_id = game.game_id)
          LEFT JOIN game_genre_cross ON (game_genre_cross.game_id = game.game_id)
          LEFT JOIN game_genre ON (game_genre_cross.game_genre_id = game_genre.id)
          LEFT JOIN game_boxscan ON (game_boxscan.game_id = game_aka.game_id)
          LEFT JOIN screenshot_game ON (screenshot_game.game_id = game.game_id)
          LEFT JOIN game_music ON (game_music.game_id = game.game_id)
          LEFT JOIN game_programming_language ON (game.game_id = game_programming_language.game_id)
          LEFT JOIN game_engine ON (game.game_id = game_engine.game_id)
          LEFT JOIN game_developer ON (game.game_id = game_developer.game_id)
          LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)
          LEFT JOIN game_release on (game_release.game_id = game.game_id)
          LEFT JOIN pub_dev pd1 ON (game_release.pub_dev_id = pd1.pub_dev_id)
         WHERE ";
}

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

    if (isset($publisher_input)) {
        $publisher_input = $mysqli->real_escape_string($publisher_input);
    } else {
        $publisher_input = "";
    }

    if (isset($developer_input)) {
        $developer_input = $mysqli->real_escape_string($developer_input);
    } else {
        $developer_input = "";
    }

    if (isset($year_input)) {
        $year_input = $mysqli->real_escape_string($year_input);
    } else {
        $year_input = "";
    }

    if (isset($cat_input)) {
        $cat_input = $mysqli->real_escape_string($cat_input);
    } else {
        $cat_input = "";
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

    //check the year select
    if (empty($year) or $year == '-') {
        $year_select = "";
    } elseif ($year == "null") {
        $year_select = " AND game_release.date IS NULL";
    } else {
        $year_select = " AND YEAR(game_release.date) = $year";
    }

    //check the game_author select
    if (empty($game_author)) {
        $game_author_select = "";
    } else {
        $game_author_select = " AND game_individual.individual_id = '$game_author'";
    }

    //check the category select
    if (empty($category) or $category == '-') {
        $category_select = "";
    } elseif ($category == "null") {
        $category_select = " AND game_genre_cross.game_genre_id IS NULL";
    } else {
        $category_select = " AND game_genre_cross.game_genre_id = $category";
    }

    //
    // Here comes a bunch of tickbox checks.
    //

    //if (isset($download) and $download == "1") {
    //    $download_select = " AND game_download.download_id IS NOT NULL";
    //}

    //This is just too slow in combination with the advanced options
    //if (isset($screenshot) and $screenshot == "1") {
    //    $screenshot_select = " AND screenshot_game.screenshot_id IS NOT NULL";
    //}

    //if (isset($boxscan) and $boxscan == "1") {
    //    $boxscan_select = " AND game_boxscan.game_boxscan_id IS NOT NULL";
    //}

    if (isset($review) and $review == "1") {
        $review_select = " AND review_game.review_id IS NOT NULL";
    }

    if (isset($arcade) and $arcade == "1") {
        $arcade_select = " AND game.port_id ='1'";
        $smarty->assign('games_arcade', '1');
    }

    if (isset($development) and $development == "1") {
        $development_select = " AND game_release.status = 'Development'";
        $smarty->assign('games_development', '1');
    }

    if (isset($unreleased) and $unreleased == "1") {
        $unreleased_select = " AND game_release.status = 'Unreleased'";
    }

    if (isset($stos) and $stos == "1") {
        $stos_select = " AND game_programming_language.programming_language_id = 1";
    }

    if (isset($unfinished) and $unfinished == "1") {
        $unfinished_select = " AND game_release.status = 'Unfinished'";
    }

    if (isset($seuck) and $seuck == "1") {
        $seuck_select = " AND game_engine.engine_id ='1'";
    }

    if (isset($stac) and $stac == "1") {
        $stac_select = " AND game_engine.engine_id ='2'";
    }

    //Before we start the build the query, we check if there is at least
    //one search field filled in or used!

    if ($publisher_select == "" and $gamebrowse_select == "" and $publisher_input == "" and $developer_input == ""
        and $year_input == "" and $cat_input == "" and $gamesearch == "" and $developer_select == ""
        and $year_select == "" and $category_select == "" and empty($game_author_select)
        and empty($unreleased_select) and empty($development_select) and empty($arcade_select) and empty($stos_select)
        and empty($unfinished_select) and empty($seuck_select) and empty($stac_select) and empty($screenshot)
        and empty($download) and empty($boxscan) and empty($review_select)
    ) {
        $edit_message             = "Please fill in one of the fields";
        $_SESSION['edit_message'] = $edit_message;

        if (isset($mode)) {
            header("Location: ../games/games_main.php?mode=$mode");
        } else {
            header("Location: ../games/games_main.php");
        }
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

        if (!empty($publisher_input)) {
            $RESULTGAME .= " AND pd1.pub_dev_name LIKE '%$publisher_input%'";
        } else {
            //    $RESULTGAME .= " AND pd1.pub_dev_name LIKE '%'";
        }

        if (!empty($developer_input)) {
            $RESULTGAME .= " AND pd2.pub_dev_name LIKE '%$developer_input%'";
        } else {
            //   $RESULTGAME .= " AND pd2.pub_dev_name LIKE '%'";
        }

        if (!empty($year_input)) {
            $RESULTGAME .= " AND YEAR(game_release.date) = $year_input";
        } else {
            //   $RESULTGAME .= " AND game_year.game_year LIKE '%'";
        }

        if (!empty($cat_input)) {
            $RESULTGAME .= " AND game_genre.name LIKE '%$cat_input%'";
        } else {
        }

        $RESULTGAME .= $gamebrowse_select;
        $RESULTGAME .= $publisher_select;
        $RESULTGAME .= $developer_select;

        //if (isset($download) and $download == "1") {
        //    $RESULTGAME .= $download_select;
        //}
        //if (isset($screenshot) and $screenshot == "1") {
        //    $RESULTGAME .= $screenshot_select;
        //}
        //if (isset($boxscan) and $boxscan == "1") {
        //    $RESULTGAME .= $boxscan_select;
        //}

        if (isset($review) and $review == "1") {
            $RESULTGAME .= $review_select;
        }
        if (isset($year_select)) {
            $RESULTGAME .= $year_select;
        }
        if (isset($category_select)) {
            $RESULTGAME .= $category_select;
        }
        if (isset($game_author_select)) {
            $RESULTGAME .= $game_author_select;
        }
        if (isset($arcade) and $arcade == "1") {
            $RESULTGAME .= $arcade_select;
        }
        if (isset($development) and $development == "1") {
            $RESULTGAME .= $development_select;
        }
        if (isset($unreleased) and $unreleased == "1") {
            $RESULTGAME .= " AND game_release.status = 'Unreleased'";
        }
        if (isset($unfinished) and $unfinished == "1") {
            $RESULTGAME .= " AND game_release.status = 'Unfinished'";
        }
        if (isset($seuck) and $seuck == "1") {
            $RESULTGAME .= " AND game_engine.engine_id ='1'";
        }
        if (isset($stos) and $stos == "1") {
            $RESULTGAME .= " AND game_programming_language.programming_language_id = 1";
        }
        if (isset($stac) and $stac == "1") {
            $RESULTGAME .= " AND game_engine.engine_id ='2'";
        }

        $RESULTGAME .= ' GROUP BY game.game_id, game.game_name HAVING COUNT(DISTINCT game.game_id, game.game_name) = 1';
        $RESULTGAME .= ' ORDER BY game_name ASC';

        $games = $mysqli->query($RESULTGAME) or die("Error retrieving games:".$mysqli->error);

        if (empty($games)) {
            $edit_message             = "There are problems with the game search, please try again";
            $_SESSION['edit_message'] = $edit_message;
            $smarty->assign("message", $edit_message);

            header("Location: ../games/games_main.php");
        } else {
            $rows = $games->num_rows;

            //check for aka name
            if (!empty($gamesearch)) {
                $game_aka_name_query = "SELECT aka_name FROM game_aka WHERE aka_name LIKE '%$gamesearch%'";
                $game_aka_name_sql = $mysqli->query($game_aka_name_query);
                $rows2 = $game_aka_name_sql->num_rows;
            } else {
                $rows2 = 0;
            }

            if ($rows > 0 or $rows2 > 0) {
                if (!empty($gamesearch)) {
                    $RESULTAKA .= "game_aka.aka_name LIKE '%$gamesearch%'";
                } else {
                    $RESULTAKA .= "game_aka.aka_name LIKE '%'";
                }
                if (!empty($publisher_input)) {
                    $RESULTAKA .= " AND pd1.pub_dev_name LIKE '%$publisher_input%'";
                } else {
                    //    $RESULTAKA .= " AND pd1.pub_dev_name LIKE '%'";
                }

                if (!empty($developer_input)) {
                    $RESULTAKA .= " AND pd2.pub_dev_name LIKE '%$developer_input%'";
                } else {
                    //    $RESULTAKA .= " AND pd2.pub_dev_name LIKE '%'";
                }

                if (!empty($year_input)) {
                    $RESULTAKA .= " AND YEAR(game_release.date) = $year_input";
                } else {
                    //   $RESULTAKA .= " AND game_year.game_year LIKE '%'";
                }

                if (!empty($cat_input)) {
                    $RESULTAKA .= " AND game_genre.name LIKE '%$cat_input%'";
                } else {
                    //    $RESULTAKA .= " AND game_genre.game_genre_name LIKE '%'";
                }

                $RESULTAKA .= $akabrowse_select;
                $RESULTAKA .= $publisher_select;
                $RESULTAKA .= $developer_select;

                //if (isset($download) and $download == "1") {
                //    $RESULTAKA .= $download_select;
                //}
                //if (isset($screenshot) and $screenshot == "1") {
                //    $RESULTAKA .= $screenshot_select;
                //}
                //if (isset($boxscan) and $boxscan == "1") {
                //    $RESULTAKA .= $boxscan_select;
                //}
                if (isset($review) and $review == "1") {
                    $RESULTAKA .= $review_select;
                }
                if (isset($year_select)) {
                    $RESULTAKA .= $year_select;
                }
                if (isset($game_author_select)) {
                    $RESULTAKA .= $game_author_select;
                }
                if (isset($category_select)) {
                    $RESULTAKA .= $category_select;
                }
                if (isset($arcade) and $arcade == "1") {
                    $RESULTAKA .= $arcade_select;
                }
                if (isset($development) and $development == "1") {
                    $RESULTAKA .= $development_select;
                }
                if (isset($unreleased) and $unreleased == "1") {
                    $RESULTAKA .= " AND game_release.status = 'Unreleased'";
                }
                if (isset($unfinished) and $unfinished == "1") {
                    $RESULTAKA .= " AND game_release.status = 'Unfinished'";
                }
                if (isset($seuck) and $seuck == "1") {
                    $RESULTAKA .= " AND game_engine.engine_id ='1'";
                }
                if (isset($stos) and $stos == "1") {
                    $RESULTAKA .= " AND game_programming_language.programming_language_id = 1";
                }
                if (isset($stac) and $stac == "1") {
                    $RESULTAKA .= " AND game_engine.engine_id ='2'";
                }
                $RESULTAKA .= ' GROUP BY game_aka.game_id, game_aka.aka_name';
                $RESULTAKA .= ' HAVING COUNT(DISTINCT game_aka.game_id, game_aka.aka_name) = 1';
                $RESULTAKA .= ' ORDER BY game_aka.aka_name ASC';

                $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $RESULTGAME") or die(mysqli_error());
                $mysqli->query("INSERT INTO temp $RESULTAKA") or die(mysqli_error());

                $temp_query = $mysqli->query("SELECT * FROM temp ORDER BY game_name ASC") or die("does not compute3");

                $i = 0;

                while ($sql_game_search = $temp_query->fetch_array(MYSQLI_BOTH)) {
                    $screenshot_image = '';
                    $screenshot_id = '';

                    //do this for when we only have 1 game result
                    $game_id_1_result = $sql_game_search['game_id'];

                    $game_name = $sql_game_search['game_name'];
                    $dev_name = $sql_game_search['developer_name'];

                    if ($sql_game_search['game_boxscan_id'] != '') {
                        $box = "1";
                    } else {
                        $box = "0";
                    }
                    if ($sql_game_search['screenshot_id'] != '') {
                        $screen = "1";
                    } else {
                        $screen = "0";
                    }
                    if ($sql_game_search['music_id'] != '') {
                        $music = "1";
                    } else {
                        $music = "0";
                    }

                    if ($dev_name == '') {
                        $dev_name = 'n/a';
                    }

                    $ignore = 0;

                    if (isset($screenshot) and $screenshot == "1") {
                        if ($screen == "0") {
                            $ignore = 1;
                        }
                    }

                    if (isset($boxscan) and $boxscan == "1") {
                        if ($box == "0") {
                            $ignore = 1;
                        }
                    }

                    if ($ignore == 0) {
                        $i++;

                        if (isset($export) and $export == "1") {
                            // this is the array used in export mode
                            $list_data = array(
                                'id'=>$i,
                                'game_id'=>$sql_game_search['game_id'],
                                'game_name'=>$game_name,
                                'developer_id' => $sql_game_search['developer_id'],
                                'developer_name' => $dev_name,
                                'music' => $music,
                                'boxscan' => $box,
                                'screenshot' => $screen);

                            $data[] = $list_data;
                        } else {
                            if (isset($boxscan) and $boxscan == "1") {
                                //Select a random boxscan record
                                $sql_screenshots = $mysqli->query(
                                    "
                                SELECT *
                                FROM game_boxscan
                                WHERE game_id='$sql_game_search[game_id]' and game_boxscan_side = '0'
                                ORDER BY RAND() LIMIT 1"
                                )
                                or die("Database error - selecting screenshots");

                                while ($screenshot_result =  $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
                                    //Ready screenshots path and filename
                                    $screenshot_image = $game_boxscan_path;
                                    $screenshot_image .= $screenshot_result['game_boxscan_id'];
                                    $screenshot_image .= '.';
                                    $screenshot_image .= $screenshot_result['imgext'];
                                    $screenshot_id = $screenshot_result['game_boxscan_id'];
                                }
                            } else {
                                //Select a random screenshot record
                                $sql_screenshots = $mysqli->query(
                                    "SELECT *
                                    FROM screenshot_game
                                    LEFT JOIN screenshot_main
                                    ON (screenshot_game.screenshot_id = screenshot_main.screenshot_id)
                                    WHERE screenshot_game.game_id = '$sql_game_search[game_id]'
                                    ORDER BY RAND() LIMIT 1"
                                ) or die("Database error - selecting screenshots");

                                while ($screenshot_result =  $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
                                    //Ready screenshots path and filename
                                    $screenshot_image = $game_screenshot_path;
                                    $screenshot_image .= $screenshot_result['screenshot_id'];
                                    $screenshot_image .= '.';
                                    $screenshot_image .= $screenshot_result['imgext'];
                                    $screenshot_id = $screenshot_result['screenshot_id'];
                                }
                            }

                            $smarty->append(
                                'game_search', array(
                                'game_id' => $sql_game_search['game_id'],
                                'game_name' => $game_name,
                                'developer_id' => $sql_game_search['developer_id'],
                                'developer_name' => $dev_name,
                                'music' => $sql_game_search['music_id'],
                                'boxscan' => $sql_game_search['game_boxscan_id'],
                                'review' => $sql_game_search['review_game_id'],
                                'path' => $game_screenshot_path,
                                'screenshot_image' => $screenshot_image,
                                'screenshot_id' => $screenshot_id,
                                )
                            );
                        }
                    }
                }

                $mysqli->query("DROP TABLE temp") or die("does not compute4");

                //return JSON formatted data
                if (isset($data)) {
                    $smarty->assign('data', json_encode($data));
                    $smarty->assign('export', 'export');
                }

                if ($i == 0) {
                    $edit_message             = "No entries found for your selection";
                    $_SESSION['edit_message'] = $edit_message;
                    $smarty->assign("message", $edit_message);

                    if (isset($mode)) {
                        header("Location: ../games/games_main.php?mode=$mode");
                    } else {
                        header("Location: ../games/games_main.php");
                    }
                } else {
                    $time_elapsed_secs = microtime(true) - $start;
                    $smarty->assign("nr_of_games", $i);

                    //if we have only 1 search result, go to the detail page at once!
                    if ($i == 1) {
                        header("Location: ../games/games_detail.php?game_id=$game_id_1_result");
                    }

                    $rest4 = $i%4;
                    $smarty->assign("rest4", $rest4);

                    $rest3 = $i%3;
                    $smarty->assign("rest3", $rest3);

                    $rest2 = $i%2;
                    $smarty->assign("rest2", $rest2);

                    $smarty->assign("query_time", $time_elapsed_secs);

                    $smarty->assign(
                        'breadcrumb',
                        array(
                            new AL\Common\Model\Breadcrumb("/games/games_main_list.php", "Games List")
                        )
                    );

                    //Send all smarty variables to the templates
                    $smarty->display("file:" . $mainsite_template_folder . "games_main_list.html");
                }
            } else {
                $edit_message             = "No entries found for your selection";
                $_SESSION['edit_message'] = $edit_message;
                $smarty->assign("message", $edit_message);

                if (isset($mode)) {
                    header("Location: ../games/games_main.php?mode=$mode");
                } else {
                    header("Location: ../games/games_main.php");
                }
            }
        }
    }
}
