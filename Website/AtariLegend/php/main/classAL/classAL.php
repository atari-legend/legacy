<?php
/***************************************************************************
*                                classAL.php
*                            ------------------------------
*   begin                : Friday, September 14, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*
*   Id: classAL.php,v 0.1 2017/09/14 11:39 STG
****************************************************************************/

//*********************************************************************************************
// This is the class of AL page
//********************************************************************************************* 

//load all common functions
include("../../config/common.php");

//load the tiles
include("../../common/tiles/screenstar.php");
include("../../common/tiles/did_you_know_tile.php");
include("../../common/tiles/latest_comments_tile.php");
include("../../common/tiles/tile_bug_report.php");

//Send all smarty variables to the templates
if (isset ($action) and $action == 'andreas')
{
    
    // get the comments from the database
    $sql_comment = $mysqli->query("SELECT *
                                FROM andreas
                                ORDER BY andreas.timestamp DESC") or die("Error, can't query comments");

    // lets put the comments in a smarty array
    while ($query_comment = $sql_comment->fetch_array(MYSQLI_BOTH))
    {
        $oldcomment = $query_comment['comment'];
        $oldcomment = BBCode($oldcomment);
        $oldcomment = nl2br($oldcomment);
        $oldcomment = stripslashes($oldcomment);
        
        $date = date("F j, Y",$query_comment['timestamp']);
        
        $smarty->append('comments_andreas',
            array('comment' => $oldcomment,
                  'date' => $date,
                  'user_name' => $query_comment['user_name']));
    }

    $smarty->assign('action','andreas');
}

$smarty->display("file:" . $mainsite_template_folder . "class_of_AL.html");

//close the connection
mysqli_close($mysqli);
?>
