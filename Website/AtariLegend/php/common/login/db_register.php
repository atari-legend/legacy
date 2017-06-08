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

// Make sure all fields were entered
if(!$_POST['userid'] || !$_POST['password'] || !$_POST['password_again'] || !$_POST['email'])
{    
    $_SESSION['edit_message'] = "You didn't fill in a required field.";
    header("Location: ../../main/front/front.php?action=register");
}
else
{ 
    // Spruce up username, check length
    $_POST['userid'] = trim($_POST['userid']);

    if(strlen($_POST['userid']) > 30)
    {
        $_SESSION['edit_message'] = "Sorry, the username is longer than 30 characters, please shorten it.";
        header("Location: ../../main/front/front.php?action=register");
    }
    else
    {
        // Check if username is already in use
        $user_name = $mysqli->real_escape_string($_POST['userid']);
        $query_rows = $mysqli->query("select userid from users where userid = '$user_name'");
        $number = $query_rows->num_rows;
        
        if($number > 0)
        {
            $_SESSION['edit_message'] = "Sorry, the username is already taken, please pick another one";
            header("Location: ../../main/front/front.php?action=register");
        }
        else
        {
             // Check if both pwd fields are the same
            if ($_POST['password'] <> $_POST['password_again'])
            {
                $_SESSION['edit_message'] = "The password fields do not correspond!";
                header("Location: ../../main/front/front.php?action=register");

            }
            else
            {
                //check if the email addres is valid
                if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) 
                {
                    $_SESSION['edit_message'] =  "Invalid email format"; 
                    header("Location: ../../main/front/front.php?action=register");
                }
                else
                {
                    //check if the email already exists
                    $query_rows = $mysqli->query("select * from users where email = '$_POST[email]'");
                    $number = $query_rows->num_rows;
                    
                    if($number > 0)
                    {
                        $_SESSION['edit_message'] =  "Email address already exists in database!"; 
                        header("Location: ../../main/front/front.php?action=register");
                    }
                    else
                    {

                        //Add the new account to the database
                        $user_name = $mysqli->real_escape_string($_POST['userid']);
                        $md5pass = hash('md5',$_POST['password']); // The md5 hashed password.
                        $sha512 = hash('sha512',$_POST['password']); // The hashed password.
                        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));//create random salt
                        $update_password = hash('sha512', $sha512 . $random_salt); // Create salted password
                        $timestamp = time();
         
                        $sdbquery = $mysqli->query("INSERT INTO users (userid, password, sha512_password, salt, email, permission, join_date, last_visit, user_website, user_fb, user_twitter, user_af) VALUES ('$user_name', '$md5pass', '$update_password', '$random_salt', '$email', 2, '$timestamp', '$timestamp', '$website', '$fb_profile', '$twitter_profile', '$af_profile')") or die("Couldn't insert user into users table");
                        $new_user_id = $mysqli->insert_id;
                        
                        //Let's log in - fill the session vars
                        if (login($_POST['userid'], $sha512, $mysqli) == true) {   
                            create_log_entry('Users', $new_user_id, 'User', $new_user_id, 'Insert', $_SESSION['user_id']);
                            $_SESSION['edit_message'] = "Account succesfully created - You are logged in.";
                            header("Location: ../../main/front/front.php");
                        }
                        else
                        {
                            $_SESSION['edit_message'] = "Account succesfully created - Please log in";
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
mysqli_close($mysqli)
?>

