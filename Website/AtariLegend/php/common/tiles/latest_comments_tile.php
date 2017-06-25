<?php
/***************************************************************************
*                                latest_comments_tile.php
*                            ----------------------------
*   begin                : thursday, June 22, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id: latest_comments_tile.php,v 0.1 2017/06/22 19:46 ST Graveyard
*
***************************************************************************/

//*********************************************************************************************
// This is the php code for the latest game comments
//*********************************************************************************************

//Select the comments from the DB
$sql_comment = $mysqli->query("SELECT *
                                FROM game_user_comments
                                LEFT JOIN comments ON ( game_user_comments.comment_id = comments.comments_id )
                                LEFT JOIN users ON ( comments.user_id = users.user_id )
                                LEFT JOIN game ON ( game_user_comments.game_id = game.game_id )
                                ORDER BY comments.timestamp DESC LIMIT 3") or die("Syntax Error! Couldn't not get the comments!");

                                // lets put the comments in a smarty array

while ($query_comment = $sql_comment->fetch_array(MYSQLI_BOTH)) 
{
    
    $oldcomment = $query_comment['comment'];
    $oldcomment = nl2br($oldcomment);
    $oldcomment = InsertALCode($oldcomment);
    $oldcomment = trim($oldcomment);
    $oldcomment = RemoveSmillies($oldcomment);
    $oldcomment = stripslashes($oldcomment);
    
    $date = date("F j, Y",$query_comment['timestamp']);
    
    $smarty->append('comments',
	    array('comment' => $oldcomment,
			  'date' => $date,
			  'game' => $query_comment['game_name'],
			  'game_id' => $query_comment['game_id'],
			  'user_name' => $query_comment['userid'],
			  'email' => $query_comment['email']));
}
?>
