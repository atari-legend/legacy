<?php
/***************************************************************************
 *                                downloads_list.php
 *                            --------------------------
 *   begin                : Saturday, March 11, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 *
 *   Id: downloads_list.php,v 0.10 2017/03/11 22:37 Gatekeeper
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 The downloads result page which leads to all options of the download
 ***********************************************************************************
 */
 
//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

date_default_timezone_set('UTC');
$start = microtime(true);

if ($download_type == '-') {
    $_SESSION['edit_message'] = "Please select a download type";
    header("Location: ../downloads/downloads_main.php");
}

if ($download_type == 'Demo' or $download_type == 'Menu') {
    $_SESSION['edit_message'] = "This search type is still under construction";
    header("Location: ../downloads/downloads_main.php");
}

if ($gamebrowse == '-' and $gamesearch == '') {
    $_SESSION['edit_message'] = "Please fill in the necesarry fields";
    header("Location: ../downloads/downloads_main.php");
}

//Let's start with the game query
if ($download_type == 'Game') {
    $sql_build = "SELECT game.game_id,
                           game.game_name,
                           game_publisher.pub_dev_id as 'publisher_id',
                           pd1.pub_dev_name as 'publisher_name',
                           game_developer.dev_pub_id as 'developer_id',
                           pd2.pub_dev_name as 'developer_name',
                           game_year.game_year,
                           'Game' AS software_type
                           FROM game
                           LEFT JOIN game_year on (game_year.game_id = game.game_id)
                           LEFT JOIN game_publisher ON (game_publisher.game_id = game.game_id)
                           LEFT JOIN pub_dev pd1 ON (pd1.pub_dev_id = game_publisher.pub_dev_id)
                           LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)
                           LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id) WHERE ";

    if (isset($action) and $action == "search") {
        if (isset($gamesearch)) {
            $gamesearch = $mysqli->real_escape_string($gamesearch);
        } else {
            $gamesearch = "";
        }

        //check the $gamebrowse select
        if (empty($gamebrowse) or $gamebrowse == '-') {
            $gamebrowse_select = "";
        } elseif ($gamebrowse == 'num') {
            $gamebrowse_select = "AND game.game_name REGEXP '^[0-9].*'";
        } else {
            $gamebrowse = $mysqli->real_escape_string($gamebrowse);
            $gamebrowse_select = "AND game.game_name LIKE '$gamebrowse%'";
        }
        
        if (!empty($gamesearch)) {
            $sql_build .= "game.game_name LIKE '%$gamesearch%' ";
        } else {
            $sql_build .= "game.game_name LIKE '%' ";
        }
        $sql_build .= $gamebrowse_select;
        
        $sql_build .= ' GROUP BY game.game_id, game.game_name HAVING COUNT(DISTINCT game.game_id, game.game_name) = 1';
        $sql_build .= ' ORDER BY game_name ASC';
        
        $downloads = $mysqli->query($sql_build);

        if (empty($downloads)) {
            $edit_message             = "There are problems with the games search, please try again";
            $_SESSION['edit_message'] = $edit_message;
          
            header("Location: ../downloads/downloads_main.php");
        } else {
            $temp_query = $mysqli->query($sql_build) or die("does not compute");

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
                
                //check the number of downloads for this particular game
                $number_downloads = $mysqli->query("SELECT count(*) as count FROM game_download WHERE game_id='$sql_game_search[game_id]'") or die("couldn't get number of downloads for this title");
                $array = $number_downloads->fetch_array(MYSQLI_BOTH);

                $smarty->append('download_search', array(
                        'game_id' => $sql_game_search['game_id'],
                        'game_name' => $game_name,
                        'publisher_id' => $sql_game_search['publisher_id'],
                        'publisher_name' => $pub_name,
                        'developer_id' => $sql_game_search['developer_id'],
                        'developer_name' => $dev_name,
                        'year' => $sql_game_search['game_year'],
                        'number_downloads' => $array['count']
                    ));
            }
                        
            $time_elapsed_secs = microtime(true) - $start;
            
            $smarty->assign("nr_of_games", $i);
            $smarty->assign("query_time", $time_elapsed_secs);

            $smarty->assign("user_id", $_SESSION['user_id']);
            $smarty->assign("type", 'game');
            
            //Send all smarty variables to the templates
            $smarty->display("file:" . $cpanel_template_folder . "downloads_list.html");
        }
    }
}
