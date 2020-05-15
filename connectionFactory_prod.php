<?php 
class ConnectionFactory { 
        
    public static function GetConnection() { 
	  $mysqli = new mysqli("dubathnekpdbuse1.mysql.db","dubathnekpdbuse1","dB0VHU5er","dubathnekpdbuse1");
	  if ($mysqli->connect_errno) {
		  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	  }
	  
	  return $mysqli;  
    } 
} 
?>
