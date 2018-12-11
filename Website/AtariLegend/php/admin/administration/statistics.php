<?php
/***************************************************************************
 *                                statistics.php
 *                            -----------------------
 *   begin                : Friday, Oct 03, 2003
 *   copyright            : (C) 2003 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        :     Website images added,
 *
 *
 *
 *   Id: statistics.php,v 0.10 2003/10/03 23:00 Silver Surfer
 *  Update: 2015/05/29 23:38 ST Graveyard
 *          - Added logged on user details
 *          2015/12/21 19:29 ST Graveyard
 *          - Added right side quicksearch for 1920 width
 *          2017/04/15 00:46 ST Graveyard
 *          - Complete re-write with charts
 *
 ***************************************************************************/

include("../../config/common.php");
include("../../config/admin.php");

//load the search fields of the quick search side menu
include("../../admin/games/quick_search_games.php");

//load the stats tile
include("../../common/tiles/tile_stats.php");

//Lets get all the date of the selected user
$sql_users = $mysqli->query("SELECT * FROM users
                          WHERE user_id = '" . $_SESSION['user_id'] . "' ") or die("Couldn't query users Database");

while ($query_users = $sql_users->fetch_array(MYSQLI_BOTH)) {
    $smarty->assign('users', array(
        'user_id' => $query_users['user_id'],
        'user_name' => $query_users['userid'],
        'image' => "$user_avatar_path$query_users[user_id].$query_users[avatar_ext]"
    ));
}

foreach (KarmaGood() as $key => $value) {
    $smarty->append('karma_good', array(
        'karma' => $value[0],
        'user_name' => $value[1],
        'user_id' => $value[2]
    ));
}

foreach (KarmaBad() as $key => $value) {
    $smarty->append('karma_bad', array(
        'karma' => $value[0],
        'user_name' => $value[1],
        'user_id' => $value[2]
    ));
}

//******************************************//
//*Get the data for the good karma chart****//
//******************************************//

//* Karma 0 to 100
$result   = $mysqli->query("SELECT * FROM users WHERE karma > '0' and karma <= '100'")
    or die("error getting karma 0 - 100");
$karma = $result->num_rows;
$karma_good_value[0] = $karma;
$karma_good_label[0] = "<100";

//* Karma 100 to 500
$result   = $mysqli->query("SELECT * FROM users WHERE karma > '100' and karma <= '500'")
    or die("error getting karma 0 - 500");
$karma = $result->num_rows;
$karma_good_value[1] = $karma;
$karma_good_label[1] = "<500";

//* Karma 500 to 1000
$result   = $mysqli->query("SELECT * FROM users WHERE karma > '500' and karma <= '1000'")
    or die("error getting karma 500 - 2000");
$karma = $result->num_rows;
$karma_good_value[2] = $karma;
$karma_good_label[2] = "<1000";

//* Karma 1000 to 2000
$result   = $mysqli->query("SELECT * FROM users WHERE karma > '1000' and karma <= '2000'")
    or die("error getting karma 500 - 2000");
$karma = $result->num_rows;
$karma_good_value[3] = $karma;
$karma_good_label[3] = "<2000";

//* Karma > 2000
$result   = $mysqli->query("SELECT * FROM users WHERE karma > '2000'")
    or die("error getting karma > 2000");
$karma = $result->num_rows;
$karma_good_value[4] = $karma;
$karma_good_label[4] = ">2000";

$smarty->assign('karma_good_value', json_encode($karma_good_value));
$smarty->assign('karma_good_label', json_encode($karma_good_label));

//******************************************//
//*Get the data for the bad karma chart****//
//******************************************//

//* Karma 0 to -100
$result   = $mysqli->query("SELECT * FROM users WHERE karma <= '0' and karma >= '-100'")
    or die("error getting karma 0 -100");
$karma = $result->num_rows;
$karma_bad_value[0] = $karma;
$karma_bad_label[0] = ">-100";

//* Karma -100 to -500
$result   = $mysqli->query("SELECT * FROM users WHERE karma < '-100' and karma >= '-500'")
    or die("error getting karma -100 -500");
$karma = $result->num_rows;
$karma_bad_value[1] = $karma;
$karma_bad_label[1] = ">-500";

//* Karma -500 to -1000
$result   = $mysqli->query("SELECT * FROM users WHERE karma < '-500' and karma >= '-1000'")
    or die("error getting karma -500 -2000");
$karma = $result->num_rows;
$karma_bad_value[2] = $karma;
$karma_bad_label[2] = ">-1000";

//* Karma -1000 to -2000
$result   = $mysqli->query("SELECT * FROM users WHERE karma < '-1000' and karma >= '-2000'")
    or die("error getting karma -500 -2000");
$karma = $result->num_rows;
$karma_bad_value[3] = $karma;
$karma_bad_label[3] = ">-2000";

//* Karma < 2000
$result   = $mysqli->query("SELECT * FROM users WHERE karma < '-2000'") or die("error getting karma > 2000");
$karma = $result->num_rows;
$karma_bad_value[4] = $karma;
$karma_bad_label[4] = "<-2000";

$smarty->assign('karma_bad_value', json_encode($karma_bad_value));
$smarty->assign('karma_bad_label', json_encode($karma_bad_label));

$karma_border[0] = "#000000";
$karma_border_width[0] = "1";
$karma_bg[0] = "#c2c2c2";
$karma_hover[0] = "#c2c2c2";

$karma_border[1] = "#000000";
$karma_border_width[1] = "1";
$karma_bg[1] = "#8b8b8b";
$karma_hover[1] = "#8b8b8b";

$karma_border[2] = "#000000";
$karma_border_width[2] = "1";
$karma_bg[2] = "#646464";
$karma_hover[2] = "#646464";

$karma_border[3] = "#000000";
$karma_border_width[3] = "1";
$karma_bg[3] = "#3d3d3d";
$karma_hover[3] = "#3d3d3d";

$karma_border[4] = "#000000";
$karma_border_width[4] = "1";
$karma_bg[4] = "#151515";
$karma_hover[4] = "#151515";

$smarty->assign('karma_bg', json_encode($karma_bg));
$smarty->assign('karma_hover', json_encode($karma_hover));
$smarty->assign('karma_border', json_encode($karma_border));
$smarty->assign('karma_border_width', json_encode($karma_border_width));

//**************************************
// Changes per Section
//**************************************
//* Changelog - Games
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'Games'")
    or die("error getting games from change_log");
$change_log = $result->num_rows;
$change_log_data[0] = $change_log;
$change_log_label[0] = "Games";

//* Changelog - Users
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'Users'")
    or die("error getting Users from change_log");
$change_log = $result->num_rows;
$change_log_data[1] = $change_log;
$change_log_label[1] = "Users";

//* Changelog - Links
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'Links'")
    or die("error getting Links from change_log");
$change_log = $result->num_rows;
$change_log_data[2] = $change_log;
$change_log_label[2] = "Links";

//* Changelog - Individuals
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'Individuals'")
    or die("error getting Individuals from change_log");
$change_log = $result->num_rows;
$change_log_data[3] = $change_log;
$change_log_label[3] = "Individuals";

//* Changelog - News
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'News'")
    or die("error getting News from change_log");
$change_log = $result->num_rows;
$change_log_data[4] = $change_log;
$change_log_label[4] = "News";

//* Changelog - Crew
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'Crew'")
    or die("error getting Crew from change_log");
$change_log = $result->num_rows;
$change_log_data[5] = $change_log;
$change_log_label[5] = "Crew";

//* Changelog - Menu disk
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'Menu disk'")
    or die("error getting Menu disk from change_log");
$change_log = $result->num_rows;
$change_log_data[6] = $change_log;
$change_log_label[6] = "Menu disk";

//* Changelog - Downloads
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'Downloads'")
    or die("error getting Downloads from change_log");
$change_log = $result->num_rows;
$change_log_data[7] = $change_log;
$change_log_label[7] = "Downloads";

//* Changelog - Articles
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'Articles'")
    or die("error getting Articles from change_log");
$change_log = $result->num_rows;
$change_log_data[8] = $change_log;
$change_log_label[8] = "Articles";

$smarty->assign('change_log_data', json_encode($change_log_data));
$smarty->assign('change_log_label', json_encode($change_log_label));

//**************************************
// nr of changes in the past 12 months
//**************************************

$current_month = date("m") + 3;
$last_month = date("m") + 2;
$last_year = date("Y") - 1;
$current_year = date("Y") - 1;
$current_day = 01;
$months = array(1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',
    6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec');
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

for ($k = 1; $k <= 12; $k++) {
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

    $result_monthly   = $mysqli->query("SELECT * FROM change_log
        WHERE timestamp >= $date_low and timestamp < $date_high") or die("error getting change_log data");
    $change_log_monthly = $result_monthly->num_rows;
    $change_log_monthly_data[$i] = $change_log_monthly;
    $change_log_monthly_label[$i] = $months[(int) $last_month];
    $change_log_monthly_label[$i] .= ' ';
    $change_log_monthly_label[$i] .= $last_year;
    $change_log_bg[$i] = "#c2c2c2";
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

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "start_page.html");
