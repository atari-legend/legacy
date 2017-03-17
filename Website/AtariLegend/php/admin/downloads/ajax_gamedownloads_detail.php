<?php
/***************************************************************************
 *                             ajax_gamedownloads_detail
 *                            ------------------------------
 *   begin                : Friday, March 17, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.Com
 *   actual update        : Creation from scratch for smarty usage
 *
 *
 *   Id: ajax_gamedownloads_detail,v 0.1 2017/03/17 STG 20:13
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 Build game series page
 ***********************************************************************************
 */
include("../../config/common.php");
include("../../config/admin.php");

// EDIT BOX FOR A MENU DISK!!!
if (isset($action) and $action == "edit_download_box" and $game_download_id !== '') {
    
//************************************************************************************************
//Let's get the game info for the file name concatenation, and the download data for disks already
//uploaded - This is now needed to display the header line
//************************************************************************************************
    $SQL_GAME_INFO = $mysqli->query("SELECT * FROM game
                                   LEFT JOIN game_publisher ON (game.game_id = game_publisher.game_id)
                                   LEFT JOIN pub_dev ON (game_publisher.pub_dev_id = pub_dev.pub_dev_id)
                                   LEFT JOIN game_year ON (game.game_id = game_year.game_id)
                                   WHERE game.game_id='$game_id'") or die("Error getting game info");

    $game_info = $SQL_GAME_INFO->fetch_array(MYSQLI_BOTH);

    //get some basic game info
    $smarty->assign('game', array(
        'game_id' => $game_id,
        'game_name' => $game_info['game_name']
    ));

    //get the existing downloads
    $SQL_DOWNLOADS = $mysqli->query("SELECT * FROM game_download 
                                              LEFT JOIN download_main ON (game_download.download_id = download_main.download_id)
                                              WHERE game_download.game_download_id='$game_download_id'") or die("Error getting download info");

    while ($downloads = $SQL_DOWNLOADS->fetch_array(MYSQLI_BOTH)) {
        // first lets create the filenames
        $filename = "$game_info[game_name]";

        if ($game_info['game_year'] == '') {
            $filename .= " (19xx)";
        } else {
            $filename .= " ($game_info[game_year])";
        }
        if ($game_info['pub_dev_id'] !== '') {
            $filename .= "($game_info[pub_dev_name])";
        }
        if ($downloads['download_ext'] == "stx") {
            $filename .= "[pasti]";
        }
        if ($downloads['download_ext'] == "msa") {
            $filename .= "[MSA]";
        }
        
        $filename .= ".zip";

        $filepath = $game_file_path;
        $filepath .= $downloads['game_download_id'];

        //convert the date
        $date = date("F j, Y", $downloads['date']);

        //start filling the smarty object
        $smarty->assign('downloads', array(
            'game_download_id' => $downloads['game_download_id'],
            'disable' => $downloads['disable'],
            'filename' => $filename,
            'filepath' => $filepath,
            'date' => $date
        ));
    }    
    
    
    
//  First we get all the data of this download        
    $sql_downloads = "SELECT *
                        FROM game_download
                        LEFT JOIN download_main ON (game_download.download_id = download_main.download_id)
                        LEFT JOIN download_format ON (download_main.download_id = download_format.download_id)
                        LEFT JOIN format ON (download_format.format_id = format.format_id)
                        LEFT JOIN game_download_lingo ON (game_download_lingo.game_download_id = game_download.game_download_id)
                        LEFT JOIN lingo ON ( lingo.lingo_id = game_download_lingo.lingo_id)
                        LEFT JOIN game_download_details ON ( game_download_details.game_download_id = game_download.game_download_id)
                        WHERE game_download.game_download_id = '$game_download_id'";

    $result_downloads = $mysqli->query($sql_downloads) or die(mysqli_error());
    $row              = $result_downloads->fetch_array(MYSQLI_BOTH);
    
    $download_format  = $row['format_id'];
    $smarty->assign('download_format', $download_format);
    
    $download_lingo   = $row['lingo_id'];
    $smarty->assign('download_lingo', $download_lingo);
    
    $user_id          = $row['user_id'];
    
    $download_date = date("F j, Y", $row['date']);
    
    //get the username
    $query_usn = $mysqli->query("SELECT userid FROM users WHERE user_id = '$user_id'") or die("couldn't get usn of the download");
    $sql_usn = $query_usn->fetch_array(MYSQLI_BOTH);
       
    $smarty->assign('download_details', array(
        'download_id' => $row['download_id'],
        'download_ext' => $row['download_ext'],
        'user_id' => $user_id,
        'username' => $sql_usn['userid'],
        'date' => $download_date,
        'disable' => $row['disable'],
        'game_download_id' => $row['game_download_id'],
        'version' => $row['version'],
        'info' => $row['info']
    ));

    // Get the download credits
    $sql_individuals = "SELECT      individuals.ind_id,
                                    individuals.ind_name,
                                    game_download_individual.game_download_id,
                                    author_type.author_type_info
                                    FROM individuals
                                    LEFT JOIN game_download_individual ON (individuals.ind_id = game_download_individual.ind_id)
                                    LEFT JOIN author_type ON (game_download_individual.author_type_id = author_type.author_type_id)
                                    WHERE game_download_individual.game_download_id = '$game_download_id'
                                    ORDER BY individuals.ind_name ASC";

    $query_individual = $mysqli->query($sql_individuals) or die('Error: ' . mysqli_error($mysqli));

    $query_ind_id = "";

    while ($query = $query_individual->fetch_array(MYSQLI_BOTH)) {
        if ($query_ind_id <> $query['ind_id']) {
         
            $sql_ind_nicks = $mysqli->query("SELECT nick_id FROM individual_nicks WHERE ind_id = '$query[ind_id]'");
            
            while ($fetch_ind_nicks = $sql_ind_nicks->fetch_array(MYSQLI_BOTH)) {
             
                $nick_id = $fetch_ind_nicks['nick_id'];
                
                $sql_nick_names = $mysqli->query("SELECT ind_name from individuals WHERE ind_id = '$nick_id'") or die('Error: ' . mysqli_error($mysqli));
            
                while ($fetch_nick_names = $sql_nick_names->fetch_array(MYSQLI_BOTH)) {

                    $smarty->append('ind_nick', array(
                        'ind_id' => $query['ind_id'],
                        'individual_nicks_id' => $nick_id, 
                        'nick' => $fetch_nick_names['ind_name']
                    ));
                }
            }   
        }

        // This smarty is used for the download credits
        $smarty->append('individuals', array(
            'menu_disk_credits_id' => $query['menu_disk_credits_id'],
            'ind_id' => $query['ind_id'],
            'ind_name' => $query['ind_name'],
            'menu_disk_id' => $menu_disk_id,
            'author_type_info' => $query['author_type_info']
        ));

        $query_ind_id = $query['ind_id'];
    }
    
    
    // download format dropdown
    $query_download_format = $mysqli->query("SELECT * FROM format ORDER BY format_id ASC");

    while ($query = $query_download_format->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('format_id', $query['format_id']);
        $smarty->append('format', $query['format']);
    }
    
    // lingo dropdown
    $query_lingo = $mysqli->query("SELECT * FROM lingo ORDER BY lingo_id ASC");

    while ($query = $query_lingo->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('lingo_id', $query['lingo_id']);
        $smarty->append('lingo_name', $query['lingo_name']);
    }

    $smarty->assign('smarty_action', 'edit_download_box');
    $smarty->assign('gam_download_id', $game_download_id);
}





// CLOSE EDIT BOX FOR A MENU DISK!
if (isset($action) and $action == "close_edit_disk_box" and $menu_disk_id !== '') {
    $sql_menus = "SELECT menu_disk.menu_sets_id,
                        menu_set.menu_sets_name,
                        menu_disk.menu_disk_id,
                        menu_disk.menu_disk_number,
                        menu_disk.menu_disk_letter,
                        menu_disk.menu_disk_version,
                        menu_disk.menu_disk_part,
                        crew.crew_id,
                        crew.crew_name,
                        individuals.ind_id,
                        individuals.ind_name,
                        menu_disk_state.menu_state
                        FROM menu_disk
                        LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
                        LEFT JOIN crew_menu_prod ON (menu_set.menu_sets_id = crew_menu_prod.menu_sets_id)
                        LEFT JOIN crew ON (crew_menu_prod.crew_id = crew.crew_id)
                        LEFT JOIN ind_menu_prod ON (menu_set.menu_sets_id = ind_menu_prod.menu_sets_id)
                        LEFT JOIN individuals ON (ind_menu_prod.ind_id = individuals.ind_id)
                        LEFT JOIN menu_disk_state ON ( menu_disk.state = menu_disk_state.state_id)
                        WHERE menu_disk.menu_disk_id = '$menu_disk_id'";

    $result_menus = $mysqli->query($sql_menus);
    $row          = $result_menus->fetch_array(MYSQLI_BOTH);

    // Create Menu disk name
    $menu_disk_name = "$row[menu_sets_name] ";
    if (isset($row['menu_disk_number'])) {
        $menu_disk_name .= "$row[menu_disk_number]";
    }
    if (isset($row['menu_disk_letter'])) {
        $menu_disk_name .= "$row[menu_disk_letter]";
    }
    if (isset($row['menu_disk_part'])) {
        if (is_numeric($row['menu_disk_part'])) {
            $menu_disk_name .= " part $row[menu_disk_part]";
        } else {
            $menu_disk_name .= "$row[menu_disk_part]";
        }
    }
    if (isset($row['menu_disk_version']) and $row['menu_disk_version'] !== '') {
        $menu_disk_name .= " v$row[menu_disk_version]";
    }

    $smarty->assign('menus', array(
        'menu_sets_id' => $row['menu_sets_id'],
        'menu_sets_name' => $row['menu_sets_name'],
        'menu_disk_name' => $menu_disk_name,
        'menu_disk_id' => $row['menu_disk_id'],
        'menu_disk_number' => $row['menu_disk_number'],
        'menu_disk_letter' => $row['menu_disk_letter'],
        'menu_disk_version' => $row['menu_disk_version'],
        'menu_disk_part' => $row['menu_disk_part'],
        'crew_id' => $row['crew_id'],
        'crew_name' => $row['crew_name'],
        'ind_id' => $row['ind_id'],
        'ind_name' => $row['ind_name'],
        'menu_state' => $row['menu_state']
    ));

    $smarty->assign('smarty_action', 'close_edit_disk_box');
    $smarty->assign('menu_disk_id', $menu_disk_id);
}

// POP ADD INTRO CREDITS
if (isset($action) and $action == "add_intro_credit") {
    // Create individuals array
    $menu_disk_id = $query;

    $sql_individuals = "SELECT ind_id,ind_name FROM individuals ORDER BY ind_name ASC";
    //$sql_aka         = "SELECT ind_id,nick FROM individual_nicks ORDER BY nick ASC";

    //Create a temporary table to build an array with both names and nicknames
    $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_individuals") or die('Error: ' . mysqli_error($mysqli));
    //$mysqli->query("INSERT INTO temp $sql_aka") or die('Error: ' . mysqli_error($mysqli));

    $query_temporary = $mysqli->query("SELECT * FROM temp WHERE ind_name LIKE 'a%' ORDER BY ind_name ASC") or die('Error: ' . mysqli_error($mysqli));
    $mysqli->query("DROP TABLE temp");

    while ($genealogy_ind = $query_temporary->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('ind', array(
            'ind_id' => $genealogy_ind['ind_id'],
            'ind_name' => $genealogy_ind['ind_name']
        ));
    }

    // Get Author types for
    $sql_author_types = "SELECT * FROM author_type ORDER BY author_type_info ASC";
    $query_author = $mysqli->query($sql_author_types) or die('Error: ' . mysqli_error($mysqli));

    while ($author_ind = $query_author->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('author_type', array(
            'author_type_id' => $author_ind['author_type_id'],
            'author_type_info' => $author_ind['author_type_info']
        ));
    }

    // Create dropdown values a-z
    $az_value  = az_dropdown_value(0);
    $az_output = az_dropdown_output(0);

    $smarty->assign('az_value', $az_value);
    $smarty->assign('az_output', $az_output);

    $smarty->assign('smarty_action', 'add_intro_credit');
    $smarty->assign('menu_disk_id', $menu_disk_id);
}

if (isset($action) and $action == "ind_gen_browse") {
    if (isset($query)) {
        $sql_individuals = "SELECT ind_id,ind_name FROM individuals ORDER BY ind_name ASC";
        //$sql_aka         = "SELECT ind_id,nick FROM individual_nicks ORDER BY nick ASC";

        //Create a temporary table to build an array with both names and nicknames
        $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_individuals") or die('Error: ' . mysqli_error($mysqli));
        //$mysqli->query("INSERT INTO temp $sql_aka") or die('Error: ' . mysqli_error($mysqli));

        if ($query == "num") {
            $query_temporary = $mysqli->query("SELECT * FROM temp WHERE ind_name REGEXP '^[0-9].*' ORDER BY ind_name ASC") or die('Error: ' . mysqli_error($mysqli));
        } else {
            $query_temporary = $mysqli->query("SELECT * FROM temp WHERE ind_name LIKE '$query%' ORDER BY ind_name ASC") or die('Error: ' . mysqli_error($mysqli));
        }
        $mysqli->query("DROP TABLE temp");
    }
    while ($genealogy_ind = $query_temporary->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('author_type', array(
            'ind_id' => $genealogy_ind['ind_id'],
            'ind_name' => $genealogy_ind['ind_name']
        ));
    }
    $smarty->assign('smarty_action', 'ind_gen_browse');
}

if (isset($action) and $action == "ind_gen_search") {
    if (isset($query) and $query !== "empty") {
        $sql_individuals = "SELECT ind_id,ind_name FROM individuals ORDER BY ind_name ASC";
        //$sql_aka         = "SELECT ind_id,nick FROM individual_nicks ORDER BY nick ASC";

        //Create a temporary table to build an array with both names and nicknames
        $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_individuals") or die('Error: ' . mysqli_error($mysqli));
        //$mysqli->query("INSERT INTO temp $sql_aka") or die('Error: ' . mysqli_error($mysqli));

        $query_temporary = $mysqli->query("SELECT * FROM temp WHERE ind_name LIKE '%$query%' ORDER BY ind_name ASC") or die('Error: ' . mysqli_error($mysqli));
        $mysqli->query("DROP TABLE temp");
    } elseif ($query == "empty") {
        $sql_individuals = "SELECT ind_id,ind_name FROM individuals ORDER BY ind_name ASC";
        //$sql_aka         = "SELECT ind_id,nick FROM individual_nicks ORDER BY nick ASC";

        //Create a temporary table to build an array with both names and nicknames
        $mysqli->query("CREATE TEMPORARY TABLE temp ENGINE=MEMORY $sql_individuals") or die("failed to create temporary table");
        //$mysqli->query("INSERT INTO temp $sql_aka") or die("failed to insert akas into temporary table");

        $query_temporary = $mysqli->query("SELECT * FROM temp WHERE ind_name LIKE '%a%' ORDER BY ind_name ASC") or die("Failed to query temporary table");
        $mysqli->query("DROP TABLE temp");
    }

    while ($genealogy_ind = $query_temporary->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('author_type', array(
            'ind_id' => $genealogy_ind['ind_id'],
            'ind_name' => $genealogy_ind['ind_name']
        ));
    }

    $smarty->assign('smarty_action', 'ind_gen_browse');
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");
