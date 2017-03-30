<?php
/***************************************************************************
 *                                db_downloads_game.php
 *                            ------------------------
 *   begin                : Thursday, March 16, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : admin@atarilegend.com
 *   actual update        : Creation of file
 *
 *   Id: db_downloads_game.php,v 0.10 2017/03/16 23:42 ST Gravedigger
 ***************************************************************************/

//****************************************************************************************
// This is the main page for the game downloads.
//****************************************************************************************

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

//****************************************************************************************
// We wanna add a new download
//****************************************************************************************
if (isset($action) and $action == 'add_download') {
    require_once('../../vendor/pclzip/pclzip/pclzip.lib.php');

    $game_download_name = $_FILES['game_download_name'];

    if (isset($game_download_name)) {
        $file_name = $_FILES['game_download_name']['name'];

        $tempfilename = $_FILES['game_download_name']['tmp_name'];

        // Time for zip magic
        $zip = new PclZip("$tempfilename");

        // Obtain the contentlist of the zip file.
        if (($list = $zip->listContent()) == 0) {
            die("Error : " . $zip->errorInfo(true));
        }

        // Get the filename from the returned array
        $filename = $list[0]['filename'];

        // Split the filename to get the extention
        $ext = strrchr($filename, ".");

        // Get rid of the . in the extention
        $ext = explode(".", $ext);

        // convert to lowercase just incase....
        $ext = strtolower($ext[1]);

        // check if the extention is valid.
        if ($ext == "stx" || $ext == "msa" || $ext == "st") { // pretty isn't it? ;)
        } else {
              exit("Try uploading a diskimage type that is allowed, like stx or msa not $ext");
        }

        // create a timestamp for the date of upload
        $timestamp = time();

        // Insert the ext,timestamp and the download id into the download table.
        $sdbquery = $mysqli->query("INSERT INTO download_main (download_ext,date, user_id) VALUES ('$ext','$timestamp', '$_SESSION[user_id]')") or die("ERROR! Couldn't insert date, ext in download_main");

        //select the newly created download_id from the download_main table
        $GAMEDOWN = $mysqli->query("SELECT download_id FROM download_main
                                 ORDER BY download_id desc") or die("Database error - selecting download_main");

        $gamedownrow = $GAMEDOWN->fetch_row();
        
         // Insert this download id and the game id into the game download table.
        $sdbquery = $mysqli->query("INSERT INTO game_download (game_id,download_id) VALUES ('$game_id','$gamedownrow[0]')") or die("ERROR! Couldn't insert ids in game_download");

        // Time to unzip the file to the temporary directory
        $archive = new PclZip("$tempfilename");

        if ($archive->extract(PCLZIP_OPT_PATH, "$game_file_temp_path") == 0) {
            die("Error : " . $archive->errorInfo(true));
        }

        // rename diskimage to increment number
        rename("$game_file_temp_path$filename", "$game_file_temp_path$gamedownrow[0].$ext") or die("couldn't rename the file");

        //Time to rezip file and place it in the proper location.
        $archive = new PclZip("$game_file_path$gamedownrow[0].zip");
        $v_list  = $archive->create("$game_file_temp_path$gamedownrow[0].$ext", PCLZIP_OPT_REMOVE_ALL_PATH);
        if ($v_list == 0) {
            die("Error : " . $archive->errorInfo(true));
        }

        // Time to do the safeties, here we do a sha512 file hash that we later enter into the database, this will be used in the download
        // function to check everytime the file is being downloaded... if the hashes don't match, then datacorruption have changed the file.
        $crc = openssl_digest("$game_file_path$gamedownrow[0].zip", 'sha512');
        
        //$crc = md5_file("$game_file_path$gamedownrow[0].zip");

        $sdbquery = $mysqli->query("UPDATE download_main SET sha512 = '$crc' WHERE download_id = '$gamedownrow[0]'") or die("Couldn't insert sha512hash");

        // Add entry to search table for search purposes
        // $mysqli->query("UPDATE game_search SET download='1' WHERE game_id='$game_id'");

        // Chmod file so that we can backup/delete files through ftp.
        chmod("$game_file_path$gamedownrow[0].zip", 0777);

        // Delete the unzipped file in the temporary directory
        unlink("$game_file_temp_path$gamedownrow[0].$ext");

        create_log_entry('Games', $game_id, 'File', $game_id, 'Insert', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "game uploaded";

        header("Location: ../downloads/downloads_game_detail.php?game_id=$game_id");
    }
}

//****************************************************************************************
// This is where we add an option to the download
//****************************************************************************************
if (isset($action) and $action == "add_option") {

    if ($download_options_id == '-' or $download_options_id == '')
    {
        echo "Please select a download option <br><br>";
    }
    else
    {
        // Insert this option into game_download_options table.
        $sdbquery = $mysqli->query("INSERT INTO game_download_options (game_download_id,download_options_id) VALUES ('$game_download_id','$download_options_id')") or die("ERROR! Couldn't insert ids in game_download_options");
        
        $_SESSION['edit_message'] = "Option inserted";
        
        create_log_entry('Downloads', $game_id, 'Options', $download_options_id, 'Insert', $_SESSION['user_id']);  
    }
    
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
    
    $smarty->assign('game_download_id', $game_download_id);
    $smarty->assign('game_id', $game_id);
    
    $smarty->assign('smarty_action', 'update_options');
    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");

}

//****************************************************************************************
// This is where we delete an option from the download
//****************************************************************************************
if (isset($action) and $action == "delete_option") {

        // Delete from game_download_options table.
        $mysqli->query("DELETE from game_download_options WHERE game_download_id='$game_download_id' AND download_options_id='$download_options_id'") or die('Error: ' . mysqli_error($mysqli));
         
        $_SESSION['edit_message'] = "Option deleted";
        
        create_log_entry('Downloads', $game_id, 'Options', $download_options_id, 'Delete', $_SESSION['user_id']);  
        
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
        
        $smarty->assign('game_download_id', $game_download_id);
        $smarty->assign('game_id', $game_id);
        
        $smarty->assign('smarty_action', 'update_options');
        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");
}

//****************************************************************************************
// This is where we add an non compatible TOS to the download
//****************************************************************************************
if (isset($action) and $action == "add_tos") {

    if ($download_tos_id == '-' or $download_tos_id == '')
    {
        echo "Please select a TOS version <br><br>";
    }
    else
    {
        // Insert this option into game_download_options table.
        $sdbquery = $mysqli->query("INSERT INTO game_download_tos (game_download_id,tos_version_id) VALUES ('$game_download_id','$download_tos_id')") or die("ERROR! Couldn't insert ids in game_download_tos");
        
        $_SESSION['edit_message'] = "TOS version inserted";
        
        create_log_entry('Downloads', $game_id, 'TOS', $download_tos_id, 'Insert', $_SESSION['user_id']);  
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
         
    $smarty->assign('game_download_id', $game_download_id);
    $smarty->assign('game_id', $game_id);
    
    $smarty->assign('smarty_action', 'update_tos');
    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");
    
}


//****************************************************************************************
// This is where we delete a TOS version from the download
//****************************************************************************************
if (isset($action) and $action == "delete_tos") {

        // Delete from game_download_options table.
        $mysqli->query("DELETE from game_download_tos WHERE game_download_id='$game_download_id' AND tos_version_id='$download_tos_id'") or die('Error: ' . mysqli_error($mysqli));
         
        $_SESSION['edit_message'] = "TOS version deleted";
        
        create_log_entry('Downloads', $game_id, 'TOS', $download_tos_id, 'Delete', $_SESSION['user_id']);  
        
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
        
        $smarty->assign('game_download_id', $game_download_id);
        $smarty->assign('game_id', $game_id);
        
        $smarty->assign('smarty_action', 'update_tos');
        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");
}


//****************************************************************************************
// This is where we add a trainer option to the download
//****************************************************************************************
if (isset($action) and $action == "add_trainer") {

    if ($download_trainer_id == '-' or $download_trainer_id == '')
    {
        echo "Please select a trainer option<br><br>";
    }
    else
    {
        // Insert this trainer option into game_download_trainer table.
        $sdbquery = $mysqli->query("INSERT INTO game_download_trainer (game_download_id,trainer_options_id) VALUES ('$game_download_id','$download_trainer_id')") or die("ERROR! Couldn't insert ids in game_download_trainer table");
        
        $_SESSION['edit_message'] = "Trainer option inserted";
        
        create_log_entry('Downloads', $game_id, 'Trainer', $download_trainer_id, 'Insert', $_SESSION['user_id']);  
    }   
        
    // get the download trainer
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
     
    $smarty->assign('game_download_id', $game_download_id);
    $smarty->assign('game_id', $game_id);
    
    $smarty->assign('smarty_action', 'update_trainer');
    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");

}

//****************************************************************************************
// This is where we delete a Trainer options from the download
//****************************************************************************************
if (isset($action) and $action == "delete_trainer") {

        // delete the trainer option from the game_download_options table.
        $mysqli->query("DELETE from game_download_trainer WHERE game_download_id='$game_download_id' AND trainer_options_id='$download_trainer_id'") or die('Error: ' . mysqli_error($mysqli));
         
        $_SESSION['edit_message'] = "Trainer option deleted";
        
        create_log_entry('Downloads', $game_id, 'Trainer', $download_trainer_id, 'Delete', $_SESSION['user_id']);  
        
         // get the download tos
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
        
        $smarty->assign('game_download_id', $game_download_id);
        $smarty->assign('game_id', $game_id);
        
        $smarty->assign('smarty_action', 'update_trainer');
        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");
}

//****************************************************************************************
// This is where we add a crew to the download
//****************************************************************************************
if (isset($action) and $action == "add_crew") {

    if ($download_crew_id == '-' or $download_crew_id == '')
    {
        echo "Please select a crew<br><br>";
    }
    else
    {
        // Insert this crew into game_download_trainer table.
        $sdbquery = $mysqli->query("INSERT INTO game_download_crew (game_download_id,crew_id) VALUES ('$game_download_id','$download_crew_id')") or die("ERROR! Couldn't insert ids in game_download_crew table");
        
        $_SESSION['edit_message'] = "Crew inserted";
        
        create_log_entry('Downloads', $game_id, 'Crew', $download_crew_id, 'Insert', $_SESSION['user_id']);  
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
     
    $smarty->assign('game_download_id', $game_download_id);
    $smarty->assign('game_id', $game_id);
    
    $smarty->assign('smarty_action', 'update_crew');
    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");

}

//****************************************************************************************
// This is where we delete a crew from the download
//****************************************************************************************
if (isset($action) and $action == "delete_crew") {

        // delete the crew from the game_download_crew table.
        $mysqli->query("DELETE from game_download_crew WHERE game_download_id='$game_download_id' AND crew_id='$download_crew_id'") or die('Error: ' . mysqli_error($mysqli));
         
        $_SESSION['edit_message'] = "Crew deleted";
        
        create_log_entry('Downloads', $game_id, 'Crew', $download_crew_id, 'Delete', $_SESSION['user_id']);  
        
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
        
        $smarty->assign('game_download_id', $game_download_id);
        $smarty->assign('game_id', $game_id);
        
        $smarty->assign('smarty_action', 'update_crew');
        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");
}


//****************************************************************************************
// This is where we add a menudisk to the download
//****************************************************************************************
if (isset($action) and $action == "add_menudisk") {

    if ($download_menudisk_id == '-' or $download_menudisk_id == '')
    {
        echo "Please select a menudisk<br><br>";
    }
    else
    {
        // let's get the menudisk_title_game_id
        $sql_menudisk = "SELECT menu_disk_title_game_id
                        FROM menu_disk_title_game
                        LEFT JOIN menu_disk_title ON (menu_disk_title_game.menu_disk_title_id = menu_disk_title.menu_disk_title_id)
                        WHERE menu_disk_title_game.game_id = '$game_id' AND menu_disk_title.menu_disk_id = '$download_menudisk_id'";

        $result_menudisk = $mysqli->query($sql_menudisk) or die(mysqli_error());
        $row              = $result_menudisk->fetch_array(MYSQLI_BOTH);
        $menu_disk_title_game_id = $row['menu_disk_title_game_id'];
        
        if ( $menu_disk_title_game_id == '')
        {
            echo "Selected menudisk does not contain this game!<br><br>";
        }
        else
        {        
            // Insert this download into game_download_menu table.
            $sdbquery = $mysqli->query("INSERT INTO game_download_menu (game_download_id,menu_disk_title_game_id) VALUES ('$game_download_id','$menu_disk_title_game_id')") or die("ERROR! Couldn't insert ids in game_download_menu table");
            
            $_SESSION['edit_message'] = "menudisk inserted";
            
            create_log_entry('Downloads', $game_id, 'Menudisk', $game_id, 'Insert', $_SESSION['user_id']);  
        }
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
    
     
    $smarty->assign('game_download_id', $game_download_id);
    $smarty->assign('game_id', $game_id);
    
    $smarty->assign('smarty_action', 'update_menudisk');
    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");
}

//****************************************************************************************
// This is where we delete a menudisk from the download
//****************************************************************************************
if (isset($action) and $action == "delete_menudisk") {
          
        // delete the crew from the game_download_crew table.
        $mysqli->query("DELETE from game_download_menu WHERE game_download_id='$game_download_id' AND menu_disk_title_game_id='$menu_disk_title_game_id'") or die('Error: ' . mysqli_error($mysqli));
         
        $_SESSION['edit_message'] = "menudisk deleted";
        
        create_log_entry('Downloads', $game_id, 'Menudisk', $game_id, 'Delete', $_SESSION['user_id']);  
        
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
        
        $smarty->assign('game_download_id', $game_download_id);
        $smarty->assign('game_id', $game_id);
        
        $smarty->assign('smarty_action', 'update_menudisk');
        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");
}

//****************************************************************************************
// Create set chain for download
//****************************************************************************************
if (isset($action) and ($action == "create_set" OR $action == "delete_set" OR $action == "link_set")) {

    if (isset($download_set_id)) {
       
       if ($action == "create_set")
        {
            /* first see if this title is already chained */
            $sql = $mysqli->query("SELECT * FROM game_download_set
            WHERE game_download_id = '$game_download_id'") or die("error selecting chain");
            if ($sql->num_rows > 0) {
                echo "This download is already chained - delete chain first<br><br>";
            } else {
                //check if the title is already linked
                $sql_set_nr = "SELECT game_download_set_nr FROM game_download_set WHERE game_download_id = '$game_download_id'";
                $query_ser_nr = $mysqli->query($sql_set_nr) or die("problem with set nr query");
                $query_data = $query_ser_nr->fetch_array(MYSQLI_BOTH);
                $set_nr     = $query_data['menu_disk_title_set_nr'];

                //if not linked
                if ($set_nr == 0 or $set_nr = '') {
                    /*We need to get the highest set nr */
                    $sql_set_nr = "SELECT game_download_set_nr FROM game_download_set order by game_download_set_nr DESC";
                    $query_set_nr = $mysqli->query($sql_set_nr) or die("problem with set nr query");
                    if ($query_set_nr->num_rows > 0) {
                        while ($row = $query_set_nr->fetch_array(MYSQLI_BOTH)) {
                            $set_nr = $row['game_download_set_nr'];
                            $set_nr++;
                            break;
                        }
                    } else {
                        $set_nr = 1;
                    }
                }

                $sql_download_set = $mysqli->query("INSERT INTO game_download_set (game_download_set_nr, game_download_set_chain, game_download_id) VALUES ('$set_nr','1', $game_download_id)") or die("error inserting download chain");
                $osd_message = "Chain created for this download";

                create_log_entry('Downloads', $game_id, 'Chain', $game_id, 'Insert', $_SESSION['user_id']);  
            }
        }
        
        if ($action == "delete_set")
        {
            $mysqli->query("DELETE from game_download_set WHERE game_download_id='$game_download_id' AND game_download_set_id='$download_set_id'") or die('Error: ' . mysqli_error($mysqli));
             
            $_SESSION['edit_message'] = "Set deleted";
            
            create_log_entry('Downloads', $game_id, 'Chain', $game_id, 'Delete', $_SESSION['user_id']);             
        }
    
        if ($action == "link_set")
        {
             if ($download_chain == 'Nr' or $download_chain == '') {
                echo "Please add a correct part nr<br><br>";
            } elseif ($download_set_id == '' or $download_set_id == '-') {
                echo "Please select a set";
            } else {
                //check if the title is already linked
                $sql = $mysqli->query("SELECT * FROM game_download_set
              WHERE game_download_id = '$game_download_id'") or die("error selecting chain");
                if ($sql->num_rows > 0) {
                    echo "This title is already chained - delete chain first";
                } else {
                    $sql_download_set = $mysqli->query("INSERT INTO game_download_set (game_download_set_nr, game_download_set_chain, game_download_id) VALUES ('$download_set_id','$download_chain', $game_download_id)") or die("error inserting download chain");
                    $osd_message = "Chain created for this download";

                    create_log_entry('Downloads', $game_id, 'Chain', $game_id, 'Insert', $_SESSION['user_id']);
                }
            }
        }
   
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
    
    $smarty->assign('game_download_id', $game_download_id);
    $smarty->assign('game_id', $game_id);
    
    $smarty->assign('smarty_action', 'update_set');
    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");
}


//****************************************************************************************
// ADD AUTHORS TO DOWNLOAD
//****************************************************************************************
if (isset($action) and ( $action == "add_author" or $action == "delete_download_authors")) {
    
    if ($action == "add_author")
    {
        if (isset($ind_id) and isset($author_type_id) and isset($game_download_id)) {
            //Insert individual into the game_download_individual table
            $mysqli->query("INSERT INTO game_download_individual (game_download_id,ind_id,author_type_id) VALUES ('$game_download_id','$ind_id','$author_type_id')");

            create_log_entry('Downloads', $game_id, 'Authors', $ind_id, 'Insert', $_SESSION['user_id']);
        }
    }
    
    if ($action == "delete_download_authors")
    {
        create_log_entry('Downloads', $game_id, 'Authors', $ind_id, 'Delete', $_SESSION['user_id']);
        
        $mysqli->query("DELETE FROM game_download_individual WHERE game_download_ind_id = '$game_download_ind_id'");        
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
    
    $smarty->assign('game_download_id', $game_download_id);
    $smarty->assign('game_id', $game_id);
    
    $smarty->assign('smarty_action', 'update_individuals');
    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");

}

//****************************************************************************************
// Quick add format
//****************************************************************************************
if (isset($action) and $action == "game_download_format_add") {

    if ( $new_format_name == '' ) {
        $_SESSION['edit_message'] = "Please enter a format";
    }
    else
    {
        $sql            = $mysqli->query("INSERT INTO format (format) VALUES ('$new_format_name')") or die('Error: ' . mysqli_error($mysqli));
        $new_format_id  = $mysqli->insert_id;

        create_log_entry('Format', $new_format_id, 'Format', $new_format_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$new_format_name added to the format table";
    }
    
    header("Location: ../downloads/downloads_game_detail.php?game_id=$game_id");   
}

//****************************************************************************************
// Quick add option
//****************************************************************************************
if (isset($action) and $action == "game_download_option_add") {

    if ( $new_option_name == '' ) {
        $_SESSION['edit_message'] = "Please enter an option";
    }
    else
    {
        $sql            = $mysqli->query("INSERT INTO download_options (download_option) VALUES ('$new_option_name')") or die('Error: ' . mysqli_error($mysqli));
        $new_option_id  = $mysqli->insert_id;

        create_log_entry('Option', $new_option_id, 'Option', $new_option_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$new_option_name added to the download_options table";
    }
    
    header("Location: ../downloads/downloads_game_detail.php?game_id=$game_id"); 
}

//****************************************************************************************
// Quick add lingo
//****************************************************************************************
if (isset($action) and $action == "game_download_lingo_add") {

    if ( $new_lingo_name == '' or $lingo_short == '') {
        $_SESSION['edit_message'] = "Please enter a language and abbrevation";
    }
    else
    {
        $sql           = $mysqli->query("INSERT INTO  lingo (lingo_name, lingo_short) VALUES ('$new_lingo_name', '$lingo_short')") or die("error inserting lingo");
        $new_lingo_id  = $mysqli->insert_id;

        create_log_entry('Lingo', $new_lingo_id, 'Lingo', $new_lingo_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$new_lingo_name added to the download_lingo table";
    }
    
    header("Location: ../downloads/downloads_game_detail.php?game_id=$game_id"); 
}

//****************************************************************************************
// Quick add TOS
//****************************************************************************************
if (isset($action) and $action == "game_download_tos_add") {

    if ( $new_tos_name == '' ) {
        $_SESSION['edit_message'] = "Please enter a TOS version";
    }
    else
    {
        $sql         = $mysqli->query("INSERT INTO  tos_version (tos_version) VALUES ('$new_tos_name')") or die("error inserting tos");
        $new_tos_id  = $mysqli->insert_id;

        create_log_entry('TOS', $new_tos_id, 'TOS', $new_tos_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$new_tos_name added to the tos_version table";
    }
    
    header("Location: ../downloads/downloads_game_detail.php?game_id=$game_id"); 
}

//****************************************************************************************
// Quick add trainer
//****************************************************************************************
if (isset($action) and $action == "game_download_trainer_add") {

    if ( $new_trainer_name == '' ) {
        $_SESSION['edit_message'] = "Please enter a trainer option";
    }
    else
    {
        $sql         = $mysqli->query("INSERT INTO  trainer_options (trainer_options) VALUES ('$new_trainer_name')") or die("error inserting trainer option");
        $new_trainer_id  = $mysqli->insert_id;

        create_log_entry('Trainer', $new_trainer_id, 'Trainer', $new_trainer_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$new_trainer_name added to the trainer_options table";
    }
    
    header("Location: ../downloads/downloads_game_detail.php?game_id=$game_id"); 
}
        
//****************************************************************************************
// This is where we add/modify the main download options
//****************************************************************************************
if (isset($action) and $action == "mod_download") {

    //check if we need to add or modify the game_download_details table
    $sql_nr_details = "SELECT * FROM game_download_details WHERE game_download_id ='$game_download_id'";
    $query_nr_details = $mysqli->query($sql_nr_details) or die("problem getting download details");
    if ($query_nr_details->num_rows > 0) {
        $textfield = $mysqli->real_escape_string($download_info);
        $sdbquery = $mysqli->query("UPDATE game_download_details SET version='$download_version', info= '$textfield' WHERE  game_download_id ='$game_download_id'") or die("ERROR! Couldn't update game_download_details");
    }else{
       // Insert into game_download_details table.
       $textfield = $mysqli->real_escape_string($download_info);
       $sdbquery = $mysqli->query("INSERT INTO game_download_details (game_download_id,version,info) VALUES ('$game_download_id','$download_version', '$textfield')") or die("ERROR! Couldn't insert into game_download_details");
    }
    
    //check if we need to add or modify the game_download_lingo table
    if ( $download_language  == '-' ){}
    else
    {    
        $sql_nr_lingo = "SELECT * FROM game_download_lingo WHERE game_download_id ='$game_download_id'";
        $query_nr_lingo = $mysqli->query($sql_nr_lingo) or die("problem getting download lingo");
        if ($query_nr_lingo->num_rows > 0) {
            $sdbquery = $mysqli->query("UPDATE game_download_lingo SET lingo_id='$download_language' WHERE game_download_id ='$game_download_id'") or die("ERROR! Couldn't update game_download_lingo");
        }else{
           // Insert this option into game_download_lingo table.
           $sdbquery = $mysqli->query("INSERT INTO game_download_lingo (game_download_id,lingo_id) VALUES ('$game_download_id','$download_language')") or die("ERROR! Couldn't insert into game_download_lingo");
        }
    }
    
    //check if we need to add or modify the download format table
    if ( $download_format == '-' ){}
    else
    {    
        //let's get the download id
        $sql_download_id = $mysqli->query("SELECT download_id FROM game_download WHERE game_download_id='$game_download_id'")
                                  or die("Database error - selecting download_main");
        $download_row = $sql_download_id->fetch_row();
        $download_id = $download_row[0];
          
        $sql_nr_format = "SELECT * FROM download_format WHERE download_id ='$download_id'";
        $query_nr_format = $mysqli->query($sql_nr_format) or die("problem getting download format");
        if ($query_nr_format->num_rows > 0) {
            $sdbquery = $mysqli->query("UPDATE download_format SET format_id='$download_format' WHERE download_id ='$download_id'") or die("ERROR! Couldn't update download_format");
        }else{
           // Insert this option into game_download_lingo table.
           $sdbquery = $mysqli->query("INSERT INTO download_format (download_id,format_id) VALUES ('$download_id','$download_format')") or die("ERROR! Couldn't insert into download_format");
        }
    }
    
    //check if we need to add or modify the game_download_intro table
    if ( $download_intro  == '-' ){}
    else
    {    
        $sql_nr_demo = "SELECT * FROM game_download_intro WHERE game_download_id ='$game_download_id'";
        $query_nr_demo = $mysqli->query($sql_nr_demo) or die("problem getting download intro");
        if ($query_nr_demo->num_rows > 0) {
            $sdbquery = $mysqli->query("UPDATE game_download_intro SET demo_id='$download_intro' WHERE game_download_id ='$game_download_id'") or die("ERROR! Couldn't update game_download_intro");
        }else{
           // Insert this option into game_download_lingo table.
           $sdbquery = $mysqli->query("INSERT INTO game_download_intro (game_download_id,demo_id) VALUES ('$game_download_id','$download_intro')") or die("ERROR! Couldn't insert into game_download_demo");
        }
    }
    
    $_SESSION['edit_message'] = "Download details updated";
    create_log_entry('Downloads', $game_id, 'Details', $game_id, 'Update', $_SESSION['user_id']);  
    
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
    
    $user_id          = $row['user_id'];
    $download_date = date("F j, Y", $row['date']);
    
    $download_demo   = $row['demo_id'];
    $smarty->assign('download_demo', $download_demo);
    
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

    $smarty->assign('game_download_id', $game_download_id);
    $smarty->assign('game_id', $game_id);
    
    $smarty->assign('smarty_action', 'update_details');
    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");
}


//****************************************************************************************
// This is where we completely delete the download
//****************************************************************************************
if (isset($action) and $action == "delete_download") {
    create_log_entry('Games', $game_id, 'File', $game_id, 'Delete', $_SESSION['user_id']);

    // let's get the download id
    $sql_download_id = $mysqli->query("SELECT download_id FROM game_download WHERE game_download_id = '$game_download_id'") 
                                        or die("Database error - selecting download_id");
    $download_row = $sql_download_id->fetch_row();
    $download_id = $download_row[0];
    
    //lets start deleting everything from this download
    $mysqli->query("DELETE from download_main WHERE download_id='$download_id'") or die('Error: ' . mysqli_error($mysqli));
    $mysqli->query("DELETE from download_format WHERE download_id='$download_id'") or die('Error: ' . mysqli_error($mysqli));
    $mysqli->query("DELETE from game_download WHERE game_download_id='$game_download_id'") or die('Error: ' . mysqli_error($mysqli));
    $mysqli->query("DELETE from game_download_set WHERE game_download_id='$game_download_id'") or die('Error: ' . mysqli_error($mysqli));
    $mysqli->query("DELETE from game_download_lingo WHERE game_download_id='$game_download_id'") or die('Error: ' . mysqli_error($mysqli));
    $mysqli->query("DELETE from game_download_details WHERE game_download_id='$game_download_id'") or die('Error: ' . mysqli_error($mysqli));
    $mysqli->query("DELETE from game_download_options WHERE game_download_id='$game_download_id'") or die('Error: ' . mysqli_error($mysqli));
    $mysqli->query("DELETE from game_download_menu WHERE game_download_id='$game_download_id'") or die('Error: ' . mysqli_error($mysqli));
    $mysqli->query("DELETE from game_download_tos WHERE game_download_id='$game_download_id'") or die('Error: ' . mysqli_error($mysqli));
    $mysqli->query("DELETE from game_download_intro WHERE game_download_id='$game_download_id'") or die('Error: ' . mysqli_error($mysqli));
    $mysqli->query("DELETE from game_download_trainer WHERE game_download_id='$game_download_id'") or die('Error: ' . mysqli_error($mysqli));
    $mysqli->query("DELETE from game_download_individual WHERE game_download_id='$game_download_id'") or die('Error: ' . mysqli_error($mysqli));
    $mysqli->query("DELETE from game_download_crew WHERE game_download_id='$game_download_id'") or die('Error: ' . mysqli_error($mysqli));
    
    unlink("$game_file_path$download_id.zip");
    $_SESSION['edit_message'] = "file deleted";
    header("Location: ../downloads/downloads_game_detail.php?game_id=$game_id");
}

  
//close the connection
mysqli_close($mysqli);
