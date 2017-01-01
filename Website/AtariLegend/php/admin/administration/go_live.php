<?php
/***************************************************************************
*                                go_live.php
*                            ----------------------------
*   begin                : Tuesday 13, December 2016
*   copyright            : (C) 2015 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id:   go_live.php,v 0.1 2016/12/13 21:55 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is a script to do some minor database changes necesarry for a proper go live
// This is only run once
//*********************************************************************************************

include("../../config/common.php");

//alter the interview_main table
$sdbquery = $mysqli->query("ALTER TABLE interview_main CHANGE member_id user_id INT( 11 )") or die("Interview_main could not be altered");

//alter table website
$sdbquery = $mysqli->query("ALTER TABLE website CHANGE website_user_sub user_id INT( 11 )") or die("Website could not be altered");

//alter table users
$sdbquery = $mysqli->query("ALTER TABLE users ADD sha512_password CHAR( 128 ) NULL AFTER password") or die ("user table sha512 column could not be altered");

//alter table users
$sdbquery = $mysqli->query("ALTER TABLE users ADD salt CHAR( 128 ) NULL AFTER sha512_password") or die ("user table salt column could not be altered");
