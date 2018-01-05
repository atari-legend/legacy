<?php
/***************************************************************************
 *                                open_db_tile.php
 *                            -----------------------
 *   begin                : Friday, January 5, 2018
 *   copyright            : (C) 2018 Atari Legend
 *   actual update        : File created for security reasons
 *
 *   Id:open_db_tile.php,v 0.1 2018/01/05 05-01-2018 ST Graveyard
 *
 ***************************************************************************/
include("../../config/common.php");
include("../../config/admin.php");

//Send all smarty variables to the templates
$smarty->display("file:" . $database_dumps_path . "HEADER.html");
