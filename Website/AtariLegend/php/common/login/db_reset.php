<?php

/*******************************************************************************
*                                db_reset.php
*                            ------------------------------
*   begin                : 2017-06-03
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*
*   Id: db_reset.php, v 0.10 2017-06-03 Gatekeeper
*
********************************************************************************

*********************************************************************************
* This code will generate a new password for a certain user and sent it to the
* users email adress for password reset
*********************************************************************************/

include("../../config/common.php");
include("../../vendor/phpmailer/phpmailer/PHPMailerAutoload.php");

require_once __DIR__."/../../common/Model/Database/ChangeLog.php" ;
require_once __DIR__."/../../common/DAO/ChangeLogDAO.php" ;

$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);

if (isset($action) and $action == 'check_email') {
    if (!$_POST['email']) {
        $_SESSION['edit_message'] = "You didn't fill in a required field.";
        header("Location: ../../main/front/front.php?action=reset");
    } else {
        //check if the email addres is valid
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['edit_message'] =  "Invalid email format";
            header("Location: ../../main/front/front.php?action=reset");
        } else {
            //check if email address exists in DB
            $query_rows = $mysqli->query("select * from users where email = '$_POST[email]'");
            $number = $query_rows->num_rows;

            if ($number == 0) {
                $_SESSION['edit_message'] =  "There is no user with this email address in our DB - "
                    ."Please contact the admins";
                header("Location: ../../main/front/front.php?action=reset");
            } else { //lets create an email
                $sql_user_id = $query_rows->fetch_array(MYSQLI_BOTH);

                // Create a unique salt. This will never leave PHP unencrypted.
                $salt = $sql_user_id['userid'];

                // Create the unique user password reset key
                $password = hash('sha512', $salt.$_POST['email']);
                $timestamp = time();

                // Add all this into the user_reset table with a timestamp. This will be used to make this password
                // expire in time.
                $sdbquery = $mysqli->query("INSERT INTO users_reset (user_id, password, time)
                    VALUES ('$sql_user_id[user_id]', '$password', '$timestamp')")
                    or die("Couldn't insert user into users_reset table");

                // Create a url which we will direct them to reset their password
                $pwrurl = $pwd_reset_link.$password;

                $mail = new PHPMailer;

                $start = microtime(true);
                $i     = 0;

                $mail->AddAddress($_POST["email"]);

                // Create Email

                //We need to comment out this comment to have it to work from server, on localhost it runs with this
                //command $mail->isSMTP(); // Set mailer to use SMTP

                $mail->SMTPDebug  = 1;                            // enables SMTP debug information (for testing)
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

                $mail->Subject = 'Atarilegend - Password Reset';

                // Mail them their key
                $mailbody = "Dear user,\n\nIf this e-mail does not apply to you please ignore it. It appears that "
                    ."you have requested a password reset at our website www.atarilegend.com\n\nTo reset your password,"
                    ." please click the link below. If you cannot click it, please paste it into your web browser's "
                    ."address bar.\n\n" . $pwrurl . "\n\nThanks,\nTEAM AL";

                $mail->Body    = $mailbody;

                if (!$mail->send()) {
                    //$_SESSION['edit_message'] = "Message could not be sent.";
                    $_SESSION['edit_message'] = "Failed sending email - please contact the administrators";
                } else {
                    $_SESSION['edit_message'] = "An email was sent to ";
                    $_SESSION['edit_message'] .= $_POST["email"];
                    $_SESSION['edit_message'] .= ". Please follow the link";
                }

                $time_elapsed_secs = microtime(true) - $start;
                header("Location: ../../main/front/front.php");
            }
        }
    }
}

