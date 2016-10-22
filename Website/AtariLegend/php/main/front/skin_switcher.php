<?php
/***************************************************************************
 *                                skin_switcher.php
 *                            --------------------------
 *   copyright            : (C) 2015 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *
 *
 ***************************************************************************/

//Skin Switching functions

extract($_REQUEST);

include("../../includes/connect.php");
include("../../../php/includes/smarty/libs/Smarty.class.php");
include("../../includes/config.php");
include("../../includes/user_functions.php");
include("../../includes/functions.php");
include("../../includes/karma.php");

//Check if the user is logged on to the site
sec_session_start();

//create skin switch links dynamically with called page
//using the filter command, this should be a safe way of using PHP_SELF

//Let's see if the user has choosen a skin and set the skin in session
if (isset($action) and $action == "skinswitch") {
    if (isset($skin)) {
        $_SESSION['skin'] = $skin;
    }
}
?>
