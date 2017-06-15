<?php
/*******************************************************************************
 *                                common.php
 *                            -----------------------
 *   begin                : Tuesday, february 11, 2004
 *   copyright            : (C) 2003 Atari Legend
 *   email                : maarten.martens@freebel.net
 *
 *   Id: common.php,v 0.10 2015/08/20 00:02 ST Graveyard
 *
 ********************************************************************************

 *********************************************************************************
 *In here we call all common includes and variables ... We also check on sessions!
 *********************************************************************************/

extract($_REQUEST);

include("../../config/connect.php");
include("../../../php/vendor/smarty/smarty/libs/Smarty.class.php");
include("../../config/config.php");
include("../../lib/user_functions.php");
include("../../lib/functions.php");
include("../../lib/karma.php");

if (file_exists("../../config/database_upgrade.php")==true) { exit("Upgrade mode");}

//Check if the user is logged on to the site
sec_session_start();

if (login_check($mysqli) == true) {
    $smarty->assign('user_session', array(
        'userid' => $_SESSION['userid'],
        'user_id' => $_SESSION['user_id'],
        'permission' => $_SESSION['permission'],
        'extension' => $_SESSION['image'],
        'image' => "$user_avatar_path$_SESSION[user_id].$_SESSION[image]"
    )); 
}


//We have the last logon time of each user in the user table. We need to compare this with the current time - 1 minute. 
//So if the last log on time of the user is bigger than the current time - 1 minute, we can asume the user is online.
$five_minutes = time()-(60*1); 
$nr_users = 0;
$nr_users_24 = 0;

//Lets get all the data of the user who are online
$sql_users = $mysqli->query("SELECT * FROM users
                              WHERE last_visit > '$five_minutes'") or die("Couldn't query users Database 1 min");

while ($query_users = $sql_users->fetch_array(MYSQLI_BOTH)) {
    $nr_users = $nr_users + 1; 
    
    $smarty->append('users_online', array(
        'user_id' => $query_users['user_id'],
        'user_name' => $query_users['userid']
    ));
}

$smarty->assign('nr_users', $nr_users);

//Now let's check who was online in the last 24 hours
$twentyfour_hours = time()-(60*1440); 

//Lets get all the data of the user who were online
$sql_users = $mysqli->query("SELECT * FROM users
                              WHERE last_visit > '$twentyfour_hours'") or die("Couldn't query users Database 24h");

while ($query_users = $sql_users->fetch_array(MYSQLI_BOTH)) {
    $nr_users_24 = $nr_users_24 + 1; 
    
    $smarty->append('users_24h', array(
        'user_id' => $query_users['user_id'],
        'user_name' => $query_users['userid']
    ));
}

$smarty->assign('nr_users_24', $nr_users_24);

include("../../config/template_config.php");

//transfer edit messages to template
if (isset($_SESSION['edit_message'])) {
    $smarty->assign('edit_message', $_SESSION['edit_message']);
    unset($_SESSION['edit_message']);
}

if (SITESTATUS == "offline") {
    if ($_SESSION['permission'] !== "1") {
        header("Location: " . SITEURL . "blank.php");
    }
}
?>
