<?php
/***************************************************************************
*                                changes_per_month_tile.php
*                            ----------------------------
*   begin                : Thursday, May 11, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id:   changes_year_tile.php,v 0.1 2017/05/11 20:43 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php code tile which shows the changes per month of the last year
//*********************************************************************************************

//**************************************
// nr of changes in the past 12 months
//**************************************
$current_month = date("m") + 3;
$last_month = date("m") + 2;
$last_year = date("Y") - 1;
$current_year = date("Y") - 1;
$current_day = 01;
$months = array(1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec');
$i = 0;

if ($current_month == 13) {
    $current_month = 1;
    $current_year = $current_year + 1;
}

if ($last_month == 13) {
    $last_month = 1;
    $last_year = $last_year + 1;
}

if ($current_month == 14) {
    $current_month = 2;
    $current_year = $current_year + 1;
}

if ($last_month == 14) {
    $last_month = 2;
    $last_year = $last_year + 1;
}

if ($current_month == 15) {
    $current_month = 3;
    $current_year = $current_year + 1;
}

for ($k = 1 ; $k <= 12; $k++) {
    if ($current_month == 13) {
        $current_month = 1;
        $current_year = $current_year + 1;
    }

    if ($last_month == 13) {
        $last_month = 1;
        $last_year = $last_year + 1;
    }

    $date_high = date_to_timestamp($current_year, $current_month, $current_day);
    $date_low = date_to_timestamp($last_year, $last_month, $current_day);

    $result_monthly   = $mysqli->query("SELECT * FROM change_log WHERE timestamp >= $date_low and timestamp < $date_high") or die("error getting change_log data");
    $change_log_monthly = $result_monthly->num_rows;
    $change_log_monthly_data[$i] = $change_log_monthly;
    $change_log_monthly_label[$i] = $months[(int) $last_month];
    $change_log_monthly_label[$i] .= ' ';
    $change_log_monthly_label[$i] .= $last_year;

    if ($i % 2 == 0) {
        $change_log_bg[$i] = "#c2c2c2";
    } else {
        $change_log_bg[$i] = "#666666";
    }
    $change_log_border_width[$i] = "1";
    $change_log_border[$i] = "#000000";

    $last_month = $last_month + 1;
    $current_month = $current_month + 1;
    $i = $i + 1;
}

$smarty->assign('change_log_monthly_data', json_encode($change_log_monthly_data));
$smarty->assign('change_log_monthly_label', json_encode($change_log_monthly_label));

$smarty->assign('change_log_bg', json_encode($change_log_bg));
$smarty->assign('change_log_border_width', json_encode($change_log_border_width));
$smarty->assign('change_log_border', json_encode($change_log_border));
