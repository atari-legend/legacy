<?php
/***************************************************************************
*                                db_register.php
*                            -----------------------------
*   begin                : Monday, June 5, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id: db_register.php,v 0.1 2015/06/05 19:40 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php for register tile of the front page
//*********************************************************************************************

//load all common functions
include("../../config/common.php");
include("../../vendor/phpmailer/phpmailer/PHPMailerAutoload.php");

if (isset($action) and $action == 'confirm') {
    //when the confirmation email link is pressed we enter this part of the code. We check if the user exists and set the account to active.
    //Then we auto log in!
   
    if (isset($_GET['usn']) && !empty($_GET['usn']) and isset($_GET['pwd']) && !empty($_GET['pwd'])) {
        // Verify data
        $query_user = $mysqli->query("SELECT * FROM users WHERE userid='$_GET[usn]' AND password='$_GET[pwd]' AND inactive='1'") or die(mysql_error());
        $match  = $query_user->num_rows;
        
        if ($match > 0) {
            $query_update_user = $mysqli->query("UPDATE users SET inactive = '0' WHERE userid = '$_GET[usn]'") or die("Couldn't Update user table");
           
            $_SESSION['edit_message'] = "Account succesfully updated - Please log in";
            header("Location: ../../main/front/front.php");
        } else {
            $_SESSION['edit_message'] = "User not found in database - contact admin";
            header("Location: ../../main/front/front.php");
        }
    } else {
        $_SESSION['edit_message'] = "incorrect link - data missing - please contact admin";
        header("Location: ../../main/front/front.php");
    }
} else {
    // Make sure all fields were entered
    if (!$_POST['userid'] || !$_POST['password'] || !$_POST['password_again'] || !$_POST['email']) {
        $_SESSION['edit_message'] = "You didn't fill in a required field.";
        header("Location: ../../main/front/front.php?action=register");
    } else {
        // Spruce up username, check length
        $_POST['userid'] = trim($_POST['userid']);

        if (strlen($_POST['userid']) > 30) {
            $_SESSION['edit_message'] = "Sorry, the username is longer than 30 characters, please shorten it.";
            header("Location: ../../main/front/front.php?action=register");
        } else {
            // Check if username is already in use
            $user_name = $mysqli->real_escape_string($_POST['userid']);
            $query_rows = $mysqli->query("select userid from users where userid = '$user_name'");
            $number = $query_rows->num_rows;
            
            if ($number > 0) {
                $_SESSION['edit_message'] = "Sorry, the username is already taken, please pick another one";
                header("Location: ../../main/front/front.php?action=register");
            } else {
                // Check if both pwd fields are the same
                if ($_POST['password'] <> $_POST['password_again']) {
                    $_SESSION['edit_message'] = "The password fields do not correspond!";
                    header("Location: ../../main/front/front.php?action=register");
                } else {
                    //check if the email addres is valid
                    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                        $_SESSION['edit_message'] =  "Invalid email format";
                        header("Location: ../../main/front/front.php?action=register");
                    } else {
                        //check if the email already exists
                        $query_rows = $mysqli->query("select * from users where email = '$_POST[email]'");
                        $number = $query_rows->num_rows;
                        
                        if ($number > 0) {
                            $_SESSION['edit_message'] =  "Email address already exists in database!";
                            header("Location: ../../main/front/front.php?action=register");
                        } else {
                            //Add the new account to the database but make it inactive for now
                            $user_name = $mysqli->real_escape_string($_POST['userid']);
                            $md5pass = hash('md5', $_POST['password']); // The md5 hashed password.
                            $sha512 = hash('sha512', $_POST['password']); // The hashed password.
                            $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));//create random salt
                            $update_password = hash('sha512', $sha512 . $random_salt); // Create salted password
                            $timestamp = time();
             
                            $sdbquery = $mysqli->query("INSERT INTO users (userid, password, sha512_password, salt, email, permission, join_date, last_visit, user_website, user_fb, user_twitter, user_af, inactive) VALUES ('$user_name', '$md5pass', '$update_password', '$random_salt', '$email', 2, '$timestamp', '$timestamp', '$website', '$fb_profile', '$twitter_profile', '$af_profile', '1')") or die("Couldn't insert user into users table");
                            $new_user_id = $mysqli->insert_id;
                            
                            //Let's create an email for verification
                            // Create a url which we will direct them to reset their password
                            $pwrurl = $confirm_account_link.'&pwd='.$md5pass.'&usn='.$user_name;
                  
                            $mail = new PHPMailer;

                            $start = microtime(true);
                            $i     = 0;
                   
                            $mail->AddAddress($email);

                            // Create Email
                            
                            //We need to comment out this comment to have it to work from server, on localhost it runs with this command
                            //$mail->isSMTP(); // Set mailer to use SMTP
                            
                            
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

                            $mail->Subject = 'Atarilegend - Account confirmation';
                            
                            // Mail them their key
                            $mailbody = "Dear user,\n\nIf this e-mail does not apply to you please ignore it. Please activate your account at www.atarilegend.com\n\nby clicking the link below. If you cannot click it, please paste it into your web browser's address bar.\n\n" . $pwrurl . "\n\nThanks,\nTEAM AL";

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
                            
                            create_log_entry('Users', $new_user_id, 'User', $new_user_id, 'Insert', $new_user_id);
                            $_SESSION['edit_message'] = "An email was sent to you. Please follow the link to activate the account";
                            header("Location: ../../main/front/front.php");
                        }
                    }
                }
            }
        }
    }
}

//Send all smarty variables to the templates
$smarty->display("file:".$mainsite_template_folder."frontpage.html");

//close the connection
mysqli_close($mysqli);
