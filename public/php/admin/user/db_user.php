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

require_once __DIR__."/../../common/Model/Database/ChangeLog.php";
require_once __DIR__."/../../common/DAO/ChangeLogDAO.php";

$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);

//We have to make sure that a user can only change his own data and not others unless he is an admin!
if ($user_id_selected == $_SESSION['user_id']) {
} else {
    include("../../config/admin_rights.php");
}

$result = $mysqli->query("SELECT userid FROM users WHERE user_id=$user_id_selected");
$row = $result->fetch_assoc();
$edited_user_name = $row["userid"];

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

            $_SESSION['image'] = $ext;

            if ($width < 601 and $height < 601) {
                $_SESSION['edit_message'] = "Avatar added";

                $changeLogDao->insertChangeLog(
                    new \AL\Common\Model\Database\ChangeLog(
                        -1,
                        "Users",
                        $user_id_selected,
                        $edited_user_name,
                        "Avatar",
                        $user_id_selected,
                        $edited_user_name,
                        $_SESSION["user_id"],
                        \AL\Common\Model\Database\ChangeLog::ACTION_INSERT
                    )
                );
            } else {
                $_SESSION['edit_message'] = "Upload failed due to not confirming to specs - "
                    ."width and height must be 600px max";
                $mysqli->query("UPDATE users SET avatar_ext='' WHERE user_id='$user_id_selected'");
                unlink("$user_avatar_save_path$user_id_selected.$ext");
            }
        } else {
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
    $_SESSION['image'] = '';

    $changeLogDao->insertChangeLog(
        new \AL\Common\Model\Database\ChangeLog(
            -1,
            "Users",
            $user_id_selected,
            $edited_user_name,
            "Avatar",
            $user_id_selected,
            $edited_user_name,
            $_SESSION["user_id"],
            \AL\Common\Model\Database\ChangeLog::ACTION_DELETE
        )
    );
}

//****************************************************************************************
// reset pwd
//****************************************************************************************
if (isset($action) and $action == 'reset_pwd') {
    //$mysqli->query("UPDATE users SET password='', sha512_password = '', salt = '' WHERE user_id='$user_id_selected'");
    //$_SESSION['edit_message'] = "Password reset";

    //Admins can change pwd's for everyone - the current pwd field is not necessary
    if ($_SESSION['permission']==1) {
        //add the new password
        $md5pass = hash('md5', $_POST['user_new_pwd']); // The md5 hashed password.
        $sha512 = hash('sha512', $_POST['user_new_pwd']); // The hashed password.
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));//create random salt
        $update_password = hash('sha512', $sha512 . $random_salt); // Create salted password

        $mysqli->query("UPDATE users SET password='$md5pass',
            sha512_password = '$update_password',
            salt = '$random_salt'
            WHERE user_id='$user_id_selected'");

        //If you are changing your own pwd, we need to update the session vars
        if ($user_id_selected == $_SESSION['user_id']) {
            //Let's log in - fill the session vars
            if (login($_SESSION['userid'], $sha512, $mysqli) == true) {
                $changeLogDao->insertChangeLog(
                    new \AL\Common\Model\Database\ChangeLog(
                        -1,
                        "Users",
                        $user_id_selected,
                        $edited_user_name,
                        "User",
                        $user_id_selected,
                        $edited_user_name,
                        $_SESSION["user_id"],
                        \AL\Common\Model\Database\ChangeLog::ACTION_UPDATE
                    )
                );

                $_SESSION['edit_message'] = "Own account succesfully updated";
                header("Location: ../user/user_detail.php?user_id_selected=$user_id_selected");
            } else {
                $_SESSION['edit_message'] = "Own account succesfully updated - Please log in";
                header("Location: ../../main/front/front.php");
            }
        } else {
            $_SESSION['edit_message'] = "Account succesfully updated";
            header("Location: ../user/user_detail.php?user_id_selected=$user_id_selected");
        }
    } else {
        // Check if current pwd is correct
        $password = $_POST['p'];
        if (login($_SESSION['userid'], $password, $mysqli) == true) {
            //check if both new pwd's are the same
            if ($_POST['user_new_pwd'] == $_POST['user_confirm_pwd']) {
                //add the new password
                $md5pass = hash('md5', $_POST['user_new_pwd']); // The md5 hashed password.
                $sha512 = hash('sha512', $_POST['user_new_pwd']); // The hashed password.
                $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));//create random salt
                $update_password = hash('sha512', $sha512 . $random_salt); // Create salted password

                $mysqli->query("UPDATE users SET password='$md5pass',
                    sha512_password = '$update_password',
                    salt = '$random_salt'
                    WHERE user_id='$user_id_selected'");

                //Let's log in - fill the session vars
                if (login($_SESSION['userid'], $sha512, $mysqli) == true) {
                    $changeLogDao->insertChangeLog(
                        new \AL\Common\Model\Database\ChangeLog(
                            -1,
                            "Users",
                            $user_id_selected,
                            $edited_user_name,
                            "User",
                            $user_id_selected,
                            $edited_user_name,
                            $_SESSION["user_id"],
                            \AL\Common\Model\Database\ChangeLog::ACTION_UPDATE
                        )
                    );
                    $_SESSION['edit_message'] = "Account succesfully updated";
                    header("Location: ../user/user_detail.php?user_id_selected=$user_id_selected");
                } else {
                    $_SESSION['edit_message'] = "Account succesfully updated - Please log in";
                    header("Location: ../../main/front/front.php");
                }
            } else {
                $_SESSION['edit_message'] = "The new and confirmed passwords are not the same";
                header("Location: ../user/user_detail.php?user_id_selected=$user_id_selected");
            }
        } else {
            $_SESSION['edit_message'] = "The current password is not correct";
            header("Location: ../user/user_detail.php?user_id_selected=$user_id_selected");
        }
    }
}

