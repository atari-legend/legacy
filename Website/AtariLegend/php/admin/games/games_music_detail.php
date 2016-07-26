<?php
/***************************************************************************
*                                games_music_detail.php
*                            -----------------------------
*   begin                : Tuesday, November 15, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*						   Created file
*						
*   Id: games_music_detail.php,v 0.10 2005/11/15 ST Graveyard
*   Id: games_music_detail.php,v 0.20 2016/07/26 ST Graveyard
*			- AL 2.0
*
***************************************************************************/

//load all common functions
include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php");

/*
***********************************************************************************
This is the game music detail page. 
***********************************************************************************
*/
if (isset($action) and $action == 'play_music')
{
	$query_music = $mysqli->query("SELECT * FROM music 
							WHERE music.music_id='$music_id'");
							
	$sql_music = $query_music->fetch_array(MYSQLI_BOTH);

	$filename="$music_game_path$sql_music[music_id].$sql_music[imgext]";

	$fp=fopen($filename, "rb");
	
	header("Content-Type: $sql_music[mime_type]");
	header("Content-Length: ".filesize($filename));
	
	if ($sql_music['imgext']=='mod')
		{
	    	header('Content-Disposition: attachment; filename="music.mod"');
		}
	if ($sql_music['imgext']=='ym')
		{
	    	header('Content-Disposition: attachment; filename="music.ym"');
		}
	if ($sql_music['imgext']=='snd')
		{
	    	header('Content-Disposition: attachment; filename="music.snd"');
		}
	if ($sql_music['imgext']=='mp3')
		{
	    	header('Content-Disposition: attachment; filename="music.mp3"');
		}
	
	fpassthru($fp);
	exit;
}

if (isset($action) and $action == 'pick_composer')
{
	if ( $individuals == '-' )
	{
		$_SESSION['edit_message'] = "Please pick a composer or add one in the detail page";
	}
	else
	{
		$smarty->assign('action', 'pick_composer');
	
		//We need to get all the info of this game. 
		$SQL_IND = $mysqli->query("SELECT *
							   	 FROM individuals
						         WHERE ind_id='$individuals'")
			        or die ("Error getting ind name");
	
		while ( $IND=$SQL_IND->fetch_array(MYSQLI_BOTH) ) 
		{  
			$smarty->assign('ind_selected',
		  	 		 array( 'ind_id'  => $IND['ind_id'],
					 		'ind_name' => $IND['ind_name']));
		}
	}
}

//We need to get all the info of this game. 
$SQL_GAME = $mysqli->query("SELECT game_name, 
						   game.game_id
						   FROM game 
					       WHERE game.game_id='$game_id'")
		      or die ("Error getting game info");
			
while ( $GAME=$SQL_GAME->fetch_array(MYSQLI_BOTH) ) 
{  
	$smarty->assign('game',
	   		 array('game_id' => $GAME['game_id'],
				   'game_name' => $GAME['game_name']));
}

//get the music info
$sql_music = $mysqli->query("SELECT * FROM game_music 
							LEFT JOIN music ON (game_music.music_id = music.music_id)
							LEFT JOIN music_author ON (music.music_id = music_author.music_id)
							LEFT JOIN individuals ON (music_author.ind_id = individuals.ind_id)
							LEFT JOIN music_types ON (music.music_id = music_types.music_id)
							LEFT JOIN music_types_main ON (music_types.music_types_main_id = music_types_main.music_types_main_id)
							WHERE game_music.game_id='$game_id'");
$i = 0;
while ( $MUSIC=$sql_music->fetch_array(MYSQLI_BOTH) ) 
{ 		
	$i++;
	
	$smarty->append('music',
	   		 array('music_id' => $MUSIC['music_id'],
				   'ind_name' => $MUSIC['ind_name'],
				   'music_id' => $MUSIC['music_id'],
				   'extention' => $MUSIC['extention']));
}

$smarty->assign('nr_of_zaks', $i);

$SQL_MUSICIAN = $mysqli->query("SELECT *
						   FROM game_author
						   LEFT JOIN author_type ON ( game_author.author_type_id = author_type.author_type_id )
					       LEFT JOIN game ON ( game_author.game_id = game.game_id )
						   LEFT JOIN individuals ON ( game_author.ind_id = individuals.ind_id )
						   WHERE game.game_id='$game_id'
						   AND author_type.author_type_info = 'music'")
		      or die ("Error getting game musician");
$i = 0;

while ( $MUSICIAN=$SQL_MUSICIAN->fetch_array(MYSQLI_BOTH) ) 
{  
	$i++;
	
	$smarty->append('ind',
	   		 array('ind_id' => $MUSICIAN['ind_id'],
				   'ind_name' => $MUSICIAN['ind_name']));
}

if (isset($i) and $i == 0 )
{
	$_SESSION['edit_message'] =  "No musician attached to this game, go to the detail pages to add a musician first";
	header("Location: ../games/games_music.php");
}
else
{
	$_SESSION['edit_message'] =  "To add more musicians, just click the game name in the header to go to the detail pages of this game";
}

$smarty->assign("user_id",$_SESSION['user_id']);

$smarty->assign('quick_search_games', 'quick_search_game_music_detail');
$smarty->assign('left_nav', 'leftnav_position_game_music_detail');

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."games_music_detail.html");

//close the connection
mysqli_close($mysqli);

