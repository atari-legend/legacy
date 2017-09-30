<?php
/***************************************************************************
 *                                interviews_main.php
*                            ------------------------------
*   begin                : Monday, August 21, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*
*   Id: interviews_main.php,v 0.1 2017/08/21 23:22 STG
****************************************************************************/

//****************************************************************************************
// This is the main page of the interviews. 
//****************************************************************************************

//load all common functions
include("../../config/common.php");

//load the tiles
include("../../common/tiles/screenstar.php");
include("../../common/tiles/did_you_know_tile.php");
include("../../common/tiles/latest_comments_tile.php");
include("../../common/tiles/tile_bug_report.php");

//***********************************************************************************
//Let's get all the interview and author data
//***********************************************************************************
$v_counter = (isset($_GET["v_counter"]) ? $_GET["v_counter"] : 0);

// count number of interviews
$query_number = $mysqli->query("SELECT * FROM interview_main") or die("Couldn't get the number of interviews - count");
$v_rows = $query_number->num_rows;

//main query
$sql_interview = $mysqli->query("SELECT *
                        FROM interview_main
                        LEFT JOIN interview_text on (interview_main.interview_id = interview_text.interview_id)
                        LEFT JOIN users on (interview_main.user_id = users.user_id)
                        LEFT JOIN individuals on (interview_main.ind_id = individuals.ind_id)
                        LEFT JOIN individual_text on (interview_main.ind_id = individual_text.ind_id)
                        ORDER BY interview_text.interview_date DESC LIMIT  " . $v_counter . ", 5") or die("Error - Couldn't query interview data");

while ($query_interview = $sql_interview->fetch_array(MYSQLI_BOTH))
{	  
    $v_interview_date = date("F j, Y", $query_interview['interview_date']);

    $interview_text = $query_interview['interview_intro'];
    $interview_text = nl2br($interview_text);
    $interview_text = InsertALCode($interview_text);

    $interview_chapters = $query_interview['interview_chapters'];
    $interview_chapters = nl2br($interview_chapters);
    $interview_chapters = InsertALCode($interview_chapters);

    //get the profile of the author
    if(preg_match("/[a-z]/i", $query_interview['ind_profile'])){
        $profile = $query_interview['ind_profile'];
    }
    else {$profile = 'none';}

    //The interviewed person's picture
    if ($query_interview['ind_imgext'] == 'png' or $query_interview['ind_imgext'] == 'jpg' or $query_interview['ind_imgext'] == 'gif') {
        $v_ind_image = $individual_screenshot_path;
        $v_ind_image .= $query_interview['ind_id'];
        $v_ind_image .= '.';
        $v_ind_image .= $query_interview['ind_imgext'];
    } else {
        $v_ind_image = "none";
    }

    $smarty->append('interviews', array(
        'individual_name' => $query_interview['ind_name'],
        'individual_id' => $query_interview['ind_id'],
        'individual_profile' => $profile,
        'interview_author' => $query_interview['userid'],
        'interview_author_id' => $query_interview['user_id'],
        'interview_id' => $query_interview['interview_id'],
        'email' => $query_interview['email'],
        'user_fb' => $query_interview['user_fb'],
        'user_website' => $query_interview['user_website'],
        'user_twitter' => $query_interview['user_twitter'],
        'user_af' => $query_interview['user_af'],
        'interview_date' => $v_interview_date,
        'interview_img' => $v_ind_image,
        'interview_intro' => $interview_text
    ));
}

$smarty->assign('nr_interviews',$v_rows);

//Check if back arrow is needed
if ($v_counter > 0) {
    // Build the link
    $v_linkback = ('?v_counter=' . ($v_counter - 5));
}

//Check if we need to place a next arrow
if ($v_rows > ($v_counter + 5)) {
    //Build the link
    $v_linknext = ('?v_counter=' . ($v_counter + 5));
}

if (empty($c_counter)) {
    $c_counter = "";
}
if (empty($v_linkback)) {
    $v_linkback = "";
}
if (empty($v_linknext)) {
    $v_linknext = "";
}

$smarty->assign('links', array(
    'linkback' => $v_linkback,
    'linknext' => $v_linknext,
    'v_counter' => $v_counter,
    'c_counter' => $c_counter
));


//Send all smarty variables to the templates
$smarty->display("file:" . $mainsite_template_folder . "interviews_main.html");

//close the connection
mysqli_close($mysqli);