if (isset($action) and $action == 'new_pwd') {
    // Gather the post data
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["password_again"];
    $hash = $_POST["q"];

    //check if the email addres is valid
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['edit_message'] =  "Invalid email format";
        header("Location: ../../main/front/front.php?action=new_pwd&q=$hash");
    } else {
        //check if email address exists in DB
        $query_rows = $mysqli->query("select * from users where email = '$_POST[email]'");
        $number = $query_rows->num_rows;

        if ($number == 0) {
            $_SESSION['edit_message'] =  "There is no user with this email address in our DB - "
                ."Please contact the admins";
            header("Location: ../../main/front/front.php?action=new_pwd&q=$hash");
        } else {
            if ($password != $confirmpassword) {
                $_SESSION['edit_message'] =  "The passwords you entered are not the same - please try again";
                header("Location: ../../main/front/front.php?action=new_pwd&q=$hash");
            } else {
                //get the userid
                $query_rows = $mysqli->query("select * from users where email = '$email'");
                $sql_user_id = $query_rows->fetch_array(MYSQLI_BOTH);
                $salt = $sql_user_id['userid'];

                // Generate the reset key
                $resetkey = hash('sha512', $salt.$email);

                // Does the new reset key match the old one?
                if ($resetkey == $hash) {
                    //now check if this hash exists
                    $twentyfour_hours = time()-(60*1440);
                    $query_time = $mysqli->query("select * from users_reset where password = '$resetkey'")
                        or die("problem getting time from the users_reset table");
                    $number_hash = $query_time->num_rows;

                    if ($number_hash == 0) {
                        $_SESSION['edit_message'] =  "Something went wrong - validation not possible, contact the "
                            ."admins or try a new password request";
                        header("Location: ../../main/front/front.php");
                    } else {
                        //is this hash still valid?
                        $sql_time = $query_time->fetch_array(MYSQLI_BOTH);
                        $hash_valid = $sql_time['time'];
                        if ($hash_valid >= $twentyfour_hours) {
                            $md5pass = hash('md5', $_POST['password']); // The md5 hashed password.
                            $sha512 = hash('sha512', $_POST['password']); // The hashed password.
                            $random_salt = hash(
                                'sha512',
                                uniqid(mt_rand(1, mt_getrandmax()), true)
                            );//create random salt
                            $update_password = hash('sha512', $sha512 . $random_salt); // Create salted password
                            $timestamp = time();

                            $sdbquery = $mysqli->query("UPDATE users SET password = '$md5pass',
                                sha512_password = '$update_password', salt = '$random_salt',
                                last_visit = '$timestamp' WHERE user_id = '$sql_user_id[user_id]'")
                                or die("Couldn't update the user table: ".$mysqli->error);

                            //delete the hash from the user_reset table so a new reset can be done
                            $sql_hash = $mysqli->query("DELETE FROM users_reset WHERE password = '$hash'")
                                or die("Couldn't delete password from users_rest table");

                            //Let's log in - fill the session vars

                            if (login($sql_user_id['userid'], $sha512, $mysqli) == true) {
                                $changeLogDao->insertChangeLog(
                                    new \AL\Common\Model\Database\ChangeLog(
                                        -1,
                                        "Users",
                                        $sql_user_id['user_id'],
                                        $sql_user_id['userid'],
                                        "User",
                                        $sql_user_id['userid'],
                                        $sql_user_id['userid'],
                                        $_SESSION['user_id'],
                                        \AL\Common\Model\Database\ChangeLog::ACTION_UPDATE
                                    )
                                );

                                $_SESSION['edit_message'] = "Password succesfully reset - You are logged in.";
                                header("Location: ../../main/front/front.php");
                            } else {
                                $_SESSION['edit_message'] = "Password succesfully reset - Please log in";
                                header("Location: ../../main/front/front.php");
                            }
                        } else {
                            $_SESSION['edit_message'] =  "Something went wrong - hash password request expired, try a "
                                ."new password request";

                            //delete the hash from the user_reset table so a new reset can be done
                            $sql_hash = $mysqli->query("DELETE FROM users_reset WHERE password = '$hash'")
                                or die("Couldn't delete password from users_rest table");

                            header("Location: ../../main/front/front.php");
                        }
                    }
                } else {
                    $_SESSION['edit_message'] =  "Something went wrong - Did you enter the correct email addres?";
                    header("Location: ../../main/front/front.php?action=new_pwd&q=$hash");
                }
            }
        }
    }
}
