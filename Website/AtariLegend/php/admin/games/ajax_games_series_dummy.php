<?php
/***************************************************************************
*                             games_series_main.php
*                            -----------------------
*   begin                : Saturday, Sept 24, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : Creation from scratch for smarty usage
						   
*							
*
*   Id: games_series_main.php,v 0.2 2005/09/24 Silver Surfer
*
***************************************************************************/

/*
***********************************************************************************
Build game series page
***********************************************************************************
*/
extract($_REQUEST);
include("../../includes/common.php");
include("../../includes/admin.php");

//check the $gamesearch field
if (isset($gamesearch))
{			
}	
else
{ 
	$gamesearch = "";
}
		
//check the $gamebrowse select
if (empty($gamebrowse) or $gamebrowse == '-')
{
	$gamebrowse_select = "";
}
elseif ($gamebrowse == 'num')
{
	$gamebrowse_select = "AND game.game_name REGEXP '^[0-9].*'";
}
else
{
	$gamebrowse_select = "AND game.game_name LIKE '$gamebrowse%'";
}
				
				
 $sql_build = "SELECT game.game_id,
			   game.game_name,
			   game_publisher.pub_dev_id as 'publisher_id',
			   pd1.pub_dev_name as 'publisher_name',
			   game_developer.dev_pub_id as 'developer_id',
			   pd2.pub_dev_name as 'developer_name',
			   game_year.game_year AS 'year'";
$sql_build .= "	FROM game ";
$sql_build .= "	LEFT JOIN game_year on (game_year.game_id = game.game_id) ";
$sql_build .= " LEFT JOIN game_publisher ON (game_publisher.game_id = game.game_id)"; 
$sql_build .= " LEFT JOIN pub_dev pd1 ON (pd1.pub_dev_id = game_publisher.pub_dev_id)"; 
$sql_build .= " LEFT JOIN game_developer ON (game_developer.game_id = game.game_id)";
$sql_build .= " LEFT JOIN pub_dev pd2 on (pd2.pub_dev_id = game_developer.dev_pub_id)"; 

$sql_build .= " WHERE game_name LIKE '%$gamesearch%'";
$sql_build .= $gamebrowse_select;

$sql_build .= " GROUP BY game.game_name";

$sql_series_link = $mysqli->query($sql_build)
					or die ("Couldn't query Game Series Database ($sql_build)");

$smarty->assign('smarty_action', 'game_list');

while  ($query_series_link = $sql_series_link->fetch_array(MYSQLI_BOTH)) 
{ 		// This smarty is used for creating the list of games contained within a game series
		$smarty->append('series_link',
		array('game_id' => $query_series_link['game_id'],
			  'game_name' => $query_series_link['game_name'],
			  'publisher_id' => $query_series_link['publisher_id'],
			  'publisher_name' => $query_series_link['publisher_name'],
			  'developer_id' => $query_series_link['developer_id'],
			  'developer_name' => $query_series_link['developer_name'],
			  'year' => $query_series_link['year']));
}

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."games_series_add_games.html");
?>
