<?php
/***************************************************************************
*                                technical_doc.php
*                            -----------------------
*   begin                : Friday, October 21, 2016
*   copyright            : (C) 2016 Atari Legend
*   email                : admin@atarilegend.com
*
*   id : technical_doc.php ,v 0.10 2016/10/21 ST Graveyard 14:23
*           - AL 2.0
*
***************************************************************************/

include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php");

if (isset($action) && $action == 'menus') {
    //Send all smarty variables to the templates
    $smarty->display("file:".$cpanel_template_folder."technical_doc_menus.html");
} else {
    //Send all smarty variables to the templates
    $smarty->display("file:".$cpanel_template_folder."technical_doc.html");
}
