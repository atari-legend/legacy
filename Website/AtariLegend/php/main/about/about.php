<?php
/***************************************************************************
 *                                about.php
 *                            ------------------------------
 *   begin                : Friday, September 14, 2017
 *   copyright            : (C) 2017 Atari Legend
 *   email                : martens_maarten@hotmail.com
 ****************************************************************************/

//*********************************************************************************************
// This is the class of AL page
//*********************************************************************************************

//load all common functions
require "../../config/common.php";

//load the tiles
require "../../common/tiles/screenstar.php";
require "../../common/tiles/did_you_know_tile.php";
require "../../common/tiles/latest_comments_tile.php";
require "../../common/tiles/tile_bug_report.php";

require_once __DIR__."/../../common/Model/Breadcrumb.php";

//Send all smarty variables to the templates
if (isset($action) and $action == 'andreas') {
    // get the comments from the database
    $sql_comment = $mysqli->query(
        "SELECT *
                                FROM andreas
                                ORDER BY andreas.timestamp DESC"
    ) or die("Error, can't query comments");

    // lets put the comments in a smarty array
    while ($query_comment = $sql_comment->fetch_array(MYSQLI_BOTH)) {
        $oldcomment = $query_comment['comment'];
        $oldcomment = BBCode($oldcomment);
        $oldcomment = nl2br($oldcomment);
        $oldcomment = stripslashes($oldcomment);

        $date = date("F j, Y", $query_comment['timestamp']);

        $smarty->append(
            'comments_andreas', array(
            'comment' => $oldcomment,
            'date' => $date,
            'user_name' => $query_comment['user_name']
            )
        );
    }
    $smarty->assign('action', 'andreas');
}

$smarty->assign(
    'breadcrumb',
    array(
        new AL\Common\Model\Breadcrumb("/about/about.php", "About")
    )
);

$smarty->display("file:" . $mainsite_template_folder . "about.html");

//close the connection
mysqli_close($mysqli);
