<?php 
/***************************************************************************
*                                connect.php
*                            -----------------------
*   begin                : Sunday, Aug 24, 2003
*   copyright            : (C) 2003 Atari Legend
*   email                : maarten.martens@freebel.net
*
*   Id: connect.php,v 0.10 2003/08/24 21:04 Gatekeeper
*
***************************************************************************/

$db_username = "root";
$db_password = "";
$db_databasename = "atarilegend";

//$db_username = "atarilegend.com";
//$db_password = "4t4r1l3g3nd";
//$db_databasename = "atarilegend.com_devatarilegend";

//make connection with MYSQL DB
$mysqli = new mysqli("localhost", $db_username, $db_password, $db_databasename); 
?>
