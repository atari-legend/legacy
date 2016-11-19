<?php
/***************************************************************************
 *                                interviews_screenshots_add.php
 *                            -------------------------------------
 *   begin                : Saturday, July 30 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : created this page
 *
 *   Id:  interviews_screenshots_add.php,v 0.10 2005/07/30 23:07 Gatekeeper
 *   Id:  interviews_screenshots_add.php,v 0.20 2016/08/03 22:39 Gatekeeper
 *   - AL 2.0
 *
 ***************************************************************************/

//****************************************************************************************
// This is the image selection/upload screen for the interviews
//****************************************************************************************

include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php");

//Get the screenshots for this interview, if they exist
$sql_screenshots = $mysqli->query("SELECT * FROM screenshot_interview
                    LEFT JOIN screenshot_main ON (screenshot_interview.screenshot_id = screenshot_main.screenshot_id)
                WHERE screenshot_interview.interview_id = '$interview_id' ORDER BY screenshot_interview.screenshot_id") or die("Database error - selecting screenshots");

//get the number of screenshots in the archive
$v_screenshots = $sql_screenshots->num_rows;
$smarty->assign("screenshots_nr", $v_screenshots);

$count = 1;

while ($screenshots = $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
    // Get the image dimensions for the pop up window
    $imginfo    = getimagesize("$interview_screenshot_save_path$screenshots[screenshot_id].$screenshots[imgext]");
    $width      = $imginfo[0] + 20;
    $height     = $imginfo[1] + 25;
    $image_path = "$interview_screenshot_path$screenshots[screenshot_id].$screenshots[imgext]";

    $smarty->append('screenshots', array(
        'count' => $count,
        'width' => $width,
        'height' => $height,
        'image_path' => $image_path,
        'id' => $screenshots['screenshot_id']
    ));

    $count++;
}

//we need to get the data of the loaded interview
$sql_interview = $mysqli->query("SELECT * FROM interview_main
                  LEFT JOIN interview_text ON ( interview_main.interview_id = interview_text.interview_id )
                  LEFT JOIN individuals on ( interview_main.ind_id = individuals.ind_id )
                WHERE interview_main.interview_id = '$interview_id'") or die("Database error - selecting interview data");

while ($interview = $sql_interview->fetch_array(MYSQLI_BOTH)) {
    $smarty->assign('interview', array(
        'interview_id' => $interview_id,
        'interview_ind_name' => $interview['ind_name'],
        'interview_author' => $interview['user_id'],
        'interview_ind_id' => $interview['ind_id']
    ));
}

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "interviews_screenshots_add.html");

//close the connection
mysqli_close($mysqli);
