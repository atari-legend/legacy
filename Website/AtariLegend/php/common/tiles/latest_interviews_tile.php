<?php
/***************************************************************************
*                                latest_interviews_tile.php
*                            -------------------------------
*   begin                : Monday, August 21, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id: latest_interviews_tile.php,v 0.1 2017/08/21 00:42 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php code for the latest interviews tile
//*********************************************************************************************

//Get the latest interviews
$sql_interview = $mysqli->query("SELECT *
    FROM interview_main
    LEFT JOIN interview_text on (interview_main.interview_id = interview_text.interview_id)
    LEFT JOIN users on (interview_main.user_id = users.user_id)
    LEFT JOIN individuals on (interview_main.ind_id = individuals.ind_id)
    LEFT JOIN individual_text on (interview_main.ind_id = individual_text.ind_id)
    ORDER BY interview_text.interview_date DESC LIMIT 5") or die("couldn't get 5 latest interviews");

while ($sql_recent_interviews = $sql_interview->fetch_array(MYSQLI_BOTH)) {
    $v_interview_date = date("F j, Y", $sql_recent_interviews['interview_date']);

    $interview_text = $sql_recent_interviews['interview_intro'];
    $interview_text = nl2br($interview_text);
    $interview_text = InsertALCode($interview_text);

    //convert the date to readible format
    $v_interview_date = date("F j, Y", $sql_recent_interviews['interview_date']);

    $smarty->append(

        'recent_interviews',
        array( 'individual_name' => $sql_recent_interviews['ind_name'],
                'individual_id' => $sql_recent_interviews['ind_id'],
                'interview_author' => $sql_recent_interviews['userid'],
                'interview_author_id' => $sql_recent_interviews['user_id'],
                'interview_email' => $sql_recent_interviews['email'],
                'interview_id' => $sql_recent_interviews['interview_id'],
                'interview_date' => $v_interview_date,
                'interview_intro' => $interview_text)
    );
}
