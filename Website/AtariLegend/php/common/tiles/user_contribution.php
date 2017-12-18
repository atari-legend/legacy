<?php
/***************************************************************************
*                               user_contribution.php
*                            ---------------------------
*   begin                : Sunday, may 28, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id: user_contribution.php,v 0.1 2017/05/28 23:55 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php code for the user contribution tile
//*********************************************************************************************

//**************************************
// Changes per Section by this user
//**************************************
//* Changelog - Games
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'Games' and user_id = $user_id_contrib") or die("error getting games from change_log");
$change_log = $result->num_rows;
$change_log_bg[0] = "#c2c2c2";
$change_log_data[0] = $change_log;
$change_log_label[0] = "Games";
//* Changelog - Links
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'Links' and user_id = $user_id_contrib") or die("error getting Links from change_log");
$change_log = $result->num_rows;
$change_log_bg[1] = "#666666";
$change_log_data[1] = $change_log;
$change_log_label[1] = "Links";
//* Changelog - Individuals
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'Individuals' and user_id = $user_id_contrib") or die("error getting Individuals from change_log");
$change_log = $result->num_rows;
$change_log_bg[2] = "#c2c2c2";
$change_log_data[2] = $change_log;
$change_log_label[2] = "Individuals";
//* Changelog - News
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'News' and user_id = $user_id_contrib") or die("error getting News from change_log");
$change_log = $result->num_rows;
$change_log_bg[3] = "#666666";
$change_log_data[3] = $change_log;
$change_log_label[3] = "News";
//* Changelog - Crew
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'Crew' and user_id = $user_id_contrib") or die("error getting Crew from change_log");
$change_log = $result->num_rows;
$change_log_bg[4] = "#c2c2c2";
$change_log_data[4] = $change_log;
$change_log_label[4] = "Crew";
//* Changelog - Menu disk
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'Menu disk' and user_id = $user_id_contrib") or die("error getting Menu disk from change_log");
$change_log = $result->num_rows;
$change_log_bg[5] = "#666666";
$change_log_data[5] = $change_log;
$change_log_label[5] = "Menu disk";
//* Changelog - Downloads
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'Downloads' and user_id = $user_id_contrib") or die("error getting Downloads from change_log");
$change_log = $result->num_rows;
$change_log_bg[6] = "#c2c2c2";
$change_log_data[6] = $change_log;
$change_log_label[6] = "Downloads";
//* Changelog - Articles
$result   = $mysqli->query("SELECT * FROM change_log WHERE section = 'Articles' and user_id = $user_id_contrib") or die("error getting Articles from change_log");
$change_log = $result->num_rows;
$change_log_bg[7] = "#666666";
$change_log_data[7] = $change_log;
$change_log_label[7] = "Articles";
$smarty->assign('change_log_data', json_encode($change_log_data));
$smarty->assign('change_log_bg', json_encode($change_log_bg));
$smarty->assign('change_log_label', json_encode($change_log_label));
