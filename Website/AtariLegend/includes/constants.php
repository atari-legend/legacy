<?php
/***************************************************************************
*                                constants.php
*                            --------------------------
*   begin                : Monday, 26 January, 2004
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : Browser detection added both to smarty and a php constant
*						   
*						   
*
*   Id: constants.php,v 0.11 2004/10/27 14:30 silver
*
***************************************************************************/

// Define what version of mysql the server is using.
// Fill in either mysql3 or mysql4 depending on your server version.
define("MYSQLVER", "mysql4");

//Is the site online or not - we use this for updates
define("SITESTATUS", "online");

// This is the url of the site
define("SITEURL", "http://www.atarilegend.com/");

// Determine the browser

unset ($BROWSER_AGENT);

function browser_get_agent () {
    global $BROWSER_AGENT;
    return $BROWSER_AGENT;
}

if (ereg( 'MSIE ([0-9].[0-9]{1,2})',$_SERVER['HTTP_USER_AGENT'],$log_version)) {
    $BROWSER_VER=$log_version[1];
    $BROWSER_AGENT='IE';
} elseif (ereg( 'Opera ([0-9].[0-9]{1,2})',$_SERVER['HTTP_USER_AGENT'],$log_version)) {
    $BROWSER_VER=$log_version[1];
    $BROWSER_AGENT='OPERA';
} elseif (ereg( 'Mozilla/([0-9].[0-9]{1,2})',$_SERVER['HTTP_USER_AGENT'],$log_version)) {
    $BROWSER_VER=$log_version[1];
    $BROWSER_AGENT='MOZILLA';
} else {
    $BROWSER_VER=0;
    $BROWSER_AGENT='OTHER';
}

// make constant and smarty value

if (browser_get_agent()=="IE") {$smarty->assign('browser', 'ie'); define("BROWSER", "ie");
} elseif (browser_get_agent()=="MOZILLA") {$smarty->assign('browser', 'mozilla'); define("BROWSER", "mozilla");
} elseif (browser_get_agent()=="OPERA") {$smarty->assign('browser', 'ie'); define("BROWSER", "ie");
} elseif (browser_get_agent()=="OTHER") {$smarty->assign('browser', 'ie'); define("BROWSER", "ie");
}
?>
