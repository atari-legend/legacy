<?php
/***************************************************************************
*                                link_mod.php
*                            -----------------------
*   begin                : Saturday, Jan 08, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : silversurfer@atari-forum.com
*   actual update        : file creation
*
*
*   Id: link_mod.php,v 0.10 2005/01/08 Silver Surfer
*   Id: link_mod.php,v 0.20 2015/09/27 STG
*   Id: link_mod.php,v 0.30 2015/12/24 ST Graveman - Added right side
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

$smarty->assign('website_id', $website_id);

$LINKSQL = $mysqli->query("SELECT * FROM website
        WHERE website.website_id='$website_id'")
       or die("Error while querying the links database");

$rowlink= $LINKSQL->fetch_array(MYSQLI_BOTH);

  $website_image = $website_image_path;
  $website_image .= $rowlink['website_id'];
  $website_image .= ".";
  $website_image .= $rowlink['website_imgext'];
  $website_description_text = trim($rowlink['description']);

$smarty->assign('website', array(
    'website_name' => $rowlink['website_name'],
    'website_url' => $rowlink['website_url'],
    'website_id' => $rowlink['website_id'],
//  'category_id' => $rowlink['website_category_id'],
    'website_description_text' => $website_description_text,
    'website_imgext' => $rowlink['website_imgext'],
    'inactive' => $rowlink['inactive'],
    'website_image' => $website_image));

//get the categories of this website
$website = $mysqli->query("SELECT * FROM website_category_cross
          LEFT JOIN website_category
            ON (website_category_cross.website_category_id = website_category.website_category_id)
          WHERE website_category_cross.website_id = '$website_id'");

while ($category_row = $website->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('website_category', array(
        'category_name' => $category_row['website_category_name'],
        'category_id' => $category_row['website_category_id']));
}

//check if the categorie has some websites linked to it
$website_count = $mysqli->query("SELECT * FROM website_category_cross WHERE website_id = '$website_id'");
$nr_of_cats = $website_count->num_rows;

$smarty->assign('nr_of_cats', $nr_of_cats);

// Do the category selector
$RESULT=$mysqli->query("SELECT * FROM website_category ORDER BY website_category_name");

while ($rowlinkcat = $RESULT->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('category', array(
        'category_id' => $rowlinkcat['website_category_id'],
        'category_name' => $rowlinkcat['website_category_name']));
}

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."link_mod.html");
