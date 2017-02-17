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
        'permission' => $_SESSION['permission']
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
?>
