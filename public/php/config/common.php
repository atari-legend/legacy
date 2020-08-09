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

require_once __DIR__ . "/../vendor/autoload.php";
include("../../config/connect.php");
include("../../config/config.php");
include("../../lib/user_functions.php");
include("../../lib/functions.php");
include("../../lib/karma.php");
include("../../lib/who_is_online.php");

// Define default email config that will get overwritten
// in email_settings.php
$email_mailer = 'mail';
$smtp_host = '';
$smtp_username = '';
$smtp_password = '';
$smtp_port = -1;
$smtp_auth = false;
$smtp_secure = '';

// email_settings.php may not exist (to use the default settings)
// So suppress errors with @
@include("../../config/email_settings.php");

if (file_exists("../../config/database_upgrade.php")==true) {
    exit("Upgrade mode");
}

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
