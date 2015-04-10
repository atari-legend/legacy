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


//make connection with MYSQL DB
$Cnn = @mysql_connect("localhost", "root", ""); 
   if (!$Cnn) 
   { 
   	 echo( "<p> Unable to connect to the database server at this time. </p>" ); 
   	 exit(); 
   }
   
//pick the DB
mysql_select_db("atarilegend", $Cnn); 
	if (! @mysql_select_db("atarilegend") ) 
	{ 
	  echo( "<p>Unable to locate the AtariLegend database at this time.</p>" ); 
	  exit(); 
	}
	
?>
