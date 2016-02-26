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
$db_password = "higher";
$db_databasename = "atarilegend3";


//make connection with MYSQL DB
$mysqli = new mysqli("localhost", $db_username, $db_password, $db_databasename); 
?>
