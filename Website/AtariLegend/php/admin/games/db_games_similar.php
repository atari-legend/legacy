<?php
/***************************************************************************
*                                games_similar.php
*                            --------------------------
*   begin                : 2006 April
*   copyright            : (C) 2006 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: games_similar.php,v 0.10 2006-04-05 Silver
*
***************************************************************************/


//load all common functions
include("../../includes/common.php");
include("../../includes/admin.php");


//***********************************************************************************
//If delete similar link has been pressed
//***********************************************************************************
if (isset($action) and $action == 'delete_similar')
{
	$sql_aka = $mysqli->query("DELETE FROM game_similar WHERE game_similar_id = '$game_similar_id' AND game_id = '$game_id'") 
			   or die ("Couldn't delete similar game");
		header("Location: ../games/games_similar.php?game_id=$game_id");
}

//***********************************************************************************
//If add similar button has been pressed
//***********************************************************************************
if (isset($action) and $action == 'add_game_similar')
{
	$sql_aka = $mysqli->query("INSERT INTO game_similar (game_id, game_similar_cross) VALUES ('$game_id','$game_similar')")
 			   or die ("Couldn't insert similar game");
		header("Location: ../games/games_similar.php?game_id=$game_id");
}

//close the connection
mysqli_close($mysqli);
?>