//****************************************************************************************
// modify user
//****************************************************************************************
if (isset($action) and $action == 'modify_user') {
    if ($user_website == 'http://') {
        $user_website = '';
    }

    if ($user_fb == 'https://') {
        $user_fb = '';
    }

    if ($user_twitter == 'https://') {
        $user_twitter = '';
    }

    if ($user_af == 'http://') {
        $user_af = '';
    }

    if (isset($user_inactive)) {
        $user_inactive = '1';
    } else {
        $user_inactive = '0';
    }
    if (isset($user_show_email)) {
        $user_show_email = '1';
    } else {
        $user_show_email = '0';
    }

    if (isset($_POST['pmd5']) &&  $_POST['pmd5'] != '' && isset($_POST['p']) && $_POST['p'] != '') {
        $user_name = $mysqli->real_escape_string($user_name);
        $md5pass = $_POST['pmd5']; // The md5 hashed password.
        $sha512 = $_POST['p']; // The hashed password.
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));//create random salt
        $update_password = hash('sha512', $sha512 . $random_salt); // Create salted password

        $mysqli->query("UPDATE users SET userid='$user_name', password='$md5pass',
            sha512_password='$update_password', salt='$random_salt',
            email='$user_email', permission='$user_permission', user_website='$user_website',
            user_fb='$user_fb', user_twitter='$user_twitter', user_af='$user_af',
            inactive=$user_inactive, show_email='$user_show_email'
            WHERE user_id='$user_id_selected'") or die($mysqli->error);

        $_SESSION['edit_message'] = "User data modified";
    } else {
        $user_name = $mysqli->real_escape_string($user_name);

        $mysqli->query("UPDATE users SET userid='$user_name', email='$user_email',
            permission='$user_permission', user_website='$user_website',
            user_fb='$user_fb', user_twitter='$user_twitter',
            user_af='$user_af', inactive='$user_inactive', show_email='$user_show_email'
            WHERE user_id='$user_id_selected'") or die($mysqli->error);

        $_SESSION['edit_message'] = "User data modified";
    }

    $changeLogDao->insertChangeLog(
        new \AL\Common\Model\Database\ChangeLog(
            -1,
            "Users",
            $user_id_selected,
            $user_name,
            "User",
            $user_id_selected,
            $user_name,
            $_SESSION["user_id"],
            \AL\Common\Model\Database\ChangeLog::ACTION_UPDATE
        )
    );
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
        $_SESSION['edit_message'] = 'Deletion failed - This user has submitted game comments - '
            .'Delete it in the appropriate section';
    } else {
        $sql = $mysqli->query("SELECT * FROM review_main
              LEFT JOIN review_game ON (review_main.review_id = review_game.review_id)
              LEFT JOIN game ON ( review_game.game_id = game.game_id )
              WHERE review_main.user_id = '$user_id_selected'") or die("error selecting game reviews");

        if ($sql->num_rows > 0) {
            $_SESSION['edit_message'] = 'Deletion failed - This user has submitted game reviews - '
                .'Delete it in the appropriate section';
        } else {
            $sql = $mysqli->query("SELECT * FROM game_submitinfo
                    LEFT JOIN game ON (game_submitinfo.game_id = game.game_id)
                    WHERE user_id = '$user_id_selected'") or die("error selecting game info");
            if ($sql->num_rows > 0) {
                $_SESSION['edit_message'] = 'Deletion failed - This user has submitted game info - '
                    .'Delete it in the appropriate section';
            } else {
                $sql = $mysqli->query("SELECT * FROM website WHERE user_id = '$user_id_selected'")
                    or die("error selecting links");

                if ($sql->num_rows > 0) {
                    $_SESSION['edit_message'] = 'Deletion failed - This user has submitted links - '
                        .'Delete it in the appropriate section';
                } else {
                    $sql = $mysqli->query("SELECT * FROM news WHERE user_id = '$user_id_selected'")
                        or die("error selecting news");

                    if ($sql->num_rows > 0) {
                        $_SESSION['edit_message'] = 'Deletion failed - This user has submitted news updates - '
                            .'Delete it in the appropriate section';
                    } else {
                        $changeLogDao->insertChangeLog(
                            new \AL\Common\Model\Database\ChangeLog(
                                -1,
                                "Users",
                                $user_id_selected,
                                $user_name,
                                "User",
                                $user_id_selected,
                                $user_name,
                                $_SESSION["user_id"],
                                \AL\Common\Model\Database\ChangeLog::ACTION_DELETE
                            )
                        );

                        $mysqli->query("DELETE from users WHERE user_id='$user_id_selected'")
                            or die('deleting user failed');

                        $_SESSION['edit_message'] = 'User deleted succesfully';

                        if ($user_id_selected == $_SESSION['user_id']) {
                            // If the user deleted themselves, log them out
                            $_SESSION = array();
                            header("Location: /");
                            mysqli_close($mysqli);
                            die();
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
