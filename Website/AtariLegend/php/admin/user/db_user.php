<?php
/***************************************************************************
 *                                db_user.php
 *                            -----------------------
 *   begin                : friday, November 11, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : file creation
 *
 *   Id: db_user.php,v 1.01 2015/12/21 ST Graveyard - Added messages
 *                          - Added more SQL statements
 *   Id: db_user.php,v 1.02 2016/08/19 ST Graveyard - Added Change log
 *   Id: db_user.php,v 1.03 2017/04/02 ST Graveyard - Added real escape when updating username
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 This is the database modification area for the cpanel
 ***********************************************************************************
 */
// include common variables and functions
include("../../config/common.php");
include("../../config/admin.php");

//****************************************************************************************
// add avatar
//****************************************************************************************
if (isset($action) and $action == 'avatar_upload') {
    $image = $_FILES['image'];

    $tmp_name = $image['tmp_name'];

    if ($tmp_name !== 'none') {
        // Check what extention the file has and if it is allowed.
        $ext        = "";
        $type_image = $image['type'];

        // set extension
        if ($type_image == 'image/x-png') {
            $ext = 'png';
        } elseif ($type_image == 'image/png') {
            $ext = 'png';
        } elseif ($type_image == 'image/gif') {
            $ext = 'gif';
        } elseif ($type_image == 'image/jpeg') {
            $ext = 'jpg';
        }

        if ($ext !== "") {
            // Rename the uploaded file to the users id number and move it to its proper place.
            $mysqli->query("UPDATE users SET avatar_ext='$ext' WHERE user_id='$user_id_selected'");
            $file_data = rename("$tmp_name", "$user_avatar_save_path$user_id_selected.$ext");
            chmod("$user_avatar_save_path$user_id_selected.$ext", 0777);
            
             // check for size specs
            $imginfo = getimagesize("$user_avatar_save_path$user_id_selected.$ext") or die("getimagesize not working");
            $width  = $imginfo[0];
            $height = $imginfo[1];

            if ($width < 101 and $height < 101) {
                $_SESSION['edit_message'] = "Avatar added";
                create_log_entry('Users', $user_id_selected, 'Avatar', $user_id_selected, 'Insert', $_SESSION['user_id']);
            } else {
                $_SESSION['edit_message'] = "Upload failed due to not confirming to specs - width and height must be 100px wide max";
                $mysqli->query("UPDATE users SET avatar_ext='' WHERE user_id='$user_id_selected'");
                unlink("$user_avatar_save_path$user_id_selected.$ext");
            }
        }
        else
        {
            $_SESSION['edit_message'] = "Please upload only files with extension png, jpg or gif";
        }
    }
}

//****************************************************************************************
// delete avatar
//****************************************************************************************
if (isset($action) and $action == "delete_avatar") {
    $avatar_query = $mysqli->query("SELECT avatar_ext FROM users WHERE user_id='$user_id_selected'");
    list($avatar_ext) = $avatar_query->fetch_array(MYSQLI_BOTH);

    $mysqli->query("UPDATE users SET avatar_ext='' WHERE user_id='$user_id_selected'");
    $_SESSION['edit_message'] = "Avatar deleted";
    unlink("$user_avatar_save_path$user_id_selected.$avatar_ext");

    create_log_entry('Users', $user_id_selected, 'Avatar', $user_id_selected, 'Delete', $_SESSION['user_id']);
}

//****************************************************************************************
// reset pwd
//****************************************************************************************
if (isset($action) and $action == 'reset_pwd') {
    $mysqli->query("UPDATE users SET password='', sha512_password = '', salt = '' WHERE user_id='$user_id_selected'");
    $_SESSION['edit_message'] = "Password reset";

    create_log_entry('Users', $user_id_selected, 'User', $user_id_selected, 'Update', $_SESSION['user_id']);
}

