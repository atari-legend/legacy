<?

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

//make connection with MYSQL DB
$mysqli = new mysqli("localhost", "root", "", "atarilegend");

?>
