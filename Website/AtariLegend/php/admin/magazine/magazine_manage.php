<?php
/***************************************************************************
 *                                magazine_manage.php
 *                            -----------------------
 *   begin                : Saturday, Sept 11, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : silversurfer@atari-forum.com
 *   actual update        : file creation
 *
 *
 *   Id: magazine_manage.php.php,v 1.10 2005/09/11 Silver Surfer
 *
 ***************************************************************************/

/*
 ***********************************************************************************
 Add Magazine screens!
 ***********************************************************************************
 */

include("../../config/common.php");
include("../../config/admin.php");

$sql_magazine = $mysqli->query("SELECT * FROM magazine ORDER BY magazine_name ASC") or die("Error retriving magazines");

while (list($magazine_id, $magazine_name) = $sql_magazine->fetch_row()) {
    $smarty->append('magazine', array(
        'magazine_id' => $magazine_id,
        'magazine_name' => $magazine_name
    ));
}

//Send all smarty variables to the templates
$smarty->display("file:" . $cpanel_template_folder . "magazine_manage.html");
