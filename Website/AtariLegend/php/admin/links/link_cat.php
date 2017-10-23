<?php
/***************************************************************************
*                                link_cat.php
*                            -----------------------
*   begin                : Saturday, Jan 08, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*
*
*   Id: link_cat.php,v 0.10 2005/01/08 Silver Surfer
*   Id: link_cat.php,v 0.20 2015/10/01 STG
*   Id: link_cat.php,v 0.30 2015/12/24 ST Graveman - Added right side
*
***************************************************************************/

/*
***********************************************************************************
In this section we modify links
***********************************************************************************
*/

include("../../config/common.php");
include("../../admin/games/quick_search_games.php");
include("../../config/admin.php");

$website = $mysqli->query("SELECT website_category_id, website_category_name FROM website_category ORDER by website_category_name");

while ($category_row = $website->fetch_array(MYSQLI_BOTH)) {
    $website_count = $mysqli->query("SELECT website_id FROM website_category_cross WHERE website_category_id = '$category_row[website_category_id]'");
    $nr_of_links = $website_count->num_rows;

    $smarty->append('category', array(
        'category_name' => $category_row['website_category_name'],
        'category_id' => $category_row['website_category_id'],
        'category_count' => $nr_of_links));
}

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."link_cat.html");
