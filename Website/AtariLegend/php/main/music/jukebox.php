<?
/***************************************************************************
*                                jukebox.php
*                            --------------------------
*   begin                : Tuesday, February 24, 2004
*   copyright            : (C) 2004 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: jukebox.php,v 0.20 2015/12/11 Silver Surfer/Perihelion
*
***************************************************************************/

// include common
include("../includes/common.php");

// Obtain the Authors
$query_artist = $mysqli->query("SELECT * FROM game_music 
				LEFT JOIN music ON (game_music.music_id = music.music_id)
				LEFT JOIN music_author ON (music.music_id = music_author.music_id)
				LEFT JOIN individuals ON (music_author.ind_id = individuals.ind_id)
				GROUP BY individuals.ind_id
				HAVING COUNT(DISTINCT individuals.ind_id) = 1
				ORDER BY individuals.ind_name") or die("fucked up query");
												
	while ($sql_artist = $query_artist->fetch_array(MYSQLI_BOTH)) {

		$smarty->append('artist',
	    	array('individual_id' => $sql_artist['ind_id'],
		  	'individual_name' => $sql_artist['ind_name']));	
} 												

// if artist_id is set then obtain the songs made by that author
if (isset($artist_id))

	{
	
		$smarty->assign('artist_id', $artist_id);

		$query_music = $mysqli->query("SELECT * FROM game_music 
						LEFT JOIN music ON (game_music.music_id = music.music_id)
						LEFT JOIN music_author ON (music.music_id = music_author.music_id)
						LEFT JOIN music_types ON (music.music_id = music_types.music_id)
						LEFT JOIN music_types_main ON (music_types.music_types_main_id = music_types_main.music_types_main_id)
						LEFT JOIN game ON (game_music.game_id = game.game_id)
						WHERE music_author.ind_id = $artist_id
						ORDER BY game.game_name") or die("fucked up query2");
	
	while ($sql_music = $query_music->fetch_array(MYSQLI_BOTH)) 
		{ 

			$smarty->append('music',
	    			array('music_id' => $sql_music['music_id'],
		  		'game_name' => $sql_music['game_name'],
		  		'imgext' => $sql_music['imgext']));		
		}



	} else {
	// if artist_id is not set then make artist id 0, for some reason smarty isset is not working.
	$artist_id="";
	$smarty->assign('artist_id', $artist_id);
	}
	

	

if (isset($artist_scroll))
	{
		$smarty->assign('artist_scroll', $artist_scroll);
	}

//Send all smarty variables to the templates
$smarty->display('extends:../templates/0/jukebox.html');
?>

