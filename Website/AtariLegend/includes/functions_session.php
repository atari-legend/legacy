<?php
/***************************************************************************
*                                functions_session.php
*                            --------------------------
*   begin                : Monday, 26 January, 2004
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : Start of file
*						   						  
*						   
*
*   Id: functions_session.php,v 0.10 2004/02/14 00:55 silver
*
***************************************************************************/

/**
 * Returns true if the username has been taken
 * by another user, false otherwise.
 */
function usernameTaken($username)
{
   if(!get_magic_quotes_gpc()){
      $username = addslashes($username);
   }
   $query_rows = mysql_query("select userid from users where userid = '$username'");
   return (mysql_numrows($query_rows) > 0);
}

/**
 * Inserts the given (username, password) pair
 * into the database. Returns true on success,
 * false otherwise.
 */
function addNewUser($username, $password, $email)
{
   $timestamp = time();
   
   $query_insert = "INSERT INTO users (userid, password, email, join_date, permission, last_visit) VALUES ('$username', '$password', '$email', '$timestamp', 2, '$timestamp')";
   return mysql_query($query_insert);
}

/**
 * Checks whether or not the given username is in the
 * database, if so it checks if the given password is
 * the same password in the database for that user.
 * If the user doesn't exist or if the passwords don't
 * match up, it returns an error code (1 or 2). 
 * On success it returns 0.
 */
function confirmUser($username, $password){
   /* Add slashes if necessary (for query) */
   if(!get_magic_quotes_gpc()) {
	$username = addslashes($username);
   }

   /* Verify that user is in database */
   $query_user = mysql_query("select password from users where userid = '$username'");
   if(!$query_user || (mysql_numrows($query_user) < 1)){
      return 1; //Indicates username failure
   }

   /* Retrieve password from result, strip slashes */
   $sql_user = mysql_fetch_array($query_user);
   $sql_user['password']  = stripslashes($sql_user['password']);
   $password = stripslashes($password);

   /* Validate that password is correct */
   if($password == $sql_user['password']){
      return 0; //Success! Username and password confirmed
   }
   else{
      return 2; //Indicates password failure
   }
}

/**
 * checkLogin - Checks if the user has already previously
 * logged in, and a session with the user has already been
 * established. Also checks to see if user has been remembered.
 * If so, the database is queried to make sure of the user's 
 * authenticity. Returns true if the user has logged in.
 */
function checkLogin(){
   /* Check if user has been remembered */
    if(isset($_COOKIE['cooksession'])){
   	  $session_id = $_COOKIE['cooksession'];
	  
	  //get the username and password
   	  $query_user = mysql_query("SELECT * FROM users WHERE session = '$session_id'");
	  $sql_user = mysql_fetch_array($query_user);
      
	  //Store the username and password in the session
	  $_SESSION['password'] = $sql_user["password"];
	  $_SESSION['user_id'] = $sql_user["user_id"];
	  $_SESSION['username'] = $sql_user["userid"];
	  $_SESSION['permission'] = $sql_user["permission"];
   }

   /* Username and password have been set */
   if(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['permission'])){
      /* Confirm that username and password are valid */
      if(confirmUser($_SESSION['username'], $_SESSION['password']) != 0){
         /* Variables are incorrect, user not logged in */
         unset($_SESSION['username']);
         unset($_SESSION['password']);
		 unset($_SESSION['permission']);
         return false;
      }
	  /* Update the database with the last visit date */	
	  $user = $_SESSION['username'];
	  $pwd = $_SESSION['password'];
	  $timestamp = time();
	  $sdbquery = mysql_query("UPDATE users SET last_visit = '$timestamp' WHERE userid = '$user' AND password = '$pwd'");   
      return true;
   }
   /* User not logged in */
   else{
      return false;
   }
}




?>