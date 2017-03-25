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
        
        if ($downloads['download_ext'] == "st") {
            $filename .= "[ST]";
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
                        LEFT JOIN game_download_intro ON (game_download_intro.game_download_id = game_download.game_download_id)
                        LEFT JOIN demo ON (game_download_intro.demo_id = demo.demo_id)
                        WHERE game_download.game_download_id = '$game_download_id'";

    $result_downloads = $mysqli->query($sql_downloads) or die(mysqli_error());
    $row              = $result_downloads->fetch_array(MYSQLI_BOTH);
    
    $download_format  = $row['format_id'];
    $smarty->assign('download_format', $download_format);
    
    $download_lingo   = $row['lingo_id'];
    $smarty->assign('download_lingo', $download_lingo);
    
    $download_demo   = $row['demo_id'];
    $smarty->assign('download_demo', $download_demo);
    
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

    // get the download options
    $sql_options = "SELECT *
                    FROM game_download_options
                    LEFT JOIN download_options ON (game_download_options.download_options_id = download_options.download_options_id)
                    WHERE game_download_options.game_download_id = '$game_download_id'";
                    
    $query_options = $mysqli->query($sql_options) or die('Error: ' . mysqli_error($mysqli));
    
    while ($query = $query_options->fetch_array(MYSQLI_BOTH)) {
         $smarty->append('download_options', array(
                        'download_options_id' => $query['download_options_id'],
                        'download_option' => $query['download_option']
                    )); 
    } 
    
    
     // get the download tos
    $sql_tos = "SELECT *
                    FROM game_download_tos
                    LEFT JOIN tos_version ON (game_download_tos.tos_version_id = tos_version.tos_version_id)
                    WHERE game_download_tos.game_download_id = '$game_download_id'";
                    
    $query_tos = $mysqli->query($sql_tos) or die('Error: ' . mysqli_error($mysqli));
    
    while ($query = $query_tos->fetch_array(MYSQLI_BOTH)) {
         $smarty->append('download_tos', array(
                        'download_tos_id' => $query['tos_version_id'],
                        'download_tos' => $query['tos_version']
                    )); 
    } 
    
     // get the download trainers
    $sql_trainer = "SELECT *
                    FROM game_download_trainer
                    LEFT JOIN trainer_options ON (game_download_trainer.trainer_options_id = trainer_options.trainer_options_id)
                    WHERE game_download_trainer.game_download_id = '$game_download_id'";
                    
    $query_trainer = $mysqli->query($sql_trainer) or die('Error: ' . mysqli_error($mysqli));
    
    while ($query = $query_trainer->fetch_array(MYSQLI_BOTH)) {
         $smarty->append('download_trainer', array(
                        'download_trainer_id' => $query['trainer_options_id'],
                        'download_trainer' => $query['trainer_options']
                    )); 
    } 
    
    // get the linked crews
    $sql_crew = "SELECT *
                    FROM game_download_crew
                    LEFT JOIN crew ON (game_download_crew.crew_id = crew.crew_id)
                    WHERE game_download_crew.game_download_id = '$game_download_id'";
                    
    $query_crew = $mysqli->query($sql_crew) or die('Error: ' . mysqli_error($mysqli));
    
    while ($query = $query_crew->fetch_array(MYSQLI_BOTH)) {
         $smarty->append('download_crew', array(
                        'download_crew_id' => $query['crew_id'],
                        'download_crew' => $query['crew_name']
                    )); 
    } 
    
    // get the linked menudisks
    $sql_menudisks = "SELECT *
                        FROM game_download_menu 
                        LEFT JOIN menu_disk_title_game ON (game_download_menu.menu_disk_title_game_id = menu_disk_title_game.menu_disk_title_game_id)
                        LEFT JOIN menu_disk_title ON (menu_disk_title_game.menu_disk_title_id = menu_disk_title.menu_disk_title_id)
                        LEFT JOIN menu_disk ON (menu_disk_title.menu_disk_id = menu_disk.menu_disk_id)
                        LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
                        WHERE game_download_menu.game_download_id = '$game_download_id'";
                        
    $query_menudisks = $mysqli->query($sql_menudisks) or die('Error: ' . mysqli_error($mysqli));
    
    while ($row = $query_menudisks->fetch_array(MYSQLI_BOTH)) {
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
       
        $smarty->append('download_menudisk', array(
                        'menu_disk_title_game_id' => $row['menu_disk_title_game_id'],
                        'menu_sets_id' => $row['menu_sets_id'],
                        'download_menudisk_name' => $menu_disk_name,                       
                        'download_menudisk_id' => $row['menu_disk_id'] )); 
    } 
    
    // Get the download authors
    $sql_individuals = "SELECT
          individuals.ind_id,
          individuals.ind_name,
          game_download_individual.game_download_ind_id,
          author_type.author_type_info
          FROM individuals
          LEFT JOIN game_download_individual ON (individuals.ind_id = game_download_individual.ind_id)
          LEFT JOIN author_type ON (game_download_individual.author_type_id = author_type.author_type_id)
          WHERE game_download_individual.game_download_id = '$game_download_id'
          ORDER BY individuals.ind_name ASC";

    $query_individual = $mysqli->query($sql_individuals);

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

        // This smarty is used for for the game_download_individuals
        $smarty->append('individuals', array(
            'game_download_ind_id' => $query['game_download_ind_id'],
            'ind_id' => $query['ind_id'],
            'ind_name' => $query['ind_name'],
            'author_type_info' => $query['author_type_info']
        ));

        $query_ind_id = $query['ind_id'];
    }
    
    //  get the chain/set linked to this download
    $SQL_sets = $mysqli->query("SELECT * FROM game_download_set 
                                              LEFT JOIN game_download ON (game_download.game_download_id = game_download_set.game_download_id)
                                              LEFT JOIN download_main ON (game_download.download_id = download_main.download_id)   
                                              LEFT JOIN game ON (game_download.game_id = game.game_id)
                                              LEFT JOIN game_publisher ON (game.game_id = game_publisher.game_id)
                                              LEFT JOIN pub_dev ON (game_publisher.pub_dev_id = pub_dev.pub_dev_id)
                                              LEFT JOIN game_year ON (game.game_id = game_year.game_id)
                                              WHERE game_download.game_download_id='$game_download_id'") or die("Error getting set info");

    while ($sets = $SQL_sets->fetch_array(MYSQLI_BOTH)) {
        // first lets create the filenames
        $filename = "$sets[game_name]";

        if ($sets['game_year'] == '') {
            $filename .= " (19xx)";
        } else {
            $filename .= " ($sets[game_year])";
        }
        if ($sets['pub_dev_id'] !== '') {
            $filename .= "($sets[pub_dev_name])";
        }
        if ($sets['download_ext'] == "stx") {
            $filename .= "[pasti]";
        }
        if ($sets['download_ext'] == "msa") {
            $filename .= "[MSA]";
        }
        
        if ($sets['download_ext'] == "st") {
            $filename .= "[ST]";
        }
        
        $filename .= ".zip";
        
        $smarty->assign('set_chain', $sets['game_download_set_chain']);

        //start filling the smarty object
        $smarty->append('download_set', array(
            'game_download_id' => $sets['game_download_id'],
            'set_id' => $sets['game_download_set_id'],
            'chain_nr' => $sets['game_download_set_chain'],
            'set_nr' => $sets['game_download_set_nr'],
            'set_name' => $filename
        ));
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
    
     // download intro dropdown
    $query_download_demo = $mysqli->query("SELECT * FROM demo ORDER BY demo_name ASC");

    while ($query = $query_download_demo->fetch_array(MYSQLI_BOTH)) {
        $smarty->append('demo_id', $query['demo_id']);
        $smarty->append('demo_name', $query['demo_name']);
    }
    
    // download options dropdown
    $query_options = $mysqli->query("SELECT * FROM download_options ORDER BY download_options_id ASC");

    while ($query = $query_options->fetch_array(MYSQLI_BOTH)) {
         $smarty->append('options', array(
                        'options_id' => $query['download_options_id'],
                        'option' => $query['download_option']
                    )); 
    }
    
    // download TOS dropdown
    $query_tos = $mysqli->query("SELECT * FROM tos_version ORDER BY tos_version_id ASC");

    while ($query = $query_tos->fetch_array(MYSQLI_BOTH)) {
         $smarty->append('tos', array(
                        'tos_id' => $query['tos_version_id'],
                        'tos' => $query['tos_version']
                    )); 
    }
    
     // download TRAINER dropdown
    $query_trainer = $mysqli->query("SELECT * FROM trainer_options ORDER BY trainer_options_id ASC");

    while ($query = $query_trainer->fetch_array(MYSQLI_BOTH)) {
         $smarty->append('trainer', array(
                        'trainer_id' => $query['trainer_options_id'],
                        'trainer' => $query['trainer_options']
                    )); 
    }
    
    // crew dropdown
    $query_crew = $mysqli->query("SELECT * FROM crew ORDER BY crew_name ASC");

    while ($query = $query_crew->fetch_array(MYSQLI_BOTH)) {
         $smarty->append('crew', array(
                        'crew_id' => $query['crew_id'],
                        'crew' => $query['crew_name']
                    )); 
    }
    
    //menudisk dropdown
    $sql_menus = "SELECT * 
                  FROM menu_disk
                  LEFT JOIN menu_set ON (menu_disk.menu_sets_id = menu_set.menu_sets_id)
                  ORDER BY menu_set.menu_sets_name ASC";

    $result_menus = $mysqli->query($sql_menus) or die('Error: ' . mysqli_error($mysqli));
    while ($row = $result_menus->fetch_array(MYSQLI_BOTH)) {

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
       
        $smarty->append('menudisk', array(
                        'menudisk_name' => $menu_disk_name,
                        'menudisk_id' => $row['menu_disk_id'] )); 
    }
    
    //  chain/set dropdown
    $SQL_sets = $mysqli->query("SELECT * FROM game_download_set 
                                              LEFT JOIN game_download ON (game_download.game_download_id = game_download_set.game_download_id)
                                              LEFT JOIN download_main ON (game_download.download_id = download_main.download_id)   
                                              LEFT JOIN game ON (game_download.game_id = game.game_id)
                                              LEFT JOIN game_publisher ON (game.game_id = game_publisher.game_id)
                                              LEFT JOIN pub_dev ON (game_publisher.pub_dev_id = pub_dev.pub_dev_id)
                                              LEFT JOIN game_year ON (game.game_id = game_year.game_id)
                                              ORDER BY game.game_name") or die("Error getting set info");

    while ($sets = $SQL_sets->fetch_array(MYSQLI_BOTH)) {
        // first lets create the filenames
        $filename = "$sets[game_name]";

        if ($sets['game_year'] == '') {
            $filename .= " (19xx)";
        } else {
            $filename .= " ($sets[game_year])";
        }
        if ($sets['pub_dev_id'] !== '') {
            $filename .= "($sets[pub_dev_name])";
        }
        if ($sets['download_ext'] == "stx") {
            $filename .= "[pasti]";
        }
        if ($sets['download_ext'] == "msa") {
            $filename .= "[MSA]";
        }
        
        if ($sets['download_ext'] == "st") {
            $filename .= "[ST]";
        }
        
        $filename .= ".zip";

        //start filling the smarty object
        $smarty->append('set', array(
            'game_download_id' => $sets['game_download_id'],
            'set_id' => $sets['game_download_set_id'],
            'set_nr' => $sets['game_download_set_nr'],
            'set_name' => $filename
        ));
    }         
    
    //Get the individuals
    $sql_individuals = $mysqli->query("SELECT * FROM individuals ORDER BY ind_name ASC") or die('Error: ' . mysqli_error($mysqli));
   
    while ($individuals = $sql_individuals->fetch_array(MYSQLI_BOTH)) {
        if ($individuals['ind_name'] != '') {
            $smarty->append('ind_gene', array(
                'ind_id' => $individuals['ind_id'],
                'ind_name' => $individuals['ind_name']
            ));
        }
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
    
    $smarty->assign('smarty_action', 'edit_download_box');
    $smarty->assign('game_download_id', $game_download_id);
}


if (isset($action) and $action == "closeedit_download_box" and $game_download_id !== '') {
    
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
    $SQL_DOWNLOADS = "SELECT * FROM game_download 
                               LEFT JOIN download_main ON (game_download.download_id = download_main.download_id)
                               WHERE game_download.game_download_id='$game_download_id'";

    $result_downloads = $mysqli->query($SQL_DOWNLOADS) or die('Error: ' . mysqli_error($mysqli));
    $downloads        = $result_downloads->fetch_array(MYSQLI_BOTH);
       
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
    if ($downloads['download_ext'] == "st") {
        $filename .= "[ST]";
    }
    
    $filename .= ".zip";

    $filepath = $game_file_path;
    $filepath .= $downloads['game_download_id'];

    //convert the date
    $date = date("F j, Y", $downloads['date']);

    //start filling the smarty object
    $smarty->assign('downloads', array(
        'game_download_id' => $downloads['game_download_id'],
        'game_id' => $game_id,
        'disable' => $downloads['disable'],
        'filename' => $filename,
        'filepath' => $filepath,
        'date' => $date
    ));

    $smarty->assign('smarty_action', 'closeedit_download_box');
    $smarty->assign('game_download_id', $game_download_id);
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


//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");
