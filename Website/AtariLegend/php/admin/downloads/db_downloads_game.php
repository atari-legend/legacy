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
        $_SESSION['edit_message'] = "Please select a download option";
        
        
        $smarty->assign('smarty_action', 'update_options');
        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");
    }
    else
    {
        // Insert this option into game_download_options table.
        $sdbquery = $mysqli->query("INSERT INTO game_download_options (game_download_id,download_options_id) VALUES ('$game_download_id','$download_options_id')") or die("ERROR! Couldn't insert ids in game_download_options");
        
        $_SESSION['edit_message'] = "Option inserted";
        
        create_log_entry('Downloads', $game_id, 'Options', $download_options_id, 'Insert', $_SESSION['user_id']);  
        
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
        $_SESSION['edit_message'] = "Please select a TOS version";
        
        
        $smarty->assign('smarty_action', 'update_tos');
        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");
    }
    else
    {
        // Insert this option into game_download_options table.
        $sdbquery = $mysqli->query("INSERT INTO game_download_tos (game_download_id,tos_version_id) VALUES ('$game_download_id','$download_tos_id')") or die("ERROR! Couldn't insert ids in game_download_tos");
        
        $_SESSION['edit_message'] = "TOS version inserted";
        
        create_log_entry('Downloads', $game_id, 'TOS', $download_tos_id, 'Insert', $_SESSION['user_id']);  
        
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
        $_SESSION['edit_message'] = "Please select a trainer option";
        
        
        $smarty->assign('smarty_action', 'update_trainer');
        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");
    }
    else
    {
        // Insert this trainer option into game_download_trainer table.
        $sdbquery = $mysqli->query("INSERT INTO game_download_trainer (game_download_id,trainer_options_id) VALUES ('$game_download_id','$download_trainer_id')") or die("ERROR! Couldn't insert ids in game_download_trainer table");
        
        $_SESSION['edit_message'] = "Trainer option inserted";
        
        create_log_entry('Downloads', $game_id, 'Trainer', $download_trainer_id, 'Insert', $_SESSION['user_id']);  
        
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
        $_SESSION['edit_message'] = "Please select a crew";
        
        
        $smarty->assign('smarty_action', 'update_crew');
        //Send to smarty for return value
        $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");
    }
    else
    {
        // Insert this crew into game_download_trainer table.
        $sdbquery = $mysqli->query("INSERT INTO game_download_crew (game_download_id,crew_id) VALUES ('$game_download_id','$download_crew_id')") or die("ERROR! Couldn't insert ids in game_download_crew table");
        
        $_SESSION['edit_message'] = "Crew inserted";
        
        create_log_entry('Downloads', $game_id, 'Crew', $download_crew_id, 'Insert', $_SESSION['user_id']);  
        
      
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
// This is where we add/modify the main download options
//****************************************************************************************
if (isset($action) and $action == "mod_download") {

    //check if we need to add or modify the game_download_details table
    $sql_nr_details = "SELECT * FROM game_download_details WHERE game_download_id ='$game_download_id'";
    $query_nr_details = $mysqli->query($sql_nr_details) or die("problem getting download details");
    if ($query_nr_details->num_rows > 0) {
        $sdbquery = $mysqli->query("UPDATE game_download_details SET version='$download_version', info= '$download_info' WHERE  game_download_id ='$game_download_id'") or die("ERROR! Couldn't update game_download_details");
    }else{
       // Insert into game_download_details table.
       $sdbquery = $mysqli->query("INSERT INTO game_download_details (game_download_id,version,info) VALUES ('$game_download_id','$download_version', '$download_info')") or die("ERROR! Couldn't insert into game_download_details");
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

    $smarty->assign('game_download_id', $game_download_id);
    $smarty->assign('game_id', $game_id);
    
    $smarty->assign('smarty_action', 'update_details');
    //Send to smarty for return value
    $smarty->display("file:" . $cpanel_template_folder . "ajax_gamedownloads_detail.html");
}

  
//close the connection
mysqli_close($mysqli);
