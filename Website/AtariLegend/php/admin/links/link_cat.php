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

include("../../common/DAO/LinkCategoryDAO.php");

$dao = new AL\Common\DAO\LinkCategoryDAO($mysqli);
$smarty->assign('categories', $dao->getAllCategories());
$smarty->display("file:".$cpanel_template_folder."links/link_cat.html");
