<?php
/***************************************************************************
 *                                db_user_management.php
 *                            -----------------------
 *   begin                : 2016-02-24
 *   copyright            : (C) 2016 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        :
 *
 *   Id: db_user_management.php,v 0.10 2016-02-24 Silver Surfer
 *   Id: db_user_management.php,v 0.11 2016-08-21 STG
 *          - added change log
 *
 ***************************************************************************/

include("../../config/common.php");
include("../../config/admin.php");
include("../../config/admin_rights.php");

require_once __DIR__."/../../common/Model/Database/ChangeLog.php";
require_once __DIR__."/../../common/DAO/ChangeLogDAO.php";

use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__."/../../vendor/autoload.php";

$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);

// Ajax driven delete user query
if (isset($action) and $action == "delete_user") {
    if (isset($user_id)) {
        $start = microtime(true);
        $i     = 0;
        foreach ($user_id as $user) {
            $result = $mysqli->query("SELECT userid FROM users WHERE user_id=$user");
            $row = $result->fetch_assoc();
            $user_name = $row["userid"];

            $changeLogDao->insertChangeLog(
                new \AL\Common\Model\Database\ChangeLog(
                    -1,
                    "Users",
                    $user,
                    $user_name,
                    "User",
                    $user,
                    $user_name,
                    $_SESSION['user_id'],
                    \AL\Common\Model\Database\ChangeLog::ACTION_DELETE
                )
            );

            $sql = $mysqli->query("DELETE FROM users WHERE user_id = '$user' ") or die("error deleting user");
            $i++;
        }
        $time_elapsed_secs        = microtime(true) - $start;
        $edit_message = "$i User(s) deleted succesfully";
    } else {
        $edit_message = 'Please SELECT a user you want to delete';
    }
}

if (isset($action) and $action == "email_user") {
    if (isset($user_id)) {
        $mail = new PHPMailer(true);

        $start = microtime(true);
        $i     = 0;
        foreach ($user_id as $user) {
            //get the email address
            $sql = $mysqli->query("SELECT email FROM users WHERE user_id = '$user' ")
                or die("error getting email user");
            $query_data = $sql->fetch_array(MYSQLI_BOTH);

            $mail->AddAddress($query_data['email']);
            $i++;
        }

        //We need to comment out this comment to have it to work from server, on localhost it runs with this command
        //$mail->isSMTP(); // Set mailer to use SMTP

        //$mail->SMTPDebug  = 2;                            // enables SMTP debug information (for testing)
        // 1 = errors and messages
        // 2 = messages only
        $mail->Mailer     = $email_mailer;
        $mail->Host       = $smtp_host;
        $mail->SMTPAuth   = $smtp_auth;
        $mail->Username   = $smtp_username;
        $mail->Password   = $smtp_password;
        $mail->SMTPSecure = $smtp_secure;
        $mail->Port       = $smtp_port;

        $mail->setFrom($pwd_reset_from, 'Atarilegend');
        $mail->addReplyTo($pwd_reset_reply, 'Atarilegend');

        $mail->isHTML(false); // Set email format to HTML

        $mail->Subject = $email_head;
        $mail->Body    = $email_descr;

        try {
            $mail->send();
            $edit_message = "Email sent";
        } catch (Exception $e) {
            $edit_message = "Mailer Error: ".$e->getMessage();
        }

        $time_elapsed_secs = microtime(true) - $start;
    } else {
        $edit_message = 'Please SELECT a user you want to sent an email to';
    }
}

if ((isset($action) and $action == "deactivate_user")) {
    if (isset($user_id)) {
        $start = microtime(true);
        $i     = 0;
        foreach ($user_id as $user) {
            $result = $mysqli->query("SELECT userid FROM users WHERE user_id=$user");
            $row = $result->fetch_assoc();
            $user_name = $row["userid"];

            $changeLogDao->insertChangeLog(
                new \AL\Common\Model\Database\ChangeLog(
                    -1,
                    "Users",
                    $user,
                    $user_name,
                    "User",
                    $user,
                    $user_name,
                    $_SESSION['user_id'],
                    \AL\Common\Model\Database\ChangeLog::ACTION_UPDATE
                )
            );

            $sql = $mysqli->query("UPDATE users SET inactive = '1' WHERE user_id = '$user'; ")
                or die("error updating user");
            $i++;
        }
        $time_elapsed_secs        = microtime(true) - $start;
        $edit_message = 'User(s) updated';
    } else {
        $edit_message = 'Please SELECT a user you want to deactivate';
    }
}

if ((isset($action) and $action == "activate_user")) {
    if (isset($user_id)) {
        $start = microtime(true);
        $i     = 0;
        foreach ($user_id as $user) {
            $result = $mysqli->query("SELECT userid FROM users WHERE user_id=$user");
            $row = $result->fetch_assoc();
            $user_name = $row["userid"];

            $changeLogDao->insertChangeLog(
                new \AL\Common\Model\Database\ChangeLog(
                    -1,
                    "Users",
                    $user,
                    $user_name,
                    "User",
                    $user,
                    $user_name,
                    $_SESSION['user_id'],
                    \AL\Common\Model\Database\ChangeLog::ACTION_UPDATE
                )
            );

            $sql = $mysqli->query("UPDATE users SET inactive = 0 WHERE user_id = '$user'; ")
                or die("error updating user");
            $i++;
        }
        $time_elapsed_secs        = microtime(true) - $start;
        $edit_message = 'User(s) updated';
    } else {
        $edit_message = 'Please SELECT a user you want to activate';
    }
}

echo $edit_message;
