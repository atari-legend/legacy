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
// When the update button has been pressed, the file name and comments get updated
//****************************************************************************************
if (isset($action) and $action == 'update_download') {
    if (isset($cracker)) {
        $mysqli->query("UPDATE game_download SET cracker='$cracker' WHERE game_download_id='$game_download_id'");
    }
    if (isset($supplier)) {
        $mysqli->query("UPDATE game_download SET supplier='$supplier' WHERE game_download_id='$game_download_id'");
    }
    if (isset($screen)) {
        $mysqli->query("UPDATE game_download SET screen='$screen' WHERE game_download_id='$game_download_id'");
    }
    if (isset($language)) {
        $mysqli->query("UPDATE game_download SET language='$language' WHERE game_download_id='$game_download_id'");
    }
    if (isset($trainer)) {
        $mysqli->query("UPDATE game_download SET trainer='$trainer' WHERE game_download_id='$game_download_id'");
    }
    if (isset($legend)) {
        $mysqli->query("UPDATE game_download SET legend='$legend' WHERE game_download_id='$game_download_id'");
    }
    if (isset($disks)) {
        $mysqli->query("UPDATE game_download SET disks='$disks' WHERE game_download_id='$game_download_id'");
    }
    if (isset($set_nr)) {
        $mysqli->query("UPDATE game_download SET set_nr='$set_nr' WHERE game_download_id='$game_download_id'");
    }
    if (isset($intro)) {
        $mysqli->query("UPDATE game_download SET intro='$intro' WHERE game_download_id='$game_download_id'");
    }
    if (isset($harddrive)) {
        $mysqli->query("UPDATE game_download SET harddrive='$harddrive' WHERE game_download_id='$game_download_id'");
    }
    if (isset($disable)) {
        $mysqli->query("UPDATE game_download SET disable='$disable' WHERE game_download_id='$game_download_id'");
    }
    if (isset($version)) {
        $mysqli->query("UPDATE game_download SET version='$version' WHERE game_download_id='$game_download_id'");
    }
    if (isset($tos)) {
        $mysqli->query("UPDATE game_download SET tos='$tos' WHERE game_download_id='$game_download_id'");
    }
    create_log_entry('Games', $game_id, 'File', $game_id, 'Update', $_SESSION['user_id']);

    $_SESSION['edit_message'] = "file updated";
    header("Location: ../games/games_upload.php?game_id=$game_id");
}

//****************************************************************************************
// This is where we delete the download
//****************************************************************************************
if (isset($action) and $action == "delete_download") {
    create_log_entry('Games', $game_id, 'File', $game_id, 'Delete', $_SESSION['user_id']);

    $mysqli->query("DELETE from game_download WHERE game_download_id='$game_download_id'");
    unlink("$game_file_path$game_download_id.zip");
    $_SESSION['edit_message'] = "file deleted";
    header("Location: ../games/games_upload.php?game_id=$game_id");
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

        // Insert this option into game_download_options table.
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
  
//close the connection
mysqli_close($mysqli);
