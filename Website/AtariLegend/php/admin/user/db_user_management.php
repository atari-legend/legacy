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
include("../../vendor/phpmailer/phpmailer/PHPMailerAutoload.php");

// Ajax driven delete user query
if (isset($action) and $action == "delete_user") {
    if (isset($user_id)) {
        $start = microtime(true);
        $i     = 0;
        foreach ($user_id as $user) {
            create_log_entry('Users', $user, 'User', $user, 'Delete', $_SESSION['user_id']);

            $sql = $mysqli->query("DELETE FROM users WHERE user_id = '$user' ") or die("error deleting user");
            $i++;
        }
        $time_elapsed_secs        = microtime(true) - $start;
        $_SESSION['edit_message'] = "$i User(s) deleted succesfully";
    } else {
        $_SESSION['edit_message'] = 'Please SELECT a user you want to delete';
    }
}

if (isset($action) and $action == "email_user") {
    if (isset($user_id)) {
        $mail = new PHPMailer;

        $start = microtime(true);
        $i     = 0;
        foreach ($user_id as $user) {
            //get the email address
            $sql = $mysqli->query("SELECT email FROM users WHERE user_id = '$user' ") or die("error getting email user");
            $query_data = $sql->fetch_array(MYSQLI_BOTH);

            $mail->AddAddress($query_data['email']);
            $i++;
        }

        //We need to comment out this comment to have it to work from server, on localhost it runs with this command
        //$mail->isSMTP(); // Set mailer to use SMTP
       
        //$mail->SMTPDebug  = 2;                            // enables SMTP debug information (for testing)
        // 1 = errors and messages
        // 2 = messages only
        //$mail->Host = 'smtp.live.com';                    // Specify main and backup SMTP servers
        $mail->Host       = $ms_host;
        $mail->SMTPAuth   = true; // Enable SMTP authentication
        //$mail->Username = 'atarilegend@hotmail.com';      // SMTP username
        //$mail->Password = '@Tar1L3geNd';                  // SMTP password
        $mail->Username   = $ms_usn;
        $mail->Password   = $ms_pwd;
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        //$mail->SMTPSecure = 'ssl';
        //$mail->Port = 587;                                // TCP port to connect to
        $mail->Port       = $ms_port;

        $mail->setFrom($pwd_reset_from, 'Atarilegend');
        $mail->addReplyTo($pwd_reset_reply, 'Atarilegend');

        $mail->isHTML(false); // Set email format to HTML

        $mail->Subject = $email_head;
        $mail->Body    = $email_descr;

        if (!$mail->send()) {
            //$_SESSION['edit_message'] = "Message could not be sent.";
            $_SESSION['edit_message'] = "Mailer Error: ";
        } else {
            $_SESSION['edit_message'] = "Email sent";
        }

        $time_elapsed_secs = microtime(true) - $start;
    } else {
        $_SESSION['edit_message'] = 'Please SELECT a user you want to sent an email to';
    }
}

if ((isset($action) and $action == "deactivate_user")) {
    if (isset($user_id)) {
        $start = microtime(true);
        $i     = 0;
        foreach ($user_id as $user) {
            create_log_entry('Users', $user, 'User', $user, 'Update', $_SESSION['user_id']);

            $sql = $mysqli->query("UPDATE users SET inactive = '1' WHERE user_id = '$user'; ") or die("error updating user");
            $i++;
        }
        $time_elapsed_secs        = microtime(true) - $start;
        $_SESSION['edit_message'] = 'User(s) updated';
    } else {
        $_SESSION['edit_message'] = 'Please SELECT a user you want to deactivate';
    }
}

if ((isset($action) and $action == "activate_user")) {
    if (isset($user_id)) {
        $start = microtime(true);
        $i     = 0;
        foreach ($user_id as $user) {
            create_log_entry('Users', $user, 'User', $user, 'Update', $_SESSION['user_id']);

            $sql = $mysqli->query("UPDATE users SET inactive = ' ' WHERE user_id = '$user'; ") or die("error updating user");
            $i++;
        }
        $time_elapsed_secs        = microtime(true) - $start;
        $_SESSION['edit_message'] = 'User(s) updated';
    } else {
        $_SESSION['edit_message'] = 'Please SELECT a user you want to activate';
    }
}

header("Location: ../user/user_management.php");
