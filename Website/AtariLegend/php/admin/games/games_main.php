<?php
/***************************************************************************
*                                games_main.php
*                            --------------------------
*   begin                : Sunday, August 28, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: games_main.php,v 0.10 2005/08/28 17:30 Gatekeeper
*   Id: games_main.php,v 0.20 2015/08/24 22:24 Gatekeeper
*   Id: games_main.php,v 0.30 2015/12/21 19:47 Gatekeeper - adding the quick search include
*
***************************************************************************/

/*
***********************************************************************************
This is the game browse page where you can navigate your way through the games db
***********************************************************************************
*/

//load all common functions
include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php");  

date_default_timezone_set('UTC');
$start = microtime(true);

$result = $mysqli->query("SELECT * FROM game");
$games_nr = $result->num_rows;

$smarty->assign("user_id",$_SESSION['user_id']);

$smarty->assign("games_nr",$games_nr);

if (isset ($_SESSION['edit_message']))
{
	$smarty->assign("message",$_SESSION['edit_message']);
}

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."games_main.html");

//close the connection
mysqli_close($mysqli);
?>
