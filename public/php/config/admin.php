<?php
/***************************************************************************
*                                admin.php
*                            --------------------------
*   copyright            : (C) 2015 Atari Legend
*   email                : silversurfer@atari-forum.com
*
*
***************************************************************************/

//Include this file if you want a page to require admin permission level
//Needs to be included after common.php is included.

//this include is a shortcut. I wanted to visitors also to be able to do bugreports at cpanel level.
//But I did not want to include this file in every single page, so I placed the include here.
include("../../common/tiles/tile_bug_report.php");

// This is the actual authorization check

// We allow scripts running on the command line to run so that we can run the
// DB upgrade script when we auto-deploy on DEV
if (php_sapi_name() !== "cli" && login_check($mysqli) == false) {
    $_SESSION['edit_message'] = "Please log in to use this functionality";
    header('Location:../../main/front/front.php');
}
