<?php
/***************************************************************************
 *                                link_addnew.php
 *                            -----------------------
 *   begin                : Monday, Aug 25, 2003
 *   copyright            : (C) 2003 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : file creation
 *
 *
 *   Id: link_addnew.php,v 0.10 2005/01/08 Silver Surfer
 *   Id: link_addnew.php,v 0.20 2015/09/07 ST Graveyard
 *   Id: link_addnew.php,v 0.30 2015/12/24 ST Graveyard - Add right side in 1920
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 In this section we can add a new link to the DB
 ***********************************************************************************
 */
include("../../config/common.php");
include("../../admin/games/quick_search_games.php");
include("../../config/admin.php");

$RESULT = $mysqli->query("SELECT * FROM website_category ORDER BY website_category_name");

while ($rowlinkcat = $RESULT->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('website_category', array(
        'website_category_id' => $rowlinkcat['website_category_id'],
        'website_category_name' => $rowlinkcat['website_category_name']
    ));
}

$smarty->assign("user_id", $_SESSION['user_id']);

//****************************************************************************************
// VALIDATE LINKS THAT HAVE SUBMITTED THROUGH THE FRONTPAGE
//****************************************************************************************

$result = $mysqli->query("SELECT * FROM website_validate LEFT JOIN users ON (website_validate.user_id = users.user_id)")
    or die("couldn't query website_validate");

if ($result->num_rows < 1) {
    $section   = "Validate links";
    $error_msg = "There are currently no new submitted links in the database to be validated.";

    $smarty->assign('error_msg', array(
        'section' => $section,
        'message' => $error_msg
    ));
} else {
    while ($valrow = $result->fetch_array(MYSQLI_BOTH)) {
        $link_sub = $mysqli->query("SELECT user_id FROM website WHERE user_id='$valrow[user_id]'")->num_rows;

        $website_date = date("F j, Y", $valrow['website_date']);
        $user_name    = get_username_from_id($valrow['user_id']);

        $smarty->append('validate', array(
            'website_id' => $valrow['website_id'],
            'website_name' => $valrow['website_name'],
            'website_url' => $valrow['website_url'],
            'website_date' => $website_date,
            'website_category' => $valrow['website_category'],
            'website_description' => $valrow['website_description'],
            'user_email' => $valrow['email'],
            'link_sub' => $link_sub,
            'user_id' => $valrow['user_id'],
            'user_name' => $user_name
        ));
    }
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "links/link_addnew.html");
