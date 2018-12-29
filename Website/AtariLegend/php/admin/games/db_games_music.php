<?php
/***************************************************************************
 *                                db_games_music.php
 *                            -----------------------
 *   begin                : Saturday, Sept 24, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : re-creation of code from scratch into new file.
 *
 *  Id: db_games_music.php,v 0.20 2016/07/26 ST Graveyard
 *          - AL 2.0
 *  Id: db_games_music.php,v 0.21 2016/08/19 ST Graveyard
 *          - added change log
 *  id: db_games_music.php,v 0.22 2017/02/26 22:19 STG
 *         - fix sql warnings stonish server
 *         - game music deletion did not work!
 ***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

//****************************************************************************************
// This is delete music file from game
//****************************************************************************************

if (isset($action) and $action == 'delete_music') {
    if (isset($music_id)) {
        foreach ((array) $music_id_selected as $music) {
            //get the extension
            $MUSIC = $mysqli->query("SELECT * FROM music
                              WHERE music_id = '$music'") or die("Database error - selecting screenshots");

            $musicrow  = $MUSIC->fetch_array(MYSQLI_BOTH);
            $music_ext = $musicrow['imgext'];

            $sql = $mysqli->query("DELETE FROM music WHERE music_id = '$music' ") or die("error deleting music");
            $sql = $mysqli->query("DELETE FROM game_music WHERE music_id = '$music' ")
                or die("error deleting game_music");
            $sql = $mysqli->query("DELETE FROM music_author WHERE music_id = '$music' ")
                or die("error deleting music_author");
            $sql = $mysqli->query("DELETE FROM music_types WHERE music_id = '$music' ")
                or die("error deleting music_types");

            $new_path = $music_game_save_path;
            $new_path .= $music;
            $new_path .= ".";
            $new_path .= $music_ext;

            unlink("$new_path");
        }
    }

    $_SESSION['edit_message'] = "Music file deleted";
    create_log_entry('Games', $game_id, 'Music', $game_id, 'Delete', $_SESSION['user_id']);
    header("Location: ../games/games_music_detail.php?game_id=$game_id");
}

//****************************************************************************************
// Upload new music files
//****************************************************************************************

if (isset($action) and $action == 'upload_zaks') {
    //Here we'll be looping on each of the inputs on the page that are filled in with an image!

    $image = $_FILES['music'];

    foreach ($image['tmp_name'] as $key => $tmp_name) {
        if ($tmp_name !== 'none') {
            // Check what extention the file has and if it is allowed.

            $ext        = "";
            $type_image = $image['name'][$key];
            $pos        = strrpos($type_image, '.');
            $ext        = substr($type_image, $pos + 1);

            $mime_type = $image['type'][$key];

            // lower case please.
            $ext = strtolower($ext);
            // Is the extention allowed?

            if ($ext == 'ym' or $ext == 'mod' or $ext == 'snd' or $ext == 'mp3') {
                // First we insert extension of the file... this also creates an autoinc number for us.
                $sdbquery = $mysqli->query("INSERT INTO music (music_id,imgext,mime_type)
                    VALUES ('','$ext','$mime_type')") or die("Database error - inserting music_id");

                //select the newly entered music_id from the main table
                $MUSIC = $mysqli->query("SELECT music_id FROM music
                              ORDER BY music_id desc") or die("Database error - selecting music_id");

                $musicrow = $MUSIC->fetch_row();
                $music_id = $musicrow[0];

                $sdbquery = $mysqli->query("INSERT INTO game_music (game_id,music_id)
                    VALUES ('$game_id','$music_id')") or die("Database error - inserting music id");

                // Insert the author id

                $sdbquery = $mysqli->query("INSERT INTO music_author (music_id,ind_id)
                    VALUES ('$music_id','$ind_id')") or die("Database error - couldn't insert author id");

                // Get the type id and insert it into the music type table
                $typequery = $mysqli->query("SELECT music_types_main_id FROM music_types_main WHERE extention='$ext'")
                    or die("Database error - selecting music_id");

                $typerow = $typequery->fetch_row();
                $type_id = $typerow[0];

                // Insert the type id
                $sdbquery = $mysqli->query("INSERT INTO music_types (music_types_main_id,music_id)
                    VALUES ('$type_id','$music_id')") or die("Database error - inserting type id");

                // Rename the uploaded file to its autoincrement number and move it to its proper place.
                $file_data = rename($image['tmp_name'][$key], "$music_game_save_path$music_id.$ext")
                    or die("couldn't rename and move file");

                chmod("$music_game_save_path$music_id.$ext", 0777) or die("couldn't chmod file");
                $_SESSION['edit_message'] = "Music file uploaded";

                create_log_entry('Games', $game_id, 'Music', $game_id, 'Insert', $_SESSION['user_id']);
            } else {
                $_SESSION['edit_message'] = "Please use extension ym, mod, mp3 or snd";
                //$smarty->assign('message', 'Please use extension ym, mod, mp3 or snd');
            }
        }
    }
    header("Location: ../games/games_music_detail.php?game_id=$game_id");
}
