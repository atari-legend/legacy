<?php
/***************************************************************************
 *                                db_demos_music.php
 *                            -----------------------
 *   begin                : Sunday, november 13, 2005
 *   copyright            : (C) 2003 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : file creation
 *
 *
 *
 ***************************************************************************/

// This document contain all the code needed to operate the website database.
// We are using the action var to separate all the queries.

include("../../includes/common.php");
include("../../includes/admin.php");

//****************************************************************************************
// This is the delete demo music section
//****************************************************************************************
if (isset($action) and $action == 'delete_music') {

    if (isset($music_id)) {
        foreach ($music_id_selected as $music) {
            //get the extension

            $MUSIC = $mysqli->query("SELECT * FROM music
                              WHERE music_id = '$music'") or die("Database error - selecting music");

            $musicrow  = $MUSIC->fetch_array(MYSQLI_BOTH);
            $music_ext = $musicrow[imgext];

            $sql = $mysqli->query("DELETE FROM music WHERE music_id = '$music' ") or die("error deleting music");
            $sql = $mysqli->query("DELETE FROM demo_music WHERE music_id = '$music' ") or die("error deleting game_music");
            $sql = $mysqli->query("DELETE FROM music_author WHERE music_id = '$music' ") or die("error deleting music_author");
            $sql = $mysqli->query("DELETE FROM music_types WHERE music_id = '$music' ") or die("error deleting music_types");

            $new_path = $music_demo_path;
            $new_path .= $music;
            $new_path .= ".";
            $new_path .= $music_ext;

            unlink("$new_path");
        }
    }
    header("Location: ../demos/demos_music_detail.php?demo_id=$demo_id");
}

//****************************************************************************************
// Upload file section
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
                $sdbquery = $mysqli->query("INSERT INTO music (music_id,imgext,mime_type) VALUES ('','$ext','$mime_type')") or die("Database error - inserting music_id");

                //select the newly entered music_id from the main table
                $MUSIC = $mysqli->query("SELECT music_id FROM music
                              ORDER BY music_id desc") or die("Database error - selecting music_id");

                $musicrow = $MUSIC->fetch_row();
                $music_id = $musicrow[0];

                $sdbquery = $mysqli->query("INSERT INTO demo_music (demo_id,music_id) VALUES ('$demo_id','$music_id')") or die("Database error - inserting music id");

                // Insert the author id

                $sdbquery = $mysqli->query("INSERT INTO music_author (music_id,ind_id) VALUES ('$music_id','$ind_id')") or die("Database error - couldn't insert author id");

                // Get the type id and insert it into the music type table
                $typequery = $mysqli->query("SELECT music_types_main_id FROM music_types_main WHERE extention='$ext'") or die("Database error - selecting music_id");

                $typerow = $typequery->fetch_row();
                $type_id = $typerow[0];

                // Insert the type id
                $sdbquery = $mysqli->query("INSERT INTO music_types (music_types_main_id,music_id) VALUES ('$type_id','$music_id')") or die("Database error - inserting type id");

                // Rename the uploaded file to its autoincrement number and move it to its proper place.
                $file_data = rename($image['tmp_name'][$key], "$music_demo_path$music_id.$ext") or die("couldn't rename and move file");

                chmod("$music_demo_path$music_id.$ext", 0777) or die("couldn't chmod file");

            } else {
                $smarty->assign('message', 'Please use extension ym, mod, mp3 or snd');
            }

        }
    }
    header("Location: ../demos/demos_music_detail.php?demo_id=$demo_id");
}

?>
