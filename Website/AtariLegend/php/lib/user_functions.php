<?php
/*******************************************************************************
 *                                user_functions.php
 *                            -----------------------
 *   begin                : 2015-04-28
 *   copyright            : (C) 2015 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *
 *   Id: user_functions.php,v 0.10 2015-04-28
 *
 ********************************************************************************

 *********************************************************************************
 * User management functions
 *********************************************************************************/

function sec_session_start() {
    $session_name = 'sec_session_id'; // Set a custom session name
    $secure       = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly     = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === false) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start(); // Start the PHP session
    session_regenerate_id(true); // regenerated the session, delete the old one.
}

function md5_test($userid, $md5_password, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible.
    if ($stmt = $mysqli->prepare("SELECT user_id, userid, password
        FROM users
       WHERE userid = ? AND sha512_password IS NULL AND password IS NOT NULL
        LIMIT 1")) {
        $stmt->bind_param('s', $userid); // Bind "$userid" to parameter.
        $stmt->execute(); // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id, $userid, $db_md5_password);
        $stmt->fetch();

        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts

            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked
                // Send an email to user saying their account is locked
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted.
                if ($db_md5_password == $md5_password) {
                    // Password is correct!
                    // Insert the new user into the database
                    // Create a random salt
                    $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));

                    // Create salted password
                    $update_password = hash('sha512', $password . $random_salt);

                    if ($update_stmt = $mysqli->prepare("UPDATE users SET password=NULL, sha512_password=?, salt=? WHERE user_id=?")) {
                        $update_stmt->bind_param('sss', $update_password, $random_salt, $user_id);
                        // Execute the prepared query.
                        if (!$update_stmt->execute()) {
                            header('Location: ../error.php?err=md5 failure: UPDATE');
                        }
                    }
                    // Login successful.
                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $mysqli->query("INSERT INTO users_login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    }
}

function login($userid, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible.
    if ($stmt = $mysqli->prepare("SELECT user_id, userid, sha512_password, salt, permission, avatar_ext, inactive
        FROM users
       WHERE userid = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $userid); // Bind "$userid" to parameter.
        $stmt->execute(); // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id, $userid, $db_password, $salt, $permission, $avatar_ext, $inactive);
        $stmt->fetch();
        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts
            //if (checkbrute($user_id, $mysqli) == true) {
            //    // Account is locked
            //    $_SESSION['edit_message'] = "Your account is locked because of too many failed attempts";
            //    header("Location: ../../main/front/front.php");
            //} else {
            // Check if the password in the database matches
            // the password the user submitted.
            if ($db_password == $password and $inactive == 0) {
                // Password is correct!
                // Get the user-agent string of the user.
                $user_browser             = $_SERVER['HTTP_USER_AGENT'];
                // XSS protection as we might print this value
                $user_id                  = preg_replace("/[^0-9]+/", "", $user_id);
                $_SESSION['user_id']      = $user_id;
                // XSS protection as we might print this value
                $userid                   = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $userid);
                $_SESSION['userid']       = $userid;
                $_SESSION['permission']   = $permission;
                $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                $_SESSION['image']        = $avatar_ext;
                // Login successful.
                return true;
            } else {
                // Password is not correct
                // We record this attempt in the database
                $now = time();
                $mysqli->query("INSERT INTO users_login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                return false;
            }
            // }
        } else {
            // No user exists.
            return false;
        }
    }
}


function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time
    $now = time();

    // All login attempts are counted from the past 2 hours.
    $valid_attempts = $now - (2 * 60 * 60);

    if ($stmt = $mysqli->prepare("SELECT time
                             FROM users_login_attempts
                             WHERE user_id = ?
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);

        // Execute the prepared query.
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 5 failed logins
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}

function login_check($mysqli) {

    //check for cookie
    //I can't do the extra pwd check sadly enough as I don't seem to have the know how.
    if (isset($_COOKIE['cooksession'])) {
        $session_id = $_COOKIE['cooksession'];

        //get the username and password
        $query_user = $mysqli->query("SELECT * FROM users WHERE session = '$session_id'");

        $v_rows = $query_user->num_rows;

        if ($v_rows > 0) {
            $user = $query_user->fetch_array(MYSQLI_BOTH);

            $_SESSION['userid'] = $user['userid'];
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['permission'] = $user['permission'];
            $_SESSION['image'] = $user['avatar_ext'];

            // update last visit
            $now = time();
            if ($update_stmt = $mysqli->prepare("UPDATE users SET last_visit=? WHERE user_id=?")) {
                $update_stmt->bind_param('ss', $now, $_SESSION['user_id']);
                // Execute the prepared query.
                if (!$update_stmt->execute()) {
                    header('Location: ../error.php?err=time failure: UPDATE');
                }
            }
            return true;
        } else {
            return false;
        }
    } else {
        // Check if all session variables are set
        if (isset($_SESSION['user_id'], $_SESSION['userid'], $_SESSION['login_string'], $_SESSION['permission'])) {
            $user_id      = $_SESSION['user_id'];
            $login_string = $_SESSION['login_string'];
            $userid       = $_SESSION['userid'];
            $permission   = $_SESSION['permission'];

            // Get the user-agent string of the user.
            $user_browser = $_SERVER['HTTP_USER_AGENT'];

            if ($stmt = $mysqli->prepare("SELECT sha512_password
                                          FROM users
                                          WHERE user_id = ? LIMIT 1")) {
                // Bind "$user_id" to parameter.
                $stmt->bind_param('i', $user_id);
                $stmt->execute(); // Execute the prepared query.
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    // If the user exists get variables from result.
                    $stmt->bind_result($password);
                    $stmt->fetch();
                    $login_check = hash('sha512', $password . $user_browser);

                    if ($login_check == $login_string) {
                        // Logged In!!!!
                        // update last visit
                        $now = time();
                        if ($update_stmt = $mysqli->prepare("UPDATE users SET last_visit=? WHERE user_id=?")) {
                            $update_stmt->bind_param('ss', $now, $user_id);
                            // Execute the prepared query.
                            if (!$update_stmt->execute()) {
                                header('Location: ../error.php?err=time failure: UPDATE');
                            }
                        }
                        return true;
                    } else {
                        // Not logged in
                        return false;
                    }
                } else {
                    // Not logged in
                    return false;
                }
            } else {
                // Not logged in
                return false;
            }
        } else {
            // Not logged in
            return false;
        }
    }
}

function esc_url($url) {
    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array(
        '%0d',
        '%0a',
        '%0D',
        '%0A'
    );
    $url   = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}
