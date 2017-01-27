<?php
/***************************************************************************
 *                                interviews_main.php
 *                            ------------------------------
 *   begin                : Thursday, July 21, 2005
 *   copyright            : (C) 2003 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : Start of creation file
 *
 *   Id: interviews_main.php,v 0.10 21/07/2005 22:17 Gatekeeper
 *   Id: interviews_main.php,v 0.20 02/08/2016 22:34 Gatekeeper
 *   - AL 2.0
 *
 ***************************************************************************/

//****************************************************************************************
// The main interview page
//****************************************************************************************

include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

//Get list of all individuals
$sql_individuals = $mysqli->query("SELECT * FROM individuals ORDER BY ind_name ASC") or die("Couldn't query indiciduals database");

while ($individuals = $sql_individuals->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('individuals', array(
        'ind_id' => $individuals['ind_id'],
        'ind_name' => $individuals['ind_name']
    ));
}

//Get list of individuals who have been interviewed
$sql_individuals2 = $mysqli->query("SELECT * FROM interview_main
                LEFT JOIN individuals ON (interview_main.ind_id = individuals.ind_id)
                ORDER BY individuals.ind_name ASC") or die("Couldn't query indiciduals database");

while ($individuals2 = $sql_individuals2->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('individuals_interviewed', array(
        'ind_id' => $individuals2['ind_id'],
        'ind_name' => $individuals2['ind_name']
    ));
}


if (isset($action) and $action == 'search') {
    if ($individual_search == " " or $individual_search == '-') {
        //show all
        $sql_interview = $mysqli->query("SELECT * FROM interview_main
                  LEFT JOIN interview_text on (interview_main.interview_id = interview_text.interview_id)
                  LEFT JOIN users on ( interview_main.user_id = users.user_id )
                  LEFT JOIN individuals on ( interview_main.ind_id = individuals.ind_id )
                  LEFT JOIN individual_text on (interview_main.ind_id = individual_text.ind_id)
                  ORDER BY individuals.ind_name ASC") or die("Couldn't query database for interviews");
    } else {
        $sql_interview = $mysqli->query("SELECT * FROM interview_main
                  LEFT JOIN interview_text on (interview_main.interview_id = interview_text.interview_id)
                  LEFT JOIN users on ( interview_main.user_id = users.user_id )
                  LEFT JOIN individuals on ( interview_main.ind_id = individuals.ind_id )
                  LEFT JOIN individual_text on (interview_main.ind_id = individual_text.ind_id)
                  WHERE individuals.ind_id = '$individual_search'
                  ORDER BY individuals.ind_name ASC") or die("Couldn't query database for interviews");
    }

    //get the number of interviews in the archive
    $v_interviews = $sql_interview->num_rows;
    $message      = 'Your search query resulted in ';
    $message .= $v_interviews;
    $message .= ' hits';
    $smarty->assign("message", $message);

    while ($interview = $sql_interview->fetch_array(MYSQLI_BOTH)) {
        //The interviewed person's picture
        if ($interview['ind_imgext'] == 'png' or $interview['ind_imgext'] == 'jpg' or $interview['ind_imgext'] == 'gif') {
            $v_ind_image = $individual_screenshot_path;
            $v_ind_image .= $interview['ind_id'];
            $v_ind_image .= '.';
            $v_ind_image .= $interview['ind_imgext'];
        } else {
            $v_ind_image = "none";
        }

        $interview_date = date("F j, Y", $interview['interview_date']);
        $interview_text = $interview['interview_intro'];
        $interview_text = nl2br($interview_text);
        $interview_text = InsertALCode($interview_text);
        $interview_text = InsertSmillies($interview_text);
        $interview_name = rawurlencode($interview['ind_name']);

        $smarty->append('interview', array(
            'user_id' => $interview['userid'],
            'user_email' => $interview['email'],
            'interview_id' => $interview['interview_id'],
            'ind_id' => $interview['ind_id'],
            'ind_name' => $interview['ind_name'],
            'email_name' => $interview_name,
            'ind_photo' => $v_ind_image,
            'interview_date' => $interview_date,
            'interview_text' => $interview_text
        ));
    }
}

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "interviews_main.html");

//close the connection
mysqli_close($mysqli);
