<?php
/***************************************************************************
 *                                company_logos.php
 *                            -----------------------
 *   begin                : Sunday, August 7, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : maarten.martens@freebel.net
 *   actual update        : Creation of file
 *   Id: company_logos.php,v 0.10 2005/08/07 14:40 Gatekeeper
 *
 *
 *   Id: company_logos.php,v 0.10 2005/08/07 Grave
 *   Id: company_logos.php,v 0.20 2016/07/31 Grave
 *      - AL 2.0
 *
 ***************************************************************************

 ***************************************************************************
 A little logo preview page
 ***************************************************************************/

include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php");

$sql_logos = $mysqli->query("SELECT *
                            FROM pub_dev
                            LEFT JOIN pub_dev_text ON (pub_dev.pub_dev_id = pub_dev_text.pub_dev_id)
                            WHERE pub_dev_text.pub_dev_imgext <> 'NULL'
                            ORDER BY pub_dev.pub_dev_name");

while ($logos = $sql_logos->fetch_array(MYSQLI_BOTH)) {


    $company_image = $company_screenshot_path;
    $company_image .= $logos['pub_dev_id'];
    $company_image .= '.';
    $company_image .= $logos['pub_dev_imgext'];

    $smarty->append('company', array(
        'comp_id' => $logos['pub_dev_id'],
        'company_image' => $company_image,
        'comp_name' => $logos['pub_dev_name']
    ));
}

$smarty->assign("user_id", $_SESSION['user_id']);

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "company_logos.html");

//close the connection
mysqli_close($mysqli);
