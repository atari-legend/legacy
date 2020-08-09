<?php
/***************************************************************************
*                               construction.php
*                            --------------------------
*   begin                : friday, July 21, 2005
*   copyright            : (C) 2004 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: construction.php,v 0.10 2005/07/21 17:51 ST Graveyard
*   Id: construction.php,v 0.20 2016/07/12 19:37 ST Graveyard
*
***************************************************************************/

//load all common functions
include("../../config/common.php");
include("../../config/admin.php");

$_SESSION['edit_message'] = "This is page is under construction - Patience is a virtue!";
header("Location: ../index.php");
