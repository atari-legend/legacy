<?php
/***************************************************************************
 *                                games_main_list.php
 *                            --------------------------
 *   begin                : Sunday, June 25, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : admin@atarilegend.com
 *
 *   Id: games_main_list.php,v 0.10 2017/06/25 23:19 Gatekeeper
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the game browse page where you can navigate your way through the games db
 ***********************************************************************************
 */

//load all common functions
include("../../config/common.php");

//Load this include to fill the pub and dev field. No need to reinvent the wheel, right? Or is this lazy coding? :-)
include("../../admin/games/quick_search_games.php");

//load the tiles
include("../../common/tiles/latest_comments_tile.php");
include("../../common/tiles/changes_per_month_tile.php");

// get the game_years from the game_year table
$sql_year = $mysqli->query("SELECT distinct game_year from game_year order by game_year") 
                     or die ("problems getting data from game_year table");

while ($game_year = $sql_year->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('game_year', array(
            'game_year' => $game_year['game_year']));
}

date_default_timezone_set('UTC');
$start = microtime(true);

// First create base sql statements
$RESULTGAME = "SELECT game.game_id,
        game.game_name,
        review_game.review_game_id,
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
        game_year.game_year,
        game_cat_cross.game_cat_id,
        game_cat.game_cat_name
        FROM game
        LEFT JOIN review_game ON (review_game.game_id = game.game_id)
        LEFT JOIN game_boxscan ON (game_boxscan.game_id = game.game_id)
        LEFT JOIN game_cat_cross ON (game_cat_cross.game_id = game.game_id)
        LEFT JOIN game_cat ON (game_cat_cross.game_cat_id = game_cat.game_cat_id)
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
         review_game.review_game_id,
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
         game_year.game_year,
         game_cat_cross.game_cat_id,
         game_cat.game_cat_name
      FROM game_aka
      LEFT JOIN game ON (game_aka.game_id = game.game_id)
      LEFT JOIN review_game ON (review_game.game_id = game.game_id)
      LEFT JOIN game_cat_cross ON (game_cat_cross.game_id = game.game_id)
      LEFT JOIN game_cat ON (game_cat_cross.game_cat_id = game_cat.game_cat_id)
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

    //check the year select
    if (empty($year) or $year == '-') {
        $year_select = "";
    } elseif ($year == "null") {
        $year_select = " AND game_year.game_year IS NULL";
    } else {
        $year_select = " AND game_year.game_year LIKE '$year'";
    }
    
    //check the category select
    if (empty($category) or $category == '-') {
        $category_select = "";
    } elseif ($category == "null") {
        $category_select = " AND game_cat_cross.game_cat_id IS NULL";
    } else {
        $category_select = " AND game_cat_cross.game_cat_id = $category";
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

    if ($publisher_select == "" and $gamebrowse_select == "" and $publisher_input == "" and $developer_input == "" and $year_input == "" and $cat_input == "" and $gamesearch == "" and $developer_select == "" and $year_select == "" and $category_select == "" and empty($falcon_only_select) 
        and empty($falcon_enhanced_select) and empty($falcon_rgb_select) and empty($falcon_vga_select) and empty($ste_only_select) and empty($ste_enhanced_select) 
        and empty($unreleased_select) and empty($development_select) and empty($arcade_select) and empty($wanted_select) and empty($monochrome_select) and empty($stos_select) 
        and empty($unfinished_select) and empty($seuck_select) and empty($stac_select) and empty($screenshot) and empty($download) and empty($boxscan) and empty($review_select)) {
        $edit_message             = "Please fill in one of the fields";
        $_SESSION['edit_message'] = $edit_message;

        header("Location: ../games/games_main.php?mode=$mode");
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
            $RESULTGAME .= " AND game_year.game_year LIKE '%$year_input%'";
        } else {
         //   $RESULTGAME .= " AND game_year.game_year LIKE '%'";
        }
        
        if (!empty($cat_input)) {
            $RESULTGAME .= " AND game_cat.game_cat_name LIKE '%$cat_input%'";
        } else {
         //   $RESULTGAME .= " AND game_cat.game_cat_name LIKE '%'";
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
                if (!empty($publisher_input)) {
                    $RESULTAKA .= " AND pd1.pub_dev_name LIKE '%$publisher_input%'";
                } else {
                    $RESULTAKA .= " AND pd1.pub_dev_name LIKE '%'";
                }
                
                if (!empty($developer_input)) {
                    $RESULTAKA .= " AND pd2.pub_dev_name LIKE '%$developer_input%'";
                } else {
                    $RESULTAKA .= " AND pd2.pub_dev_name LIKE '%'";
                }
                
                if (!empty($year_input)) {
                    $RESULTAKA .= " AND game_year.game_year LIKE '%$year_input%'";
                } else {
                    $RESULTAKA .= " AND game_year.game_year LIKE '%'";
                }
                
                if (!empty($cat_input)) {
                    $RESULTAKA .= " AND game_cat.game_cat_name LIKE '%$cat_input%'";
                } else {
                    $RESULTAKA .= " AND game_cat.game_cat_name LIKE '%'";
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
                if (isset($category_select)) {
                    $RESULTAKA .= $category_select;
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

                while ($sql_game_search = $temp_query->fetch_array(MYSQLI_BOTH)) 
                {       
                    $screenshot_image = '';
                    $screenshot_id = '';
                    
                    $game_name = $sql_game_search['game_name'];
                    $pub_name = $sql_game_search['publisher_name'];
                    $dev_name = $sql_game_search['developer_name'];
                    
                    if ($sql_game_search['game_boxscan_id'] != '') {$box = "1";}else{$box = "0";}    
                    if ($sql_game_search['game_download_id'] != '') {$down = "1";}else{$down = "0";}    
                    if ($sql_game_search['screenshot_id'] != '') {$screen = "1";}else{$screen = "0";}  
                    if ($sql_game_search['music_id'] != '') {$music = "1";}else{$music = "0";}  

                    if ( $dev_name == '' ){$dev_name = 'n/a';}   
                    if ( $pub_name == '' ){$pub_name = 'n/a';}      
                    if ( $sql_game_search['game_year'] == '' ){$sql_game_search['game_year'] = 'n/a';}                        
                    
                    $ignore = 0;
                    
                    if (isset($screenshot) and $screenshot == "1") 
                    {
                       if ($screen == "0")
                       {
                           $ignore = 1;
                       }
                    }
                    
                    if (isset($boxscan) and $boxscan == "1") 
                    {
                       if ($box == "0")
                       {
                           $ignore = 1;
                       }
                    }
                    
                    if (isset($download) and $download == "1") 
                    {
                        
                        if ($down == '0')
                        {
                            $ignore = 1;
                        }
                    }
                    
                    if ( $ignore == 0 )
                    {
                        $i++;
                         
                        if (isset($export) and $export == "1") {
                            // this is the array used in export mode
                            $list_data = array(
                                'id'=>$i,
                                'game_id'=>$sql_game_search['game_id'],
                                'game_name'=>$game_name,
                                'publisher_id'=> $sql_game_search['publisher_id'],
                                'publisher_name' => $pub_name,
                                'developer_id' => $sql_game_search['developer_id'],
                                'developer_name' => $dev_name,
                                'year' => $sql_game_search['game_year'],
                                'music' => $music,
                                'boxscan' => $box,
                                'download' => $down,
                                'screenshot' => $screen,
                                'falcon_only' => $sql_game_search['falcon_only'],
                                'falcon_enhan' => $sql_game_search['falcon_enhanced'],
                                'falcon_rgb' => $sql_game_search['falcon_rgb'],
                                'falcon_vga' => $sql_game_search['falcon_vga'],
                                'ste_enhanced' => $sql_game_search['ste_enhanced'],
                                'ste_only' => $sql_game_search['ste_only']);
                                
                                $data[] = $list_data;
                        }
                        else
                        {
                            if (isset($boxscan) and $boxscan == "1") 
                            {
                                //Select a random boxscan record
                                $sql_screenshots = $mysqli->query("SELECT *
                                                                    FROM game_boxscan 
                                                                    WHERE game_id='$sql_game_search[game_id]' and game_boxscan_side = '0'						   	   
                                                                    ORDER BY RAND() LIMIT 1") or die("Database error - selecting screenshots"); 
                        
                                while ($screenshot_result =  $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
                                    //Ready screenshots path and filename
                                    $screenshot_image = $game_boxscan_path;
                                    $screenshot_image .= $screenshot_result['game_boxscan_id'];
                                    $screenshot_image .= '.';
                                    $screenshot_image .= $screenshot_result['imgext'];
                                    $screenshot_id = $screenshot_result['game_boxscan_id'];
                                }
                                
                            }
                            else
                            {
                                //Select a random screenshot record
                                $sql_screenshots = $mysqli->query("SELECT *
                                                                    FROM screenshot_game 
                                                                    LEFT JOIN screenshot_main ON (screenshot_game.screenshot_id = screenshot_main.screenshot_id) 
                                                                    WHERE screenshot_game.game_id = '$sql_game_search[game_id]'						   	   
                                                                    ORDER BY RAND() LIMIT 1") or die("Database error - selecting screenshots"); 
                        
                                while ($screenshot_result =  $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
                                    //Ready screenshots path and filename
                                    $screenshot_image = $game_screenshot_path;
                                    $screenshot_image .= $screenshot_result['screenshot_id'];
                                    $screenshot_image .= '.';
                                    $screenshot_image .= $screenshot_result['imgext'];
                                    $screenshot_id = $screenshot_result['screenshot_id'];
                                }
                            }
                            
                            $smarty->append('game_search', array(
                                'game_id' => $sql_game_search['game_id'],
                                'game_name' => $game_name,
                                'publisher_id' => $sql_game_search['publisher_id'],
                                'publisher_name' => $pub_name,
                                'developer_id' => $sql_game_search['developer_id'],
                                'developer_name' => $dev_name,
                                'year' => $sql_game_search['game_year'],
                                'music' => $sql_game_search['music_id'],
                                'boxscan' => $sql_game_search['game_boxscan_id'],
                                'download' => $sql_game_search['game_download_id'],
                                'review' => $sql_game_search['review_game_id'],
                                'path' => $game_screenshot_path,
                                'screenshot_image' => $screenshot_image,
                                'screenshot_id' => $screenshot_id,
                                'falcon_only' => $sql_game_search['falcon_only'],
                                'falcon_enhan' => $sql_game_search['falcon_enhanced'],
                                'falcon_rgb' => $sql_game_search['falcon_rgb'],
                                'falcon_vga' => $sql_game_search['falcon_vga'],
                                'ste_enhanced' => $sql_game_search['ste_enhanced'],
                                'ste_only' => $sql_game_search['ste_only']
                            ));  
                        }   
                    }
                }
                
                $mysqli->query("DROP TABLE temp") or die("does not compute4");
 
                //return JSON formatted data
                if (isset($data))
                {
                    $smarty->assign('data', json_encode($data));
                    $smarty->assign('export', 'export');
                }
                
                if ($i == 0)
                {
                    $edit_message             = "No entries found for your selection";
                    $_SESSION['edit_message'] = $edit_message;
                    $smarty->assign("message", $edit_message);

                    header("Location: ../games/games_main.php?mode=$mode");
                }
                else
                {
                    $time_elapsed_secs = microtime(true) - $start;
                    $smarty->assign("nr_of_games", $i);
                    
                    $rest4 = $i%4; 
                    $smarty->assign("rest4", $rest4);
                    
                    $rest3 = $i%3; 
                    $smarty->assign("rest3", $rest3);
                    
                    $rest2 = $i%2; 
                    $smarty->assign("rest2", $rest2);
                    
                    $smarty->assign("query_time", $time_elapsed_secs);

                    //Send all smarty variables to the templates
                    $smarty->display("file:" . $mainsite_template_folder . "games_main_list.html");
                }
            } else {
                $edit_message             = "No entries found for your selection";
                $_SESSION['edit_message'] = $edit_message;
                $smarty->assign("message", $edit_message);

                header("Location: ../games/games_main.php?mode=$mode");
            }
        }
    }
}