//****************************************************************************************
// modify user
//****************************************************************************************
if (isset($action) and $action == 'modify_user') {
    
    if (isset($_POST['pmd5']) &&  $_POST['pmd5'] != '' && isset($_POST['p']) && $_POST['p'] != '' ) {
      
        $user_name = $mysqli->real_escape_string($user_name);
        $md5pass = $_POST['pmd5']; // The md5 hashed password.
        $sha512 = $_POST['p']; // The hashed password.
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));//create random salt
        $update_password = hash('sha512', $sha512 . $random_salt); // Create salted password
    
        if (isset ($user_inactive))
        {
            $mysqli->query("UPDATE users SET userid='$user_name', password='$md5pass', sha512_password='$update_password', salt='$random_salt', email='$user_email', permission='$user_permission', user_website='$user_website', user_icq='$user_icq', user_msnm='$user_msnm', user_aim='$user_aim', inactive='$user_inactive' WHERE user_id='$user_id_selected'");
        }
        else
        {
            $mysqli->query("UPDATE users SET userid='$user_name', password='$md5pass', sha512_password='$update_password', salt='$random_salt', email='$user_email', permission='$user_permission', user_website='$user_website', user_icq='$user_icq', user_msnm='$user_msnm', user_aim='$user_aim', inactive=' ' WHERE user_id='$user_id_selected'");
        }
        $_SESSION['edit_message'] = "User data modified";

        create_log_entry('Users', $user_id_selected, 'User', $user_id_selected, 'Update', $_SESSION['user_id']);
    } else {
        
        $user_name = $mysqli->real_escape_string($user_name);
        
        if (isset ($user_inactive))
        {
            $mysqli->query("UPDATE users SET userid='$user_name', email='$user_email', permission='$user_permission', user_website='$user_website', user_icq='$user_icq', user_msnm='$user_msnm', user_aim='$user_aim', inactive='$user_inactive' WHERE user_id='$user_id_selected'");
        }
        else
        {
            $mysqli->query("UPDATE users SET userid='$user_name', email='$user_email', permission='$user_permission', user_website='$user_website', user_icq='$user_icq', user_msnm='$user_msnm', user_aim='$user_aim', inactive=' ' WHERE user_id='$user_id_selected'");
        }
        $_SESSION['edit_message'] = "User data modified";

        create_log_entry('Users', $user_id_selected, 'User', $user_id_selected, 'Update', $_SESSION['user_id']);
    }
}

//****************************************************************************************
// delete user
//****************************************************************************************
if (isset($action) and $action == 'delete_user') {
    //First we need to do a hell of a lot checks before we can delete an actual user.
    $sql = $mysqli->query("SELECT * FROM comments
            LEFT JOIN game_user_comments ON (comments.comments_id = game_user_comments.comment_id)
            LEFT JOIN game ON ( game_user_comments.game_id = game.game_id )
            WHERE comments.user_id = '$user_id_selected'") or die("error selecting game comments");

    if ($sql->num_rows > 0) {
        $_SESSION['edit_message'] = 'Deletion failed - This user has submitted game comments - Delete it in the appropriate section';
    } else {
        $sql = $mysqli->query("SELECT * FROM review_main
              LEFT JOIN review_game ON (review_main.review_id = review_game.review_id)
              LEFT JOIN game ON ( review_game.game_id = game.game_id )
              WHERE review_main.user_id = '$user_id_selected'") or die("error selecting game reviews");

        if ($sql->num_rows > 0) {
            $_SESSION['edit_message'] = 'Deletion failed - This user has submitted game reviews - Delete it in the appropriate section';
        } else {
            $sql = $mysqli->query("SELECT * FROM game_submitinfo
                    LEFT JOIN game ON (game_submitinfo.game_id = game.game_id)
                    WHERE user_id = '$user_id_selected'") or die("error selecting game info");
            if ($sql->num_rows > 0) {
                $_SESSION['edit_message'] = 'Deletion failed - This user has submitted game info - Delete it in the appropriate section';
            } else {
                $sql = $mysqli->query("SELECT * FROM website WHERE user_id = '$user_id_selected'") or die("error selecting links");

                if ($sql->num_rows > 0) {
                    $_SESSION['edit_message'] = 'Deletion failed - This user has submitted links - Delete it in the appropriate section';
                } else {
                    $sql = $mysqli->query("SELECT * FROM news WHERE user_id = '$user_id_selected'") or die("error selecting news");

                    if ($sql->num_rows > 0) {
                        $_SESSION['edit_message'] = 'Deletion failed - This user has submitted news updates - Delete it in the appropriate section';
                    } else {
                        $sql = $mysqli->query("SELECT * FROM comments
                        LEFT JOIN demo_user_comments ON (comments.comments_id = demo_user_comments.comments_id)
                        LEFT JOIN demo ON ( demo_user_comments.demo_id = demo.demo_id )
                        WHERE comments.user_id = $user_id_selected") or die("error selecting demo comments");

                        if ($sql->num_rows > 0) {
                            $_SESSION['edit_message'] = 'Deletion failed - This user has submitted demo comments - Delete it in the appropriate section';
                        } else {
                            create_log_entry('Users', $user_id_selected, 'User', $user_id_selected, 'Delete', $_SESSION['user_id']);

                            $mysqli->query("DELETE from users WHERE user_id='$user_id_selected'") or die('deleting user failed');

                            $_SESSION['edit_message'] = 'User deleted succesfully';
                        }
                    }
                }
            }
        }
    }
}

header("Location: ../user/user_detail.php?user_id_selected=$user_id_selected");

//close the connection
mysqli_close($mysqli);
