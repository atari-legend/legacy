<?php
/***************************************************************************
*                                config.php
*                            -----------------------
*   begin                : Sunday May 23 2004
*   copyright            : (C) 2003 Atari Legend
*   email                : maarten.martens@freebel.net
*
*   Id: config.php,v 0.20 2015/08/15 17:56 ST Graveyard
*
***************************************************************************/

//***************************************************************
//This is the config file for the project
//***************************************************************

//***************************************************************
// Set overall variables
//***************************************************************

// Set timezone
date_default_timezone_set('UTC');

// Report all PHP errors
error_reporting(-1);

//Is the site online or not - we use this for updates
define("SITESTATUS", "online");

// This is the url of the site
define("SITEHOST", "www.atarilegend.com");
define("SITEURL", "http://".SITEHOST."/");

// The URL of the site as requested in the browser, without a trailing slash
// Useful to generate absolute URLs that will work both
// for 'localhost', 'dev.stonish.net' and 'www.atarilegend.com'
define("REQUEST_SITEURL", $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]);

//***************************************************************
// Setup the Smarty Templating framework
//***************************************************************

$smarty = new Smarty;

$smarty->template_dir = '../../../themes/templates/';
$smarty->compile_dir = '../../../php/temp/smarty/templates_c/';
$smarty->config_dir = '../../../php/temp/smarty/configs/';
$smarty->cache_dir = '../../../php/temp/smarty/cache/';
$smarty->addPluginsDir('../../../php/lib/smarty_plugins/');

//***************************************************************
// Some configs for the user management
//***************************************************************

define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");

define("SECURE", false);    // FOR DEVELOPMENT ONLY!!!!

//***************************************************************
// Mail server variables -- change these is we change server!
//***************************************************************

// this is the data used when creating emails regarding reset pwd and registration
$pwd_reset_link = "http://www.atarilegend.com/php/main/front/front.php?action=new_pwd&q=";
$pwd_reset_from = 'admin@atarilegend.com';
$pwd_reset_reply = 'admin@atarilegend.com';

$confirm_account_link = "http://www.atarilegend.com/php/common/login/db_register.php?action=confirm";

//***************************************************************
// Setup filepath variables
//***************************************************************

// database dumps
$database_dumps_path="../../data/database-dumps/";

//articles
$article_screenshot_path="../../data/images/article_screenshots/";
$article_screenshot_save_path="../../../data/images/article_screenshots/";

//company
$company_screenshot_path="../../data/images/company_logos/";
$company_screenshot_save_path="../../../data/images/company_logos/";
$individual_screenshot_path="../../data/images/individual_screenshots/";
$individual_screenshot_save_path="../../../data/images/individual_screenshots/";

//games
$game_boxscan_path="../../data/images/game_boxscans/";
$game_boxscan_save_path="../../../data/images/game_boxscans/";
$game_file_path="../../../data/zips/games/";
$game_file_temp_path="../../../data/zips/temp/";
$game_gallery_path="../../data/images/game_gallery/";
$game_screenshot_path="../../data/images/game_screenshots/";
$game_screenshot_save_path="../../../data/images/game_screenshots/";
$game_submit_screenshot_path="../../data/images/game_submit_screenshots/";
$game_submit_screenshot_save_path="../../../data/images/game_submit_screenshots/";
$game_fact_screenshot_path="../../data/images/game_fact_screenshots/";
$game_fact_screenshot_save_path="../../../data/images/game_fact_screenshots/";
$music_game_path="../../data/music/games/";
$music_game_save_path="../../../data/music/games/";

//releases
$game_release_scan_path="../../data/images/game_release_scans/";
$game_release_scan_save_path="../../../data/images/game_release_scans/";

//interview
$interview_screenshot_path="../../data/images/interview_screenshots/";
$interview_screenshot_save_path="../../../data/images/interview_screenshots/";

//menu
$menu_screenshot_path="../../data/images/menu_screenshots/";
$menu_screenshot_save_path="../../../data/images/menu_screenshots/";
$menu_file_path="../../../data/zips/menus/";
$menu_file_temp_path="../../../data/zips/temp/";

//news
$news_images_path="../../data/images/news_images/";
$news_images_save_path="../../../data/images/news_images/";

//links
$website_image_path="../../data/images/website_images/";
$website_image_path="../../data/images/website_images/";
$website_image_save_path="../../../data/images/website_images/";

//trivia
$trivia_screenshot_path="../../data/images/trivia_screens/";
$spotlight_screenshot_path="../../data/images/spotlight_screens/";
$spotlight_screenshot_save_path="../../../data/images/spotlight_screens/";

//demos
$demo_screenshot_path="../../data/images/demo_screenshots/";
$demo_file_path="../../data/zips/demos/";
$demo_file_temp_path="../../data/zips/temp/";
$music_demo_path="../../data/music/demos/";

//Crews
$crew_logo_path="../../data/images/crew_logos/";
$crew_logo_save_path="../../../data/images/crew_logos/";

//magazine
$magazine_scan_path="../../data/images/magazine_scans/";

//users
$user_avatar_path="../../data/images/user_avatars/";
$user_avatar_save_path="../../../data/images/user_avatars/";

//Dump
$media_scan_path="../../data/images/media_scans/";
$media_scan_save_path="../../../data/images/media_scans/";

// Include environment-specific settings
require('local_settings.php');
